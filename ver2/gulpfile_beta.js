var fs 					= require('fs');
var fileExists 			= require('file-exists');

var gulp 				= require('gulp');
var watch 				= require('gulp-watch');
var rename 				= require('gulp-rename');
var rimraf 				= require('gulp-rimraf');
var copy 				= require('gulp-copy');
var zip 				= require('gulp-zip');
var foreach 			= require('gulp-foreach');
var SSI 				= require('node-ssi');
var runSequence 		= require('run-sequence');
var postcss 			= require('gulp-postcss');
var postcssImport 		= require('postcss-import');
var postcssSimpleVars 	= require('postcss-simple-vars');
var postcssCalc 		= require('postcss-calc');
var postcssColor 		= require('postcss-color-function');
var postcssSprites		= require('postcss-sprites');
var postcssMixins 		= require('postcss-mixins');
var postcssSimpleExtend = require('postcss-simple-extend');
var postcssBadSelectors = require('postcss-bad-selectors');
var sourcemaps 			= require('gulp-sourcemaps');
var autoprefixer 		= require('autoprefixer');
var plumber 			= require('gulp-plumber');
var filter 				= require('gulp-filter');
var shell 				= require('gulp-shell');
var path 				= require('path');
var i2r 				= require('gulp-image-to-rule');
var pipeErrorStop 		= require('pipe-error-stop');
var imagemin 			= require('gulp-imagemin');
var cssbeautify 		= require('gulp-cssbeautify');
var gulpif 				= require('gulp-if');
var imageResize 		= require('gulp-image-resize');
var yargs 				= require('yargs');


var browserSync 		= require('browser-sync').create();
var reload 				= browserSync.reload;

var ssi = new SSI({
	baseDir: '',
	encoding: 'utf-8',
	payload: {
		v: 5
	}
});

var envVars = yargs.argv;

// Get config
var config = {};
var configFilePath = getPathToFolder(process.env.INIT_CWD, 'server')  + '/2c-gulp-config.json';

if (fileExists(configFilePath)) {
	config = require(configFilePath);
};

var spriteOpts    = {
	stylesheetPath: './css',
	spritePath    : './css/images/sprite.png',
	retina        : true,
	filterBy      : function(image) {
		return /sprite\//gi.test(image.url);
	},

	// Spritesmith options:
	padding       : 4
};


// CSS Post CSS Sprites prepare
gulp.task('lazy-rules', function() {
	return gulp.src('./css/images/sprite/*.png')
		.pipe(i2r(path.resolve('./css/_sprite.css'), {
			selectorWithPseudo: '.{base}-{pseudo}, a:{pseudo} .{base}, button:{pseudo} .{base}, a.{pseudo} .{base}, button.{pseudo} .{base}, .{base}.{pseudo}'
		}))
		.pipe(gulp.dest('.'));
});

// CSS Post Processing
gulp.task('css', function() {
	// PostCSS processors
	var postcss_processors = [
		postcssImport,										// import
		postcssMixins, 										// mixins
		postcssSimpleExtend,								// extend
		postcssSimpleVars,									// variables
		postcssCalc(),										// reduces calcs, where possible
		postcssColor(),										// colors
		autoprefixer({ browsers: ['last 3 version'] }),		// autoprefix
		toc 												// table of contents
	];

	// PostCSS task error handler
	var errorHandler = plumber(function(errorObj) {

		notify(errorObj);

		// End this task
		this.emit('end');
	});

	var notify = function(errorObj) {
		// Notify the user
		browserSync.notify('Error: ' + beautifyMessage(errorObj.message));

		// Post the message in the console
		console.log(errorObj.message);
	};

	var task = gulp.src('css/_*.css')
		.pipe(pipeErrorStop(postcss( [postcssBadSelectors(getSelectorToken)] ), {
			eachErrorCallback: function(errorObj) {
				notify(errorObj);
			}
		}))
		.pipe(filter('_load.css')) 							// filter only css files (remove the map file)
		.pipe(errorHandler) 								// Prevent pipe breaking caused by errors from gulp plugins
		.pipe(sourcemaps.init())							// source map init
		.pipe(postcss( postcss_processors )) 				// post css
		.pipe(rename( 'style.css' )) 						// rename
		.pipe(sourcemaps.write( '.' ))						// sourcemap write
		.pipe(gulpif(getEnvVar('bcss'), cssbeautify())) 	// beautify CSS
		.pipe(gulp.dest( 'css' )) 							// save css file
		.pipe(filter('**/*.css')) 							// filter only css files (remove the map file)
		.pipe(reload({stream: true})); 						// inject the changed css


	return task;
});

