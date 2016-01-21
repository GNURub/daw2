'use strict';
var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifycss = require('gulp-minify-css');
var rename = require('gulp-rename');

gulp.task('sass', function () {
  return gulp.src('./public/scss/*.scss')
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
		.pipe(autoprefixer({}))
    .pipe(gulp.dest('./public/css/'))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .pipe(gulp.dest('./public/css/'));
});

gulp.task('default', function () {
  gulp.watch('./public/scss/**/*.scss', ['sass']);
});
