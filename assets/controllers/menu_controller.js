import { Controller } from 'stimulus';
import Vue from 'vue/dist/vue.min';
import MenuEditor from '../components/MenuEditor';
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/ru-RU'
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(ElementUI, { locale })


export default class extends Controller {
    connect() {
        new Vue({
            delimiters: ['${', '}'],
            el: this.element.querySelector('.app'),
            components: {
                MenuEditor,
            }
        });
    }
}
