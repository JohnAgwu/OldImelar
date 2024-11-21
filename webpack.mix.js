const mix = require('laravel-mix');

mix
    .js('resources/js/add-product.js', 'public/assets/js/business')
    .js('resources/js/add-project.js', 'public/assets/js/business')
    .js('resources/js/edit-product.js', 'public/assets/js/business')
    .js('resources/js/edit-project.js', 'public/assets/js/business')
    .js('resources/js/send-invoice.js', 'public/assets/js/business')
    .js('resources/js/edit-invoice.js', 'public/assets/js/business')
    .js('resources/js/edit-business.js', 'public/assets/js/business')
    .js('resources/js/add-business.js', 'public/assets/js/business');
    // .sass('resources/sass/app.scss', 'public/css');
