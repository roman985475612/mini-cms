const { src, dest, task, series, watch, parallel } = require('gulp')
const rm           = require('gulp-rm')
const sass         = require('gulp-sass')(require('sass'))
const concat       = require('gulp-concat')
const autoprefixer = require('gulp-autoprefixer')
const gcmq         = require('gulp-group-css-media-queries')
const cleanCss     = require('gulp-clean-css')
const sourcemaps   = require('gulp-sourcemaps')
const babel        = require('gulp-babel')
const uglify       = require('gulp-uglify')
const svgo         = require('gulp-svgo')
const svgSprite    = require('gulp-svg-sprite')
const gulpIf       = require('gulp-if')
const webp         = require('gulp-webp')
const imagemin     = require('gulp-imagemin')
const env          = process.env.NODE_ENV
    
const SRC_PATH_ADMIN = 'resources/admin'
const DIST_PATH_ADMIN = 'public/assets/admin'
const STYLEs_LIBS_ADMIN = []
const JS_LIBS_ADMIN = [
    './node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
    './node_modules/@ckeditor/ckeditor5-build-classic/build/ckeditor.js'
]

task('clean:admin', () => {
    return src([
        `${DIST_PATH_ADMIN}/**/*`, 
        `!${DIST_PATH_ADMIN}/img/**/*`,
        `!${DIST_PATH_ADMIN}/fonts/**/*`,
        `!${DIST_PATH_ADMIN}/icons/**/*`,
        `!${DIST_PATH_ADMIN}/svg/**/*`,
    ], {read: false})
        .pipe(rm())
})

task('clean:all:admin', () => {
    return src([
        `${DIST_PATH_ADMIN}/**/*`
    ], {read: false})
        .pipe(rm())
})

task('copy:fonts:admin', () => {
    return src(`${SRC_PATH_ADMIN}/fonts/**/*`)
        .pipe(dest(`${DIST_PATH_ADMIN}/fonts`))
})

task('copy:icons:admin', () => {
    return src(`${SRC_PATH_ADMIN}/icons/**/*`)
        .pipe(dest(`${DIST_PATH_ADMIN}/icons`))
})

task('copy:css:admin', () => {
    return src([...STYLEs_LIBS_ADMIN])
        .pipe(dest(`${DIST_PATH_ADMIN}/css`))
})

task('scss:admin', () => {
    return src(`${SRC_PATH_ADMIN}/scss/style.scss`)
        .pipe(gulpIf(env === 'dev', sourcemaps.init()))
        .pipe(concat('style.min.scss'))
        .pipe(sass().on('error', sass.logError))
        .pipe(gulpIf(env === 'prod', autoprefixer({
            browsers: ['last 2 versions'],
            cascade: true
        })))
        .pipe(gulpIf(env === 'prod', gcmq()))
        .pipe(gulpIf(env === 'prod', cleanCss()))
        .pipe(gulpIf(env === 'dev', sourcemaps.write()))
        .pipe(dest(`${DIST_PATH_ADMIN}/css`))
})

task('copy:js:admin', () => {
    return src([...JS_LIBS_ADMIN])
        .pipe(dest(`${DIST_PATH_ADMIN}/js`))
})

task('js:admin', () => {
    return src(`${SRC_PATH_ADMIN}/js/*.js`)
        .pipe(gulpIf(env === 'dev', sourcemaps.init()))
        .pipe(concat('main.min.js', {newLine: ';'}))
        // .pipe(gulpIf(env === 'prod', babel({
        //     presets: ["@babel/env"]
        // })))
        .pipe(gulpIf(env === 'prod', uglify()))
        .pipe(gulpIf(env === 'dev', sourcemaps.write()))
        .pipe(dest(`${DIST_PATH_ADMIN}/js`))
})

task('img:min', () => {
    return src('resources/img/**/*.{png,jpg,jpeg}')
        .pipe(imagemin())
        .pipe(dest('public/assets/img'))
})

task('img:webp', () => {
    return src('resources/img/**/*.{png,jpg,jpeg}')
        .pipe(webp())
        .pipe(dest('public/assets/img'))
})

task('img:svg:admin', () => {
    return src(`${SRC_PATH_ADMIN}/svg/*.svg`)
        .pipe(svgo({
            plugins: [
                {
                    removeAttrs: {
                        attrs: "(fill|stroke|style|width|data.*)"
                    }
                }
            ]
        }))
        .pipe(svgSprite({
            mode: {
                symbol: {
                    sprite: "../sprite.svg"
                }
            }
        }))
        .pipe(dest(`${DIST_PATH_ADMIN}/icons`))
})

task('watch:admin', () => {
    watch(`./${SRC_PATH_ADMIN}/scss/**/*.scss`, series('scss:admin'))
    watch(`./${SRC_PATH_ADMIN}/js/**/*.js`, series('js:admin'))
})

task('default:admin', 
    series(
        'clean:admin', 
        parallel(
            'scss:admin', 
            'js:admin', 
            'copy:js:admin'
        ), 
        parallel('watch:admin')
    )
)

task('build:admin', 
    series(
        'clean:admin', 
        parallel(
            'scss:admin', 
            'js:admin', 
            'img:min', 
            'img:webp',
            'copy:js:admin',
            'copy:fonts:admin', 
            'copy:icons:admin' 
        )
    ) 
)
