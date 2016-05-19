var elixir = require('laravel-elixir');

//require('laravel-elixir-vueify');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    //mix.browserify('main.js');
    mix.styles([
        'bootstrap.min.css',
        'font-awesome.min.css',
        'jquery.Jcrop.css',
        'select2.min.css',
        'sweet-alert.css'
    ]).version('css/all.css');

    mix.scripts([
        'jquery.min.js',
        'vue.min.js',
        'bootstrap.min.js',
        'vue-resource.min.js',
        'jquery.form.js',
        'jquery.Jcrop.min.js',
        'sweet-alert.min.js',
        'select2.full.min.js'
    ]);
});
