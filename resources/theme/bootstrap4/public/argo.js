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
