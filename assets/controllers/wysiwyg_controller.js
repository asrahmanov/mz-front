import {Controller} from 'stimulus';
import 'tinymce';

export default class extends Controller {
    static values = {
        options: Object,
    };

    defaultOptions = {
        plugins: [
            'lists',
            'advlist',
            'table',
            'image',
            'imagetools',
            'media',
            'code',
            'fullscreen',
            'template',
            'paste',
            'codeeditor',
            'link',
            'newline',
        ],
        menubar: 'edit view insert format tools table',
        menu: {
            insert: {
                title: 'Insert',
                items: 'image link media template newline codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime'
            },
        },
        toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | codeeditor fullscreen',
        language: 'ru',
        branding: false,
        automatic_uploads: true,
        file_picker_types: 'file image media',
        height: 300,
        body_class: '_wysiwyg',
        end_container_on_empty_block: false,
        paste_as_text: true,
        content_style: "body {padding: 0 30px}",
        images_upload_url: '/admin/tinymce/upload',
        extended_valid_elements: 'span[*]',
        formats: {
            /*
            p: {block: "p", remove: "none", deep: true, split: true, merge_siblings: false},
            h1: {block: "p", classes: 'h1', remove: "none", deep: true, split: true, merge_siblings: false},
            h2: {block: "p", classes: 'h2', remove: "none", deep: true, split: true, merge_siblings: false},
            h3: {block: "p", classes: 'h3', remove: "none", deep: true, split: true, merge_siblings: false},
             */
            p: {block: "p", remove: "none"},
            h1: {block: "p", remove: "none", classes: 'h1', deep: true, split: true, merge_siblings: false},
            h2: {block: "p", remove: "none" , classes: 'h2',  deep: true, split: true, merge_siblings: false},
            h3: {block: "p", remove: "none" , classes: 'h3',  deep: true, split: true, merge_siblings: false},
            blockquote: {block: 'blockquote'},

            redbubble: {block: 'p', classes: 'branch-article__info _icon-info'},
        },
        style_formats: [
            {title: 'Красная выноска', format: 'redbubble'},
        ],
        style_formats_merge: true,
        templates: [
            {
                'title': 'Две адаптивные колонки', 'description': '',
                'content':
                    '<div class="row">' +
                        '<div class="col"><p>Колонка 1</p></div>' +
                        '<div class="col"><p>Колонка 2</p></div>' +
                    '</div>' +
                    '<p></p>'
            },
            {
                'title': 'Три адаптивные колонки', 'description': '',
                'content':
                    '<div class="row">' +
                        '<div class="col"><p>Колонка 1</p></div>' +
                        '<div class="col"><p>Колонка 2</p></div>' +
                        '<div class="col"><p>Колонка 3</p></div>' +
                    '</div>' +
                    '<p></p>'
            },
            {
                'title': '4 адаптивные колонки', 'description': '',
                'content':
                    '<div class="row">' +
                        '<div class="col"><p>Колонка 1</p></div>' +
                        '<div class="col"><p>Колонка 2</p></div>' +
                        '<div class="col"><p>Колонка 3</p></div>' +
                        '<div class="col"><p>Колонка 4</p></div>' +
                    '</div>' +
                    '<p></p>'
            },
            {"title": "Форма записи", 'description': '', "url": "/form/appointment"},
        ]
    }

    connect() {
        document.addEventListener('DOMContentLoaded', () => {
            tinymce.init({
                target: this.element,
                ...this.defaultOptions,
                ...this.optionsValue,
            });
        })
    }
}
