/* eslint-disable no-console, func-names, object-shorthand, no-var, no-unused-vars, arrow-parens */

var Argo = {
    shtml: function (href, currentScript) {
        fetch(href)
            .then(
                (response) => response.text(),
            )
            .then(
                (html) => {
                    currentScript.parentElement.innerHTML = html;
                },
            )
            .catch(
                (error) => {
                    console.warn(error);
                },
            );
    },
};
