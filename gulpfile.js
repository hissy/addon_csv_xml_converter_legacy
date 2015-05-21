var gulp = require('gulp');
var zip = require('gulp-zip');
var composer = require('gulp-composer');

gulp.task('build', function () {
    return gulp.src(['csv_xml_converter/**/*'], {base: "."})
        .pipe(gulp.dest('./build'))
        .pipe(composer({ cwd: './build/csv_xml_converter' }));
});

gulp.task('zip', function () {
    return gulp.src(['build/**/*'], {base: "./build"})
        .pipe(zip('csv_xml_converter.zip'))
        .pipe(gulp.dest('./release'));
});

gulp.task('default', ['build']);