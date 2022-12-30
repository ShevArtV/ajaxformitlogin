import AjaxFormitLogin from "./modules/ajaxformitlogin.class.js";

const aflConfigs = document.querySelectorAll('input[name="afl_config"]');
window.aflForms = {};
if (aflConfigs.length) {
    aflConfigs.forEach(el => {
        let config = JSON.parse(el.value);
        window.aflForms[config.formSelector] = new AjaxFormitLogin('.' + config.formSelector, config);
    });
}

document.addEventListener('afl_complete', e => {
    console.log(e.detail);
});