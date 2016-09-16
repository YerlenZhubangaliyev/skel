var modules = require('../tasks-modules');

/**
 * Default task
 */
modules.gulp.task('default', ['clean'], function () {
    modules.runSequence(
        'sprite',
        'styles',
        'scripts',
        'images',
        'vendor-styles',
        'vendor-scripts'
    );
});
