const autoprefixer     = require('gulp-autoprefixer'),
    babelify           = require('babelify'),
    browserify         = require('browserify'),
    buffer             = require('vinyl-buffer'),
    cleanCss           = require('gulp-clean-css'),
    cssNano            = require('gulp-cssnano'),
    connectHistory     = require('connect-history-api-fallback'),
    gulp               = require('gulp'),
    historyApiFallback = require('connect-history-api-fallback'),
    minify             = require('gulp-minify'),
    rename             = require('gulp-rename'),
    uglify             = require('gulp-uglify'),
    replace            = require('gulp-replace'),
    sass               = require('gulp-sass'),
    source             = require('vinyl-source-stream'),
    sourcemaps         = require('gulp-sourcemaps');

const settings = {
  js: {
    src: 'src/js',
    entry: 'main.js',
    output: 'bundle.min.js',
    dest: 'public/js',
  },
  css: {
    src: 'src/scss',
    dest: 'public/css',
  },
};

/**
 * @task browserify
 * Handles javascript compilation
 */
gulp.task('js', () => {
  return browserify({
    entries: `${settings.js.src}/${settings.js.entry}`,
    debug: true
  })
  .transform(babelify, {
    presets: [
      [
        'env', {
          targets: {
            browsers: ['last 2 versions', 'safari >= 7']
          }
        }
      ]
    ]
  })
  .bundle()
  .pipe(source(settings.js.entry))
  .pipe(buffer())
  .pipe(sourcemaps.init({loadMaps: true}))
  .pipe(uglify())
  .pipe(rename(`./${settings.js.output}`))
  .pipe(sourcemaps.write())
  .pipe(gulp.dest(settings.js.dest))
  .pipe(browserSync.reload({stream: true}))
});

/**
 * @task scss
 * Handles scss compilation
 */
gulp.task('scss', () => {
  return gulp
    .src(settings.css.src + '/**/*.scss')
    .pipe(sass())
    .pipe(autoprefixer('last 2 version', '> 1%', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(cleanCss({ compatibility: 'ie8' }))
    .pipe(minify())
    .pipe(gulp.dest(settings.css.dest))
    .pipe(browserSync.reload({ stream: true }));
});

/**
 * @task watch
 */
gulp.task('watch', () => {
  gulp.watch(settings.js.src + '/**/*.js', ['js']);
  gulp.watch(settings.css.src + '/**/*.scss', ['scss']);
});

/**
 * @task default
 */
gulp.task('default', ['watch']);

/**
 * @task build
 */
gulp.task('build', ['scss', 'js']);