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

/* BOOTSTRAP, JQUERY */
mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');

/* TOASTR */
mix.copy('node_modules/toastr/build/toastr.min.css', 'public/css/toastr.min.css')
    .copy('node_modules/toastr/build/toastr.min.js', 'public/js/toastr.min.js');

/* SWIPER */
mix.copy('node_modules/swiper/dist/css/swiper.min.css', 'public/css/swiper.min.css')
    .copy('node_modules/swiper/dist/js/swiper.min.js', 'public/js/swiper.min.js');

/* DATEPICKER */
mix.copy('resources/assets/css/bootstrap-datepicker.min.css', 'public/css')
    .copy('resources/assets/js/bootstrap-datepicker.min.js', 'public/js');

/* IMAGES */
mix.copyDirectory('resources/assets/img-service', 'public/img-service');

/* SITE STYLES & SCRIPTS */
mix.sass('resources/assets/sass/spacing.sass', 'public/css/spacing.css')
    .sass('resources/assets/sass/site_style.sass', 'public/css/styles.css')
    .js('resources/assets/js/main.js', 'public/js')
    .copy('node_modules/normalize.css/normalize.css', 'public/css/normalize.css')
    .copy('resources/assets/js/functions.js', 'public/js');

/* ADMIN STYLES & SCRIPTS */
mix.sass('resources/assets/sass/admin_style.sass', 'public/css/admin/styles.css')
    .js('resources/assets/js/admin/main.js', 'public/js/admin')
    .js('resources/assets/js/admin/vue.settings.js', 'public/js/admin')
    .copy('resources/assets/js/admin/bootstrap-file.js', 'public/js/admin')
    .copy('resources/assets/js/admin/functions.js', 'public/js/admin');