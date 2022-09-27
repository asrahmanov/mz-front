import 'handsontable/dist/handsontable.full.css';
import Handsontable from "handsontable";
import { registerLanguageDictionary, ruRU } from 'handsontable/i18n';

registerLanguageDictionary(ruRU);
window.Handsontable = Handsontable;

const mapper = {
    emptyRowCleaner: function(gridData, table) {
        let result = [];
        $.each(gridData, function( rowKey, object) {
            if (! table.isEmptyRow(rowKey)) result[rowKey] = object;
        });
        return result;
    },

    table: null,
    el: null,

    commonOptions: {
        stretchH: 'all',
        width: '100%',
        language: 'ru-RU',
        licenseKey: 'non-commercial-and-evaluation',
        minSpareRows: 1,
        contextMenu: ['row_below', 'remove_row'],
    },

    init: function(el, options){
        let container = document.createElement('div');
        el.after(container);
        el.classList.add('d-none');
        this.table = new Handsontable(container, {
            ...this.commonOptions,
            ...options,
            data: el.value ? JSON.parse(el.value) : [],
            afterChange: function(changes){
                el.value = JSON.stringify(this.getSourceData());
            }
        })
        el.handsontable = this.table;
        let resizeObserver = new ResizeObserver(entries => {
            el.handsontable.refreshDimensions();
        });
        resizeObserver.observe(container);
    }
}

let doctor_education = document.getElementById('doctor_education');
doctor_education && mapper.init(doctor_education, {
    colHeaders: ['Год', 'Учреждение', 'Специальность'],
    dataSchema: {year: null, institution: null, specialty: null},
    columns: [
        {
            data: 'year',
            type: 'text',
        },
        {
            data: 'institution',
            type: 'text',
        },
        {
            data: 'cost',
            type: 'text',
        },
    ],
});

let doctor_additionalEducation = document.getElementById('doctor_additionalEducation');
doctor_additionalEducation && mapper.init(doctor_additionalEducation, {
    colHeaders: ['Год', 'Учреждение', 'Специальность'],
    dataSchema: {year: null, institution: null, specialty: null},
    columns: [
        {
            data: 'year',
            type: 'text',
        },
        {
            data: 'institution',
            type: 'text',
        },
        {
            data: 'cost',
            type: 'text',
        },
    ],
});
