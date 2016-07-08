'use strict';

var modules = require('../tasks-modules');

/**
 * Генерирует favicons
 */
modules.gulp.task('favicons', ['cleanFaviconTemplate'], function () {
    return modules.gulp.src(modules.config.paths.src.favicon).pipe(modules.favicons({
            appName:        modules.config.app,
            appDescription: "",
            developerName:  "",
            developerURL:   "",
            background:     "#fff",
            path:           modules.config.paths.dest.faviconsUrlPath,
            url:            "",
            display:        "standalone",
            orientation:    "portrait",
            version:        1.0,
            logging:        false,
            online:         false,
            html:           modules.config.paths.src.faviconsTemplate,
            pipeHTML:       false,
            replace:        false
        }))
        .on("error", function (e) {
            console.log(e)
        })
        .pipe(modules.gulp.dest(modules.config.paths.dest.favicons));
});
