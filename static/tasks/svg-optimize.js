'use strict';

var
    modules = require('../tasks-modules')
    ;

/**
 * Optimize svg in source
 */
modules.gulp.task('svg-optimize', function () {
    modules.gulp.src(modules.config.paths.src.noSpriteSvgImg)
        .pipe(modules.svgMin({
            plugins: [
                {
                    collapseGroups: true
                },
                {
                    removeXMLProcInst: false
                }
            ]
        }))
        .pipe(modules.gulp.dest(modules.config.paths.src.noSpriteImg))
    ;
});
