'use strict';

var modules = require('../tasks-modules');

/**
 * Javascript vendor libs compilation
 */
modules.gulp.task('vendor-scripts', function () {
    modules.scriptsBuild(modules.config.paths.src.vendorJsFiles, true)
});
