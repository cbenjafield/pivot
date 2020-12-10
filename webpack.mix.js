const mix = require('laravel-mix');
const tailwind = require('tailwindcss');
require('laravel-mix-purgecss');

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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/site.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/site.scss', 'public/css')
    .sass('resources/themes/jda/scss/theme.scss', 'public/themes/jda/css')
    .options({
        processCssUrls: false,
        postCss: [
            tailwind('./tailwind.config.js'),
        ]
    });
