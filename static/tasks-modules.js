'use strict';

var
    /**
     * Сборщик
     *
     * @type {Gulp|exports}
     */
    gulp           = require('gulp'),
    /**
     *
     * @type {Browserify|exports|module.exports}
     */
    browserify     = require('browserify'),
    /**
     * Модуль - удалятель
     *
     * @type {exports}
     */
    del            = require('del'),
    /**
     * Модуль для вывода ошибок (без остановки pipe)
     *
     * @type {plumber|exports}
     */
    plumber        = require('gulp-plumber'),
    /**
     * Модуль позволяет прописывать условия
     *
     * @type {exports}
     */
    gulpIf         = require('gulp-if'),
    /**
     * Минификатор JS
     *
     * @type {exports}
     */
    jsUglify       = require('gulp-uglify'),
    /**
     * CSS минификатор и оптимзатор
     */
    cssNano        = require('gulp-cssnano'),
    /**
     * Генерация CSS sourcemaps
     *
     * @type {exports}
     */
    sourceMap      = require('gulp-sourcemaps'),
    /**
     * Сборка SCSS
     *
     * @type {exports}
     */
    sass           = require('gulp-sass'),
    /**
     * Позволяет склеивать CSS через @import
     *
     * @type {exports}
     */
    cssImport      = require('gulp-cssimport'),
    /**
     *
     */
    cssInlineImage = require('gulp-css-inline-images'),
    /**
     * Позволяет выполнять таски последовательно
     *
     * @type {exports}
     */
    runSequence    = require('run-sequence'),
    /**
     * Общая конфигурация для задач
     *
     * @type {config|exports}
     */
    config         = require('./config'),
    /**
     *
     * @type {*|exports|module.exports}
     */
    through        = require('through2'),
    /**
     * Удаляет ненужные конструкции из кода (нужно в продакшн)
     *
     * @type {*|exports|module.exports}
     */
    stripify       = require('stripify'),
    /**
     * ES6 транспилер
     *
     * @type {Babelify|exports|module.exports}
     */
    babelify       = require('babelify'),
    /**
     * Шаблоны
     *
     * @type {combynify|exports|module.exports}
     */
    combynify      = require('combynify'),
    /**
     *
     */
    uglifyify      = require('uglifyify'),
    /**
     *
     */
    envify         = require('envify'),
    /**
     *
     * @type {*|exports|module.exports}
     */
    tap            = require('gulp-tap'),
    /**
     *
     * @type {*|exports|module.exports}
     */
    gutil          = require('gulp-util'),
    /**
     *
     */
    svgSprite      = require('gulp-svg-sprite'),
    /**
     * Optimize SVG images
     */
    svgMin         = require('gulp-svgmin'),
    /**
     *
     */
    favicons       = require('gulp-favicons'),
    /**
     * Компиляция скриптов
     *
     * @param files
     * @param forceUglify
     * @returns {*}
     */
    scriptsBuild   = function (files, forceUglify) {
        gulp.src(files)
            .pipe(plumber())
            .pipe(tap(
                function (file) {
                    var domain = require('domain').create();

                    domain.on("error",
                        function (err) {
                            gutil.log(gutil.colors.red("Browserify compile error:"), err.message, "\n\t", gutil.colors.cyan("in file"), file.path);
                            gutil.beep();
                        }
                    );
                    domain.run(function () {
                        file.contents = browserify({
                            entries: [file.path],
                            debug:   false
                        })
                        .transform(combynify)
                        //.transform(babelify, {presets: ["es2015", "react"]})
                            .bundle();
                    });
                }
            ))
            .pipe(gulp.dest(config.paths.dest.jsOutput));
    };

module.exports = {
    config:         config,
    gulp:           gulp,
    del:            del,
    plumber:        plumber,
    gulpIf:         gulpIf,
    jsUglify:       jsUglify,
    sass:           sass,
    cssImport:      cssImport,
    runSequence:    runSequence,
    cssNano:        cssNano,
    sourceMap:      sourceMap,
    cssInlineImage: cssInlineImage,
    svgSprite:      svgSprite,
    svgMin:         svgMin,
    favicons:       favicons,
    scriptsBuild:   scriptsBuild
};
