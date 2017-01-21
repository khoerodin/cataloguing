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

    // Tools
    new elixir.Task('tools', function() {
        gulp.task('tools', function() {

            var partials = gulp.src(['resources/templates/tools/*.html'])
                .pipe(handlebars())
                .pipe(wrap('Handlebars.registerPartial(<%= processPartialName(file.relative) %>, Handlebars.template(<%= contents %>));', {}, {
                    imports: {
                        processPartialName: function(fileName) {
                          return JSON.stringify(path.basename(fileName, '.js').substr(1));
                        }
                    }
                }));

            var templates = gulp.src('resources/templates/tools/*.html')
                .pipe(handlebars())
                .pipe(wrap('Handlebars.template(<%= contents %>)'))
                .pipe(declare({
                    namespace: 'Tools.templates',
                    noRedeclare: true
                }));

            return merge(partials, templates)
                .pipe(concat('tools.js'))
                .pipe(gulp.dest('resources/assets/js/handlebars-templates'));

        });
    });

    // Accounts
    new elixir.Task('accounts', function() {
        gulp.task('accounts', function() {

            var partials = gulp.src(['resources/templates/accounts/*.html'])
                .pipe(handlebars())
                .pipe(wrap('Handlebars.registerPartial(<%= processPartialName(file.relative) %>, Handlebars.template(<%= contents %>));', {}, {
                    imports: {
                        processPartialName: function(fileName) {
                          return JSON.stringify(path.basename(fileName, '.js').substr(1));
                        }
                    }
                }));

            var templates = gulp.src('resources/templates/accounts/*.html')
                .pipe(handlebars())
                .pipe(wrap('Handlebars.template(<%= contents %>)'))
                .pipe(declare({
                    namespace: 'Accounts.templates',
                    noRedeclare: true
                }));

            return merge(partials, templates)
                .pipe(concat('accounts.js'))
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
        'libraries/bootstrap3-typeahead_edited.js',
        'libraries/jquery-ui.js',
        'libraries/jquery.dataTables.min.js',
        'libraries/dataTables.bootstrap.min.js',
        'libraries/bootstrap-select.min.js',
        'libraries/ajax-bootstrap-select.min.js',
        'libraries/bootbox.min.js',        
        'libraries/dataTables.colResize.js',
        'libraries/selectize.min.js',
        'libraries/handlebars.runtime.3.0.3.min.js',

        // hashids
        './node_modules/hashids/dist/hashids.min.js',

        // global script for all pages
        'libraries/global-script.js',

        // handlebars
        'handlebars-templates/home.js',        

        // scripts template
        './resources/templates/home/scripts.js',
        // global script on footer
        'libraries/global-footer.js',
    ], 'public/js/h.js');

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
        './resources/templates/dictionary/scripts.js',
        // global script on footer
        'libraries/global-footer.js',
    ], 'public/js/d.js');

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
        './resources/templates/settings/scripts.js',
        // global script on footer
        'libraries/global-footer.js',
    ], 'public/js/s.js');

    // TOOLS
    mix.scripts([
        // libraries
        'libraries/jquery.min.js',
        'libraries/bootstrap.min.js',
        'libraries/jquery.dataTables.min.js',
        'libraries/dataTables.bootstrap.min.js',
        'libraries/dataTables.colResize.js',
        'libraries/jquery.form.js',
        'libraries/bootstrap-select.min.js',
        'libraries/fuelux.min.js',
        'libraries/handlebars.runtime.3.0.3.min.js',

        // hashids
        './node_modules/hashids/dist/hashids.min.js',
        
        // global script for all pages
        'libraries/global-script.js',

        // handlebars
        'handlebars-templates/tools.js',

        // scripts template
        './resources/templates/tools/scripts.js',
        'libraries/bootstrap-filestyle.min.js',
        // global script on footer
        'libraries/global-footer.js',
    ], 'public/js/t.js');

    // ACCOUNTS
    mix.scripts([
        // libraries
        'libraries/jquery.min.js',
        'libraries/bootstrap.min.js',
        'libraries/jquery.dataTables.min.js',
        'libraries/dataTables.bootstrap.min.js',
        'libraries/dataTables.colResize.js',
        'libraries/jquery.form.js',
        'libraries/bootstrap-select.min.js',
        'libraries/fuelux.min.js',
        'libraries/handlebars.runtime.3.0.3.min.js',

        // hashids
        './node_modules/hashids/dist/hashids.min.js',
        
        // global script for all pages
        'libraries/global-script.js',

        // handlebars
        'handlebars-templates/accounts.js',

        // scripts template
        './resources/templates/accounts/scripts.js',
        // global script on footer
        'libraries/global-footer.js',
    ], 'public/js/a.js');
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
        'font-awesome.min.css',
        'awesome-bootstrap-checkbox.css',
        'selectize.css',
        'selectize.bootstrap3.css',
    ], 'public/css/s.css');

    // LOGIN - REGISTER
    mix.styles([
        'mybootstrap.css',
        'styles.css'
    ], 'public/css/l.css');
});

elixir(function(mix) {
    mix.version([
        'public/css/s.css',
        'public/css/l.css',

        'public/js/h.js',
        'public/js/d.js',
        'public/js/s.js',
        'public/js/t.js',
        'public/js/a.js',
    ]);
});