import slugify from "slugify";

$('.slug').each(function (i, el){
    if (el.value) return;
    let target = el.dataset.target;
    if (target === 'undefined') return;
    target = document.querySelector(target);
    console.log('target', target);
    target.addEventListener('input', (e) => {
        el.value = slugify(e.target.value.toLowerCase());
    });
});
