var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

gulp.task('default', function() {
    gulp.src('publish/resources/assets/sass/admin.scss')
        .pipe(sass())
        .pipe(autoprefixer('last 10 versions'))
        .pipe(gulp.dest('publish/public/css'));
});