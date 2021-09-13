const mix = require('laravel-mix');
require('laravel-mix-blade-reload');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .vue({version : 3})
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss"),
    ])
    .webpackConfig({
        devServer : {
            allowedHosts : ['docs.envuso.test']
        }
    })
    .bladeReload()
    .disableNotifications();

mix.babelConfig({
    plugins : [
        [
            "prismjs", {
            "languages" : ["json", "shell", "typescript", "javascript"],
            "plugins"   : ["line-numbers", "line-highlight", "autolinker", "show-language", "copy-to-clipboard", "normalize-whitespace"],
            "theme"     : "./prism/themes/prism-material-oceanic.css",
            "css"       : true
        }
        ]
    ]
});

if (mix.inProduction()) {
    mix.version();
}
