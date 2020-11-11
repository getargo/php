/* eslint-disable no-console, func-names, object-shorthand, no-var, no-unused-vars, arrow-parens */

var Argo = {
    shtml: function (href, id) {
        fetch(href)
            .then(
                (response) => response.text(),
            )
            .then(
                (html) => {
                    document.getElementById(id).innerHTML = html;
                },
            )
            .catch(
                (error) => {
                    console.warn(error);
                },
            );
    },
};
