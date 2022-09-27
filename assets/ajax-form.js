console.log('loaded');
function ajaxForm(formElement) {
    if (!(formElement instanceof HTMLFormElement)) {
        return;
    }

    let formSubmitHandler = function (submitEvent) {
        if (form_validate(this) !== 0) {
            return;
        }
        this.closest('.popup') && popup_close(this.closest('.popup'));
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        })
            .then(response => {
                response.json()
                    .then(responseMsgObj => {
                        if (!response.ok) {
                            throw new Error();
                        }
                        setTimeout(() => {
                            showAlert(responseMsgObj.text)
                        }, 500);
                    })
                    .catch(r => showAlert('Форма заполнена не верно', 1));
            })
            .catch(r => showAlert('Ошибка соединения', 1));
        submitEvent.preventDefault();
    }
    formElement.addEventListener('submit', formSubmitHandler);
}

window.ajaxForm = ajaxForm;
document.querySelectorAll('form.ajax').forEach( el => ajaxForm(el));
