// webpack.mix.js

let mix = require('laravel-mix');

mix
    .setPublicPath('./public/assets')
    .js('resources/js/app.js', 'js')
    .sass('resources/scss/app.scss', 'css')
    .browserSync({
        proxy: 'localhost/myapp', // Set to your "localhost/folder" or virtual host "myvhost.local"
        files: [
            './**/*.html',
            './**/*.php',
            './resources'
        ]
    });