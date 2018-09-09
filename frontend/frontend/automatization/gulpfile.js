var
	resources = {
		pug : '../resources/jade/',
		stylus : '../resources/stylus/',
		coffee : '../resources/coffee/',
		img : '../resources/assets/img/',
		sprite : '../resources/assets/sprites/',
		svg : '../resources/assets/svg/',
		fonts : '../resources/assets/fonts/'
	},
	public = {
		path : '../../../public/',
		pathBackEnd : '../../../resources/views/',
		html : '../../public/views/',
		//css : '../../public/css/',
		css : '../../../public/css/',
		//fonts : '../../public/css/fonts/',
		fonts : '../../../public/css/fonts/',
		//js : '../../public/js/',
		js : '../../../public/js/',
		img : '../../../public/img/'
		//img : '../../public/img/'
	};

var
	gulp 				= require('gulp'),
	pug 				= require('gulp-pug'),
	coffee 			= require('gulp-coffee'),
	uglify 			= require('gulp-uglify'),
	stylus 			= require('gulp-stylus'),
	nib 				= require('nib'),
	rupture 		= require('rupture'),
	plumber 		= require('gulp-plumber'),
	runSequence = require('run-sequence'),
	spritesmith = require('gulp.spritesmith'),
	imagemin 		= require('gulp-imagemin'),
	iconfont 		= require('gulp-iconfont'),
	rename 			= require("gulp-rename"),
	iconfontCss = require('gulp-iconfont-css'),
	svgicons2svgfont = require('gulp-svgicons2svgfont'),
	browserSync = require('browser-sync'),
	es 					= require('event-stream');

var reload = browserSync.reload;


gulp.task('pug', function buildHTML() {
	var app = gulp.src([
		resources.pug + '**/*.pug',
		resources.pug + '**/**/*.pug',
		'!' + resources.pug + '**/_*.pug',
		'!' + resources.pug + '_**/*.pug',
		'!' + resources.pug + '_**/_*.pug',
    '!' + resources.pug + '_**/**/*.pug',
    '!' + resources.pug + '_**/**/_*.pug',
    '!' + resources.pug + 'config/*.pug',
    '!' + resources.pug + 'mixins/*.pug'
	])
	.pipe(plumber())
	.pipe(pug({
		pretty: true
	}))
	.pipe(rename({extname: '.blade.php'}))
	.pipe(gulp.dest(public.pathBackEnd));
});
console.log('donde esta',public.pathBackEnd)
// task watch
gulp.task('watch', function() {
	gulp.watch([
		resources.pug + '**/*.pug',
		resources.pug + '**/**/*.pug'
	], ['pug', reload]);

	gulp.watch([
		resources.stylus + '**/*.styl',
		resources.stylus + '**/**/*.styl'
	], ['stylus', reload]);

	gulp.watch([
		resources.coffee + '*.coffee',
		resources.coffee + '**/*.coffee'
	], ['coffee', reload]);
});

gulp.task('stylus', function() {
	return gulp.src([
		resources.stylus + '*.styl'
	])
	.pipe(plumber())
	.pipe(stylus({
		use: [nib(), rupture()],
		compress: false
	}))
	.pipe(gulp.dest(public.css));
});

// task coffee
gulp.task('coffee', function() {
	return gulp.src([
		resources.coffee + '*.coffee',
		resources.coffee + '**/*.coffee'
	])
	.pipe(plumber())
	.pipe(coffee())
	.pipe(uglify({ compress: false }))
	.pipe(gulp.dest(public.js));
});

// task browser-sync | browser-sync
gulp.task('browser-sync', function() {
	browserSync({
		port: 3000,
		keepalive: true,
		notify 	: true,
		open: true,
		//server:{
		//	baseDir: "./src/",
		//	directory : true,
		//},
		proxy: "http://localhost",
	})
});

//task imagemin
gulp.task('imagemin', function() {
	return gulp.src([
		resources.img + '*.jpg',
		resources.img + '*.png',
		resources.img + '*.gif'
	])
	.pipe(imagemin({
		progressive : true,
		optimizationLevel : 4
	}))
	.pipe(gulp.dest(public.img));
});

// task iconfont | gulp-iconfont
gulp.task('iconfont', function() {
	return gulp.src([
		resources.svg + '*.svg'
	])
	.pipe(plumber())
	.pipe(iconfontCss({
		fontName: 'icons',
		path: '../../frontend/resources/assets/svg/icons.css',
		targetPath: '../../_icons.css',
		fontPath: 'fonts/icons/'
	}))
	.pipe(iconfont({
		fontName: 'icons',
		fontHeight: 1000,
		normalize: true,
		formats: ['svg','ttf', 'eot', 'woff'],
		centerHorizontally: true
	}))
	.on('glyphs', function(glyphs, options) {
        // CSS templating, e.g.
        console.log(glyphs, options);
      })
	.pipe(gulp.dest(public.css + 'fonts/icons'));
});


// gulp.task('Iconfont', function(){
//   return gulp.src(['assets/icons/*.svg'])
//     .pipe(iconfont({
//       fontName: 'myfont', // required
//       prependUnicode: true, // recommended option
//       formats: ['ttf', 'eot', 'woff'], // default, 'woff2' and 'svg' are available
//       timestamp: runTimestamp, // recommended to get consistent builds when watching files
//     }))
//       .on('glyphs', function(glyphs, options) {
//         // CSS templating, e.g.
//         console.log(glyphs, options);
//       })
//     .pipe(gulp.dest('www/fonts/'));
// });






// task sprite | gulp.spriteminth
gulp.task('sprite', function () {
  var spriteData = gulp.src(resources.sprite + '*.png')
  .pipe(plumber())
  .pipe(spritesmith({
  	imgPath: '../img/sprite.png',
    imgName: 'sprite.png',
    cssName: '_sprite.styl'
  }));
  spriteData.img
  	.pipe(plumber())
    .pipe(imagemin())
    .pipe(gulp.dest(public.img));
  spriteData.css
  	.pipe(plumber())
    .pipe(gulp.dest(resources.stylus + 'base/'));
});

gulp.task('fonts', ['iconfont'], function() {
	return gulp.src([
		resources.fonts + '*/*'
	])
	.pipe(gulp.dest(public.fonts));
});

//task default
gulp.task('default', function (cb) {
	runSequence('pug', 'stylus', 'coffee', 'imagemin','fonts','sprite','iconfont' );
});

// task server
gulp.task('server', function (cb) {
		runSequence('browser-sync', 'watch', cb);
});
