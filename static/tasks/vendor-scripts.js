'use strict';

var modules = require('../tasks-modules');

/**
 * Компиляция JS скриптов
 */
modules.gulp.task('vendor-scripts', function () {
    modules.scriptsBuild(modules.config.paths.src.vendorJsFiles, true)
});
