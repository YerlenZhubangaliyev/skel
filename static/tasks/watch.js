'use strict';

var modules = require('../tasks-modules');

/**
 * Watcher
 */
modules.gulp.task('watch', function () {
    modules.gulp.watch(modules.config.paths.src.scssFiles, ['styles']);
    modules.gulp.watch(modules.config.paths.src.commonScssFiles, ['styles']);
    modules.gulp.watch(modules.config.paths.src.jsFilesWatch, ['scripts']);
    modules.gulp.watch(modules.config.paths.src.svgFiles, ['sprite']);
    modules.gulp.watch(modules.config.paths.src.noSpriteSvgImages, ['images']);
});
