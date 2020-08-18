/**
 * Darkbox v1.0.6
 * by WhoMeNope
 *
 * More info:
 * https://github.com/WhoMeNope/darkbox.js
 *
 * @license
 * Released under the MIT license
 * https://github.com/WhoMeNope/darkbox.js/blob/master/LICENSE
 */

(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as an anonymous module.
		define(['jquery'], factory);
	} else if (typeof module === 'object' && module.exports) {
		// Node/CommonJS
		module.exports = function (root, jQuery) {
			if (jQuery === undefined) {
				// require('jQuery') returns a factory that requires window to
				// build a jQuery instance, we normalize how we use modules
				// that require this pattern but the window provided is a noop
				// if it's defined (how jquery works)
				if (typeof window !== 'undefined') {
					jQuery = require('jquery');
				}
				else {
					jQuery = require('jquery')(root);
				}
			}
			factory(jQuery);
			return jQuery;
		};
	} else {
		// Browser globals
		window.darkbox = factory(window.jQuery);
	}
}(function ($) {

	//////////////////////////////////
	//DARKBOX BUILDER OBJECT

	function DarkboxBuilder() {
                DarkboxBuilder.prototype.setPath = function (path) {
			let newpath = path;
                        let elems =
				'<div id="darkboxOverlay"></div>' +
				'<div id="darkbox"></div>' +
				'<div id="darkbox-left"><img src="'+newpath+'images/left.svg" alt=""/></div>' +
				'<div id="darkbox-right"><img src="'+newpath+'images/right.svg" alt=""/></div>' +
				'<div id="darkbox-cancel"><img src="'+newpath+'images/close.svg" alt=""/></div>' +
				'<div id="darkbox-title"><h1 id="darkboxTitleText"></h1></div>' +
				'<div id="darkbox-progress"><div></div></div>';

			$(elems).appendTo($('body'));
		};
		DarkboxBuilder.prototype.build = function () {

		};

		DarkboxBuilder.prototype.start = function ($elem, images, options, path) {
			new Darkbox($elem, images, options, path);
		};

		$(document).ready(() => {
			this.build();
		});
	}

	//////////////////////////////////
	//DARKBOX INSTANCE OBJECT

	function Darkbox($elem, images, options, path) {
		//set options
		this.options = $.extend({}, this.constructor.defaults);
		this.setOptions(options);

		//get images
		this.images = images;

		// Cache jQuery objects
		this.$overlay = $('#darkboxOverlay');
		this.$darkbox = $('#darkbox');

		this.$darkboxLeft = $('#darkbox-left');
		this.$darkboxRight = $('#darkbox-right');
		this.$darkboxCancel = $('#darkbox-cancel');
		this.$darkboxTitle = $('#darkbox-title');
		this.$darkboxProgress = $('#darkbox-progress');
		
		this.$darkboxTitleText = $('#darkboxTitleText');

		this.$clonnedNode = null;

		//move current to first if options.startWithCurrent is set
		if(this.options.startWithCurrent) {
			let current = $elem.attr('src');

			if(!Array.isArray(this.images)) {
				this.images = [];
			}
			if(this.images.length == 0 || current !== this.images[0]) {
				let i = 0;
				for(let image in this.images) {
					if(image == current) {
						this.images.splice(i, 1);
					}
					i++;
				}
				this.images.unshift(current);
			}
		}

		this.currentImageIndex = 0;
		this.preloadNeighboringImages();

		this.setProgress();

		//start on element
		if(this.images.length > 0)
			this.start($elem);
	}

	Darkbox.defaults = {
		startWithCurrent: true,
		wrapAround: false,

		showProgressBar: true,
		showTitle: false,

		disablePageScrolling: true,

		endCallback: null,
	};

	Darkbox.prototype.setOptions = function (options) {
		$.extend(this.options, options);
	};

	Darkbox.prototype.start = function ($link) {
		// Disable scrolling of the page while open
		if (this.options.disablePageScrolling) {
			$('body').addClass('db-disable-scrolling');
		}

		//clear darkbox
		this.$darkbox.empty();

		//clone element to darkbox and set the same position as the original
		let node = $link.clone(false);

		$(node).attr('src', this.images[0]);
		
		$(node).css('position', 'absolute');
		
		$(node).css('width', $link.width() + 'px');
		$(node).css('height', $link.height() + 'px');

		let offset = $link.parent().offset();
		$(node).css('left', offset.left + 'px');
		$(node).css('top', offset.top + 'px');

		$(node).appendTo(this.$darkbox);
		this.$clonnedNode = node;

		//show darkbox
		this.$darkbox.show();
		this.$overlay.addClass('show');
		this.$overlay.addClass('fill');

		if(this.images.length > 1) {
			this.$darkboxLeft.show();
			this.$darkboxRight.show();
		}
		this.$darkboxCancel.show();
		if (this.options.showTitle)
			this.$darkboxTitle.show();
		if(this.options.showProgressBar)
			this.$darkboxProgress.show();

		$(this.$darkboxTitleText).text('Image ' + (this.currentImageIndex + 1) + ' of ' + this.images.length);

		setTimeout(() => {
			if (this.images.length > 1) {
				this.$darkboxLeft.addClass('show');
				this.$darkboxRight.addClass('show');
			}
			this.$darkboxCancel.addClass('show');
			if (this.options.showTitle)
				this.$darkboxTitle.addClass('show');
		}, 400);

		//transition to center position
		$(this.$clonnedNode).addClass('straight');
		$(this.$clonnedNode).animate({
			left: ($(window).width() - $link.width()) / 2,
			top: ($(window).height() - $link.height()) / 2,
		}, 
		400, 
		'swing',
		() => {
			$(this.$clonnedNode).addClass('scale');

			//display animation finished

			//enable keyboard hook
			this.enableKeyboardNav();

			//enable nav events
			$(this.$darkboxLeft).on('click', () => {
				this.previousImage();
			});
			$(this.$darkboxRight).on('click', () => {
				this.nextImage();
			});

			$(this.$darkboxCancel).on('click', () => {
				this.end();
			});
		});
	};

	Darkbox.prototype.setProgress = function () {
		if (this.images.length < 2)
			$(this.$darkboxProgress).find('div').css('left', '0');
		else {
			let progress = 1.0 - ((this.images.length - this.currentImageIndex - 1) / (this.images.length - 1));
			$(this.$darkboxProgress).find('div').css('left', '' + (progress * 100).toFixed(2) + '%');
		}
	};

	Darkbox.prototype.previousImage = function () {
		if (this.currentImageIndex !== 0) {
			this.changeImage(this.currentImageIndex - 1);
		} else if (this.options.wrapAround && this.images.length > 1) {
			this.changeImage(this.images.length - 1);
		}
	};
	Darkbox.prototype.nextImage = function () {
		if (this.currentImageIndex !== this.images.length - 1) {
			this.changeImage(this.currentImageIndex + 1);
		} else if (this.options.wrapAround && this.images.length > 1) {
			this.changeImage(0);
		}
	};
	Darkbox.prototype.changeImage = function (index) {
		if (this.disabledControls)
			return;
		this.disabledControls = true;

		this.currentImageIndex = index;

		this.preloadNeighboringImages();
		this.setProgress();

		$(this.$darkboxTitleText).text('Image ' + (index + 1) + ' of ' + this.images.length);

		//set next image
		const preload = new Image();
		preload.onload = () => {
			$(this.$clonnedNode).attr('src', preload.src);
			this.disabledControls = false;
		};
		preload.src = this.images[index];
	};

	// Preload previous and next images in set.
	Darkbox.prototype.preloadNeighboringImages = function () {
		if (this.images.length > this.currentImageIndex + 1) {
			var preloadNext = new Image();
			preloadNext.src = this.images[this.currentImageIndex + 1];
		}
		if (this.currentImageIndex > 0) {
			var preloadPrev = new Image();
			preloadPrev.src = this.images[this.currentImageIndex - 1];
		}
	};

	Darkbox.prototype.enableKeyboardNav = function () {
		$(document).on('keyup.keyboard', $.proxy(this.keyboardAction, this));
	};
	Darkbox.prototype.disableKeyboardNav = function () {
		$(document).off('.keyboard');
	};
	Darkbox.prototype.keyboardAction = function (event) {
		const KEYCODE_ESC = 27;
		const KEYCODE_LEFTARROW = 37;
		const KEYCODE_RIGHTARROW = 39;

		let keycode = event.keyCode;
		let key = String.fromCharCode(keycode).toLowerCase();
		if (keycode === KEYCODE_ESC || key.match(/x|o|c/)) {
			this.end();
		} else if (key === 'p' || keycode === KEYCODE_LEFTARROW) {
			this.previousImage();
		} else if (key === 'n' || keycode === KEYCODE_RIGHTARROW) {
			this.nextImage();
		}
	};

	Darkbox.prototype.end = function () {
		//disable keyboard hook
		this.disableKeyboardNav();

		//disable nav events
		$(this.$darkboxLeft).off('click');
		$(this.$darkboxRight).off('click');
		$(this.$darkboxCancel).off('click');

		//hide darkbox
		this.$darkboxLeft.removeClass('show');
		this.$darkboxRight.removeClass('show');
		this.$darkboxCancel.removeClass('show');
		this.$darkboxTitle.removeClass('show');

		this.$darkboxProgress.hide();

		$(this.$clonnedNode).animate(
			{
				opacity: 0.0,
			},
			300,
			'swing',
			() => {
				this.$darkbox.hide();

				this.$darkboxLeft.hide();
				this.$darkboxRight.hide();

				this.$darkboxCancel.hide();

				this.$darkboxTitle.hide();
			}
		);

		this.$overlay.removeClass('fill');
		setTimeout(() => {
			this.$overlay.removeClass('show');

			//hide animation finished

			$('body').removeClass('db-disable-scrolling');

		}, 600);

		//trigger endCallback
		let endCallback = this.options.endCallback;
		if (endCallback && endCallback != null && typeof endCallback === 'function') {
			setTimeout(() => {
				this.options.endCallback();
			}, 200);
		}
	};

	const dbBuilder = new DarkboxBuilder();
	$.fn.darkbox = function (images, options, path) {
                dbBuilder.setPath(path);
		dbBuilder.start(this, images, options, path);
	};
	return dbBuilder;
}));
