export default class AjaxForm {
    constructor(selector, config) {
        this.form = document.querySelector(selector);
        if (!this.form) {
            console.error('Form with selector ' + selector + ' not found. Check the correctness of the selector.');
            return false;
        }

        this.defaults = {
            clearFieldsOnSuccess: true,
            actionUrl: 'assets/components/ajaxformitlogin/action.php',
            pageId: 1,
            fileUplodedProgressMsg: '',
            fileUplodedSuccessMsg: '',
            fileUplodedErrorMsg: '',
            ajaxErrorMsg: '',
            showUplodProgress: false,
            addons: ['Notify'],
            notifyClassPath: './aflnotify.class.js',
            notifyClassName: 'AflNotify',
            moduleImportErrorMsg: 'Произошла ошибка при загрузке модуля',
            formMethod: 'POST',
            requiredCheckboxesSelector: '[data-afl-required]',
            requiredCheckboxesAttr: 'aflRequired'
        }

        this.config = Object.assign({}, this.defaults, config);
        this.antiSpamKeyInput = document.querySelectorAll('[name="secret"]');
        this.requiredCheckboxes = this.form.querySelectorAll(this.config.requiredCheckboxesSelector);
        //console.log(config);
        this.initialize();
    }

    initialize() {
        if (!this.config.addons.length) {
            throw new Error('Не передан массив имён обработчиков');
        }

        this.config.addons.forEach(property => {
            this.setAddon(property);
        });

        // adding the necessary handlers
        this.addHandlers(['submit', 'reset'], 'Form');

        if (this.requiredCheckboxes.length) {
            this.requiredCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', this.checkboxHandler.bind(this));
            });
        }

        if (this.antiSpamKeyInput.length) {
            document.addEventListener('mousemove', this.insertAntiSpamKey.bind(this), {once: true});
        }
    }

    insertAntiSpamKey() {
        this.antiSpamKeyInput.forEach(el => {
            el.value = el.dataset.secret;
        });
    }

    checkboxHandler(e) {
        const elem = e.target || e;
        const target = this.form.querySelector('[name="' + elem.dataset[this.config.requiredCheckboxesAttr] + '"]');
        if (target) {
            target.value = elem.checked ? 1 : 0;
            if (elem.checked) {
                const error = this.form.querySelector('.error_' + target.name);
                if (error) {
                    error.classList.remove('error');
                    error.innerHTML = '';
                }
            }
        }
    }

    async setAddon(property) {
        let prefix = property.toLowerCase(),
            response = false,
            messageSettings = false;
        if (prefix === 'notify') {
            response = await this.sendResponse({url: this.config.notifySettingsPath, method: 'GET'});
            if (response.ok) {
                messageSettings = await response.json();
            }
        }
        const classPath = this.config[prefix + 'ClassPath'];
        const className = this.config[prefix + 'ClassName'];
        const config = messageSettings ? messageSettings[className] : this;

        try {
            const {default: ModuleName} = await import(classPath);
            this[property] = new ModuleName(config);
        } catch (e) {
            throw new Error(this.config.moduleImportErrorMsg);
        }
    }

    sendResponse(params) {
        const body = params.body || new FormData(),
            headers = params.headers || {'X-Requested-With': 'XMLHttpRequest'},
            url = params.url || this.config.actionUrl,
            method = params.method || this.config.formMethod;

        let options = {method, headers, body};
        if (method === 'GET') {
            options = {method, headers};
        }

        return fetch(url, options);
    }


    addHandlers(handlers, postfix) {
        handlers.forEach(handler => {
            this.form.addEventListener(handler, this['on' + handler + postfix].bind(this));
        });
    }

    onsubmitForm(e) {
        e.preventDefault();
        if (this.beforeSubmit(e.target)) {
            const params = new FormData(e.target);
            params.append('pageId', this.config.pageId);
            this.sendAjax(this.config.actionUrl, params, this.responseHandler.bind(this), e.target);
        }
    }

    onresetForm(e) {
        if (this.Notify !== undefined) {
            this.Notify.close();
        }
        const currentErrors = e.target.querySelectorAll('.error');
        if (currentErrors.length) {
            currentErrors.forEach(this.resetErrors);
        }

        setTimeout(() => {
            this.insertAntiSpamKey();
            if (this.requiredCheckboxes.length) {
                this.requiredCheckboxes.forEach(checkbox => {
                    this.checkboxHandler(checkbox);
                });
            }
        }, 500);
    }

    resetErrors(e) {
        const elem = e.target || e,
            form = elem.closest('form');
        elem.classList.remove('error');
        if (elem.name && form.length) {
            console.log(elem.name);
            let requiredCheckbox = form.querySelector('[data-required="' + elem.name + '"]');
            if (requiredCheckbox) {
                elem.value = 0;
            }
            form.querySelector('.error_' + elem.name).innerHTML = '';
        }
    }

    beforeSubmit(form) {
        const currentErrors = form.querySelectorAll('.error');
        if (currentErrors.length) currentErrors.forEach(this.resetErrors);
        return true;
    }

    // Submitting a form
    sendAjax(path, params, callback, form) {
        const request = new XMLHttpRequest();
        const url = path || document.location.href;
        const $this = this;

        request.open('POST', url, true);
        request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        request.responseType = 'json';

        if (form.querySelector('input[type="file"]')?.value && this.config.showUploadProgress) {
            request.upload.onprogress = function (e) {
                $this.onUploadProgress(e, form);
            };
            request.upload.onload = function (e) {
                $this.onUploadFinished(e, form);
            };
            request.upload.onerror = function (e) {
                $this.onUploadError(e, form);
            };
        }

        request.addEventListener('readystatechange', function () {
            form.querySelectorAll('input,textarea,select,button').forEach(el => el.disabled = true);
            if (request.readyState === 4 && request.status === 200) {
                callback(request.response, form);
            } else if (request.readyState === 4 && request.status !== 200) {
                if (this.Notify !== undefined) {
                    this.Notify.error($this.config.ajaxErrorMsg);
                }
            }
        });
        request.send(params);
    }

    // handler server response
    responseHandler(response, form) {
        form.querySelectorAll('input,textarea,select,button').forEach(el => el.disabled = false);

        const event = new CustomEvent('afl_complete', {
            cancelable: true,
            bubbles: true,
            detail: {response: response, form: form},
        });
        const cancelled = document.dispatchEvent(event);

        if (cancelled) {
            if (!response.success) {
                this.onError(response, form);
            } else {
                this.onSuccess(response, form);
            }
        } else {
            return false;
        }
    }

    // handler server success response
    onSuccess(response, form) {
        if (this.Notify !== undefined) {
            this.Notify.success(response.message);
        }

        if (response.data.redirectUrl) {
            setTimeout(() => {
                window.location.href = response.data.redirectUrl;
            }, response.data.redirectTimeout);
        }

        form.querySelectorAll('.error').forEach(el => {
            if (el.name) {
                el.removeEventListener('keydown', this.resetErrors);
            }
        });
        if (this.config.clearFieldsOnSuccess != 0) {
            form.reset();
        }
    }

    // handler server error response
    onError(response, form) {
        if (response.data.errors) {
            let key, value, focused;
            for (key in response.data.errors) {
                if (key !== 'secret') {
                    let span = form.querySelector('.error_' + key);
                    if (response.data.errors.hasOwnProperty(key)) {
                        if (!focused) {
                            form.querySelector('[name="' + key + '"]').focus();
                            focused = true;
                        }
                        value = response.data.errors[key];
                        if (span) {
                            span.innerHTML = value;
                            span.classList.add('error');
                        }

                        form.querySelector('[name="' + key + '"]').classList.add('error');
                    }
                } else {
                    if (this.Notify !== undefined) {
                        this.Notify.error(response.data.errors[key]);
                        response.message = '';
                    }
                }

            }

            form.querySelectorAll('.error').forEach(el => {
                if (el.name) {
                    el.addEventListener('keydown', this.resetErrors);
                }
            });
        }

        if (this.Notify !== undefined) {
            this.Notify.error(response.message);
        }
    }

    // File upload processing methods
    onUploadProgress(e, form) {
        if (this.Notify !== undefined) {
            this.Notify.info(this.config.fileUplodedProgressMsg + Math.ceil(e.loaded / e.total * 100) + '%');
        }
    }

    onUploadFinished(e, form) {
        if (this.Notify !== undefined) {
            this.Notify.success(this.config.fileUplodedSuccessMsg);
        }
    }

    onUploadError(e, form) {
        if (this.Notify !== undefined) {
            this.Notify.error(this.config.fileUplodedErrorMsg);
        }
    }
}