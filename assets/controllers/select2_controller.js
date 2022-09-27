import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        let $el = $(this.element);
        if ($el.data('select2')) {
            console.log('true');
            $el.select2('destroy');
        }
        $el.select2({
            theme: 'bootstrap4',
            language: 'ru',
            width: '100%',
        });
    }
}
