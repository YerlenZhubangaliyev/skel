var modules = require('../tasks-modules');

/**
 * Таск по-умолчанию
 */
modules.gulp.task('default', ['clean'], function () {
    modules.runSequence(
        'sprite',
        'styles',
        'scripts',
        'favicons',
        'images',
        'vendor-styles',
        'vendor-scripts'
    );
});
