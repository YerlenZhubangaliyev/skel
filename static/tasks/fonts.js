'use strict';

var
    modules = require('../tasks-modules'),
    fs      = require('fs-extra');

/**
 * Copy fonts
 */
modules.gulp.task('fonts', function () {
    fs.copy(modules.config.paths.src.fonts, modules.config.paths.dest.fonts, function (err) {
        if (err) {
            console.error(err);
        }
    });
});
