'use strict';

var modules = require('../tasks-modules');

/**
 * Очистка сбилденных файлов
 */
modules.gulp.task('clean', function (cb) {
    modules.del([
        modules.config.paths.dest.jsFiles,
        modules.config.paths.dest.cssFiles
    ], {force: true}, cb);
});
