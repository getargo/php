class Loader {
    static loadJs (src) {
        return new Promise((resolve, reject) => {
            if (document.querySelector(`script[src="${src}"]`)) {
                resolve();

                return;
            }

            const el = document.createElement('script');

            el.type = 'text/javascript';
            el.async = true;
            el.src = src;

            el.addEventListener('load', resolve);
            el.addEventListener('error', reject);
            el.addEventListener('abort', reject);

            document.head.appendChild(el);
        });
    }

    static loadCss (src) {
        return new Promise((resolve, reject) => {
            if (document.querySelector(`link[href="${src}"]`)) {
                resolve();

                return;
            }

            const el = document.createElement('link');

            el.rel = 'stylesheet';
            el.href = src;

            el.addEventListener('load', resolve);
            el.addEventListener('error', reject);
            el.addEventListener('abort', reject);

            document.head.appendChild(el);
        });
    }
}

export default Loader;
