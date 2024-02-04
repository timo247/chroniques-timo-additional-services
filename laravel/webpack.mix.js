const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/utils.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .styles(
        ["resources/css/custom.css", "resources/css/stars-rating.css"],
        "public/css/custom.css"
    )
    .sourceMaps();
