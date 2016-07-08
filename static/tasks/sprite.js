'use strict';

var modules = require('../tasks-modules');

/**
 * Генерация SVG спрайта
 */
modules.gulp.task('sprite', function () {
    var spriteConfig = {
        mode: {
            css: {
                spacing: {
                    padding: 0,
                    box             : 'content'
                },
                layout: "diagonal",
                bust:   false,
                render: {
                    scss: {
                        dest:     modules.config.paths.dest.spriteScssFile,
                        template: modules.config.paths.src.spriteTemplate
                    }
                },
                sprite: modules.config.paths.dest.spriteSvgFile,
                dest:   './'
            },
            svg                     : {
                xmlDeclaration      : true,
                doctypeDeclaration  : true,
                namespaceIDs        : true,
                dimensionAttributes : true
            },
            "transform": ["svgo"]
        }
    };

    return modules.gulp.src([modules.config.paths.src.svgFiles])
        .pipe(modules.plumber({
            errorHandler: modules.config.onError
        }))
        .pipe(modules.svgSprite(spriteConfig))
        .pipe(modules.gulp.dest(modules.config.paths.dest.spriteScssOutput));
});
