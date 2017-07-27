'use strict';
var pkg = require('./package.json');
var fs = require('fs');

var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var concatCss = require('gulp-concat-css');

gulp.task('css', ['sass'], function () {
  return gulp.src('./assets/css/**/*.css')
    .pipe(concatCss("style.css"))
    .pipe(gulp.dest('./'));
});

gulp.task('sass', function () {
  return gulp.src('./assets/sass/**/*.scss')
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(gulp.dest('./assets/css'))
});

gulp.task('sass:watch', function () {
  gulp.watch('./assets/sass/**/*.scss', ['sass', 'css']);
});

gulp.task('default', ['sass', 'css']);
