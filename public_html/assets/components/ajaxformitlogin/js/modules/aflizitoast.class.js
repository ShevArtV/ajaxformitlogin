import AflNotify from './aflnotify.class.js';

export default class AflIziToast extends AflNotify {
    show(type, message) {
        if (window[this.config.handlerClassName] && message) {
            const options = Object.assign(this.config.handlerOptions, { title: message });
            try {
                window[this.config.handlerClassName][type](options);
            } catch (e) {
                console.error(e, `Не найден метод ${type} в классе ${this.config.handlerClassName}`);
            }
        }
    }
}
