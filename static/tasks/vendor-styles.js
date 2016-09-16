'use strict';

var modules = require('../tasks-modules');

/**
 * Scss vendor styles compilations
 */
modules.gulp.task('vendor-styles', function () {
    return modules.gulp.src([modules.config.paths.src.vendorScssFiles])
        .pipe(modules.plumber({
            errorHandler: modules.config.onError
        }))
        .pipe(modules.sass({
            includePaths: modules.config.paths.sass.includePath
        }))
        .pipe(modules.gulp.dest(modules.config.paths.dest.css));
});
