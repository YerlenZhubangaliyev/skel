'use strict';

var
    args            = require('yargs'),
    argv            = args.argv,
    appName         = argv.app,
    moduleName      = argv.mod,
    defaultEnv      = 'development',
    env             = argv.env || defaultEnv,
    dirName         = __dirname,
    isProduction    = (env === 'local') ? false : true,
    isDebug         = (isProduction) ? false : true,
    appSrcDir       = '../../static/application/' + appName + '/' + moduleName + '/',
    appDestDir      = '../../public_html/static/' + appName + '/' + moduleName + '/',
    appCommonSrcDir = '../../static/application/common/',
    config          = {
        app:          appName,
        paths:        {
            src:  {
                scss:              appSrcDir + 'src/scss',
                scssFiles:         appSrcDir + 'src/scss/**/*.scss',
                vendorScssFiles:   appSrcDir + 'src/scss/vendor.scss',
                commonScssFiles:   appCommonSrcDir + 'src/scss/**/*.scss',
                jsFiles:           [appSrcDir + 'src/js/main.js'],
                vendorJsFiles:     [appSrcDir + 'src/js/vendor.js'],
                jsFilesWatch:      [appSrcDir + 'src/js/**/*.js'],
                svgFiles:          appSrcDir + 'src/images/*.svg',
                noSpriteSvgImages: [appSrcDir + 'src/images/no-sprite/**/*'],
                noSpriteSvgImg:    [appSrcDir + 'src/images/no-sprite/**/*.svg'],
                noSpriteImg:       appSrcDir + 'src/images/no-sprite',
                faviconsTemplate:  '../../src/App/Applications/' +
                                   appName.charAt(0).toUpperCase() +
                                   appName.slice(1) + '/View/' +
                                   moduleName.charAt(0).toUpperCase() +
                                   moduleName.slice(1) +
                                   '/partials/favicons.volt',
                favicon:           appCommonSrcDir + 'src/images/favicon.png',
                fontDir:           './node_modules/materialize-css/font',
                spriteTemplate:    appSrcDir + 'src/scss/_spriteTemplate.tpl'
            },
            dest: {
                jsOutput:         appDestDir + '/js',
                spriteOutput:     appDestDir + '/img',
                spriteScssOutput: appSrcDir + 'src/scss/',
                noSpriteImg:      appDestDir + '/img/no-sprite',
                jsFiles:          appDestDir + '/**/*.js',
                css:              appDestDir + '/css',
                cssFiles:         appDestDir + '/css/**/*.css',
                favicons:         appDestDir + '/img/favicons/',
                faviconsUrlPath:  '/static/' + appName + '/' + moduleName + '/img/favicons/',
                fontDir:          appDestDir + '/font',
                spriteScssFile:   './_sprite.scss',
                spriteSvgFile:    '../../../../../../public_html/static/' + appName + '/' + moduleName + '/img/sprite.svg'
            },
            tmp:  '.tmp',
            sass: {
                includePath: [
                    'node_modules/compass-mixins/lib'
                ]
            }
        },
        /**
         * Окружение
         */
        env:          env,
        /**
         * Вывод на экран ошибок
         *
         * @param error
         */
        onError:      function (error) {
            console.log([
                '',
                "---ERROR MESSAGE START---",
                ("[" + error.name + " in " + error.plugin + "]"),
                error.message,
                "---ERROR MESSAGE END---",
                ''
            ].join('\n'));

            this.emit("end");
        },
        /**
         * Текущая директория
         */
        dirname:      dirName,
        /**
         * Продакшн?
         */
        isProduction: isProduction,
        /**
         * Режим дебага?
         */
        isDebug:      isDebug
    },
    /**
     * Устанавливаем необходимые переменные в ENV
     */
    setEnv          = function () {
        process.env.LANG = "en_US.UTF-8";
        process.env.PATH = "~/bin:/usr/bin:/bin:/usr/local/bin";
    };

setEnv();

module.exports = config;
