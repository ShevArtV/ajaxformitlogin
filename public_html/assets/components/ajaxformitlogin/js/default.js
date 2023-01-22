import AjaxFormitLogin from "./modules/ajaxformitlogin.class.js";

const aflConfigs = document.querySelectorAll('input[name="afl_config"]');
window.aflForms = {};
if (aflConfigs.length) {
    aflConfigs.forEach(el => {
        let config = JSON.parse(el.value);
        window.aflForms[config.formSelector] = new AjaxFormitLogin('.' + config.formSelector, config);
    });
    const initEvent = new CustomEvent('afl_init', {
        cancelable: false,
        bubbles: true,
        detail: {},
    });
    document.dispatchEvent(initEvent);
}