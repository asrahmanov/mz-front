import { Controller } from 'stimulus'
import Vue from 'vue/dist/vue.min';
import GeoCoords from "../components/GeoCoords";

export default class extends Controller {
    static value = { opts: Object }

    connect() {
        const root = document.createElement('div');
        root.appendChild(document.createElement('geo-coords'));
        this.element.appendChild(root);
        new Vue({
            el: root,
            components: {
                GeoCoords,
            },
            mounted() {

            }
        })
    }
}
