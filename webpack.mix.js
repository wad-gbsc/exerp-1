let mix = require('laravel-mix');
var coreui_vendor = 'vendor/mrholek/CoreUI-Free-Bootstrap-Admin-Template/Vue_Full_Project';

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

// Copy over the CoreUI Assets initially
// mix.copyDirectory(coreui_vendor + '/static/img', 'public/static/img')
//    .copy(coreui_vendor + '/static/img/logo.png', 'resources/assets/img/logo.png')
//    .copyDirectory(coreui_vendor + '/scss', 'resources/assets/scss')
//    .copyDirectory(coreui_vendor + '/src/components', 'resources/assets/js/components')
//    .copyDirectory(coreui_vendor + '/src/containers', 'resources/assets/js/containers')
//    .copyDirectory(coreui_vendor + '/src/router', 'resources/assets/js/router')
//    .copyDirectory(coreui_vendor + '/src/views', 'resources/assets/js/views')
//    .copy(coreui_vendor + '/src/_nav.js', 'resources/assets/js/_nav.js')
//    .copy(coreui_vendor + '/src/App.vue', 'resources/assets/js/App.vue', false);

mix.js('resources/assets/js/app.js', 'public/js');

// mix.js('resources/assets/js/app.js', 'public/assets/js');

// mix.scripts([
//     'resources/assets/js/enum_gender_select.js',
//     'resources/assets/js/enum_title_select.js'
// ], 'public/assets/js/enum_select.js');


// mix.sass('resources/assets/sass/app.scss', '../resources/assets/css/sass.css');

// mix.styles([
//     'resources/assets/css/app.css',
//     'resources/assets/css/sass.css'
// ])