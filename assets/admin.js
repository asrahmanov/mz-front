import './bootstrap';
import jQuery from 'jquery';
import 'admin-lte';
import 'admin-lte/dist/css/adminlte.css';
import 'admin-lte/plugins/bootstrap/js/bootstrap'
import 'admin-lte/plugins/fontawesome-free/css/all.css';
import 'admin-lte/plugins/select2/css/select2.min.css';
import 'admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.css';
import 'admin-lte/plugins/select2/js/select2.full';
import 'admin-lte/plugins/select2/js/i18n/ru';
import 'admin-lte/plugins/daterangepicker';
import 'admin-lte/plugins/daterangepicker/daterangepicker.css';
import './field/slug';
import Vue from "vue";
import GeoCoords from "./components/GeoCoords";
import EntityList from "./components/EntityList";
import EntityListActions from "./components/EntityListActions";
import BranchesMainBlock from "./components/BranchesMainBlock";

window.$ = window.jQuery = jQuery;

import './admin.css';

document.querySelectorAll('.geo-coords').forEach(node => {
    new Vue({
        el: node,
        components: {
            GeoCoords,
        },
    });
});

document.querySelectorAll('.entity-list').forEach(node => {
    new Vue({
        el: node,
        components: {
            EntityList,
        },
    });
});

document.querySelectorAll('.branches-main-block').forEach(node => {
    new Vue({
        el: node,
        components: {
            BranchesMainBlock,
        },
        render(createElement, context) {
           return  createElement('branches-main-block', {'field-name': 'test_name'});
        }
    });
});
