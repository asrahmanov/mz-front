import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';

$('.cropper-field').each((i, el) => {
    let input = $('input[type=file]', el);
    let cropperImg = $('.cropper-field__cropper', el);
    let valueField = $('[type=hidden]', el);
    let save = $('.save', el);
    let remove = $('.delete', el);
    let modalOpener = $('.modal-opener', el);
    let modal = $('.modal', el);
    let preview = $('.cropper-field__preview', el);
    let cropper;

    modalOpener.on('click', () => {
        input.click();
    });

    input.on('change', inputChangeEv => {
        if (inputChangeEv.currentTarget.files && inputChangeEv.currentTarget.files[0]) {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            cropperImg.removeClass('d-none');
            let reader = new FileReader();
            reader.onload = e => {
                cropperImg.attr('src', e.target.result);
                cropper = new Cropper(cropperImg[0], {
                        autoCrop: true,
                        viewMode: 2,
                        ready: () => {
                            cropper.setCropBoxData({ height: cropper.getContainerData().height, width: cropper.getContainerData().width  })
                        },
                    },
                );
            }
            reader.readAsDataURL(inputChangeEv.currentTarget.files[0]);
        }
    });

    save.on('click', () => {
        cropperImg[0].cropper.getCroppedCanvas().toBlob((blob) => {
            const formData = new FormData();
            formData.append('croppedImage', blob, 'cropped.jpeg');
            $.ajax('/admin/file', {
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: r => {
                    valueField.val(r.path);
                    preview.attr('src', r.path);
                    preview.removeClass('d-none');
                    modal.modal('hide');
                },
                error() {
                    console.log('Upload error');
                },
            });
        }/*, 'image/png' */);
    });

    remove.on('click', () => {
        input.val('');
    })
})
