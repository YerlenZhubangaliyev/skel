'use strict';

var
    modules = require('../tasks-modules'),
    fs      = require('fs-extra');

/**
 * Копирование изображений (не спрайт)
 */
modules.gulp.task('images', ['svg-optimize'], function () {
    fs.copy(modules.config.paths.src.noSpriteImg, modules.config.paths.dest.noSpriteImg, function (err) {
        if (err) {
            console.error(err);
        }
    });
});
