export default class AflNotify {
    constructor(config) {
        this.config = config;

        this.initialize();
    }

    initialize() {
        const script = document.querySelector('script[src="' + this.config.jsPath + '"]');
        const style = document.querySelector('link[href="' + this.config.cssPath + '"]');
        if (this.config.jsPath && !script) {
            const script = document.createElement('script');
            script.src = this.config.jsPath;
            script.async = true;
            document.body.appendChild(script);
        }

        if (this.config.cssPath && !style) {
            const styles = document.createElement('link');
            styles.href = this.config.cssPath;
            styles.rel = 'stylesheet';
            document.head.appendChild(styles);
        }
    }

    show(type, message) {
        if (message !== '') {
            alert(message);
        }
    }

    success(message) {
        this.show('success', message);
    }

    error(message) {
        this.show('error', message);
    }

    info(message) {
        this.show('info', message);
    }

    close() {
    }
}
