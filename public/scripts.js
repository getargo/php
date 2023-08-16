// turns out this needs to go behind PHP as well,
// so that it gets served under HTTP 1.0 (not php server 0.9)

function openFolder(id) {
    let xhr = new XMLHttpRequest();
    if (id.substr(0, 1) === '/') {
        id = id.substr(1);
    }
    if (id.substr(-1) === '/') {
        id = id.substr(0, -1);
    }
    xhr.open("GET", `/folder/${id}`);
    xhr.send();
    return false;
}

function process(type) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", `/${type}/process`);
    xhr.onprogress = function (event) {
        let element = document.getElementById('process-stream');
        let text = event.currentTarget.responseText;
        element.innerHTML = text;
    }
    xhr.send();
}

function xhrSubmit(method, form, action) {
    if (method == 'DELETE') {
        ok = window.confirm("Do you really want to delete this item?");
        if (! ok) {
            return;
        }
    }

    let submitFailure = document.getElementById("submit-failure");
    if (submitFailure) {
        submitFailure.innerHTML = "";
    }

    document.body.style.cursor = "wait";

    let xhr = new XMLHttpRequest();
    xhr.open(method, action);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    let submitStream = document.getElementById('submit-stream');
    if (submitStream) {
        submitStream.innerHTML = "";

        xhr.onprogress = function (event) {
            if (xhr.status === 200) {
                submitStream.innerHTML = event.currentTarget.responseText;
            }
        }

        xhr.onload = function () {
            document.body.style.cursor = "default";
        }
    } else {
        /** @todo disable the form or gray the screen while working */

        xhr.onload = function () {
            document.body.style.cursor = "default";

            // alert(xhr.status);
            // alert(xhr.getResponseHeader("X-Argo-Forward"));
            // alert(xhr.response);

            if (xhr.status < 400) {
                window.location.href = xhr.getResponseHeader("X-Argo-Forward");
            } else if (submitFailure) {
                submitFailure.innerHTML = "<pre>" + xhr.response + "</pre>";
            }
        };
    }

    xhr.send(new FormData(form));
}
