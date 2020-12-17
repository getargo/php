import Loader from '../Helpers/Loader.js';

class PrismCodeHighlighting {
    constructor () {
        // noinspection TypeScriptUMDGlobal
        Loader.loadCss('/theme/default/lib/prism/prism.min.css');
        Loader.loadCss('/theme/default/lib/prism/lang.customee.min.css');
        Loader.loadJs('/theme/default/lib/prism/prism.min.js').then(() => {
            Loader.loadJs('/theme/default/lib/prism/lang.ee.min.js').then(() => {
                window.Prism.highlightAll();
            });
        });
    }
}

export default PrismCodeHighlighting;