gulp.task('optimise:images', function() {
	return gulp.src(['build/css/images/**'])
		.pipe(imagemin({
			progressive: true,
			// use: [pngquant()]
		}))
		.pipe(gulp.dest('build/css/images'));
})

gulp.task('clean:build', function() {
	return gulp.src(['build', 'build.zip'], { read: false })
		.pipe(rimraf({ force: true }));
});

gulp.task('copy:build', function() {
	return gulp.src(['**', '!~html-vs-design/', '!ssi/**', '!package.json', '!settings.json', '!peon.json', '!README.md', '!gulpfile.js', '!css/images/sprite/*', '!css/_*.css', '!css/style.css.map', '!build', '!*.html'])
		.pipe(copy('build/'));
});

gulp.task('zip:build', function() {
	return gulp.src('build/**/*')
		.pipe(zip('build.zip'))
		.pipe(gulp.dest(''));
});


gulp.task('include:build', function() {
	return gulp.src('*.html')
		.pipe(foreach(function(stream, file){
			ssi
				.compileFile(path.basename(file.path), function(err, content) {
					fs.writeFileSync('build/' + path.basename(file.path), content);
				});
			return stream;
		}));
});

gulp.task('import-modules', function() {
	// Read css file
	var loadCSS = fs.readFileSync('./css/_load.css');

	// Remove _module imports
	var loadCSSClean = loadCSS.toString().replace(/[\n\r]?^@import\ \'_module\..*?[\n\r]?$[\n\r]*/gm, '');

	var task = gulp.src('css/_module.*.css')
		.pipe(foreach(function(stream, file){

			// Add the new imports
			loadCSSClean += '\n@import \'' + path.basename(file.path) + '\';\n';

			return stream;
		}));

	task.on('end', function() {
		// Write to the file
		fs.writeFileSync('./css/_load.css', loadCSSClean);
	});

	return task;
});

gulp.task('sprites', function() {
	return gulp.src('css/style.css')
		.pipe(postcss( [postcssSprites(spriteOpts)] ))
		.pipe(gulp.dest( 'css' ));
});

gulp.task('resize-sprite-source', function() {
	runSequence('resize-sprite-3x', 'resize-sprite-2x');
});

gulp.task('resize-sprite-3x', function() {
	return gulp.src('css/images/sprite/**/*@3x.png')
		.pipe(imageResize({
			width: '66.66666666666666667%',
			height: '66.66666666666666667%'
		}))
		.pipe(rename(function(filepath) {
			filepath.basename = filepath.basename.replace('@3x', '@2x');
		}))
		.pipe(gulp.dest('css/images/sprite'));
})

gulp.task('resize-sprite-2x', function() {
	return gulp.src('css/images/sprite/**/*@2x.png')
		.pipe(imageResize({
			width: '50%',
			height: '50%'
		}))
		.pipe(rename(function(filepath) {
			filepath.basename = filepath.basename.replace(/@\dx/, '');
		}))
		.pipe(gulp.dest('css/images/sprite'));
});

// Browser sync server
gulp.task('browser-sync', function() {
	browserSync.init({
		proxy : (config.hostname || 'localhost') + getRelativePath(process.env.INIT_CWD, 'server'),
		port  : 3000,
		open  : ('open' in config ? config.open : 'external'),
		host  : config.hostname || 'localhost'
	});
});


// Serve Task
gulp.task('serve', ['browser-sync', 'resize-sprite-source', 'lazy-rules', 'import-modules', 'css', 'watch']);

// Defaut Task
gulp.task('default', ['serve']);

// Build Task
gulp.task('build', function() {
	runSequence('clean:build', 'resize-sprite-source', 'lazy-rules', 'import-modules', 'css', 'sprites', 'copy:build', 'include:build', 'optimise:images', 'zip:build');
});

// Watch
gulp.task('watch', function() {

	// CSS watch - run only on files that match this model: _*.css
	watch('css/**/_*.css', function() {
		runSequence('css')
	});

	// Module watch - run only on files that match this model: _*.css
	watch('css/**/_module.*.css', {
		events: ['add', 'unlink']
	}, function() {
		runSequence('import-modules')
	});

	// Sprite images watch
	watch('css/images/sprite/**/*.png', function() {

		// Fix issue with PS saved images
		setTimeout(function() {
			runSequence('lazy-rules')
		}, 500);

	});

	// Resize images watch
	watch('css/images/sprite/**/*@2x.png', function() {

		// Fix issue with PS saved images
		setTimeout(function() {
			runSequence('resize-sprite-2x')
		}, 500);

	});

	// Resize images watch
	watch('css/images/sprite/**/*@3x.png', function() {

		// Fix issue with PS saved images
		setTimeout(function() {
			runSequence('resize-sprite-3x')
		}, 500);

	});

	// JS watch
	watch('js/*.js', function() {
		reload();
	});

	// HTML watch
	watch('**/*.*html', function() {
		reload();
	});
});



// Helpers

/**
 * Gets env variable or returns false if there is no varible
 * @param  {string} variable Variable name
 * @return {string}          Variable value
 */
function getEnvVar(variable) {
	if (variable in envVars) {
		return envVars[variable];
	};

	return false;
};


/**
 * Prepare message for browser notify.
 * @param  {string} message raw message
 * @return {string}         parsed message - new lines replaced by html elements.
 */
function beautifyMessage(message) {
	return '<p style="text-align: left">' + message.replace(/\n/g, '<br>') + '</p>';
};


/**
 * Gets relative path to folder
 * @param  {string} path       Full path
 * @param  {string} relativeTo Folder name
 * @return {string}            Path relative to the folder
 */
function getRelativePath(path, relativeTo) {
	if (path.match(new RegExp(relativeTo, 'i'))) {
		return path.split(new RegExp(relativeTo, 'i')).pop().replace(/\//g, '\\');
	} else {
		return '';
	};
};

/**
 * Gets path before folder
 * @param  {string} path       Full path
 * @param  {string} folderName Folder name
 * @return {string}            Path before the folder + folder name
 */
function getPathToFolder(path, folderName) {
	var match = path.match(new RegExp(folderName, 'i'));
	if (match) {
		return path.split(new RegExp(folderName, 'i')).shift() + match[0];
	} else {
		return '';
	};
};

/**
 * Add number padding
 * @param  {Integer} number       Number to modify
 * @param  {Integer} targetLength Digits count
 * @return {String}              Number with padding
 */
function leftPad(number, targetLength) {
	var output = number + '';

	while (output.length < targetLength) {
		output = '0' + output;
	};

	return output;
};

/**
 * Dash string generator
 * @param  {Integer} count Dashes count
 * @return {String}       Dashes string
 */
function generateDashes(count) {
	var dashes = [];

	for (var i = 0; i < count; i++) {
		dashes.push('-');
	};

	return dashes.join('');
};

/**
 * Get selector token from filename
 * @param  {File} file
 * @return {RegExp}      Tolen RegExp
 */
function getSelectorToken(file) {
	var file        = path.basename(file);
	var prefixRegex = /^_module(?!(\.form\-elements))|^_region/gi;
	var token       = null;

	if (prefixRegex.test(file)) {
		token = file.replace(prefixRegex, '');
		token = path.basename(token, '.css');
	}

	if (token) {
		return new RegExp('^(\\[class\\^?\\*?=\\"|\\\')?\\.?' + escapeRegExp(token.replace(/^./, '')) + '|\\$');
	}

	return token;
};

/**
 * Escape RegExp helper
 * @param  {String} str Source string
 * @return {String}     Escaped string
 */
function escapeRegExp(str) {
  return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
}

/**
 * Table of contents generator
 * @param  {Object} style PostCSS style object
 */
function toc(style) {
	var tableLength = 50;
	var comments = [];
	var table = [];
	var majorCommentIdx = 0;
	var header = '\tTable of Contents\n\tupdate on ' + new Date().toString();

	style.eachComment(function(comment) {
		var majorCommentRegExp = /-*\s\*\\[\n\r]\s*(.*?)[\n\r]+\\\*\s-*/;
		var commentRaw = comment.source.input.css;

		if (comment.text.match(majorCommentRegExp)) {
			var commentText = comment.text.match(majorCommentRegExp)[1];
			comments.push({
				text: commentText,
				type: 'major',
				isRoman: commentText.match(/^[\I\V\X]*\.\s/)
			});
		} else {
			if(/^[A-Z]/.test(comment.text)) {
				comments.push({
					text: comment.text,
					type: 'minor'
				});
			}
		}
	});

	for (var i = 0; i < comments.length; i++) {
		var commentPrefix = '';
		var tableText = '';

		if(comments[i].type === 'major') {
			if(!comments[i].isRoman) {
				majorCommentIdx += 1;

				commentPrefix = '     ' + leftPad(majorCommentIdx, 2) + '. ';
			} else {
				majorCommentIdx = 0;
			};
		} else {
			commentPrefix = '         ';
		};

		tableText = commentPrefix + comments[i].text;

		table.push(tableText + ' ' + generateDashes(tableLength - tableText.length));
	};

	style.prepend({
		text: '\n' + header + '\n\n\t' + table.join('\n\t') + '\n'
	});


	if (style.first && style.first.next()) {
		style.first.next().before = '\n\n';
	};
};