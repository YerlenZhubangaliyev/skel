'use strict';

var modules = require('../tasks-modules');

/**
 * Clean volt templates
 */
modules.gulp.task('cleanFaviconTemplate', function (cb) {
    modules.del([
        modules.config.paths.src.faviconsTemplate
    ], {force: true}, cb);
});
