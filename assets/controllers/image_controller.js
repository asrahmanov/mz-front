import {Controller} from 'stimulus';
import '../style/fields/image.css';
import humanizeString from 'humanize-string';


export default class extends Controller
{
    static targets = ['input'];

    connect() {
        this.fileInput = document.createElement('input');
        this.fileInput.type = 'file';
        this.fileInput.onchange = e => {
            if (e.currentTarget.files && e.currentTarget.files[0]) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.element.style.backgroundImage = 'url(' + e.target.result + ')';
                }
                let form = new FormData();
                form.append('file', e.currentTarget.files[0]);
                fetch('/admin/file',{
                    'method': 'POST',
                    'body': form,
                }).then(r => {
                    r.json().then(val => {
                        this.inputTarget.value = val.path;
                    })
                });
                reader.readAsDataURL(e.currentTarget.files[0]);
                this.element.classList.remove('empty');
                let nameEl = this.element.querySelector('input.image-name');
                if (! nameEl.value) {
                    nameEl.value = humanizeString(e.currentTarget.files[0].name.replace(/\.[^/.]+$/, ""));
                }
            }
        };

        if (this.inputTarget.value) {
            this.element.style.backgroundImage = 'url(' + this.inputTarget.value + ')';
        }
        else {
            this.element.classList.add('empty');
        }
    }

    openDialog(event) {
        event.preventDefault();
        this.fileInput.click();
    }

    noop(event) {
        event.stopPropagation();
    }
}
