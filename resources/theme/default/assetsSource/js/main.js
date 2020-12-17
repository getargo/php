/* eslint-disable no-new */

import PrismCodeHighlighting from './Components/PrismCodeHighlighting.js';

if (document.querySelector('code')
    || document.querySelector('pre')
) {
    new PrismCodeHighlighting();
}
