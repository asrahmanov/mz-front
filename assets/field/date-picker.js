import 'bootstrap-datepicker';
import 'bootstrap-datepicker/dist/locales/bootstrap-datepicker.ru.min';
import 'bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';
$('.date-picker').datepicker({
    maxViewMode: 2,
    language: "ru",
    multidateSeparator: ",",
    forceParse: false
});
