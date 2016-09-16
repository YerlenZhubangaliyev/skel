'use strict';

var modules = require('../tasks-modules');

/**
 * Javascript compiling
 */
modules.gulp.task('scripts', function () {
    modules.scriptsBuild(modules.config.paths.src.jsFiles, false)
});
