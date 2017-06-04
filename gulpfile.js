var gulp = require('gulp');
var sass = require('gulp-sass');
var shell = require('gulp-shell');
var watch = require('gulp-watch');


gulp.task('sass', function() {
  return gulp.src('app/sass/main.scss')
    .pipe(sass())
    .pipe(gulp.dest('dist/css'))
});

gulp.task('watch', function () {
    gulp.watch('app/sass/*.scss', ['sass']);
    gulp.watch('app/*.html', ['copy']);
    gulp.watch('app/*.php', ['copy']);
    gulp.watch('app/js/*.js', ['copyJS']);
});

gulp.task('copy', function() {
    gulp.src(['app/*.html', 'app/*.php'])
    .pipe(gulp.dest('dist/'))
});

gulp.task('copyJS', function() {
    gulp.src(['app/js/*.js'])
    .pipe(gulp.dest('dist/js/'))
});

gulp.task('default', ['watch']);
