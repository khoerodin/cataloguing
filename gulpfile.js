const elixir    = require('laravel-elixir');
var gulp        = require('gulp'); 
var htmlmin     = require('gulp-htmlmin');
var path        = require('path');
var wrap        = require('gulp-wrap');
var declare     = require('gulp-declare');
var concat      = require('gulp-concat');
var merge       = require('merge-stream');
var handlebars  = require('gulp-handlebars');

elixir.config.sourcemaps = false;
elixir.config.production = true;

elixir.extend('templates', function(message) {

    // Source:
    // https://github.com/lazd/gulp-handlebars/tree/master/examples/partials

    // Home
    new elixir.Task('home', function() {
        gulp.task('home', function() {

            var partials = gulp.src(['resources/templates/home/*.html'])
                .pipe(handlebars())
                .pipe(wrap('Handlebars.registerPartial(<%= processPartialName(file.relative) %>, Handlebars.template(<%= contents %>));', {}, {
                    imports: {
                        processPartialName: function(fileName) {
                          return JSON.stringify(path.basename(fileName, '.js').substr(1));
                        }
                    }
                }));

            var templates = gulp.src('resources/templates/home/*.html')
                .pipe(handlebars())
                .pipe(wrap('Handlebars.template(<%= contents %>)'))
                .pipe(declare({
                    namespace: 'Home.templates',
                    noRedeclare: true
                }));

            return merge(partials, templates)
                .pipe(concat('home.js'))
                .pipe(gulp.dest('resources/assets/js/handlebars-templates'));

        });
    });

    // Dictionary
    new elixir.Task('dictionary', function() {
        gulp.task('dictionary', function() {

            var partials = gulp.src(['resources/templates/dictionary/*.html'])
                .pipe(handlebars())
                .pipe(wrap('Handlebars.registerPartial(<%= processPartialName(file.relative) %>, Handlebars.template(<%= contents %>));', {}, {
                    imports: {
                        processPartialName: function(fileName) {
                          return JSON.stringify(path.basename(fileName, '.js').substr(1));
                        }
                    }
                }));

            var templates = gulp.src('resources/templates/dictionary/*.html')
                .pipe(handlebars())
                .pipe(wrap('Handlebars.template(<%= contents %>)'))
                .pipe(declare({
                    namespace: 'Dictionary.templates',
                    noRedeclare: true
                }));

            return merge(partials, templates)
                .pipe(concat('dictionary.js'))
                .pipe(gulp.dest('resources/assets/js/handlebars-templates'));

        });
    });

    // Settings
    new elixir.Task('settings', function() {
        gulp.task('settings', function() {

            var partials = gulp.src(['resources/templates/settings/*.html'])
                .pipe(handlebars())
                .pipe(wrap('Handlebars.registerPartial(<%= processPartialName(file.relative) %>, Handlebars.template(<%= contents %>));', {}, {
                    imports: {
                        processPartialName: function(fileName) {
                          return JSON.stringify(path.basename(fileName, '.js').substr(1));
                        }
                    }
                }));

            var templates = gulp.src('resources/templates/settings/*.html')
                .pipe(handlebars())
                .pipe(wrap('Handlebars.template(<%= contents %>)'))
                .pipe(declare({
                    namespace: 'Settings.templates',
                    noRedeclare: true
                }));

            return merge(partials, templates)
                .pipe(concat('settings.js'))
                .pipe(gulp.dest('resources/assets/js/handlebars-templates'));

        });
    });
});

elixir(function(mix) {
    mix.templates();
});

elixir(function(mix) {
    // HOME
    mix.scripts([
        // libraries
        'libraries/jquery.min.js',
        'libraries/bootstrap.min.js',
        'libraries/jquery-ui.js',
        'libraries/jquery.dataTables.min.js',
        'libraries/dataTables.bootstrap.min.js',
        'libraries/bootstrap-select.min.js',
        'libraries/ajax-bootstrap-select.min.js',
        'libraries/bootbox.min.js',        
        'libraries/dataTables.colResize.js',
        'libraries/handlebars.runtime.3.0.3.min.js',

        // hashids
        './node_modules/hashids/dist/hashids.min.js',

        // global script for all pages
        'libraries/global-script.js',

        // handlebars
        'handlebars-templates/home.js',        

        // scripts template
        './resources/templates/home/scripts.js'
    ], 'public/js/home.js');

    // DICTIONARY
    mix.scripts([
        // libraries
        'libraries/jquery.min.js',
        'libraries/bootstrap.min.js',
        'libraries/jquery.dataTables.min.js',
        'libraries/dataTables.bootstrap.min.js',
        'libraries/bootstrap-select.min.js',
        'libraries/ajax-bootstrap-select.min.js',
        'libraries/bootbox.min.js',
        'libraries/BootstrapMenu.min.js',
        'libraries/handlebars.runtime.3.0.3.min.js',

        // hashids
        './node_modules/hashids/dist/hashids.min.js',

        // global script for all pages
        'libraries/global-script.js',

        // handlebars
        'handlebars-templates/dictionary.js',

        // scripts template
        './resources/templates/dictionary/scripts.js'
    ], 'public/js/dictionary.js');

    // SETTINGS
    mix.scripts([
        // libraries
        'libraries/jquery.min.js',
        'libraries/bootstrap.min.js',
        'libraries/jquery-ui.js',
        'libraries/jquery.dataTables.min.js',
        'libraries/dataTables.bootstrap.min.js',
        'libraries/bootstrap-select.min.js',
        'libraries/ajax-bootstrap-select.min.js',
        'libraries/bootbox.min.js',
        'libraries/BootstrapMenu.min.js',        
        'libraries/handlebars.runtime.3.0.3.min.js',

        // hashids
        './node_modules/hashids/dist/hashids.min.js',
        
        // global script for all pages
        'libraries/global-script.js',

        // handlebars
        'handlebars-templates/settings.js',

        // scripts template
        './resources/templates/settings/scripts.js'
    ], 'public/js/settings.js');
});

elixir(function(mix) {
    // mix.sass('app.scss', './resources/assets/css/mybootstrap.css');
    // GLOBAL
    mix.styles([
        'theme.css',
        'styles.css',
        'animate.css',
        'jquery-ui.css',
        'dataTables.bootstrap.min_old.css',
        'bootstrap-select.css',
        'ajax-bootstrap-select.css',
        'awesome-bootstrap-checkbox.css',
    ], 'public/css/styles.css');

    // LOGIN - REGISTER
    mix.styles([
        'mybootstrap.css',
        'styles.css'
    ], 'public/css/login.css');
});

/*elixir(function(mix) {
    mix.version([
        'css/styles.css',
        'css/login.css',
        'js/home.js',
        'js/dictionary.js',
        'js/settings.js',
    ]);
});*/

/*elixir.extend('compressHtml', function(message) {
    new elixir.Task('compressHtml', function() {
        const opts = {
             collapseWhitespace: true,
             removeAttributeQuotes: true,
             removeComments: true, 
             minifyJS: true
       };
       return gulp.src('./storage/framework/views/*')
       .pipe(htmlmin(opts))
       .pipe(gulp.dest('./storage/framework/views/')) })
       .watch('./storage/framework/views/*')
});

elixir(function(mix) {
    mix.compressHtml();
});*/