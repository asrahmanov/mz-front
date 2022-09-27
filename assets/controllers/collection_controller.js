import { Controller } from 'stimulus';
import '../style/fields/collection.css';

export default class extends Controller {

    static targets = ['container'];

    connect() {
        let prototypeEl = this.element.querySelector('.prototype');
        this.prototype = prototypeEl.cloneNode(true);
        this.prototype.classList.remove('d-none');
        this.prototype.classList.remove('prototype');
        this.prototype.setAttribute('data-collection-target', 'row')
        this.element.style
        prototypeEl.remove();
    }

    deleteRow(event) {
        event.preventDefault();
        let rowId = event.currentTarget.dataset.targetRowId;
        let row = this.element.querySelector('[data-row-id="'+ rowId +'"]');
        row.style.transition = '0.2s';
        row.style.opacity = 0;
        row.ontransitionend = e => {e.currentTarget.remove();}
    }

    addRow(event) {
        event.preventDefault();
        let lastRow = this.element.querySelector('[data-row-id]:last-of-type');
        let num = 0;

        if (lastRow){
            num = Number(lastRow.dataset.rowId) + 1;
        }
        let html = this.prototype.outerHTML.replaceAll('__name__',  num);
        this.containerTarget.insertAdjacentHTML('beforeend', html);
    }
}
