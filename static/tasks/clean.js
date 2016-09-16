'use strict';

var modules = require('../tasks-modules');

/**
 * Clean task
 */
modules.gulp.task('clean', function (cb) {
    modules.del([
        modules.config.paths.dest.jsFiles,
        modules.config.paths.dest.cssFiles
    ], {force: true}, cb);
});
