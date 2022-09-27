import {Controller} from 'stimulus';
import 'handsontable/dist/handsontable.full.css';
import Handsontable from "handsontable";
import {registerLanguageDictionary, ruRU} from 'handsontable/i18n';

registerLanguageDictionary(ruRU);
export default class extends Controller {
    static values = {
        options: Object,
    };

    defaultOptions = {
        stretchH: 'all',
        colWidths: 100,
        width: '100%',
        language: 'ru-RU',
        licenseKey: 'non-commercial-and-evaluation',
        minSpareRows: 1,
        contextMenu: ['row_below', 'remove_row'],
    }

    connect() {
        let container = document.createElement('div');
        this.element.after(container);
        this.element.classList.add('d-none');
        let el = this.element;
        let table = new Handsontable(container, {
            ...this.defaultOptions,
            ...this.optionsValue,
            data: this.element.value ? JSON.parse(this.element.value) : [],
            afterChange: function(changes){
                el.value = JSON.stringify(this.getSourceData());
            }
        })
        let resizeObserver = new ResizeObserver(entries => {
            table.refreshDimensions();
        });
        resizeObserver.observe(container);
    }
}
