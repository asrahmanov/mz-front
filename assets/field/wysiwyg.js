import config from "../config/admin-config";

document.addEventListener('DOMContentLoaded', function(){
    tinymce.init({
        selector: 'textarea.wysiwyg',
        plugins: [
            'table',
            'image',
            'imagetools',
            'code',
            'fullscreen',
        ],
        language: 'ru',
        content_css: '/css/main.css',
        branding: false,
        images_upload_url: config.TINYMCE_UPLOAD_URL,
        automatic_uploads: true,
        file_picker_types: 'file image media',
        height: 300,
    });
});
