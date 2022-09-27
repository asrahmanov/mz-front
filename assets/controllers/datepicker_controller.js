import { Controller } from 'stimulus';
import datePicker from 'bootstrap-datepicker';
import 'bootstrap-datepicker/dist/locales/bootstrap-datepicker.ru.min';
import 'bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';

export default class extends Controller {

    static values = { opts: Object }

    connect() {
        let options = {
            maxViewMode: 2,
            language: "ru",
            multidateSeparator: ", ",
            forceParse: false,
            multidate: Boolean(this.element.dataset.multidate),
            ...this.optsValue
        }
        $(this.element).datepicker(options);
    }
}
