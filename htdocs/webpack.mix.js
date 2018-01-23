let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');

mix.sass('resources/assets/sass/site_style.sass', 'public/css/styles.css');

mix.copy('node_modules/normalize.css/normalize.css', 'public/css/normalize.css');

mix.copy('node_modules/toastr/build/toastr.min.css', 'public/css/toastr.min.css')
    .copy('node_modules/toastr/build/toastr.min.js', 'public/js/toastr.min.js');

mix.copy('node_modules/swiper/dist/css/swiper.min.css', 'public/css/swiper.min.css')
    .copy('node_modules/swiper/dist/js/swiper.min.js', 'public/js/swiper.min.js');

mix.copy('resources/assets/css/bootstrap-datepicker.min.css', 'public/css')
    .copy('resources/assets/js/bootstrap-datepicker.min.js', 'public/js');

mix.js('resources/assets/js/main.js', 'public/js');