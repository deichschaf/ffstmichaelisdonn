const mix = require('laravel-mix');

mix.js('./resources/js/app.js', './public/js')
    .js('./resources/js/index.js', './public/js')
    .sass('./resources/sass/app.scss', './public/css');
mix.version();