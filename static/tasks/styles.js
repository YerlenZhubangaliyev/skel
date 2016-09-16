'use strict';

var modules = require('../tasks-modules');

/**
 * Scss compilation
 */
modules.gulp.task('styles', function () {
    return modules.gulp.src([
        modules.config.paths.src.scssFiles,
        '!' + modules.config.paths.src.vendorScssFiles
    ])
        .pipe(modules.plumber({
            errorHandler: modules.config.onError
        }))
        .pipe(modules.sass({
            includePaths: modules.config.paths.sass.includePath
        }))
        .pipe(modules.gulpIf(modules.config.isDebug, modules.sourceMap.init()))
        .pipe(modules.gulpIf(!modules.config.isDebug, modules.cssNano()))
        .pipe(modules.gulpIf(modules.config.isDebug, modules.sourceMap.write()))
        .pipe(modules.gulp.dest(modules.config.paths.dest.css));
});
