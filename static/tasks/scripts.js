'use strict';

var modules = require('../tasks-modules');

/**
 * Компиляция JS скриптов
 */
modules.gulp.task('scripts', function () {
    modules.scriptsBuild(modules.config.paths.src.jsFiles, false)
});
