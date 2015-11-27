'use strict';
var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

gulp.task('sass', function () {
  gulp.src('./public/scss/*.scss')
    .pipe(sass().on('error', sass.logError))
		.pipe(autoprefixer({}))
    .pipe(gulp.dest('./public/css/'));
});

gulp.task('default', function () {
  gulp.watch('./public/scss/**/*.scss', ['sass']);
});
