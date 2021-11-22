/**
 * Alpha FrameWork Async JS Library
 * 
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 * @version    1.0
 */
'use strict';

( function ( $ ) {
	/**
	 * jQuery easing
	 * 
	 * @since 1.0
	 */
	$.extend( $.easing, {
		def: 'easeOutQuad',
		swing: function ( x, t, b, c, d ) {
			return $.easing[ $.easing.def ]( x, t, b, c, d );
		},
		easeOutQuad: function ( x, t, b, c, d ) {
			return -c * ( t /= d ) * ( t - 2 ) + b;
		},
		easeInOutQuart: function ( x, t, b, c, d ) {
			if ( ( t /= d / 2 ) < 1 ) return c / 2 * t * t * t * t + b;
			return -c / 2 * ( ( t -= 2 ) * t * t * t - 2 ) + b;
		},
		easeOutQuint: function ( x, t, b, c, d ) {
			return c * ( ( t = t / d - 1 ) * t * t * t * t + 1 ) + b;
		}
	} );

	theme.defaults.popup = {
		fixedContentPos: true,
		closeOnBgClick: false,
		removalDelay: 350,
		callbacks: {
			beforeOpen: function () {
				if ( this.fixedContentPos ) {
					var scrollBarWidth = window.innerWidth - document.body.clientWidth;
					$( '.sticky-content.fixed' ).css( 'padding-right', scrollBarWidth );
					$( '.mfp-wrap' ).css( 'overflow', 'hidden auto' );
				}
			},
			close: function () {
				if ( this.fixedContentPos ) {
					$( '.mfp-wrap' ).css( 'overflow', '' );
					$( '.sticky-content.fixed' ).css( 'padding-right', '' );
				}
			}
		},
	}

	theme.defaults.popupPresets = {
		login: {
			type: 'ajax',
			mainClass: "mfp-login mfp-fade",
			tLoading: '<div class="login-popup"><div class="d-loading"><i></i></div></div>',
			preloader: true,
			items: {
				src: alpha_vars.ajax_url,
			},
			ajax: {
				settings: {
					method: 'post',
					data: {
						action: 'alpha_account_form',
						nonce: alpha_vars.nonce
					}
				}, cursor: 'mfp-ajax-cur' // CSS class that will be added to body during the loading (adds "progress" cursor)
			}
		},
		video: {
			type: 'iframe',
			mainClass: "mfp-fade",
			preloader: false,
			closeBtnInside: false
		},
		firstpopup: {
			type: 'inline',
			mainClass: 'mfp-popup-template mfp-newsletter-popup mfp-flip-popup',
			callbacks: {
				beforeClose: function () {
					// if "do not show" is checked
					$( '.mfp-alpha .popup .hide-popup input[type="checkbox"]' ).prop( 'checked' ) && theme.setCookie( 'hideNewsletterPopup', true, 7 );
				}
			}
		},
		popup_template: {
			type: 'ajax',
			mainClass: "mfp-popup-template mfp-flip-popup",
			tLoading: '<div class="popup-template"><div class="d-loading"><i></i></div></div>',
			preloader: true,
			items: {
				src: alpha_vars.ajax_url,
			},
			ajax: {
				settings: {
					method: 'post',
				}, cursor: 'mfp-ajax-cur' // CSS class that will be added to body during the loading (adds "progress" cursor)
			}
		},
	}

	theme.defaults.slider = {
		a11y: false,
		containerModifierClass: 'slider-container-', // NEW
		slideClass: 'slider-slide',
		wrapperClass: 'slider-wrapper',
		slideActiveClass: 'slider-slide-active',
		slideDuplicateClass: 'slider-slide-duplicate',
	}
	theme.defaults.sliderPresets = {
		'product-single-carousel': {
			pagination: false,
			navigation: true,
			autoHeight: true,
			thumbs: {
				slideThumbActiveClass: 'active'
			}
		},
		'product-gallery-carousel': {
			spaceBetween: 20,
			slidesPerView: $( '.main-content-wrap > .sidebar-fixed' ).length ? 2 : 3,
			navigation: true,
			pagination: false,
			breakpoints: {
				768: {
					slidesPerView: 2
				},
			},
		},
		'product-thumbs': {
			slidesPerView: 4,
			navigation: true,
			pagination: false,
			spaceBetween: 10,
			normalizeSlideIndex: false,
			freeMode: true,
			watchSlidesVisibility: true,
			watchSlidesProgress: true,
		},
		'compare-slider': {
			spaceBetween: 10,
			slidesPerView: 2,
			breakpoints: {
				992: {
					spaceBetween: 30,
					slidesPerView: 4,
				},
				768: {
					spaceBetween: 20,
					slidesPerView: 3,
				}
			}
		},
		'products-flipbook': {
			onInitialized: function () {
				function stopDrag( e ) {
					$( e.target ).closest( '.product-single-carousel, .product-gallery-carousel, .product-thumbs' ).length && e.stopPropagation();
				}
				this.wrapperEl.addEventListener( 'mousedown', stopDrag );
				if ( 'ontouchstart' in document ) {
					this.wrapperEl.addEventListener( 'touchstart', stopDrag, { passive: true } );
				}
			}
		}
	}

	/**
	 * Prevent default handler
	 *
	 * @since 1.0
	 * @param {Event} e
	 * @return {void}
	 */
	theme.preventDefault = function ( e ) { e.preventDefault() }

	/**
	 * Initialize template's content.
	 * 
	 * @since 1.0
	 * @param {jQuery} $template
	 * @return {void}
	 */
	theme.initTemplate = function ( $template ) {
		theme.lazyload( $template );
		theme.slider( $template.find( '.slider-wrapper' ) );
		theme.isotopes( $template.find( '.grid' ) );
		theme.shop.initProducts( $template );
		theme.countdown( $template.find( '.countdown' ) );
		theme.call( function () {
			theme.$window.trigger( 'alpha_loadmore' );
		}, 300 );
		theme.$body.trigger( 'alpha_init_tab_template' );
	}

	/**
	 * Load template's content.
	 * 
	 * @since 1.0
	 * @param {jQuery} $template
	 * @return {void}
	 */
	theme.loadTemplate = function ( $template ) {
		var html = '';
		var orignal_split = alpha_vars.resource_split_tasks;

		// To run carousel immediately
		alpha_vars.resource_split_tasks = 0;

		$template.children( '.load-template' ).each( function () {
			html += this.text;
		} );
		if ( html ) {
			$template.html( html );
			if ( theme.skeleton ) {
				theme.skeleton( $( '.skeleton-body' ), function () {
					theme.initTemplate( $template );
				} );
			} else {
				theme.initTemplate( $template );
			}
		}

		alpha_vars.resource_split_tasks = orignal_split;
	}

	/**
	 * Check if window's width is really resized.
	 * 
	 * @since 1.0
	 * @param {number} timeStamp
	 * @return {boolean}
	 */
	theme.windowResized = function ( timeStamp ) {
		if ( timeStamp == theme.resizeTimeStamp ) {
			return theme.resizeChanged;
		}
		theme.resizeChanged = theme.canvasWidth != window.innerWidth;
		theme.canvasWidth = window.innerWidth;
		theme.resizeTimeStamp = timeStamp;
		return theme.resizeChanged;
	}

	/**
	 * Set cookie
	 * 
	 * @since 1.0
	 * @param {string} name Cookie name
	 * @param {string} value Cookie value
	 * @param {number} exdays Expire period
	 * @return {void}
	 */
	theme.setCookie = function ( name, value, exdays ) {
		var date = new Date();
		date.setTime( date.getTime() + ( exdays * 24 * 60 * 60 * 1000 ) );
		document.cookie = name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
	}

	/**
	 * Get cookie
	 *
	 * @since 1.0
	 * @param {string} name Cookie name
	 * @return {string} Cookie value
	 */
	theme.getCookie = function ( name ) {
		var n = name + "=";
		var ca = document.cookie.split( ';' );
		for ( var i = 0; i < ca.length; ++i ) {
			var c = ca[ i ];
			while ( c.charAt( 0 ) == ' ' ) {
				c = c.substring( 1 );
			}
			if ( c.indexOf( n ) == 0 ) {
				return c.substring( n.length, c.length );
			}
		}
		return "";
	}

	/**
	 * Scroll to given target in given duration.
	 *
	 * @since 1.0
	 * @param {mixed}  target   This can be number or string seletor or jQuery object.
	 * @param {number} duration This can be omitted.
	 * @return {void}
	 */
	theme.scrollTo = function ( target, duration ) {
		var _duration = typeof duration == 'undefined' ? 0 : duration;
		var offset;

		if ( typeof target == 'number' ) {
			offset = target;
		} else {
			var $target = theme.$( target ).closest( ':visible' );
			if ( $target.length ) {
				var offset = $target.offset().top;
				var $wpToolbar = $( '#wp-toolbar' );
				window.innerWidth > 600 && $wpToolbar.length && ( offset -= $wpToolbar.parent().outerHeight() );
				$( '.sticky-content.fix-top.fixed' ).each( function () {
					offset -= this.offsetHeight;
				} )
			}
		}

		$( 'html,body' ).stop().animate( { scrollTop: offset }, _duration );
	}

	/**
	 * Scroll to fixed content
	 * 
	 * @since 1.0
	 * @param {number} arg
	 * @param {number} duration
	 * @return {void}
	 */
	theme.scrollToFixedContent = function ( arg, duration ) {
		var stickyTop = 0,
			toolbarHeight = window.innerWidth > 600 && $( '#wp-toolbar' ).parent().length ? $( '#wp-toolbar' ).parent().outerHeight() : 0;

		$( '.sticky-content.fix-top' ).each( function () {
			if ( $( this ).hasClass( 'toolbox-top' ) ) {
				var pt = $( this ).css( 'padding-top' ).slice();
				if ( pt.length > 2 ) {
					stickyTop -= Number( pt.slice( 0, -2 ) );
				}
				return;
			}

			var fixed = $( this ).hasClass( 'fixed' );

			stickyTop += $( this ).addClass( 'fixed' ).outerHeight();

			fixed || $( this ).removeClass( 'fixed' );
		} )

		theme.scrollTo( arg - stickyTop - toolbarHeight, duration );
	}

	/**
	 * Get value by given param from url
	 *
	 * @since 1.0
	 * @param {string} href
	 * @param {string} name
	 * @return {string} value
	 */
	theme.getUrlParam = function ( href, name ) {
		var url = document.createElement( 'a' ), s, r;
		url.href = decodeURIComponent( decodeURI( href ) );
		s = url.search;
		if ( s.startsWith( '?' ) ) {
			s = s.substr( 1 );
		}
		var params = {};
		s.split( '&' ).forEach( function ( v ) {
			var i = v.indexOf( '=' );
			if ( i >= 0 ) {
				params[ v.substr( 0, i ) ] = v.substr( i + 1 );
			}
		} );
		return params[ name ] ? params[ name ] : '';
	}

	/**
	 * Add param to url
	 *
	 * @since 1.0
	 * @param {string} href
	 * @param {string} name
	 * @param {mixed} value
	 * @return {string}
	 */
	theme.addUrlParam = function ( href, name, value ) {
		var url = document.createElement( 'a' ), s, r;
		href = decodeURIComponent( decodeURI( href ) );
		url.href = href;
		s = url.search;
		if ( 0 <= s.indexOf( name + '=' ) ) {
			r = s.replace( new RegExp( name + '=[^&]*' ), name + '=' + value );
		} else {
			r = ( s.length && 0 <= s.indexOf( '?' ) ) ? s : '?';
			r.endsWith( '?' ) || ( r += '&' );
			r += name + '=' + value;
		}
		return encodeURI( href.replace( s, '' ) + r.replace( /&+/, '&' ) );
	}

	/**
	 * Remove param from url
	 *
	 * @since 1.0
	 * @param {string} href
	 * @param {string} name
	 * @return {string}
	 */
	theme.removeUrlParam = function ( href, name ) {
		var url = document.createElement( 'a' ), s, r;
		href = decodeURIComponent( decodeURI( href ) );
		url.href = href;
		s = url.search;
		if ( 0 <= s.indexOf( name + '=' ) ) {
			r = s.replace( new RegExp( name + '=[^&]*' ), '' ).replace( /&+/, '&' ).replace( '?&', '?' );
			r.endsWith( '&' ) && ( r = r.substr( 0, r.length - 1 ) );
			r.endsWith( '?' ) && ( r = r.substr( 0, r.length - 1 ) );
			r = r.replace( '&&', '&' );
		} else {
			r = s;
		}
		return encodeURI( href.replace( s, '' ) + r );
	}

	/**
	 * Show More
	 *
	 * @since 1.0
	 * @param {string} selector
	 */
	theme.showMore = function ( selector ) {
		theme.$( selector ).after( '<div class="d-loading relative"><i></i></div>' );
	}

	/**
	 * Hide more
	 * 
	 * @since 1.0
	 * @param {string} selector
	 * @return {void}
	 */
	theme.hideMore = function ( selector ) {
		theme.$( selector ).children( '.d-loading' ).remove();
	}

	/**
	 * Start count to number
	 * 
	 * @since 1.0
	 * @param {string} selector
	 * @return {void}
	 */
	theme.countTo = function ( selector, runAsSoon = false ) {
		if ( $.fn.countTo ) {
			theme.$( selector ).each( function () {
				var el = this;
				var $this = $( this );
				function runProgress() {
					setTimeout( function () {
						var options = {
							onComplete: function () {
								$this.addClass( 'complete' );
							}
						};
						$this.data( 'duration' ) && ( options.speed = $this.data( 'duration' ) );
						$this.data( 'from-value' ) && ( options.from = $this.data( 'from-value' ) );
						$this.data( 'to-value' ) && ( options.to = $this.data( 'to-value' ) );

						options.decimals = options.to && options.to.indexOf( '.' ) >= 0 ? ( options.to.length - options.to.indexOf( '.' ) - 1 ) : 0;
						$this.countTo( options );
					}, 300 );
				}
				runAsSoon ? runProgress() : theme.appear( el, runProgress );
			} );
		}
	}
	/**
	 * Start countdown
	 * 
	 * @since 1.0
	 * @param {string} selector
	 * @param {object} options
	 * @return {void}
	 */
	theme.countdown = function ( selector, options ) {
		if ( $.fn.countdown ) {
			theme.$( selector ).each( function () {
				var $this = $( this ),
					untilDate = $this.attr( 'data-until' ),
					compact = $this.attr( 'data-compact' ),
					dateFormat = ( !$this.attr( 'data-format' ) ) ? 'DHMS' : $this.attr( 'data-format' ),
					newLabels = ( !$this.attr( 'data-labels-short' ) ) ? alpha_vars.countdown.labels : alpha_vars.countdown.labels_short,
					newLabels1 = ( !$this.attr( 'data-labels-short' ) ) ? alpha_vars.countdown.label1 : alpha_vars.countdown.label1_short;


				$this.data( 'countdown' ) && $this.countdown( 'destroy' );

				$this.countdown( $.extend(
					$this.hasClass( 'user-tz' ) ?
						{
							until: ( !$this.attr( 'data-relative' ) ) ? new Date( untilDate ) : untilDate,
							format: dateFormat,
							padZeroes: true,
							compact: compact,
							compactLabels: [ ' y', ' m', ' w', ' days, ' ],
							timeSeparator: ' : ',
							labels: newLabels,
							labels1: newLabels1,
							serverSync: new Date( $( this ).attr( 'data-time-now' ) )
						} : {
							until: ( !$this.attr( 'data-relative' ) ) ? new Date( untilDate ) : untilDate,
							format: dateFormat,
							padZeroes: true,
							compact: compact,
							compactLabels: [ ' y', ' m', ' w', ' days, ' ],
							timeSeparator: ' : ',
							labels: newLabels,
							labels1: newLabels1
						},
					options )
				);
			} );
		}
	}

	/**
	 * Progressbar appear init
	 * 
	 * @since 1.0
	 * @param {string} selector
	 * @return {void}
	 */
	theme.progressbarInit = function ( selector, runAsSoon = false ) {
		theme.$( selector ).each( function () {

			var $this = $( this );
			function runProgress() {
				setTimeout( function () {
					if ( $this.closest( '.percent-end-progress' ).length ) {
						$this.find( '.progress-percentage' ).css( { 'opacity': 1 } );
					}
					if ( $this.prev().find( '.progress-percentage' ).length && !$this.closest( '.progress-inner-text' ).length ) {
						var $progressbar = $this.prev().find( '.progress-percentage' );
						$progressbar.css( { 'left': $this.data( 'value' ) + '%', 'opacity': 1 } );
					}
					$this.find( '.progress-bar' ).css( { width: $this.data( 'value' ) + '%' } );
				}, 200 );
			}
			runAsSoon ? runProgress() : theme.appear( this, runProgress );
		} );
	}

	/**
	 * Initialize Parallax Background
	 * 
	 * @since 1.0
	 * @param {string} selector
	 * @return {void}
	 */
	theme.parallax = function ( selector, options ) {
		if ( $.fn.themePluginParallax ) {
			theme.$( selector ).each( function () {
				var $this = $( this );
				$this.themePluginParallax(
					$.extend( true, theme.parseOptions( $this.attr( 'data-parallax-options' ) ), options )
				);
			} );
		}
	}

	// Show loading overlay when $.fn.block is called
	var funcBlock = $.fn.block;
	$.fn.block = function ( opts ) {
		if ( theme.status == 'complete' ) { // To prevent single product widget's found variation blocking while page loading
			this.append( '<div class="d-loading"><i></i></div>' );
			funcBlock.call( this, opts );
		}
		return this;
	}

	// Hide loading overlay when $.fn.block is called
	var funcUnblock = $.fn.unblock;
	$.fn.unblock = function ( opts ) {
		if ( theme.status == 'complete' ) { // To prevent single product widget's found variation blocking while page loading
			funcUnblock.call( this, opts );
			this.hasClass( 'processing' ) || this.parents( '.processing' ).length || this.children( '.d-loading' ).remove();
			theme.shop.initAlertAction();
		}
		return this;
	}

	/**
	 * Initialize Sticky Content
	 * 
	 * @class StickyContent
	 * @since 1.0
	 * @param {string, Object} selector
	 * @param {Object} options
	 * @return {void}
	 */
	theme.stickyContent = ( function () {
		function StickyContent( $el, options ) {
			return this.init( $el, options );
		}

		function refreshAll() {
			theme.$window.trigger( 'sticky_refresh.alpha', {
				index: 0,
				offsetTop: window.innerWidth > 600 && $( '#wp-toolbar' ).length && $( '#wp-toolbar' ).parent().is( ':visible' ) ? $( '#wp-toolbar' ).parent().outerHeight() : 0
			} );
		}

		function refreshAllSize( e ) {
			if ( !e || theme.windowResized( e.timeStamp ) ) {
				theme.$window.trigger( 'sticky_refresh_size.alpha' );
				theme.requestFrame( refreshAll );
			}
		}

		StickyContent.prototype.init = function ( $el, options ) {
			this.$el = $el;
			this.options = $.extend( true, {}, theme.defaults.sticky, options, theme.parseOptions( $el.attr( 'data-sticky-options' ) ) );

			theme.$window
				.on( 'sticky_refresh.alpha', this.refresh.bind( this ) )
				.on( 'sticky_refresh_size.alpha', this.refreshSize.bind( this ) );
		}

		StickyContent.prototype.refreshSize = function ( e ) {
			var beWrap = window.innerWidth >= this.options.minWidth && window.innerWidth <= this.options.maxWidth;

			this.scrollPos = window.pageYOffset; // issue: heavy js performance : 30.7ms
			if ( typeof this.top == 'undefined' ) {
				this.top = this.options.top;
			}

			if ( window.innerWidth >= 768 && this.getTop ) {
				this.top = this.getTop();
			} else if ( !this.options.top ) {
				this.top = this.isWrap ?
					this.$el.parent().offset().top :
					this.$el.offset().top + this.$el[ 0 ].offsetHeight;

				// if sticky header has toggle dropdown menu, increase top
				if ( this.$el.find( '.toggle-menu.show-home' ).length ) {
					this.top += this.$el.find( '.toggle-menu .dropdown-box' )[ 0 ].offsetHeight;
				}
			}

			if ( !this.isWrap ) {
				beWrap && this.wrap();
			} else {
				beWrap || this.unwrap();
			}

			e && theme.requestTimeout( this.refreshSize.bind( this ), 50 );
		}

		StickyContent.prototype.wrap = function () {
			this.$el.wrap( '<div class="sticky-content-wrapper"></div>' );
			this.isWrap = true;
		}

		StickyContent.prototype.unwrap = function () {
			this.$el.unwrap( '.sticky-content-wrapper' );
			this.isWrap = false;
		}

		StickyContent.prototype.refresh = function ( e, data ) {
			var pageYOffset = window.pageYOffset + data.offsetTop; // issue: heavy js performance, 6.7ms
			var $el = this.$el;

			this.refreshSize();

			// Make sticky
			if ( pageYOffset > this.top && this.isWrap ) {

				// calculate height
				this.height = $el[ 0 ].offsetHeight;
				$el.hasClass( 'fixed' ) || $el.parent().css( 'height', this.height + 'px' );

				// update sticky order
				if ( $el.hasClass( 'fix-top' ) ) {
					$el.css( 'margin-top', data.offsetTop + 'px' );
					this.zIndex = this.options.max_index - data.index;
				} else if ( $el.hasClass( 'fix-bottom' ) ) {
					$el.css( 'margin-bottom', data.offsetBottom + 'px' );
					this.zIndex = this.options.max_index - data.index;
				} else {
					$el.css( { 'transition': 'opacity .5s', 'z-index': this.zIndex } );
				}

				// update sticky status
				if ( this.options.scrollMode ) {
					if ( this.scrollPos >= pageYOffset && $el.hasClass( 'fix-top' ) ||
						this.scrollPos <= pageYOffset && $el.hasClass( 'fix-bottom' ) ) {

						$el.addClass( 'fixed' );
						this.onFixed && this.onFixed();
					} else {
						$el.removeClass( 'fixed' ).css( 'margin-top', '' ).css( 'margin-bottom', '' );
						this.onUnfixed && this.onUnfixed();
					}
					this.scrollPos = pageYOffset;
				} else {
					$el.addClass( 'fixed' );
					this.onFixed && this.onFixed();
				}

				// stack offset
				if ( $el.hasClass( 'fixed' ) ) {
					if ( $el.hasClass( 'fix-top' ) ) {
						data.offsetTop += $el[ 0 ].offsetHeight;
					} else if ( $el.hasClass( 'fix-bottom' ) ) {
						data.offsetBottom += $el[ 0 ].offsetHeight;
					}
				}
			} else {
				$el.parent().css( 'height', '' );
				$el.removeClass( 'fixed' ).css( { 'margin-top': '', 'margin-bottom': '', 'z-index': '' } );
				this.onUnfixed && this.onUnfixed();
			}
		}

		theme.$window.on( 'alpha_complete', function () {
			window.addEventListener( 'scroll', refreshAll, { passive: true } );
			theme.$window.on( 'resize', refreshAllSize );
			setTimeout( function () {
				refreshAllSize();
			}, 1000 );
		} )

		return function ( selector, options ) {
			theme.$( selector ).each( function () {
				var $this = $( this );
				$this.data( 'sticky-content' ) || $this.data( 'sticky-content', new StickyContent( $this, options ) );
			} )
		}
	} )()


	/**
	 * Register events for alert
	 * 
	 * @since 1.0
	 * @param {string} selector
	 * @return {void}
	 */
	theme.alert = function ( selector ) {
		theme.$body.on( 'click', selector + ' .btn-close', function ( e ) {
			e.preventDefault();
			if ( $( this ).closest( '.elementor-widget-' + alpha_vars.theme + '_widget_alert' ).length ) {
				selector = '.elementor-widget-' + alpha_vars.theme + '_widget_alert';
			}
			$( this ).closest( selector ).fadeOut( function () {
				$( this ).remove();
			} );
		} );
	}

	/**
	 * Register events for accordion
	 * 
	 * @since 1.0
	 * @param {string} selector
	 * @return {void}
	 */
	theme.accordion = function ( selector ) {
		theme.$body.on( 'click', selector, function ( e ) {
			var $this = $( this ),
				$body = $this.closest( '.card' ),
				$parent = $this.closest( '.accordion' );

			var link = $this.attr( 'href' );
			if ( '#' == link ) {
				$body = $body.children( ".card-body" );
			} else {
				$body = $body.find( '#' == link[ 0 ] ? $this.attr( 'href' ) : '#' + $this.attr( 'href' ) );
			}
			if ( !$body.length ) {
				return;
			}
			e.preventDefault();

			if ( !$parent.find( ".collapsing" ).length && !$parent.find( ".expanding" ).length ) {
				if ( $body.hasClass( 'expanded' ) ) {
					$parent.hasClass( 'radio-type' ) || slideToggle( $body );
				} else if ( $body.hasClass( 'collapsed' ) ) {
					if ( $parent.find( '.expanded' ).length > 0 ) {
						if ( theme.isIE ) {
							slideToggle( $parent.find( '.expanded' ), function () {
								slideToggle( $body );
							} );
						} else {
							slideToggle( $parent.find( '.expanded' ) );
							slideToggle( $body );
						}
					} else {
						slideToggle( $body );
					}
				}
			}
		} );

		// define slideToggle method
		var slideToggle = function ( $wrap, callback ) {
			var $card = $wrap.closest( '.card' ),
				$header = $card.find( selector );
			if ( $wrap.hasClass( "expanded" ) ) {
				$header.removeClass( "collapse" ).addClass( "expand" );
				$card.removeClass( "collapse" ).addClass( "expand" );
				$wrap.addClass( "collapsing" ).slideUp( 300, function () {
					$wrap.removeClass( "expanded collapsing" ).addClass( "collapsed" );
					callback && callback();
				} );
			} else if ( $wrap.hasClass( "collapsed" ) ) {
				$header.removeClass( "expand" ).addClass( "collapse" );
				$card.removeClass( "expand" ).addClass( "collapse" );
				$wrap.addClass( "expanding" ).slideDown( 300, function () {
					$wrap.removeClass( "collapsed expanding" ).addClass( "expanded" );
					callback && callback();
				} );
			}
		};
	}

	/**
	 * Register events for tab
	 * 
	 * @since 1.0
	 * @param string selector
	 * @return {void}
	 */
	theme.tab = function ( selector ) {

		theme.$body
			// tab nav link
			.on( 'click', selector + ' .nav-link', function ( e ) {
				var $link = $( this );

				// if tab is loading, return
				if ( $link.closest( selector ).hasClass( 'loading' ) ) {
					return;
				}

				// get href
				var href = 'SPAN' == this.tagName ? $link.data( 'href' ) : $link.attr( 'href' );

				// get panel
				var $panel;
				if ( '#' == href ) {
					$panel = $link.closest( '.nav' ).siblings( '.tab-content' ).children( '.tab-pane' ).eq( $link.parent().index() );
				} else {
					$panel = $( ( '#' == href.substring( 0, 1 ) ? '' : '#' ) + href );
				}
				if ( !$panel.length ) {
					return;
				}

				e.preventDefault();

				var $activePanel = $panel.parent().children( '.active' );


				if ( $link.hasClass( "active" ) || !href ) {
					return;
				}
				// change active link
				$link.parent().parent().find( '.active' ).removeClass( 'active' );
				$link.addClass( 'active' );

				theme.loadTemplate( $panel );
				theme.slider( $panel.find( '.slider-wrapper' ) );
				$activePanel.removeClass( 'in active' );
				$panel.addClass( 'active in' );
				theme.refreshLayouts();
			} )
	}

	/**
	 * Playable video
	 * 
	 * @since 1.0
	 * @param {string} selector
	 * @return {void}
	 */
	theme.playableVideo = function ( selector ) {
		$( selector + ' .video-play' ).on( 'click', function ( e ) {
			var $video = $( this ).closest( selector );
			if ( $video.hasClass( 'playing' ) ) {
				$video.removeClass( 'playing' )
					.addClass( 'paused' )
					.find( 'video' )[ 0 ].pause();
			} else {
				$video.removeClass( 'paused' )
					.addClass( 'playing' )
					.find( 'video' )[ 0 ].play();
			}
			e.preventDefault();
		} );
		$( selector + ' video' ).on( 'ended', function () {
			$( this ).closest( '.post-video' ).removeClass( 'playing' );
		} );
	}


	/**
	 * Run appear animation
	 * 
	 * @since 1.0
	 * @param {string} selector
	 * @return {void}
	 */
	theme.appearAnimate = function ( selector ) {
		var appearClass = typeof selector == 'string' && selector.indexOf( 'elementor-invisible' ) > 0 ? 'elementor-invisible' : 'appear-animate';

		theme.$( selector ).each( function () {
			var el = this;
			theme.appear( el, function () {
				if ( el.classList.contains( appearClass ) && !el.classList.contains( 'appear-animation-visible' ) ) {
					var settings = theme.parseOptions( el.getAttribute( 'data-settings' ) ),
						duration = 1000;

					if ( el.classList.contains( 'animated-slow' ) ) {
						duration = 2000;
					} else if ( el.classList.contains( 'animated-fast' ) ) {
						duration = 750;
					}

					theme.call( function () {
						el.style[ 'animation-duration' ] = duration + 'ms';
						el.style[ 'animation-delay' ] = settings._animation_delay + 'ms';
						el.style[ 'transition-property' ] = 'visibility, opacity';
						el.style[ 'transition-duration' ] = '0s';
						el.style[ 'transition-delay' ] = settings._animation_delay + 'ms';

						var animation_name = settings.animation || settings._animation || settings._animation_name;
						animation_name && el.classList.add( animation_name );

						el.classList.add( 'appear-animation-visible' );
						setTimeout(
							function () {
								el.style[ 'transition-property' ] = '';
								el.style[ 'transition-duration' ] = '';
								el.style[ 'transition-delay' ] = '';

								el.classList.add( 'animating' );

								setTimeout( function () {
									el.classList.add( 'animated-done' );
								}, duration );
							},
							settings._animation_delay ? settings._animation_delay + 500 : 500
						);
					} );
				}
			} );
		} );

		if ( typeof elementorFrontend == 'object' ) {
			theme.$window.trigger( 'resize.waypoints' );
		}
	}

	var videoIndex = {
		youtube: 'youtube.com',
		vimeo: 'vimeo.com/',
		gmaps: '//maps.google.',
		hosted: ''
	}

	/**
	 * Initialize popups
	 *
	 * @since 1.0
	 * @return {void}
	 */
	theme.initPopups = function () {

		// Register "Play Video" Popup
		theme.$body.on( 'click', '.btn-video-iframe', function ( e ) {
			e.preventDefault();
			theme.popup( {
				items: {
					src: '<video src="' + videoIndex[ $( this ).data( 'video-source' ) ] + $( this ).attr( 'href' ) + '" autoplay loop controls>',
					type: 'inline'
				},
				mainClass: 'mfp-video-popup'
			}, 'video' );
		} );

		// Close mangific popup by mousedown on outside of the content
		function closePopupByClickBg( e ) {
			var $this = $( e.target );
			if ( $this.closest( '.mfp-gallery' ).length ) {
				return;
			}
			if ( !$this.closest( '.mfp-content' ).length || $this.hasClass( 'mfp-content' ) ) {
				$.magnificPopup.instance.close();
			}
		}

		theme.$body.on( 'mousedown', '.mfp-wrap', closePopupByClickBg );
		if ( 'ontouchstart' in document ) {
			document.body.addEventListener( 'touchstart', closePopupByClickBg, { passive: true } );
		}

		/**
		 * Open first popup
		 * 
		 * @since 1.0
		 */
		function openFirstPopup( $this ) {
			var options = theme.parseOptions( $this.attr( 'data-popup-options' ) );
			setTimeout( function () {
				if ( theme.getCookie( 'hideNewsletterPopup' ) ) {
					return;
				}
				$this.imagesLoaded( function () {
					theme.popup( {
						mainClass: 'mfp-fade mfp-alpha mfp-alpha-' + options.popup_id,
						items: {
							src: $this.get( 0 )
						},
						callbacks: {
							open: function () {
								this.content.css( { 'animation-duration': options.popup_duration, 'animation-timing-function': 'linear' } );
								this.content.addClass( options.popup_animation + ' animated' );

								$( '#alpha-popup-' + options.popup_id ).css( 'display', '' );
							}
						}
					}, 'firstpopup' );
				} );
			}, 1000 * options.popup_delay );
		}

		// Open first popup
		$( 'body > .popup' ).each( function ( e ) {
			var $this = $( this );
			if ( $this.attr( 'data-popup-options' ) ) {
				openFirstPopup( $this );
			}
		} );

		// Popup on click event
		theme.$body.on( 'click', '.show-popup', function ( e ) {

			e.preventDefault();

			var id = -1;
			for ( var className of this.classList ) {
				className && className.startsWith( 'popup-id-' ) && ( id = className.substr( 9 ) );
			}

			theme.popup( {
				mainClass: 'mfp-alpha mfp-alpha-' + id,
				ajax: {
					settings: {
						data: {
							action: 'alpha_print_popup',
							nonce: alpha_vars.nonce,
							popup_id: id
						}
					}
				},
				callbacks: {
					afterChange: function () {
						this.container.html( '<div class="mfp-content"></div><div class="mfp-preloader"><div class="popup-template"><div class="d-loading"><i></i></div></div></div>' );
						this.contentContainer = this.container.children( '.mfp-content' );
						this.preloader = false;
					},
					beforeClose: function () {
						this.container.empty();
					},
					ajaxContentAdded: function () {
						var self = this,
							$popupContainer = this.container.find( '.popup' ),
							options = JSON.parse( $popupContainer.attr( 'data-popup-options' ) );

						self.contentContainer.next( '.mfp-preloader' ).css( 'max-width', $popupContainer.css( 'max-width' ) );
						setTimeout( function () {
							self.contentContainer.next( '.mfp-preloader' ).remove();
						}, 10000 );

						this.container.css( { 'animation-duration': options.popup_duration, 'animation-timing-function': 'linear' } );
						this.container.addClass( options.popup_animation + ' animated' );
						$( '#alpha-popup-' + id ).css( 'display', '' );
					}
				}
			}, 'popup_template' );
		} )
	}

	/**
	 * Initialize scroll to top button
	 * 
	 * @since 1.0
	 * @return {void}
	 */
	theme.initScrollTopButton = function () {
		// register scroll top button
		var domScrollTop = theme.byId( 'scroll-top' );
		if ( domScrollTop ) {
			theme.$body.on( 'click', '#scroll-top', function ( e ) {
				theme.scrollTo( 0 );
				e.preventDefault();
			} )

			function _refreshScrollTop() {
				if ( window.pageYOffset > 200 ) { // issue: heavy js performance, 8.3ms
					domScrollTop.classList.add( 'show' );

					// Show scroll position percent in scroll top button
					var d_height = $( document ).height(),
						w_height = $( window ).height(),
						c_scroll_pos = $( window ).scrollTop();

					var perc = c_scroll_pos / ( d_height - w_height ) * 214;

					if ( $( '#progress-indicator' ).length > 0 ) {
						$( '#progress-indicator' ).css( 'stroke-dasharray', perc + ', 400' );
					}
				} else {
					domScrollTop.classList.remove( 'show' );
				}
			}

			theme.call( _refreshScrollTop, 500 );
			window.addEventListener( 'scroll', _refreshScrollTop, { passive: true } );
		}
	}

	/**
	 * Initialize scroll to.
	 *
	 * @since 1.0
	 * @return {void}
	 */
	theme.initScrollTo = function () {

		// Scroll to hash target
		theme.scrollTo( theme.hash );

		// Scroll to target by click button.
		theme.$body.on( 'click', '.scroll-to', function ( e ) {
			var target = $( this ).attr( 'href' ).replace( location.origin + location.pathname, '' );
			if ( target.startsWith( '#' ) && target.length > 1 ) {
				e.preventDefault();
				theme.scrollTo( target );
			}
		} )
	}

	/**
	 * Initialize contact forms.
	 * 
	 * @since 1.0
	 * @return {void}
	 */
	theme.initContactForms = function () {
		$( '.wpcf7-form [aria-required="true"]' ).prop( 'required', true );
	}


	/**
	 * Initialize search form.
	 * 
	 * @since 1.0
	 * @return {void}
	 */
	theme.initSearchForm = function () {
		var $search = $( '.search-wrapper' );

		theme.$body.on( 'click', '.hs-toggle .search-toggle', function ( e ) {
			$search = $( this ).closest( '.hs-toggle' );
			theme.preventDefault( e );
			$search.toggleClass( 'show' );
			theme.requestTimeout( function () {
				$search.find( 'input[type=search]' ).focus();
			}, 300 );
		} )
		if ( 'ontouchstart' in document ) {
			$search.find( '.search-toggle' ).on( 'click', function ( e ) {
				$search = $( this ).closest( '.hs-toggle' );
				$search.toggleClass( 'show' );
			} );
			theme.$body.on( 'click', function ( e ) {
				$search = $( this ).closest( '.hs-toggle' );
				$search.removeClass( 'show' );
			} )
			$search.on( 'click', function ( e ) {
				theme.preventDefault( e );
				e.stopPropagation();
			} )
		} else if ( $search.hasClass( 'hs-dropdown' ) ) {
			$search.find( '.form-control' ).on( 'focusin', function ( e ) {
				$search = $( this ).closest( '.hs-toggle' );
				$search.addClass( 'show' );
			} ).on( 'focusout', function ( e ) {
				$search = $( this ).closest( '.hs-toggle' );
				$search.removeClass( 'show' );
			} );
		}
		// full screen search
		if ( $search.hasClass( 'hs-fullscreen' ) && $search.length ) {
			var headerHeight = $( 'header' ).height();
			$search.find( '.search-form-wrapper' ).css( 'min-height', headerHeight + 60 );
			$search.find( '.scrollable' ).css( 'max-height', 'calc(100vh - ' + ( headerHeight + 150 ) + 'px)' );
			$search.on( 'click touchstart', '.search-toggle', function ( e ) {
				var scrollBarWidth = window.innerWidth - document.body.clientWidth;
				$( 'body' ).css( 'overflow', 'hidden' );
				$( 'body' ).css( 'margin-right', scrollBarWidth + 'px' );
				e.preventDefault();
			} );
		}

		// overlap 
		if ( $search.hasClass( 'hs-overlap' ) ) {
			$search.find( '.hs-close' ).on( 'click', function ( e ) {
				e.preventDefault();
				$( this ).closest( '.search-wrapper' ).removeClass( 'show' );
			} );
		}
		$( window ).on( 'resize', function () {
			$( 'body' ).css( 'overflow', '' );
			$( 'body' ).css( 'margin-right', '' );
		} );
	}

	/**
	 * Compatibility with Elementor
	 * 
	 * @since 1.0
	 * @return {void}
	 */
	theme.initElementor = function () {
		if ( 'undefined' != typeof elementorFrontend ) {
			// Compatibility with Elementor Counter Widget
			elementorFrontend.waypoint( $( '.elementor-counter-number' ), function () {
				var $this = $( this ),
					data = $this.data(),
					decimalDigits = data.toValue.toString().match( /\.(.*)/ );

				if ( decimalDigits ) {
					data.rounding = decimalDigits[ 1 ].length;
				}

				$this.numerator( data );
			} );
		}
	}


	/**
	 * Compatibility with Vendor plugins
	 * 
	 * @since 1.0
	 * @return {void}
	 */
	theme.initVendorCompatibility = function () {

		// Dokan / 
		theme.$body.on( 'keydown', '.store-search-input', function ( e ) {
			if ( e.keyCode == 13 ) {
				setTimeout( function () {
					$( '#dokan-store-listing-filter-form-wrap #apply-filter-btn' ).trigger( 'click' );
				}, 150 );
			}
		} );

		// WC Marketplace
		theme.$body
			.on( 'click', '.wcmp-report-abouse-wrapper .close', function ( e ) {
				$( ".wcmp-report-abouse-wrapper #report_abuse_form_custom" ).fadeOut( 100 );
			} )
			.on( 'click', '.wcmp-report-abouse-wrapper #report_abuse', function ( e ) {
				$( ".wcmp-report-abouse-wrapper #report_abuse_form_custom" ).fadeIn( 100 );
			} );

		$( 'select#rating' ).prev( 'p.stars' ).prevAll( 'p.stars' ).remove();

		// Single product / summary / "more products" button
		theme.$body.on( 'click', '.goto_more_offer_tab', function ( e ) {
			e.preventDefault();
			if ( !$( '.singleproductmultivendor_tab' ).hasClass( 'active' ) ) {
				$( '.singleproductmultivendor_tab a, #tab_singleproductmultivendor' ).trigger( 'click' );
			}
			if ( $( '.woocommerce-tabs' ).length > 0 ) {
				$( 'html, body' ).animate( {
					scrollTop: $( ".woocommerce-tabs" ).offset().top - 120
				}, 1500 );
			}
		} );
	}

	/**
	 * Initialize floating elements
	 * 
	 * @since 1.0
	 * @param {string|jQuery} selector
	 * @return {void}
	 */
	theme.initFloatingElements = function ( selector ) {
		if ( $.fn.parallax ) {
			var $selectors = '';

			if ( selector ) {
				$selectors = selector;
			} else {
				$selectors = $( '[data-plugin="floating"]' );
			}

			$selectors.each( function ( e ) {
				var $this = $( this );
				if ( $this.data( 'parallax' ) ) {
					$this.parallax( 'disable' );
					$this.removeData( 'parallax' );
					$this.removeData( 'options' );
				}
				if ( $this.hasClass( 'elementor-element' ) ) {
					$this.children( '.elementor-widget-container, .elementor-container' ).addClass( 'layer' ).attr( 'data-depth', $this.attr( 'data-floating-depth' ) );
				} else {
					$this.children( '.layer' ).attr( 'data-depth', $this.attr( 'data-floating-depth' ) );
				}
				$this.parallax( $this.data( 'options' ) );
			} );
		}
	}

	/**
	 * Initialize advanced motions
	 *
	 * @since 1.0
	 * @param {string} selector
	 * @param {string} action
	 * @return {void}
	 */
	theme.initAdvancedMotions = function ( selector, action ) {
		if ( theme.isMobile ) {
			return;
		}

		if ( typeof skrollr == 'undefined' ) {
			return;
		}

		var $selectors = '';

		if ( selector ) {
			$selectors = selector;
		} else {
			$selectors = $( '[data-plugin="skrollr"]' );
		}

		$selectors.removeAttr( 'data-bottom-top data-top data-center-top' ).css( {} );
		if ( skrollr.get() ) {
			skrollr.get().destroy();
		}

		if ( action == 'destroy' ) {
			$selectors.removeAttr( 'data-plugin data-options' );
			return;
		}

		$selectors.each( function ( e ) {
			var $this = $( this ),
				options = {},
				keys = [];

			if ( $( this ).attr( 'data-options' ) ) {
				options = JSON.parse( $( this ).attr( 'data-options' ) );
				keys = Object.keys( options );
			}

			if ( 'object' == typeof options && ( keys = Object.keys( options ) ).length ) {
				keys.forEach( function ( key ) {
					$this.attr( key, options[ key ] );
				} )
			}
		} );

		if ( $selectors.length ) {
			skrollr.init( { forceHeight: false, smoothScrolling: true } );
		}
	}

	/**
	 * Initialize video player
	 * 
	 * @since 1.0
	 * @param selector 
	 * @return {void}
	 */
	theme.initVideoPlayer = function ( selector ) {
		if ( typeof selector == 'undefined' ) {
			selector = '.btn-video-player';
		}
		theme.$( selector ).on( 'click', function ( e ) {
			var video_banner = $( this ).closest( '.video-banner' );
			if ( video_banner.length && video_banner.find( 'video' ).length ) {
				var video = video_banner.find( 'video' );
				video = video[ 0 ];

				if ( video_banner.hasClass( 'playing' ) ) {
					video_banner.removeClass( 'playing' ).addClass( 'paused' );
					video.pause();
				} else {
					video_banner.removeClass( 'paused' ).addClass( 'playing' );
					video.play();
				}
			}

			if ( video_banner.find( '.parallax-background' ).length > 0 ) {
				video_banner.find( '.parallax-background' ).css( 'z-index', '-1' );
			}
			e.preventDefault();
		} )
		theme.$( selector ).closest( '.video-banner' ).find( 'video' ).on( 'playing', function () {
			$( this ).closest( '.video-banner' ).removeClass( 'paused' ).addClass( 'playing' );
		} )
		theme.$( selector ).closest( '.video-banner' ).find( 'video' ).on( 'ended', function () {
			$( this ).closest( '.video-banner' ).removeClass( 'playing' ).addClass( 'paused' );
		} )
	}

	/**
	 * Initialize ajax load post
	 *
	 * @since 1.0
	 * @return {void}
	 */
	theme.initAjaxLoadPost = ( function () {
		/**
		 * Alpha Ajax Filter
		 *
		 * @class AjaxLoadPost
		 * @since 1.0
		 * - Ajax load for products and posts in archive pages and widgets
		 * - Ajax filter products and posts
		 * - Load more by button or infinite scroll
		 * - Ajax pagination
		 * - Compatibility with YITH WooCommerce Ajax Navigation
		 */
		var AjaxLoadPost = {
			isAjaxShop: alpha_vars.shop_ajax ? $( document.body ).hasClass( 'alpha-archive-product-layout' ) : false,
			isAjaxBlog: alpha_vars.blog_ajax ? $( document.body ).hasClass( 'alpha-archive-post-layout' ) : false,
			scrollWrappers: false,
			ajax_tab_cache: {},
			/**
			 * Initialize
			 *
			 * @since 1.0
			 * @return {void}
			 */
			init: function () {

				if ( AjaxLoadPost.isAjaxShop ) {
					theme.$body
						.on( 'click', '.widget_product_categories a, .wc-block-product-categories-list-item a', this.filterByCategory )				// Product Category
						.on( 'click', '.widget_product_tag_cloud a', this.filterByLink )					// Product Tag Cloud
						.on( 'click', '.alpha-price-filter a', this.filterByLink )						// Alpha - Price Filter
						.on( 'click', '.woocommerce-widget-layered-nav a', this.filterByLink )			// Filter Products by Attribute
						.on( 'click', '.widget-filter-attribute a', this.filterByLink )					// Filter Products by Attributes
						.on( 'click', '.widget_price_filter .button', this.filterByPrice )				// Filter Products by Price
						.on( 'submit', '.alpha-price-range', this.filterByPriceRange )					// Filter Products by Price Range
						.on( 'click', '.widget_rating_filter a', this.filterByRating )					// Filter Products by Rating
						.on( 'click', '.filter-clean', this.filterByLink )								// Reset Filter
						.on( 'click', '.toolbox-show-type .btn-showtype', this.changeShowType )			// Change Show Type
						.on( 'change', '.toolbox-show-count .count', this.changeShowCount )				// Change Show Count
						.on( 'click', '.yith-woo-ajax-navigation a', this.saveLastYithAjaxTrigger )       // Compatibility with YITH ajax navigation
						.on( 'change', '.sidebar select.dropdown_product_cat', this.filterByCategory )    // Filter by category dropdown
						.on( 'click', '.categories-filter-shop .product-category a', this.filterByCategory ) // Filter by product categories widget in shop page
						.on( 'click', '.product-archive + div .pagination a', this.loadmoreByPagination ) // Load by pagination in shop page

					$( '.toolbox .woocommerce-ordering' )													// Orderby
						.off( 'change', 'select.orderby' ).on( 'change', 'select.orderby', this.sortProducts );

					$( '.product-archive > .woocommerce-info' ).wrap( '<ul class="products"></ul>' );

					if ( !alpha_vars.skeleton_screen ) {
						$( '.sidebar .dropdown_product_cat' ).off( 'change' );
					}
				} else {
					theme.$body
						.on( 'change', '.toolbox-show-count .count', this.changeShowCountPage )            // Change Show Count when ajax disabled
						.on( 'change', '.sidebar select.dropdown_product_cat', this.changeCategory )		 // Change category by dropdown

					AjaxLoadPost.initSelect2();
				}

				AjaxLoadPost.isAjaxBlog && theme.$body
					.on( 'click', '.widget_categories a', this.filterPostsByLink )                    // Filter blog by categories
					// .on('click', '.widget_tag_cloud a', this.filterPostsByLink)                  // Filter blog by tag
					.on( 'click', '.post-archive .post-filters a', this.filterPostsByLink )           // Filter blog by categories filter
					.on( 'click', '.post-archive .pagination a', this.loadmoreByPagination )          // Load by pagination in shop page

				theme.$body
					.on( 'click', '.btn-load', this.loadmoreByButton )						        // Load by button
					.on( 'click', '.products + .pagination a', this.loadmoreByPagination )              // Load by pagination in products widget
					.on( 'click', '.products .pagination a', this.loadmoreByPagination )              // Load by pagination in products widget
					.on( 'click', '.product-filters .nav-filter', this.filterWidgetByCategory )	    // Load by Nav Filter
					.on( 'click', '.filter-categories a', this.filterWidgetByCategory )		        // Load by Categories Widget's Filter
					.on( 'click', 'div:not(.post-archive) > .posts + .pagination a', this.loadmoreByPagination )				// Load by pagination in posts widget

				theme.$window.on( 'alpha_complete alpha_loadmore', this.startScrollLoad );	    // Load by infinite scroll


				// YITH AJAX Navigation Plugin Compatibility
				if ( typeof yith_wcan != 'undefined' ) {
					$( document )
						.on( 'yith-wcan-ajax-loading', this.loadingPage )
						.on( 'yith-wcan-ajax-filtered', this.loadedPage );

					// Issue for multiple products in shop pages.
					$( '.yit-wcan-container' ).each( function () {
						$( this ).parent( '.product-archive' ).length || $( this ).children( '.products' ).addClass( 'ywcps-products' ).unwrap();
					} );
					yith_wcan.container = '.product-archive .products';
				}
			},

			/**
			 * Run select2 js plugin
			 */
			initSelect2: function () {
				if ( $.fn.selectWoo ) {
					$( '.dropdown_product_cat' ).selectWoo( {
						placeholder: alpha_vars.select_category,
						minimumResultsForSearch: 5,
						width: '100%',
						allowClear: true,
						language: {
							noResults: function () {
								return alpha_vars.no_matched
							}
						}
					} )
				}
			},

			/**
			 * Event handler to change show count for non ajax mode.
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
			changeShowCountPage: function ( e ) {
				if ( this.value ) {
					location.href = theme.addUrlParam( location.href.replace( /\/page\/\d*/, '' ), 'count', this.value );
				}
			},

			/**
			 * Event handler to change category by dropdown
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
			changeCategory: function ( e ) {
				location.href = this.value ? theme.addUrlParam( alpha_vars.home_url, 'product_cat', this.value ) : alpha_vars.shop_url;
			},

			/**
			 * Event handler to filter posts by link
			 *
			 * @since 1.0
			 * @param {Event} e 
			 */
			filterPostsByLink: function ( e ) {

				// If link's toggle is clicked, return
				if ( ( e.target.tagName == 'I' || e.target.classList.contains( 'toggle-btn' ) ) && e.target.parentElement == e.currentTarget ) {
					return;
				}

				var $link = $( e.currentTarget );

				if ( $link.hasClass( 'active' ) || $link.parent().hasClass( 'current-cat' ) ) {
					e.preventDefault();
					return;
				}
				if ( $link.is( '.nav-filters .nav-filter' ) ) {
					$link.closest( '.nav-filters' ).find( '.nav-filter' ).removeClass( 'active' );
					$link.addClass( 'active' )
				}

				var $container = $( '.post-archive .posts' );

				if ( !$container.length ) {
					return;
				}

				if ( AjaxLoadPost.isAjaxBlog && AjaxLoadPost.doLoading( $container, 'filter' ) ) {
					e.preventDefault();
					var url = theme.addUrlParam( e.currentTarget.getAttribute( 'href' ), 'only_posts', 1 );
					var postType = $container.data( 'post-type' );
					if ( postType ) {
						url = theme.addUrlParam( url, 'post_style_type', postType );
					}
					$.get( encodeURI( decodeURIComponent( decodeURI( url.replace( /\/page\/(\d*)/, '' ) ) ) ), function ( res ) {
						res && AjaxLoadPost.loadedPage( 0, res, url );
					} );
				}
			},

			/**
			 * Event handler to filter products by price
			 *
			 * @since 1.0
			 * @param {Event} e 
			 */
			filterByPrice: function ( e ) {
				e.preventDefault();
				var url = location.href,
					minPrice = $( e.currentTarget ).siblings( '#min_price' ).val(),
					maxPrice = $( e.currentTarget ).siblings( '#max_price' ).val();
				minPrice && ( url = theme.addUrlParam( url, 'min_price', minPrice ) );
				maxPrice && ( url = theme.addUrlParam( url, 'max_price', maxPrice ) );
				AjaxLoadPost.loadPage( url );
			},

			/**
			 * Event handler to filter products by price
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
			filterByPriceRange: function ( e ) {
				e.preventDefault();
				var url = location.href,
					minPrice = $( e.currentTarget ).find( '.min_price' ).val(),
					maxPrice = $( e.currentTarget ).find( '.max_price' ).val();
				url = minPrice ? theme.addUrlParam( url, 'min_price', minPrice ) : theme.removeUrlParam( url, 'min_price' );
				url = maxPrice ? theme.addUrlParam( url, 'max_price', maxPrice ) : theme.removeUrlParam( url, 'max_price' );
				url != location.href && AjaxLoadPost.loadPage( url );
			},

			/**
			 * Event handler to filter products by rating
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
			filterByRating: function ( e ) {
				var match = e.currentTarget.getAttribute( 'href' ).match( /rating_filter=(\d)/ );
				if ( match && match[ 1 ] ) {
					e.preventDefault();
					AjaxLoadPost.loadPage( theme.addUrlParam( location.href, 'rating_filter', match[ 1 ] ) );
				}
			},

			/**
			 * Event handler to filter products by link
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
			filterByLink: function ( e ) {
				e.preventDefault();
				AjaxLoadPost.loadPage( e.currentTarget.getAttribute( 'href' ) );
			},

			/**
			 * Event handler to filter products by category
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
			filterByCategory: function ( e ) {
				e.preventDefault();

				var url;
				var isFromFilterWidget = false;

				if ( e.type == 'change' ) { // Dropdown's event
					url = this.value ? theme.addUrlParam( alpha_vars.home_url, 'product_cat', this.value ) : alpha_vars.shop_url;

				} else { // Link's event
					// If link's toggle is clicked, return
					if ( e.target.parentElement == e.currentTarget ) {
						return;
					}
					var $link = $( e.currentTarget );

					if ( $link.is( '.categories-filter-shop .product-category a' ) ) {
						// Products categories widget
						var $category = $link.closest( '.product-category' );
						if ( $category.hasClass( 'active' ) ) {
							return;
						}
						$category.closest( '.categories-filter-shop' ).find( '.product-category' ).removeClass( 'active' );
						$category.addClass( 'active' );
						isFromFilterWidget = true;

					} else {
						// Product categories sidebar widget
						if ( $link.hasClass( 'active' ) || $link.parent().hasClass( 'current-cat' ) ) {
							// If it's active, return
							return;
						}
					}
					url = $link.attr( 'href' );
				}

				// Make current category active in categories-filter-shop widgets
				if ( !isFromFilterWidget ) {
					theme.$body.one( 'alpha_ajax_shop_layout', function () {
						$( '.categories-filter-shop .product-category a' ).each( function () {
							$( this ).closest( '.product-category' ).toggleClass( 'active', this.href == location.href );
						} )
					} );
				}

				AjaxLoadPost.loadPage( url );
			},

			/**
			 * Event handler to filter products by category.
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
			saveLastYithAjaxTrigger: function ( e ) {
				AjaxLoadPost.lastYithAjaxTrigger = e.currentTarget;
			},

			/**
			 * Event handler to change show type.
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
			changeShowType: function ( e ) {
				e.preventDefault();
				if ( !this.classList.contains( 'active' ) ) {
					var type = this.classList.contains( alpha_vars.theme_icon_prefix + '-icon-list' ) ? 'list' : 'grid';
					$( '.product-archive .products' ).data( 'loading_show_type', type )	// For skeleton screen
					$( this ).parent().children().toggleClass( 'active' );				// Toggle active class
					AjaxLoadPost.loadPage(
						theme.addUrlParam( location.href, 'showtype', type ),
						{ showtype: type }
					);
				}
			},

			/**
			 * Event handler to change order.
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
			sortProducts: function ( e ) {
				AjaxLoadPost.loadPage( theme.addUrlParam( location.href, 'orderby', this.value ) );
			},

			/**
			 * Event handler to change show count.
			 * 
			 * @since 1.0
			 * @param {Event} e 
			 */
			changeShowCount: function ( e ) {
				AjaxLoadPost.loadPage( theme.addUrlParam( location.href, 'count', this.value ) );
			},

			/**
			 * Refresh widgets
			 * 
			 * @since 1.0
			 * @param {string} widgetSelector
			 * @param {jQuery} $newContent 
			 */
			refreshWidget: function ( widgetSelector, $newContent ) {
				var newWidgets = $newContent.find( '.sidebar ' + widgetSelector ),
					oldWidgets = $( '.sidebar ' + widgetSelector );

				oldWidgets.length && oldWidgets.each( function ( i ) {
					// if new widget exists
					if ( newWidgets.eq( i ).length ) {
						this.innerHTML = newWidgets.eq( i ).html();
					} else {
						// else
						$( this ).find( '.woocommerce-widget-layered-nav-list' ).empty();
					}
				} );
			},

			/**
			 * Refresh button
			 * 
			 * @since 1.0
			 * @param {jQuery} $wrapper
			 * @param {jQuery} $newButton
			 * @param {object} options
			 */
			refreshButton: function ( $wrapper, $newButton, options ) {
				var $btn = $wrapper.siblings( '.btn-load' );

				if ( typeof options != 'undefined' ) {
					if ( typeof options == 'string' && options ) {
						options = JSON.parse( options );
					}
					if ( !options.args || !options.args.paged || options.max > options.args.paged ) {
						if ( $btn.length ) {
							$btn[ 0 ].outerHTML = $newButton.length ? $newButton[ 0 ].outerHTML : '';
						} else {
							$newButton.length && $wrapper.after( $newButton );
						}
						return;
					}
				}

				$btn.remove();
			},

			/**
			 * Process before load 
			 * 
			 * data can be {showtype: (boolean)} or omitted.
			 *
			 * @since 1.0
			 * @param {string} url
			 * @param {mixed} data
			 */
			loadPage: function ( url, data ) {
				AjaxLoadPost.loadingPage();

				// If it's not "show type change" load, remove page number from url
				if ( 'undefined' == typeof showtype ) {
					url = encodeURI( decodeURIComponent( decodeURI( url.replace( /\/page\/(\d*)/, '' ) ) ) );
				}

				// Add show type if current layout is list
				if ( data && 'list' == data.showtype || ( !data || 'undefined' == typeof data.showtype ) && 'list' == theme.getUrlParam( location.href, 'showtype' ) ) {
					url = theme.addUrlParam( url, 'showtype', 'list' );
				} else {
					url = theme.removeUrlParam( url, 'showtype' );
				}

				// Add show count if current show count is set, except show count change
				if ( !theme.getUrlParam( url, 'count' ) ) {
					var showcount = theme.getUrlParam( location.href, 'count' );
					if ( showcount ) {
						url = theme.addUrlParam( url, 'count', showcount );
					}
				}

				$.get( theme.addUrlParam( url, 'only_posts', 1 ), function ( res ) {
					res && AjaxLoadPost.loadedPage( 0, res, url );
				} );
			},

			/**
			 * Process while loading. 
			 * 
			 * @since 1.0
			 * @param {Event} e
			 */
			loadingPage: function ( e ) {
				var $container = $( '.product-archive .products' );

				if ( $container.length ) {
					if ( e && e.type == 'yith-wcan-ajax-loading' ) {
						$container.removeClass( 'yith-wcan-loading' ).addClass( 'product-filtering' );
					}
					if ( AjaxLoadPost.doLoading( $container, 'filter' ) ) {
						theme.scrollToFixedContent(
							( $( '.toolbox-top' ).length ? $( '.toolbox-top' ) : $wrapper ).offset().top - 20,
							400
						);
					}
				}
			},

			/**
			 * Process after load 
			 * 
			 * @since 1.0
			 * @param {Event} e
			 * @param {string} res
			 * @param {string} url
			 * @param {string} loadmore_type
			 */
			loadedPage: function ( e, res, url, loadmore_type ) {
				var $res = $( res );
				$res.imagesLoaded( function () {

					var $container, $newContainer;

					// Update browser history (IE doesn't support it)
					if ( url && !theme.isIE && loadmore_type != 'button' && loadmore_type != 'scroll' ) {
						history.pushState( { pageTitle: res && res.pageTitle ? '' : res.pageTitle }, "", theme.removeUrlParam( url, 'only_posts' ) );
					}

					if ( typeof loadmore_type == 'undefined' ) {
						loadmore_type = 'filter';
					}

					if ( AjaxLoadPost.isAjaxBlog ) {
						$container = $( '.post-archive .posts' );
						$newContainer = $res.find( '.post-archive .posts' );
						if ( !$newContainer.length ) {
							$res.each( function () {
								var $this = $( this );
								if ( $this.hasClass( 'post-archive' ) ) {
									$newContainer = $this.find( '.posts' );
									return false;
								}
							} );
						}
					} else if ( AjaxLoadPost.isAjaxShop ) {
						$container = $( '.product-archive .products' );
						$newContainer = $res.find( '.product-archive .products' );
					} else {
						$container = $( '.post-archive .posts' );
						$newContainer = $res.find( '.post-archive .posts' );
						if ( !$newContainer.length ) {
							$newContainer = $res.find( '.posts' );
						}

						// Update Loadmore - Button
						if ( $container.hasClass( 'posts' ) ) { // Blog Archive
							AjaxLoadPost.refreshButton( $container, $newContainer.siblings( '.btn-load' ), $container.attr( 'data-load' ) );
						} else {
							$container = $( '.product-archive .products' );
							$newContainer = $res.find( '.product-archive .products' );

							if ( $container.hasClass( 'products' ) ) { // Shop Archive
								var $parent = $( '.product-archive' ),
									$newParent = $res.find( '.product-archive' );
								AjaxLoadPost.refreshButton( $parent, $newParent.siblings( '.btn-load' ), $container.attr( 'data-load' ) );
							}
						}
						return;
					}

					// Change content and update status.
					// When loadmore by button, scroll or pagination is performing, the 'loadmore' function performs this.
					if ( loadmore_type == 'filter' ) {
						$container.html( $newContainer.html() );
						AjaxLoadPost.endLoading( $container, loadmore_type );

						// Update Loadmore
						if ( $newContainer.attr( 'data-load' ) ) {
							$container.attr( 'data-load', $newContainer.attr( 'data-load' ) );
						} else {
							$container.removeAttr( 'data-load' );
						}
					}

					// Change page title bar
					$( '.page-title-bar' ).html( $res.find( '.page-title-bar' ).length ? $res.find( '.page-title-bar' ).html() : '' );


					if ( AjaxLoadPost.isAjaxBlog ) { // Blog Archive

						// Update Loadmore - Button
						AjaxLoadPost.refreshButton( $container, $newContainer.siblings( '.btn-load' ), $container.attr( 'data-load' ) );

						// Update Loadmore - Pagination
						var $pagination = $container.siblings( '.pagination' ),
							$newPagination = $newContainer.siblings( '.pagination' );

						if ( $pagination.length ) {
							$pagination[ 0 ].outerHTML = $newPagination.length ? $newPagination[ 0 ].outerHTML : '';
						} else {
							$newPagination.length && $container.after( $newPagination );
						}

						// Update sidebar widgets
						AjaxLoadPost.refreshWidget( '.widget_categories', $res );
						AjaxLoadPost.refreshWidget( '.widget_tag_cloud', $res );

						// Update nav filter
						var $newNavFilters = $res.find( '.post-archive .nav-filters' );
						$newNavFilters.length && $( '.post-archive .nav-filters' ).html( $newNavFilters.html() );

						// Init posts
						AjaxLoadPost.fitVideos( $container );
						theme.slider( '.post-media-carousel' );

						theme.$body.trigger( 'alpha_ajax_blog_layout', $container, res, url, loadmore_type );

					} else if ( AjaxLoadPost.isAjaxShop ) { // Products Archive

						var $parent = $( '.product-archive' ),
							$newParent = $res.find( '.product-archive' );

						// If new content is empty, show woocommerce info.
						if ( !$newContainer.length ) {
							$container.empty().append( $res.find( '.woocommerce-info' ) );
						}

						// Update Toolbox Title
						var $newTitle = $res.find( '.main-content .toolbox .title' );
						$newTitle.length && $( '.main-content .toolbox .title' ).html( $newTitle.html() );

						// Update nav filter
						var $newNavFilters = $res.find( '.main-content .toolbox .nav-filters' );
						$newNavFilters.length && $( '.main-content .toolbox .nav-filters' ).html( $newNavFilters.html() );

						// Update Show Count
						if ( typeof loadmore_type != 'undefined' && ( loadmore_type == 'button' || loadmore_type == 'scroll' ) ) {
							var $span = $( '.main-content .woocommerce-result-count > span' );
							if ( $span.length ) {
								var newShowInfo = $span.html(),
									match = newShowInfo.match( /\d+\–(\d+)/ );
								if ( match && match[ 1 ] ) {
									var last = parseInt( match[ 1 ] ) + $newContainer.children().length,
										match = newShowInfo.replace( /\d+\–\d+/, '' ).match( /\d+/ );
									$span.html( match && match[ 0 ] && last == match[ 0 ] ? alpha_vars.texts.show_info_all.replace( '%d', last ) : newShowInfo.replace( /(\d+)\–\d+/, '$1–' + last ) );
								}
							}
						} else {
							var $count = $( '.main-content .woocommerce-result-count' );
							var $toolbox = $count.parent( '.toolbox-pagination' );
							var newShowInfo = $res.find( '.woocommerce-result-count' ).html();

							$count.html( newShowInfo ? newShowInfo : '' );
							newShowInfo ? $toolbox.removeClass( 'no-pagination' ) : $toolbox.addClass( 'no-pagination' );
						}

						// Update Toolbox Pagination
						var $toolboxPagination = $parent.siblings( '.toolbox-pagination' ),
							$newToolboxPagination = $newParent.siblings( '.toolbox-pagination' );

						if ( !$toolboxPagination.length ) {
							$newToolboxPagination.length && $parent.after( $newToolboxPagination );

						} else { // Update Loadmore - Pagination
							var $pagination = $parent.siblings( '.toolbox-pagination' ).find( '.pagination' ),
								$newPagination = $newParent.siblings( '.toolbox-pagination' ).find( '.pagination' );

							if ( $pagination.length ) {
								$pagination[ 0 ].outerHTML = $newPagination.length ? $newPagination[ 0 ].outerHTML : '';
							} else {
								$newPagination.length && $parent.siblings( '.toolbox-pagination' ).append( $newPagination );
							}
						}

						// Update Loadmore - Button
						AjaxLoadPost.refreshButton( $parent, $newParent.siblings( '.btn-load' ), $container.attr( 'data-load' ) );

						// Update Sidebar Widgets
						if ( loadmore_type == 'filter' ) {
							AjaxLoadPost.refreshWidget( '.alpha-price-filter', $res );

							AjaxLoadPost.refreshWidget( '.widget_rating_filter', $res );
							theme.shop.ratingTooltip( '.widget_rating_filter' )

							AjaxLoadPost.refreshWidget( '.widget_price_filter', $res );
							theme.initPriceSlider();

							AjaxLoadPost.refreshWidget( '.widget_product_categories', $res );

							AjaxLoadPost.refreshWidget( '.widget_product_brands', $res );

							AjaxLoadPost.refreshWidget( '.widget-filter-attribute', $res );

							// Refresh Filter Products by Attribute Widgets
							AjaxLoadPost.refreshWidget( '.woocommerce-widget-layered-nav:not(.widget_product_brands)', $res );

							if ( !e || e.type != "yith-wcan-ajax-filtered" ) {
								// Refresh YITH Ajax Navigation Widgets
								AjaxLoadPost.refreshWidget( '.yith-woo-ajax-navigation', $res );
							} else {
								yith_wcan && $( yith_wcan.result_count ).show();
								var $last = $( AjaxLoadPost.lastYithAjaxTrigger );
								$last.closest( '.yith-woo-ajax-navigation' ).is( ':hidden' ) && $last.parent().toggleClass( 'chosen' );
								$( '.sidebar .yith-woo-ajax-navigation' ).show();
							}

							AjaxLoadPost.initSelect2();
						}

						if ( !$container.hasClass( 'skeleton-body' ) ) {
							if ( $container.data( 'loading_show_type' ) ) {
								$container.toggleClass( 'list-type-products', 'list' == $container.data( 'loading_show_type' ) );
								$container.attr( 'class',
									$container.attr( 'class' ).replace( /row|cols\-\d|cols\-\w\w-\d/g, '' ).replace( /\s+/, ' ' ) +
									$container.attr( 'data-col-' + $container.data( 'loading_show_type' ) )
								);
								$( '.main-content-wrap > .sidebar.closed' ).length && theme.shop.switchColumns( false );
							}
						}

						// Remove loading show type.
						$container.removeData( 'loading_show_type' );

						// Init products
						theme.shop.initProducts( $container );

						theme.$body.trigger( 'alpha_ajax_shop_layout', $container, res, url, loadmore_type );

						$container.removeClass( 'product-filtering' );
					}


					$container.removeClass( 'skeleton-body load-scroll' );
					$newContainer.hasClass( 'load-scroll' ) && $container.addClass( 'load-scroll' );

					// Sidebar Widget Compatibility
					theme.menu.initCollapsibleWidgetToggle();

					// Isotope Refresh
					if ( $container.hasClass( 'grid' ) ) {
						$container.data( 'isotope' ) && $container.isotope( 'destroy' );
						theme.isotopes( $container );
					}

					// countdown init
					theme.countdown( $container.find( '.countdown' ) );

					// Update Loadmore - Scroll
					theme.call( AjaxLoadPost.startScrollLoad, 50 );

					// Refresh layouts
					theme.call( theme.refreshLayouts, 70 );

					theme.$body.trigger( 'alpha_ajax_finish_layout', $container, res, url, loadmore_type );
				} );
			},

			/**
			 * Check load 
			 * 
			 * @since 1.0
			 * @param {jQuery} $wrapper
			 * @param {string} type
			 */
			canLoad: function ( $wrapper, type ) {
				// check max
				if ( type == 'button' || type == 'scroll' ) {
					var load = $wrapper.attr( 'data-load' );
					if ( load ) {
						var options = JSON.parse( $wrapper.attr( 'data-load' ) );
						if ( options && options.args && options.max <= options.args.paged ) {
							return false;
						}
					}
				}

				// If it is loading or active, return
				if ( $wrapper.hasClass( 'loading-more' ) || $wrapper.hasClass( 'skeleton-body' ) || $wrapper.siblings( '.d-loading' ).length ) {
					return false;
				}

				return true;
			},

			/**
			 * Show loading effects. 
			 * 
			 * @since 1.0
			 * @param {jQuery} $wrapper
			 * @param {string} type
			 */
			doLoading: function ( $wrapper, type ) {
				if ( !AjaxLoadPost.canLoad( $wrapper, type ) ) {
					return false;
				}

				// "Loading start" effect
				if ( alpha_vars.skeleton_screen && $wrapper.closest( '.product-archive, .post-archive' ).length ) {

					// Skeleton screen for archive pages

					var count = 12,
						template = '';

					if ( $wrapper.closest( '.product-archive' ).length ) {
						// Shop Ajax
						count = parseInt( theme.getCookie( 'alpha_count' ) );
						if ( !count ) {
							var $count = $( '.main-content .toolbox-show-count .count' );
							$count.length && ( count = $count.val() );
						}
						count || ( count = 12 );
					} else if ( $wrapper.closest( '.post-archive' ).length ) {

						// Blog Ajax
						$wrapper.children( '.grid-space' ).remove();
						count = alpha_vars.posts_per_page;
					}

					if ( $wrapper.hasClass( 'products' ) ) {
						// product template
						var skelType = $wrapper.hasClass( 'list-type-products' ) ? 'skel-pro skel-pro-list' : 'skel-pro';
						if ( $wrapper.data( 'loading_show_type' ) ) {
							skelType = 'list' == $wrapper.data( 'loading_show_type' ) ? 'skel-pro skel-pro-list' : 'skel-pro';
						}
						template = '<li class="product-wrap"><div class="' + skelType + '"></div></li>';
					} else {
						// post template
						var skelType = 'skel-post';
						if ( $wrapper.hasClass( 'list-type-posts' ) ) {
							skelType = 'skel-post-list';
						}
						if ( 'mask' == $wrapper.attr( 'data-post-type' ) ) {
							skelType = 'skel-post-mask';
						}
						template = '<div class="post-wrap"><div class="' + skelType + '"></div></div>';
					}

					// Empty wrapper
					if ( type == 'page' || type == 'filter' ) {
						$wrapper.html( '' );
					}

					if ( $wrapper.data( 'loading_show_type' ) ) {
						$wrapper.toggleClass( 'list-type-products', 'list' == $wrapper.data( 'loading_show_type' ) );
						$wrapper.attr( 'class',
							$wrapper.attr( 'class' ).replace( /row|cols\-\d|cols\-\w\w-\d/g, '' ).replace( /\s+/, ' ' ) +
							$wrapper.attr( 'data-col-' + $wrapper.data( 'loading_show_type' ) )
						);
					}

					if ( theme.isIE ) {
						var tmpl = '';
						while ( count-- ) { tmpl += template; }
						$wrapper.addClass( 'skeleton-body' ).append( tmpl );
					} else {
						$wrapper.addClass( 'skeleton-body' ).append( template.repeat( count ) );
					}

					if ( $wrapper.data( 'isotope' ) ) {
						$wrapper.isotope( 'destroy' );
					}

				} else {
					// Widget or not skeleton in archive pages
					if ( type == 'button' || type == 'scroll' ) {
						theme.showMore( $wrapper );
					} else {
						theme.doLoading( $wrapper.parent() );
					}
				}

				// Scroll to wrapper's top offset
				if ( type == 'page' ) {
					theme.scrollToFixedContent( ( $( '.toolbox-top' ).length ? $( '.toolbox-top' ) : $wrapper ).offset().top - 20, 400 );
				}

				$wrapper.addClass( 'loading-more' );

				return true;
			},

			/**
			 * End loading effect. 
			 * 
			 * @since 1.0
			 * @param {jQuery} $wrapper
			 * @param {string} type
			 */
			endLoading: function ( $wrapper, type ) {
				// Clear loading effect
				if ( alpha_vars.skeleton_screen && $wrapper.closest( '.product-archive, .post-archive' ).length ) { // shop or blog archive
					if ( type == 'button' || type == 'scroll' ) {
						$wrapper.find( '.skel-pro,.skel-post' ).parent().remove();
					}
					$wrapper.removeClass( 'skeleton-body' );
				} else {
					if ( type == 'button' || type == 'scroll' ) {
						theme.hideMore( $wrapper.parent() );
					} else {
						theme.endLoading( $wrapper.parent() );
					}
				}
				$wrapper.removeClass( 'loading-more' );
			},

			/**
			 * Filter widgets by category
			 * 
			 * @since 1.0
			 * @param {Event} e
			 */
			filterWidgetByCategory: function ( e ) {
				var $filter = $( e.currentTarget );

				e.preventDefault();

				// If this is filtered by archive page's toolbox filter or this is active now, return.
				if ( $filter.is( '.toolbox .nav-filter' ) || $filter.is( '.post-archive .nav-filter' ) || $filter.hasClass( 'active' ) ) {
					return;
				}

				// Find Wrapper
				var filterNav, $wrapper, filterCat = $filter.attr( 'data-cat' );

				filterNav = $filter.closest( '.nav-filters' );
				if ( filterNav.length ) {
					$wrapper = filterNav.parent().find( filterNav.hasClass( 'product-filters' ) ? '.products' : '.posts' );
				} else {
					filterNav = $filter.closest( '.filter-categories' );
					if ( filterNav.length ) {
						if ( $filter.closest( '.elementor-section' ).length ) {
							$wrapper = $filter.closest( '.elementor-section' ).find( '.products[data-load]' ).eq( 0 );
							if ( !$wrapper.length ) {
								$wrapper = $filter.closest( '.elementor-top-section' ).find( '.products[data-load]' ).eq( 0 );
							}
						} else if ( $filter.closest( '.vce-row' ).length ) {
							$wrapper = $filter.closest( '.vce-row' ).find( '.products[data-load]' ).eq( 0 );
						} else if ( $filter.closest( '.wpb_row' ).length ) {
							$wrapper = $filter.closest( '.wpb_row' ).find( '.products[data-load]' ).eq( 0 );

							// If there is no products to be filtered in vc row, just find it in the same section
							if ( !$wrapper.length ) {
								if ( $filter.closest( '.vc_section' ).length ) {
									$wrapper = $filter.closest( '.vc_section' ).find( '.products[data-load]' ).eq( 0 );
								}
							}
						}
					}
				}

				if ( $wrapper.length ) {
					filterNav.length && (
						filterNav.find( '.cat-type-icon' ).length
							? ( // if category type is icon
								filterNav.find( '.cat-type-icon' ).removeClass( 'active' ),
								$filter.closest( '.cat-type-icon' ).addClass( 'active' ) )
							: ( // if not,
								filterNav.find( '.product-category, .nav-filter' ).removeClass( 'active' ),
								$filter.closest( '.product-category, .nav-filter' ).addClass( 'active' )
							)
					);
				}

				var section_id = $wrapper.closest( '.elementor-top-section' ).data( 'id' );
				if ( section_id && AjaxLoadPost.ajax_tab_cache[ section_id ] && AjaxLoadPost.ajax_tab_cache[ section_id ][ filterCat ] ) {
					var $content = AjaxLoadPost.ajax_tab_cache[ section_id ][ filterCat ];

					$wrapper.css( 'opacity', 0 );
					$wrapper.animate(
						{
							'opacity': 1,
						},
						400,
						function () {
							$wrapper.css( 'opacity', '' );
						}
					);
					$wrapper.empty();
					$wrapper.append( $content );
					$wrapper.removeData( 'slider' );
					theme.slider( $wrapper );
				} else {
					$wrapper.length &&
						AjaxLoadPost.loadmore( {
							wrapper: $wrapper,
							page: 1,
							type: 'filter',
							category: filterCat
						} )
				}
			},

			/**
			 * Load more by button
			 * 
			 * @since 1.0
			 * @param {Event} e
			 */
			loadmoreByButton: function ( e ) {
				var $btn = $( e.currentTarget ); // This will be replaced with new html of ajax content.
				e.preventDefault();

				AjaxLoadPost.loadmore( {
					wrapper: $btn.siblings( '.product-archive' ).length ? $btn.siblings( '.product-archive' ).find( '.products' ) : $btn.siblings( '.products, .posts' ),
					page: '+1',
					type: 'button',
					onStart: function () {
						$btn.data( 'text', $btn.html() )
							.addClass( 'loading' ).blur()
							.html( alpha_vars.texts.loading );
					},
					onFail: function () {
						$btn.text( alpha_vars.texts.loadmore_error ).addClass( 'disabled' );
					}
				} );
			},

			/**
			 * Event handler for ajax loading by infinite scroll 
			 * 
			 * @since 1.0
			 */
			startScrollLoad: function () {
				AjaxLoadPost.scrollWrappers = $( '.load-scroll' );
				if ( AjaxLoadPost.scrollWrappers.length ) {
					AjaxLoadPost.loadmoreByScroll();
					theme.$window.off( 'scroll resize', AjaxLoadPost.loadmoreByScroll );
					window.addEventListener( 'scroll', AjaxLoadPost.loadmoreByScroll, { passive: true } );
					window.addEventListener( 'resize', AjaxLoadPost.loadmoreByScroll, { passive: true } );
				}
			},

			/**
			 * Load more by scroll
			 * 
			 * @since 1.0
			 * @param {jQuery} $scrollWrapper
			 */
			loadmoreByScroll: function ( $scrollWrapper ) {
				var target = AjaxLoadPost.scrollWrappers,
					loadOptions = target.attr( 'data-load' ),
					maxPage = 1,
					curPage = 1;

				if ( loadOptions ) {
					loadOptions = JSON.parse( loadOptions );
					maxPage = loadOptions.max;
					if ( loadOptions.args && loadOptions.args.paged ) {
						curPage = loadOptions.args.paged;
					}
				}

				if ( curPage >= maxPage ) {
					return;
				}

				$scrollWrapper && $scrollWrapper instanceof jQuery && ( target = $scrollWrapper );

				// load more
				target.length && AjaxLoadPost.canLoad( target, 'scroll' ) && target.each( function () {
					var rect = this.getBoundingClientRect();
					if ( rect.top + rect.height > 0 &&
						rect.top + rect.height < window.innerHeight ) {
						AjaxLoadPost.loadmore( {
							wrapper: $( this ),
							page: '+1',
							type: 'scroll',
							onDone: function ( $result, $wrapper, options ) {
								// check max
								if ( options.max && options.max <= options.args.paged ) {
									$wrapper.removeClass( 'load-scroll' );
								}
								// continue loadmore again
								theme.call( AjaxLoadPost.startScrollLoad, 50 );
							},
							onFail: function ( jqxhr, $wrapper ) {
								$wrapper.removeClass( 'load-scroll' );
							}
						} );
					}
				} );

				// remove loaded wrappers
				AjaxLoadPost.scrollWrappers = AjaxLoadPost.scrollWrappers.filter( function () {
					var $this = $( this );
					$this.children( theme.applyFilters( 'ajax_load_post/scroll_wrappers_wrap', '.post-wrap,.product-wrap' ) ).length || $this.removeClass( 'load-scroll' );
					return $this.hasClass( 'load-scroll' );
				} );
				AjaxLoadPost.scrollWrappers.length || (
					window.removeEventListener( 'scroll', AjaxLoadPost.loadmoreByScroll ),
					window.removeEventListener( 'resize', AjaxLoadPost.loadmoreByScroll )
				)
			},

			/**
			 * Fit videos
			 * 
			 * @since 1.0
			 * @param {jQuery} $wrapper
			 */
			fitVideos: function ( $wrapper, fitVids ) {
				// Video Post Refresh
				if ( $wrapper.find( '.fit-video' ).length ) {

					var defer_mecss = ( function () {
						var deferred = $.Deferred();
						if ( $( '#wp-mediaelement-css' ).length ) {
							deferred.resolve();
						} else {
							$( document.createElement( 'link' ) ).attr( {
								id: 'wp-mediaelement-css',
								href: alpha_vars.ajax_url.replace( 'wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/wp-mediaelement.min.css' ),
								media: 'all',
								rel: 'stylesheet'
							} ).appendTo( 'body' ).on(
								'load',
								function () {
									deferred.resolve();
								}
							);
						}
						return deferred.promise();
					} )();

					var defer_mecss_legacy = ( function () {
						var deferred = $.Deferred();
						if ( $( '#mediaelement-css' ).length ) {
							deferred.resolve();
						} else {
							$( document.createElement( 'link' ) ).attr( {
								id: 'mediaelement-css',
								href: alpha_vars.ajax_url.replace( 'wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/mediaelementplayer-legacy.min.css' ),
								media: 'all',
								rel: 'stylesheet'
							} ).appendTo( 'body' ).on(
								'load',
								function () {
									deferred.resolve();
								}
							);
						}
						return deferred.promise();
					} )();

					var defer_mejs = ( function () {
						var deferred = $.Deferred();

						if ( typeof window.wp.mediaelement != 'undefined' ) {
							deferred.resolve();
						} else {

							$( '<script>var _wpmejsSettings = { "stretching": "responsive" }; </script>' ).appendTo( 'body' );

							var defer_mejsplayer = ( function () {
								var deferred = $.Deferred();

								$( document.createElement( 'script' ) ).attr( 'id', 'mediaelement-core-js' )
									.appendTo( 'body' )
									.on( 'load', function () {
										deferred.resolve();
									} )
									.attr( 'src', alpha_vars.ajax_url.replace( 'wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/mediaelement-and-player.min.js' ) );

								return deferred.promise();
							} )();
							var defer_mejsmigrate = ( function () {
								var deferred = $.Deferred();

								setTimeout( function () {
									$( document.createElement( 'script' ) ).attr( 'id', 'mediaelement-migrate-js' ).appendTo( 'body' ).on(
										'load',
										function () {
											deferred.resolve();
										}
									).attr( 'src', alpha_vars.ajax_url.replace( 'wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/mediaelement-migrate.min.js' ) );
								}, 100 );

								return deferred.promise();
							} )();
							$.when( defer_mejsplayer, defer_mejsmigrate ).done(
								function ( e ) {
									$( document.createElement( 'script' ) ).attr( 'id', 'wp-mediaelement-js' ).appendTo( 'body' ).on(
										'load',
										function () {
											deferred.resolve();
										}
									).attr( 'src', alpha_vars.ajax_url.replace( 'wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/wp-mediaelement.min.js' ) );
								}
							);
						}

						return deferred.promise();
					} )();

					var defer_fitvids = ( function () {
						var deferred = $.Deferred();
						if ( $.fn.fitVids ) {
							deferred.resolve();
						} else {
							$( document.createElement( 'script' ) ).attr( 'id', 'jquery.fitvids-js' )
								.appendTo( 'body' )
								.on( 'load', function () {
									deferred.resolve();
								} ).attr( 'src', alpha_vars.assets_url + '/vendor/jquery.fitvids/jquery.fitvids.min.js' );
						}
						return deferred.promise();
					} )();

					$.when( defer_mecss, defer_mecss_legacy, defer_mejs, defer_fitvids ).done(
						function ( e ) {
							theme.call( function () {
								theme.fitVideoSize( $wrapper );
							}, 200 );
						}
					);
				}
			},

			/**
			 * Event handler for ajax loading by pagination 
			 * 
			 * @since 1.0
			 * @param {Event} e
			 */
			loadmoreByPagination: function ( e ) {
				var $btn = $( e.currentTarget ); // This will be replaced with new html of ajax content

				if ( theme.$body.hasClass( 'dokan-store' ) && $btn.closest( '.dokan-single-store' ).length ) {
					return;
				}
				e.preventDefault();

				var $pagination = $btn.closest( '.toolbox-pagination' ).length ? $btn.closest( '.toolbox-pagination' ) : $btn.closest( '.pagination' );

				AjaxLoadPost.loadmore( {
					wrapper: $pagination.siblings( '.product-archive' ).length ?
						$pagination.siblings( '.product-archive' ).find( '.products' ) :
						$pagination.siblings( '.products, .posts' ),

					page: $btn.hasClass( 'next' ) ? '+1' :
						( $btn.hasClass( 'prev' ) ? '-1' : $btn.text() ),
					type: 'page',
					onStart: function ( $wrapper, options ) {
						theme.doLoading( $btn.closest( '.pagination' ), 'simple' );
					}
				} );
			},

			/**
			 * Load more ajax content 
			 * 
			 * @since 1.0
			 * @param {object} params
			 * @return {boolean}
			 */
			loadmore: function ( params ) {
				if ( !params.wrapper ||
					1 != params.wrapper.length ||
					!params.wrapper.attr( 'data-load' ) ||
					!AjaxLoadPost.doLoading( params.wrapper, params.type ) ) {
					return false;
				}

				// Get wrapper
				var $wrapper = params.wrapper;

				// Get options
				var options = JSON.parse( $wrapper.attr( 'data-load' ) );
				options.args = options.args || {};
				if ( !options.args.paged ) {
					options.args.paged = 1;

					// Get correct page number at first in archive pages
					if ( $wrapper.closest( '.product-archive, .post-archive' ).length ) {
						var match = location.pathname.match( /\/page\/(\d*)/ );
						if ( match && match[ 1 ] ) {
							options.args.paged = parseInt( match[ 1 ] );
						}
					}
				}
				if ( 'filter' == params.type ) {
					options.args.paged = 1;
					if ( params.category ) {
						options.args.category = params.category; // filter category
					} else if ( options.args.category ) {
						delete options.args.category; // do not filter category
					}
				} else if ( '+1' === params.page ) {
					++options.args.paged;
				} else if ( '-1' === params.page ) {
					--options.args.paged;
				} else {
					options.args.paged = parseInt( params.page );
				}

				// Get ajax url
				var url = alpha_vars.ajax_url;
				if ( $wrapper.closest( '.product-archive, .post-archive' ).length ) { // shop or blog archive
					var pathname = location.pathname;
					if ( pathname.endsWith( '/' ) ) {
						pathname = pathname.slice( 0, pathname.length - 1 );
					}
					if ( pathname.indexOf( '/page/' ) >= 0 ) {
						pathname = pathname.replace( /\/page\/\d*/, '/page/' + options.args.paged );
					} else {
						pathname += '/page/' + options.args.paged;
					}

					url = theme.addUrlParam( location.origin + pathname + location.search, 'only_posts', 1 );
					if ( options.args.category && options.args.category != '*' ) {
						url = theme.addUrlParam( url, 'product_cat', category );
					}
				}

				// Add product-page param to set current page for pagination
				if ( $wrapper.hasClass( 'products' ) && !$wrapper.closest( '.product-archive' ).length ) {
					url = theme.addUrlParam( url, 'product-page', options.args.paged );
				}

				// Add post type to blog posts' ajax pagination.
				if ( $wrapper.closest( '.post-archive' ).length ) {
					var postType = $wrapper.data( 'post-type' );
					if ( postType ) {
						url = theme.addUrlParam( url, 'post_style_type', postType );
					}
				}

				// Get ajax data
				var data = {
					action: $wrapper.closest( '.product-archive, .post-archive' ).length ? '' : 'alpha_loadmore',
					nonce: alpha_vars.nonce,
					props: options.props,
					args: options.args,
					loadmore: params.type,
					cpt: options.cpt ? options.cpt : 'post',
				}

				if ( params.type == 'page' ) {
					data.pagination = 1;
				}

				// Before start loading
				params.onStart && params.onStart( $wrapper, options );

				// Do ajax
				$.post( url, data )
					.done( function ( result ) {
						// In case of posts widget's pagination, result's structure will be {html: '', pagination: ''}.
						var res_pagination = '';
						if ( $wrapper.hasClass( 'posts' ) && !$wrapper.closest( '.post-archive' ).length && params.type == 'page' ) {
							result = JSON.parse( result );
							res_pagination = result.pagination;
							result = result.html;
						}

						// In other cases, result will be html.
						var $result = $( result ),
							$content;

						$result.imagesLoaded( function () {

							// Get content, except posts widget
							if ( $wrapper.closest( '.product-archive' ).length ) {
								$content = $result.find( '.product-archive .products' );
							} else if ( $wrapper.closest( '.post-archive' ).length ) {
								$content = $result.find( '.post-archive .posts' );
								if ( !$content.length ) {
									$result.each( function () {
										var $this = $( this );
										if ( $this.hasClass( 'post-archive' ) ) {
											$content = $this.find( '.posts' );
											return false;
										}
									} );
								}
							} else {
								$content = $wrapper.hasClass( 'products' ) ? $result.find( '.products' ) : $result.children();
								var section_id = $wrapper.closest( '.elementor-top-section' ).data( 'id' );
								if ( section_id ) {
									if ( undefined == AjaxLoadPost.ajax_tab_cache[ section_id ] ) {
										AjaxLoadPost.ajax_tab_cache[ section_id ] = {};
									}

									AjaxLoadPost.ajax_tab_cache[ section_id ][ params.category ] = $content.children();
								}
							}

							// Change status and content
							if ( params.type == 'page' || params.type == 'filter' ) {
								if ( $wrapper.data( 'slider' ) ) {
									$wrapper.data( 'slider' ).destroy();
									$wrapper.removeData( 'slider' );
									$wrapper.data( 'slider-layout' ) && $wrapper.addClass( $wrapper.data( 'slider-layout' ).join( ' ' ) );
								}
								$wrapper.data( 'isotope' ) && $wrapper.data( 'isotope' ).destroy();
								$wrapper.empty();
							}

							if ( !$wrapper.hasClass( 'posts' ) || $wrapper.closest( '.post-archive' ).length ) {
								// Except posts widget, update max page and class
								var max = $content.attr( 'data-load-max' );
								if ( max ) {
									options.max = parseInt( max );
								}
								// $wrapper.attr('class', $content.attr('class'));
								$wrapper.append( $content.children() );
							} else {
								// For posts widget
								$wrapper.append( $content );
							}

							// Update wrapper status.
							$wrapper.attr( 'data-load', JSON.stringify( options ) );

							if ( $wrapper.closest( '.product-archive' ).length || $wrapper.closest( '.post-archive' ).length ) {
								AjaxLoadPost.loadedPage( 0, result, url, params.type );
							} else {
								// Change load controls for widget
								var loadmore_type = params.type == 'filter' ? options.props.loadmore_type : params.type;

								if ( loadmore_type == 'button' ) {
									if ( params.type != 'filter' && $wrapper.hasClass( 'posts' ) ) {
										var $btn = $wrapper.siblings( '.btn-load' );
										if ( $btn.length ) {
											if ( typeof options.args == 'undefined' || typeof options.max == 'undefined' ||
												typeof options.args.paged == 'undefined' || options.max <= options.args.paged ) {
												$btn.remove();
											} else {
												$btn.html( $btn.data( 'text' ) );
											}
										}
									} else {
										AjaxLoadPost.refreshButton( $wrapper, $result.find( '.btn-load' ), options );
									}

								} else if ( loadmore_type == 'page' ) {
									var $pagination = $wrapper.parent().find( '.pagination' )
									var $newPagination = $wrapper.hasClass( 'posts' ) ? $( res_pagination ) : $result.find( '.pagination' );
									if ( $pagination.length ) {
										$pagination[ 0 ].outerHTML = $newPagination.length ? $newPagination[ 0 ].outerHTML : '';
									} else {
										$newPagination.length && $wrapper.after( $newPagination );
									}

								} else if ( loadmore_type == 'scroll' ) {
									$wrapper.addClass( 'load-scroll' );
									if ( params.type == 'filter' ) {
										theme.call( function () {
											AjaxLoadPost.loadmoreByScroll( $wrapper );
										}, 50 );
									}
								}
							}

							// Init products and posts
							$wrapper.hasClass( 'products' ) && theme.shop.initProducts( $wrapper );
							$wrapper.hasClass( 'posts' ) && AjaxLoadPost.fitVideos( $wrapper );

							// Refresh layouts
							if ( $wrapper.hasClass( 'grid' ) ) {
								$wrapper.removeData( 'isotope' );
								theme.isotopes( $wrapper );
							}
							if ( $wrapper.hasClass( 'slider-wrapper' ) ) {
								theme.slider( $wrapper );
							}

							params.onDone && params.onDone( $result, $wrapper, options );

							// If category filter is not set in widget and loadmore has been limited to max, remove data-load attribute
							if ( !$wrapper.hasClass( 'filter-products' ) &&
								!( $wrapper.hasClass( 'products' ) && $wrapper.parent().siblings( '.nav-filters' ).length ) &&
								options.max && options.max <= options.args.paged && 'page' != params.type ) {
								$wrapper.removeAttr( 'data-load' );
							}

							AjaxLoadPost.endLoading( $wrapper, params.type );
							params.onAlways && params.onAlways( result, $wrapper, options );
							theme.refreshLayouts();
						} );
					} ).fail( function ( jqxhr ) {
						params.onFail && params.onFail( jqxhr, $wrapper );
						AjaxLoadPost.endLoading( $wrapper, params.type );
						params.onAlways && params.onAlways( result, $wrapper, options );
					} );

				return true;
			}
		}
		return function () {
			AjaxLoadPost.init();
			theme.AjaxLoadPost = AjaxLoadPost;
		}
	} )();

	/**
	 * Menu Class
	 *
	 * @class Menu
	 * @since 1.0
	 * @return {Object} Menu
	 */
	theme.menu = ( function () {

		function _showMobileMenu( e, callback ) {
			var $mmenuContainer = $( '.mobile-menu-wrapper .mobile-menu-container' );
			theme.$body.addClass( 'mmenu-active' );
			e.preventDefault();

			function initMobileMenu() {
				theme.liveSearch && theme.liveSearch( '', $( '.mobile-menu-wrapper .search-wrapper' ) );
				theme.menu.addToggleButtons( '.mobile-menu li' );
			}

			if ( !$mmenuContainer.find( '.mobile-menu' ).length ) {
				var cache = theme.getCache( cache );

				// check cached mobile menu.
				if ( cache.mobileMenu && cache.mobileMenuLastTime && alpha_vars.menu_last_time &&
					parseInt( cache.mobileMenuLastTime ) >= parseInt( alpha_vars.menu_last_time ) ) {

					// fetch mobile menu from cache
					$mmenuContainer.append( cache.mobileMenu );
					initMobileMenu();
					theme.setCurrentMenuItems( '.mobile-menu-wrapper' );
				} else {
					// fetch mobile menu from server
					theme.doLoading( $mmenuContainer );
					$.post( alpha_vars.ajax_url, {
						action: "alpha_load_mobile_menu",
						nonce: alpha_vars.nonce,
						load_mobile_menu: true,
					}, function ( result ) {
						result && ( result = result.replace( /(class=".*)current_page_parent\s*(.*")/, '$1$2' ) );
						$mmenuContainer.css( 'height', '' );
						theme.endLoading( $mmenuContainer );

						// Add mobile menu search
						$mmenuContainer.append( result );
						initMobileMenu();
						theme.setCurrentMenuItems( '.mobile-menu-wrapper' );

						// save mobile menu cache
						cache.mobileMenuLastTime = alpha_vars.menu_last_time;
						cache.mobileMenu = result;
						theme.setCache( cache );

						if ( typeof callback == 'function' ) {
							callback();
						}
					} );
				}
			} else {
				initMobileMenu();

				if ( typeof callback == 'function' ) {
					callback();
				}
			}
		}

		function _hideMobileMenu( e ) {
			e.preventDefault();
			theme.$body.removeClass( 'mmenu-active' );
		}

		var _initMegaMenu = function () {
			// calc megamenu position
			function _recalcMenuPosition() {
				$( 'nav .menu.horizontal-menu .megamenu' ).each( function () {
					var $this = $( this ),
						o = $this.offset(),
						left = o.left - parseInt( $this.css( 'margin-left' ) ),
						outerWidth = $this.outerWidth(),
						offsetLeft = ( left + outerWidth ) - ( window.innerWidth - 20 );

					if ( $this.hasClass( 'full-megamenu' ) && 0 == $this.closest( '.container-fluid' ).length ) {
						$this.css( "margin-left", ( $( window ).width() - outerWidth ) / 2 - left + 'px' );
					} else if ( offsetLeft > 0 && left > 20 ) {
						$this.css( "margin-left", -offsetLeft + 'px' );
					}
				} );
			}

			if ( $( '.toggle-menu.dropdown' ).length ) {
				var $togglebtn = $( '.toggle-menu.dropdown .vertical-menu' );
				var toggleBtnTop = $togglebtn.length > 0 && $togglebtn.offset().top,
					verticalTop = toggleBtnTop;

				$( '.vertical-menu .menu-item-has-children' ).on( 'mouseenter', function ( e ) {
					var $this = $( this );
					if ( $this.children( '.megamenu' ).length ) {
						var $item = $this.children( '.megamenu' ),
							offset = $item.offset(),
							top = offset.top - parseInt( $item.css( 'margin-top' ) ),
							outerHeight = $item.outerHeight();

						if ( window.pageYOffset > toggleBtnTop ) {
							verticalTop = $this.closest( '.menu' ).offset().top;
						} else {
							verticalTop = toggleBtnTop;
						};

						if ( typeof ( verticalTop ) !== 'undefined' && top >= verticalTop ) {
							var offsetTop = ( top + outerHeight ) - window.innerHeight - window.pageYOffset;
							if ( offsetTop <= 0 ) {
								$item.css( "margin-top", "0px" );
							} else if ( offsetTop < top - verticalTop ) {
								$item.css( "margin-top", -( offsetTop + 5 ) + 'px' );
							} else {
								$item.css( "margin-top", -( top - verticalTop ) + 'px' )
							}
						}
					}
				}
				);
			}

			_recalcMenuPosition();
			theme.$window.on( 'resize recalc_menus', _recalcMenuPosition );
		}

		return {
			init: function () {
				this.initMenu();
				this.initFilterMenu();
				this.initCollapsibleWidget();
				this.initCollapsibleWidgetToggle();
			},
			initMenu: function ( $selector ) {
				if ( typeof $selector == 'undefined' ) {
					$selector = '';
				}

				theme.$body
					// no link
					.on( 'click', $selector + ' .menu-item .nolink', theme.preventDefault )
					// mobile menu
					.on( 'click', '.mobile-menu-toggle', _showMobileMenu )
					.on( 'click', '.mobile-menu-overlay', _hideMobileMenu )
					.on( 'click', '.mobile-menu-close', _hideMobileMenu )
					.on( 'click', '.mobile-item-categories.show-categories-menu', function ( e ) {
						_showMobileMenu( e, function () {
							$( '.mobile-menu-container .nav a[href="#categories"]' ).trigger( 'click' );
						} );
					} )

				window.addEventListener( 'resize', _hideMobileMenu, { passive: true } );

				this.addToggleButtons( $selector + ' .collapsible-menu li' );

				// toggle dropdown
				theme.$body.on( "click", '.dropdown-menu-toggle', theme.preventDefault );


				// megamenu
				_initMegaMenu();

				// lazyload menu image
				alpha_vars.lazyload && theme.call( function () {
					$( '.megamenu [data-lazy]' ).each( function () {
						theme._lazyload_force( this );
					} )
				} );
			},
			addToggleButtons: function ( selector ) {
				theme.$( selector ).each( function () {
					var $this = $( this );
					if ( $this.hasClass( 'menu-item-has-children' ) && !$this.children( 'a' ).children( '.toggle-btn' ).length && $this.children( 'ul' ).text().trim() ) {
						$this.children( 'a' ).each( function () {
							var span = document.createElement( 'span' );
							span.className = "toggle-btn";
							this.append( span );
						} )
					}
				} );
			},
			initFilterMenu: function () {
				theme.$body.on( 'click', '.with-ul > a i, .menu .toggle-btn, .mobile-menu .toggle-btn', function ( e ) {
					var $this = $( this );
					var $ul = $this.parent().siblings( ':not(.count)' );
					if ( $ul.length > 1 ) {
						$this.parent().toggleClass( "show" ).next( ':not(.count)' ).slideToggle( 300 );
					} else if ( $ul.length > 0 ) {
						$ul.slideToggle( 300 ).parent().toggleClass( "show" );
					}
					setTimeout( function () {
						$this.closest( '.sticky-sidebar' ).trigger( 'recalc.pin' );
					}, 320 );
					e.preventDefault();
				} );
			},
			initCollapsibleWidgetToggle: function ( selector ) {
				$( '.widget .product-categories li' ).add( '.sidebar .widget.widget_categories li' ).add( '.widget .product-brands li' ).add( '.store-cat-stack-dokan li' ).each( function () { // updated(47(
					if ( this.lastElementChild && this.lastElementChild.tagName === 'UL' ) {
						var i = document.createElement( 'i' );
						i.className = alpha_vars.theme_icon_prefix + "-icon-angle-down";
						this.classList.add( 'with-ul' );
						this.classList.add( 'cat-item' );
						this.firstElementChild.appendChild( i );
					}
				} );

				theme.$( 'undefined' == typeof selector ? '.sidebar .widget-collapsible .widget-title' : selector )
					.each( function () {
						var $this = $( this );
						if ( $this.closest( '.top-filter-widgets' ).length ||
							$this.closest( '.toolbox-horizontal' ).length ||  // if in shop pages's top-filter sidebar
							$this.siblings( '.slider-wrapper' ).length ) {
							return;
						}
						// generate toggle icon
						if ( !$this.children( '.toggle-btn' ).length ) {
							var span = document.createElement( 'span' );
							span.className = 'toggle-btn';
							this.appendChild( span );
						}
					} );
			},
			initCollapsibleWidget: function () {
				// slideToggle
				theme.$body.on( 'click', '.sidebar .widget-collapsible .widget-title', function ( e ) {
					var $this = $( e.currentTarget );

					if ( $this.closest( '.top-filter-widgets' ).length ||
						$this.closest( '.toolbox-horizontal' ).length ||  // if in shop pages's top-filter sidebar
						$this.siblings( '.slider-wrapper' ).length ||
						$this.hasClass( 'sliding' ) ) {
						return;
					}
					var $content = $this.siblings( '*:not(script):not(style)' );
					$this.hasClass( "collapsed" ) || $content.css( 'display', 'block' );
					$this.addClass( "sliding" );
					$content.slideToggle( 300, function () {
						$this.removeClass( "sliding" );
						theme.$window.trigger( 'update_lazyload' );
						$( '.sticky-sidebar' ).trigger( 'recalc.pin' );
					} );
					$this.toggleClass( "collapsed" );
				} );
			}
		}
	} )();

	/**
	 * Open magnific popup
	 *
	 * @since 1.0
	 * @param {Object} options
	 * @param {string} preset
	 * @return {void}
	 */
	theme.popup = function ( options, preset ) {
		var mpInstance = $.magnificPopup.instance;
		// if something is already opened, retry after 5seconds
		if ( mpInstance.isOpen ) {
			if ( mpInstance.content ) {
				setTimeout( function () {
					theme.popup( options, preset );
				}, 5000 );
			} else {
				$.magnificPopup.close();
			}
		} else {
			// if nothing is opened, open new
			$.magnificPopup.open(
				$.extend( true, {},
					theme.defaults.popup,
					preset ? theme.defaults.popupPresets[ preset ] : {},
					options
				)
			);
		}
	}

	/**
	 * Initialize sidebar
	 * Sidebar active class will be added to body tag : "sidebar class" + "-active"
	 * 
	 * @class Sidebar
	 * @since 1.0
	 * @param {string} name
	 * @return {Sidebar}
	 */
	theme.sidebar = ( function () {
		function Sidebar( name ) {
			return this.init( name );
		}

		Sidebar.prototype.init = function ( name ) {
			var self = this;

			self.name = name;
			self.$sidebar = $( '.' + name );
			// self.isNavigation = false;

			// If sidebar exists
			if ( self.$sidebar.length ) {
				theme.$window.on( 'resize', function () {
					theme.$body.removeClass( name + '-active' );
					$( '.page-wrapper, .sticky-content' ).css( { 'margin-left': '', 'margin-right': '' } );
				} );

				// Register toggle event
				self.$sidebar.find( '.sidebar-toggle, .sidebar-toggle-btn' )
					.add( '.' + name + '-toggle' )
					.on( 'click', function ( e ) {
						self.toggle();
						e.preventDefault();
						theme.$window.trigger( 'update_lazyload' );
						$( '.sticky-sidebar' ).trigger( 'recalc.pin.left', [ 400 ] );
					} );

				// Register close event
				self.$sidebar.find( '.sidebar-overlay, .sidebar-close' )
					.on( 'click', function ( e ) {
						e.stopPropagation();
						self.toggle( 'close' );
						e.preventDefault();
						$( '.sticky-sidebar' ).trigger( 'recalc.pin.left', [ 400 ] );
					} );


				// run lazyload on scroll
				self.$sidebar.find( '.sidebar-content' ).on( 'scroll', function () {
					theme.$window.trigger( 'update_lazyload' );
				} );
			}
			return false;
		}

		Sidebar.prototype.toggle = function ( mode ) {
			var isOpened = theme.$body.hasClass( this.name + '-active' );
			if ( mode && mode == 'close' && !isOpened ) {
				return;
			}

			var width = $( '.' + this.name + ' .sidebar-content' ).outerWidth();
			var marginLeft = isOpened ? '' : ( 'right-sidebar' == this.name ? - width : width );
			var marginRight = isOpened ? '' : ( 'right-sidebar' == this.name ? width : - width );

			// move close button because of scroll bar width
			this.$sidebar.find( '.sidebar-overlay .sidebar-close' ).css( 'margin-left', - ( window.innerWidth - document.body.clientWidth ) );

			// activate sidebar
			theme.$body.toggleClass( this.name + '-active' ).removeClass( 'closed' );

			// move page wrapper
			if ( window.innerWidth <= 992 ) {
				$( '.page-wrapper' ).css( { 'margin-left': marginLeft, 'margin-right': marginRight } );

				// move sticky contents
				$( '.sticky-content.fixed' ).css( { 'transition': 'opacity .5s, margin .4s', 'margin-left': marginLeft, 'margin-right': marginRight } );
				setTimeout( function () {
					$( '.sticky-content.fixed' ).css( 'transition', 'opacity .5s' );
				}, 400 );
			}

			theme.call( theme.refreshLayouts, 300 );
		}

		theme.$window.on( 'alpha_complete', function () {
			$( '.sidebar' ).length && theme.$window.smartresize( function () {
				setTimeout( function () {
					theme.$window.trigger( 'update_lazyload' );
				}, 300 );
			} );
		} )

		return function ( name ) {
			return new Sidebar().init( name );
		}
	} )();

	/**
	 * Create minipopup object
	 * 
	 * @class Minipopup
	 * @since 1.0
	 * @return {Object} Minipopup
	 */
	theme.minipopup = ( function () {
		var timerInterval = 200;
		var $area;
		var boxes = [];
		var timers = [];
		var isPaused = false;
		var timerId = false;
		var timerClock = function () {
			if ( isPaused ) {
				return;
			}
			for ( var i = 0; i < timers.length; ++i ) {
				( timers[ i ] -= timerInterval ) <= 0 && this.close( i-- );
			}
		}

		return {
			init: function () {
				// init area
				var area = document.createElement( 'div' );
				area.className = "minipopup-area";
				$( theme.byClass( 'page-wrapper' ) ).append( area );

				$area = $( area );

				// call methods
				this.close = this.close.bind( this );
				timerClock = timerClock.bind( this );
			},
			open: function ( options, callback ) {
				var self = this,
					settings = $.extend( true, {}, theme.defaults.minipopup, options ),
					$box;

				$box = $( settings.content );

				// open
				$box.find( "img" ).on( 'load', function () {
					setTimeout( function () {
						$box.addClass( 'show' );
					}, 300 );
					if ( $box.offset().top - window.pageYOffset < 0 ) {
						self.close();
					}
					$box.on( 'mouseenter', function () {
						self.pause();
					} );
					$box.on( 'mouseleave', function ( e ) {
						self.resume();
					} );

					$box[ 0 ].addEventListener( 'touchstart', function ( e ) {
						self.pause();
						e.stopPropagation();
					}, { passive: true } );

					theme.$body[ 0 ].addEventListener( 'touchstart', function () {
						self.resume();
					}, { passive: true } );

					$box.on( 'mousedown', function () {
						$box.css( 'transform', 'translateX(0) scale(0.96)' );
					} );
					$box.on( 'mousedown', 'a', function ( e ) {
						e.stopPropagation();
					} );
					$box.on( 'mouseup', function () {
						self.close( boxes.indexOf( $box ) );
					} );
					$box.on( 'mouseup', 'a', function ( e ) {
						e.stopPropagation();
					} );

					boxes.push( $box );
					timers.push( settings.delay );

					( timers.length > 1 ) || (
						timerId = setInterval( timerClock, timerInterval )
					);

					callback && callback( $box );
				} ).on( 'error', function () {
					$box.remove();
				} );
				$box.appendTo( $area );
			},
			close: function ( indexToClose ) {
				var self = this;
				var index = ( 'undefined' === typeof indexToClose ) ? 0 : indexToClose;
				var $box = boxes.splice( index, 1 )[ 0 ];

				if ( $box ) {
					// remove timer
					timers.splice( index, 1 )[ 0 ];

					// remove box
					$box.css( 'transform', '' ).removeClass( 'show' );
					self.pause();

					setTimeout( function () {
						var $next = $box.next();
						if ( $next.length ) {
							$next.animate( {
								'margin-bottom': -1 * $box[ 0 ].offsetHeight - 20
							}, 300, 'easeOutQuint', function () {
								$next.css( 'margin-bottom', '' );
								$box.remove();
							} );
						} else {
							$box.remove();
						}
						self.resume();
					}, 300 );

					// clear timer
					boxes.length || clearTimeout( timerId );
				}
			},
			pause: function () {
				isPaused = true;
			},
			resume: function () {
				isPaused = false;
			}
		}
	} )();

	/**
	 * Create product gallery object
	 * 
	 * @class ProductGallery
	 * @since 1.0
	 * @param {string|jQuery} selector
	 * @return {void}
	 */
	theme.createProductGallery = ( function () {
		function ProductGallery( $el ) {
			return this.init( $el );
		}

		var firstScrollTopOnSticky = true;

		function setupThumbs( self ) {
			self.$thumbs = self.$wc_gallery.find( '.product-thumbs' );
			self.$thumbsDots = self.$thumbs.children();
			self.isVertical = self.$thumbs.parent().parent().hasClass( 'pg-vertical' );
			self.$thumbsWrap = self.$thumbs.parent();

			// # setup thumbs slider
			theme.slider( self.$thumbs, {}, true );

			// # refresh thumbs
			self.isVertical && window.addEventListener( 'resize', function () {
				theme.requestTimeout( function () {
					self.$thumbs.data( 'slider' ).update();
				}, 100 )
			}, { passive: true } );
		}

		// Public Properties

		ProductGallery.prototype.init = function ( $wc_gallery ) {
			var self = this;

			// If woocommmerce product gallery is undefined, create it
			typeof $wc_gallery.data( 'product_gallery' ) == 'undefined' && $wc_gallery.wc_product_gallery();
			this.$wc_gallery = $wc_gallery;
			this.wc_gallery = $wc_gallery.data( 'product_gallery' );

			// Remove woocommerce zoom triggers
			$( '.woocommerce-product-gallery__trigger' ).remove();

			// Add full image trigger, and init zoom
			this.$slider = $wc_gallery.find( '.product-single-carousel' );

			if ( this.$slider.length ) {
				this.initThumbs(); // init thumbs together for single slider
			} else {
				this.$slider = this.$wc_gallery.find( '.product-gallery-carousel' );
				if ( this.$slider.length ) {	// gallery slider
					this.$slider.on( 'initialized.slider', this.initZoom.bind( this ) );
				} else { // other types
					this.initZoom();
				}
			}

			// Prevent going to image link
			$wc_gallery
				.off( 'click', '.woocommerce-product-gallery__image a' )
				.on( 'click', theme.preventDefault );

			if ( !$wc_gallery.closest( '.product-quickview' ).length && !$wc_gallery.closest( '.product-widget' ).length ) {
				// If only single product page
				if ( !document.body.classList.contains( 'single-' + alpha_vars.theme + '_template' ) )
					$wc_gallery.on( 'click', '.woocommerce-product-gallery__image a', this.openImageFull.bind( this ) );

				// Initialize sticky thumbs type.
				if ( $wc_gallery.find( '.product-sticky-thumbs' ).length ) {
					$wc_gallery.on( 'click', '.product-sticky-thumbs img', this.clickStickyThumbnail.bind( this ) );
					window.addEventListener( 'scroll', this.scrollStickyThumbnail.bind( this ), { passive: true } );
				}
			}

			// init slider after load, such as quickview
			if ( 'complete' === theme.status ) {
				self.$slider && self.$slider.length && theme.slider( self.$slider );
			}

			theme.$window.on( 'alpha_complete', function () {
				setTimeout( self.initAfterLazyload.bind( self ), 200 );
			} )
		}

		ProductGallery.prototype.initAfterLazyload = function () {
			this.currentPostImageSrc = this.$wc_gallery.find( '.wp-post-image' ).attr( 'src' );
		}

		/**
		 * Intialize thumbs in vertical thumbs type
		 * 
		 * @since 1.0
		 */
		ProductGallery.prototype.initThumbs = function () {
			var self = this;

			setupThumbs( self );

			// init thumbs
			this.$slider
				.on( 'initialized.slider', function ( e ) {
					// init thumbnails
					self.initZoom();
				} )
		}

		ProductGallery.prototype.openImageFull = function ( e ) {
			if ( wc_single_product_params.photoswipe_options ) {
				e.preventDefault();

				// Carousel Type
				var carousel = this.$wc_gallery.find( '.product-single-carousel' ).data( 'slider' );
				if ( carousel ) {
					wc_single_product_params.photoswipe_options.index = carousel.activeIndex;
				}
				if ( this.wc_gallery.$images.filter( '.yith_featured_content' ).length ) {
					wc_single_product_params.photoswipe_options.index = carousel ? carousel.activeIndex - 1 : $( e.currentTarget ).closest( '.woocommerce-product-gallery__image' ).index() - 1;
				}

				this.wc_gallery.openPhotoswipe( e );

				// to disable elementor's light box.
				e.stopPropagation();
			}
		}

		/**
		 * Event handler triggered when sticky thumbnail is clicked
		 *
		 * @since 1.0
		 * @param {Event} e Mouse click event
		 */
		ProductGallery.prototype.clickStickyThumbnail = function ( e ) {
			var self = this;
			var $thumb = $( e.currentTarget );

			$thumb.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
			this.isStickyScrolling = true;
			theme.scrollTo( this.$wc_gallery.find( '.product-sticky-images > :nth-child(' + ( $thumb.index() + 1 ) + ')' ) );
			setTimeout( function () {
				self.isStickyScrolling = false;
			}, 300 );
		}

		/**
		 * Event handler triggered while scrolling on sticky thumbnails
		 *
		 * @since 1.0
		 */
		ProductGallery.prototype.scrollStickyThumbnail = function () {
			var self = this;
			if ( this.isStickyScrolling ) {
				return;
			}
			this.$wc_gallery.find( '.product-sticky-images img:not(.zoomImg)' ).each( function () {
				if ( theme.isOnScreen( this ) ) {
					self.$wc_gallery.find( '.product-sticky-thumbs-inner > :nth-child(' +
						( $( this ).closest( '.woocommerce-product-gallery__image' ).index() + 1 ) + ')' )
						.addClass( 'active' ).siblings().removeClass( 'active' );
					return false;
				}
			} );
		}

		ProductGallery.prototype.initZoomImage = function ( zoomTarget ) {
			if ( alpha_vars.single_product.zoom_enabled ) {
				var width = zoomTarget.children( 'img' ).attr( 'data-large_image_width' ),
					// zoom option
					zoom_options = $.extend( {
						touch: false
					}, alpha_vars.single_product.zoom_options );

				if ( 'ontouchstart' in document.documentElement ) {
					zoom_options.on = 'click';
				}

				zoomTarget.trigger( 'zoom.destroy' ).children( '.zoomImg' ).remove();

				// zoom
				if ( 'undefined' != typeof width && zoomTarget.width() < width ) {
					zoomTarget.zoom( zoom_options );

					// show zoom on hover
					// setTimeout(function () {
					zoomTarget.find( ':hover' ).length && zoomTarget.trigger( 'mouseover' );
					// }, 100);
				}
			}
		}

		ProductGallery.prototype.changePostImage = function ( variation ) {

			var $image = this.$wc_gallery.find( '.wp-post-image' );

			// Has post image been changed?
			if ( $image.hasClass( 'd-lazyload' ) || this.currentPostImageSrc == $image.attr( 'src' ) ) {
				return;
			} else {
				this.currentPostImageSrc = $image.attr( 'src' );
			}

			// Add found class to form, change nav thumbnail image on found variation
			var $postThumbImage = this.$wc_gallery.find( '.product-thumbs img' ).eq( 0 ),
				$gallery = this.$wc_gallery.find( '.product-gallery' );

			if ( $postThumbImage.length ) {
				if ( typeof variation != 'undefined' ) {
					if ( 'reset' == variation ) {
						$postThumbImage.wc_reset_variation_attr( 'src' );
						$postThumbImage.wc_reset_variation_attr( 'srcset' );
						$postThumbImage.wc_reset_variation_attr( 'sizes' );
						$postThumbImage.wc_reset_variation_attr( 'alt' );
					} else {
						$postThumbImage.wc_set_variation_attr( 'src', variation.image.gallery_thumbnail_src );
						variation.image.alt && $postThumbImage.wc_set_variation_attr( 'alt', variation.image.alt );
						variation.image.srcset && $postThumbImage.wc_set_variation_attr( 'srcset', variation.image.srcset );
						variation.image.sizes && $postThumbImage.wc_set_variation_attr( 'sizes', variation.image.sizes );
					}
				} else {
					$postThumbImage.wc_set_variation_attr( 'src', this.currentPostImageSrc );
					$image.attr( 'srcset' ) && $postThumbImage.wc_set_variation_attr( 'srcset', $image.attr( 'srcset' ) );
					$image.attr( 'sizes' ) && $postThumbImage.wc_set_variation_attr( 'sizes', $image.attr( 'sizes' ) );
					$image.attr( 'alt' ) && $postThumbImage.wc_set_variation_attr( 'alt', $image.attr( 'alt' ) );
				}
			}

			// Refresh zoom
			this.initZoomImage( $image.parent() );

			// Refresh if carousel layout
			var carousel = $gallery.children( '.product-single-carousel,.product-gallery-carousel' ).data( 'slider' );
			carousel && ( carousel.update() );

			if ( !firstScrollTopOnSticky ) {
				// If sticky, go to top;
				if ( this.$wc_gallery.closest( '.product' ).find( '.sticky-sidebar .summary' ).length ) {
					theme.scrollTo( this.$wc_gallery, 400 );
				}
			}
			firstScrollTopOnSticky = false;
		}

		ProductGallery.prototype.initZoom = function () {
			if ( alpha_vars.single_product.zoom_enabled ) {
				var self = this;

				// if not quickview, widget
				if ( !this.$wc_gallery.closest( '.product-quickview' ).length && !this.$wc_gallery.closest( '.product-widget' ).length && !this.$wc_gallery.hasClass( 'woocommerce-product-gallery--without-images' ) ) {
					var buttons = '<button class="product-gallery-btn product-image-full ' + alpha_vars.theme_icon_prefix + '-icon-zoom"></button>' + ( this.$wc_gallery.data( 'buttons' ) || '' );
					// show image full toggler
					if ( this.$slider.length && this.$slider.hasClass( 'product-single-carousel' ) ) {
						// if default or horizontal type, show only one
						this.$slider.after( buttons );
					} else {
						// else other types
						this.$wc_gallery.find( '.woocommerce-product-gallery__image > a' ).each( function () {
							$( this ).after( buttons );
						} );
					}
				}

				// zoom images
				this.$wc_gallery.find( '.woocommerce-product-gallery__image > a' ).each( function () {
					self.initZoomImage( $( this ) );
				} );
			}
		}

		return function ( selector ) {
			if ( $.fn.wc_product_gallery ) {
				theme.$( selector ).each( function () {
					var $this = $( this );
					$this.data( 'alpha_product_gallery', new ProductGallery( $this ) );
				} );
			}
		}
	} )();

	/**
	 * Initialize product gallery
	 * 
	 * @class ProductGallery
	 * @since 1.0
	 * @param {string|jQuery} selector
	 * @return {void}
	 */
	theme.initProductGallery = function () {
		function onClickImageFull( e ) {
			var $btn = $( e.currentTarget );
			e.preventDefault();

			// Default or horizontal type
			if ( $btn.siblings( '.product-single-carousel' ).length ) {
				$btn.parent().find( '.slider-slide-active a' ).trigger( 'click' );
			} else {
				$btn.prev( 'a' ).trigger( 'click' );
			}
		}

		// Image lightbox toggle
		theme.$body.on( 'click', '.product-image-full', onClickImageFull );
	}

	/**
	 * Create product single object
	 * 
	 * @class ProductSingle
	 * @since 1.0
	 * @param {string|jQuery} selector 
	 * @return {void}
	 */
	theme.createProductSingle = ( function () {
		function ProductSingle( $el ) {
			return this.init( $el );
		}

		// Public Properties
		ProductSingle.prototype.init = function ( $el ) {
			this.$product = $el;

			// gallery
			$el.find( '.woocommerce-product-gallery' ).each( function () {
				theme.createProductGallery( $( this ) );
			} )

			// variation        
			$( '.reset_variations' ).hide().removeClass( 'd-none' );

			// review
			$( document.body )
				.on( 'click', '.submit-review-toggle', function ( e ) {
					e.preventDefault();
					$( '#review_form_wrapper' ).toggleClass( 'opened' );
				} )
				.on( 'click', '#review_form_wrapper .offcanvas-overlay', function ( e ) {
					$( '#review_form_wrapper' ).removeClass( 'opened' );
				} );

			// after load, such as quickview
			if ( 'complete' === theme.status ) {
				// variation form
				if ( $.fn.wc_variation_form && typeof wc_add_to_cart_variation_params !== 'undefined' ) {
					this.$product.find( '.variations_form' ).wc_variation_form();
				}

				// quantity input
				theme.quantityInput( this.$product.find( '.qty' ) );

				// countdown
				theme.countdown( this.$product.find( '.product-countdown' ) );
			} else {
				// sticky add to cart cart
				if ( !this.$product.hasClass( 'product-widget' ) || this.$product.hasClass( 'product-quickview' ) ) {
					this.stickyCartForm( this.$product.find( '.product-sticky-content' ) );
				}
			}
		}

		/**
		 * Make cart form as sticky
		 * 
		 * @since 1.0
		 * @param {string|jQuery} selector 
		 * @return {void}
		 */
		ProductSingle.prototype.stickyCartForm = function ( selector ) {
			var $stickyForm = theme.$( selector );

			if ( $stickyForm.length != 1 ) {
				return;
			}

			var $product = $stickyForm.closest( '.product' );
			var titleEl = $product.find( '.product_title' ).get( 0 );
			var $image = $product.find( '.woocommerce-product-gallery .wp-post-image' ).eq( 0 );
			var imageSrc = alpha_vars.lazyload ? $image.attr( 'data-lazy' ) : $image.attr( 'src' );
			var $price = $product.find( 'p.price' );

			if ( !imageSrc ) {
				imageSrc = $image.attr( 'src' );
			}

			// setup sticky form
			$stickyForm.find( '.quantity-wrapper' ).before(
				'<div class="sticky-product-details">' +
				( $image.length ? '<img src="' + imageSrc + '" width="' + $image.attr( 'width' ) + '" height="' + $image.attr( 'height' ) + '" alt="' + $image.attr( 'alt' ) + '">' : '' ) +
				'<div>' +
				( titleEl ? titleEl.outerHTML.replace( '<h1', '<h3' ).replace( 'h1>', 'h3>' ).replace( 'product_title', 'product-title' ) : '' ) +
				( $price.length ? $price[ 0 ].outerHTML : '' ) + '</div>'
			);

			var sticky = $stickyForm.data( 'sticky-content' );
			if ( sticky ) {
				/**
				 * Register getTop function for sticky "add to cart" form, that runs above 768px.
				 * 
				 * @since 1.0
				 */
				sticky.getTop = function () {
					var $parent;
					if ( $stickyForm.closest( '.sticky-sidebar' ).length ) {
						$parent = $product.find( '.woocommerce-product-gallery' );
					} else {
						$parent = $stickyForm.closest( '.product-single > *' );
						if ( $parent.hasClass( 'elementor' ) ) {
							$parent = $stickyForm.closest( '.cart' );
						}
					}
					return $parent.offset().top + $parent.height();
				}

				sticky.onFixed = function () {
					theme.$body.addClass( 'addtocart-fixed' );
				}

				sticky.onUnfixed = function () {
					theme.$body.removeClass( 'addtocart-fixed' );
				}
			}

			// Fix top in mobile, fix bottom otherwise
			function _changeFixPos() {
				theme.requestTimeout( function () {
					$stickyForm.removeClass( 'fix-top fix-bottom' ).addClass( window.innerWidth < 768 ? 'fix-top' : 'fix-bottom' );
				}, 50 );
			}

			theme.$window.on( 'sticky_refresh_size.alpha', _changeFixPos );

			_changeFixPos();
		}

		return function ( selector ) {
			theme.$( selector ).each( function () {
				var $this = $( this );
				$this.data( 'alpha_product_single', new ProductSingle( $this ) );
			} );
		}
	} )();

	/**
	 * Initilize single product page, and register events for single product.
	 *
	 * @since 1.0
	 * @param {string} selector
	 * @return {void}
	 */
	theme.initProductSingle = ( function () {

		/**
		 * Initialize add to cart in ajax in single product
		 */
		function initAjaxAddToCart() {
			theme.$body.on( 'click', '.single_add_to_cart_button', function ( e ) {

				var $btn = $( e.currentTarget );

				if ( $btn.hasClass( 'disabled' ) || $btn.hasClass( 'has_buy_now' ) ) {
					return;
				}

				var $product = $btn.closest( '.product-single' );
				if ( !$product.length || $product.hasClass( 'product-type-external' ) || $product.hasClass( 'product-type-grouped' ) ||
					!$product.hasClass( 'product-widget' ) && !$product.hasClass( 'product-quickview' ) ) {
					return;
				}
				e.preventDefault();

				var $form = $btn.closest( 'form.cart' );
				if ( $form.hasClass( 'd-loading' ) ) {
					return;
				}

				var variation_id = $form.find( 'input[name="variation_id"]' ).val(),
					product_id = variation_id ? $form.find( 'input[name="product_id"]' ).val() : $btn.val(),
					quantity = $form.find( 'input[name="quantity"]' ).val(),
					$attributes = $form.find( 'select[data-attribute_name]' ),
					data = {
						product_id: variation_id ? variation_id : product_id,
						quantity: quantity
					};

				$attributes.each( function () {
					var $this = $( this );
					data[ $this.attr( 'data-attribute_name' ) ] = $this.val();
				} );

				// Initialize ajax url
				var ajax_url = '';

				// Resolve issue. For the variable product that has any type, ajax add to cart does not work
				// in single product widget and quickview
				// 2021-06-20
				if ( $product.hasClass( 'product-widget' ) || $product.hasClass( 'product-quickview' ) ) {
					ajax_url = alpha_vars.ajax_url;
					data.action = 'alpha_ajax_add_to_cart';
				} else {
					ajax_url = wc_add_to_cart_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'add_to_cart' );
				}

				theme.doLoading( $btn, 'small' );
				$btn.removeClass( 'added' );

				// Trigger event.
				theme.$body.trigger( 'adding_to_cart', [ $btn, data ] );

				$.ajax( {
					type: 'POST',
					url: ajax_url,
					data: data,
					dataType: 'json',
					success: function ( response ) {
						if ( !response ) {
							return;
						}
						if ( response.error && response.product_url ) {
							location = response.product_url;
							return;
						}

						// Redirect to cart option
						if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
							location = wc_add_to_cart_params.cart_url;
							return;
						}

						// trigger event
						$( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $btn ] );

						// show minipopup box
						var link = $form.attr( 'action' ),
							image = $product.find( '.wp-post-image' ).attr( 'src' ),
							title = $product.find( '.product_title' ).text(),
							price = variation_id ? $form.find( '.woocommerce-variation-price .price' ).html() : $product.find( '.price' ).html(),
							count = parseInt( $form.find( '.qty' ).val() ),
							id = $product.attr( 'id' );

						price || ( price = $product.find( '.price' ).html() );

						var $popup_product = $( '.minipopup-area' ).find( "#" + id );

						if ( id == $popup_product.attr( 'id' ) ) {
							$popup_product.find( '.cart-count' ).html( parseInt( $popup_product.find( '.cart-count' ).html() ) + count );
						} else {
							theme.minipopup.open( {
								content: '<div class="minipopup-box">\
									<div class="product product-list-sm" id="' + id + '">\
										<figure class="product-media"><a href="' + link + '"><img src="' + image + '"></img></a></figure>\
										<div class="product-details"><a class="product-title" href="' + link + '"><span class="cart-count">' + count + '</span> x ' + title + '</a>' + alpha_vars.texts.cart_suffix + '</div></div>\
										<div class="minipopup-footer">' + '<a href="' + alpha_vars.pages.cart + '" class="btn btn-sm btn-rounded">' + alpha_vars.texts.view_cart + '</a><a href="' + alpha_vars.pages.checkout + '" class="btn btn-sm btn-dark btn-rounded">' + alpha_vars.texts.view_checkout + '</a></div></div>'
							} );
						}
					},
					complete: function () {
						theme.endLoading( $btn );
					}
				} );
			} );
		}

		/**
		 * Initiazlie variable product
		 * 
		 * @since 1.0
		 */
		/*
		function initVariableProduct() {
			function onClickListVariation( e ) {
				var $btn = $( e.currentTarget );
				if ( $btn.hasClass( 'disabled' ) ) {
					return;
				}
				if ( $btn.hasClass( 'active' ) ) {
					$btn.removeClass( 'active' )
						.parent().next().val( '' ).change();
				} else {
					$btn.addClass( 'active' ).siblings().removeClass( 'active' );
					$btn.parent().next().val( $btn.attr( 'name' ) ).change();
				}
			}

			function onClickResetVariation( e ) {
				$( e.currentTarget ).closest( '.variations_form' ).find( '.active' ).removeClass( 'active' );
			}

			function onToggleResetVariation() {
				var $reset = $( theme.byClass( 'reset_variations', this ) );
				$reset.css( 'visibility' ) == 'hidden' ? $reset.hide() : $reset.show();
			}

			function onFoundVariation( e, variation ) {

				var $product = $( e.currentTarget ).closest( '.product' );
				// Display product of matched variation.
				var gallery = $product.find( '.woocommerce-product-gallery' ).data( 'alpha_product_gallery' );
				if ( gallery ) {
					gallery.changePostImage( variation );
				}

				// Display sale countdown of matched variation.
				var $counter = $product.find( '.countdown-variations' );
				if ( $counter.length ) {
					if ( variation && variation.is_purchasable && variation.alpha_date_on_sale_to ) {
						var $countdown = $counter.find( '.countdown' );
						if ( $countdown.data( 'until' ) != variation.alpha_date_on_sale_to ) {
							theme.countdown( $countdown, { until: new Date( variation.alpha_date_on_sale_to ) } );
							$countdown.data( 'until', variation.alpha_date_on_sale_to );
						}
						$counter.slideDown();
					} else {
						$counter.slideUp();
					}
				}
			}

			function onResetVariation( e ) {
				var $product = $( e.currentTarget ).closest( '.product' );
				var $gallery = $product.find( '.woocommerce-product-gallery' );

				if ( $gallery.length ) {
					var gallery = $gallery.data( 'alpha_product_gallery' );
					if ( gallery ) {
						gallery.changePostImage( 'reset' );
					}
				}

				$product.find( '.countdown-variations' ).slideUp();
			}

			function onUpdateVariation() {
				var $form = $( this );
				$form.find( '.product-variations>button' ).addClass( 'disabled' );

				// Loop through selects and disable/enable options based on selections.
				$form.find( 'select' ).each( function () {
					var $this = $( this );
					var $buttons = $this.closest( '.variations > *' ).find( '.product-variations' );
					$this.children( '.enabled' ).each( function () {
						$buttons.children( '[name="' + this.getAttribute( 'value' ) + '"]' ).removeClass( 'disabled' );
					} );
					$this.children( ':selected' ).each( function () {
						$buttons.children( '[name="' + this.getAttribute( 'value' ) + '"]' ).addClass( 'active' );
					} );
				} );
			}

			// Variation
			theme.$body.on( 'click', '.variations .product-variations button', onClickListVariation )
				.on( 'click', '.reset_variations', onClickResetVariation )
				.on( 'check_variations', '.variations_form', onToggleResetVariation )
				.on( 'found_variation', '.variations_form', onFoundVariation )
				.on( 'reset_image', '.variations_form', onResetVariation )
				.on( 'update_variation_values', '.variations_form', onUpdateVariation )
		}
		*/
		/**
		 * Initalize guide link
		 * 
		 * @since 1.0
		 */
		function initGuideLink() {
			// Guide Link
			theme.$body.on( 'click', '.guide-link', function () {
				var $link = $( this.getAttribute( 'href' ) + '>a' );
				$link.length && $link.trigger( 'click' );
			} );

			if ( theme.hash.toLowerCase().indexOf( 'tab-title-alpha_pa_block_' ) ) {
				$( theme.hash + '>a' ).trigger( 'click' );
			}
		}

		/**
		 * Initialize woocommerce product data
		 * 
		 * @since 1.0
		 */
		function initProductData() {
			// Init data tab accordion
			theme.$body.on( 'init', '.woocommerce-tabs.accordion', function () {
				var $tabs = $( this );
				setTimeout( function () {
					var selector = '';
					if ( theme.hash.toLowerCase().indexOf( 'comment-' ) >= 0 ||
						theme.hash === '#reviews' || theme.hash === '#tab-reviews' ||
						location.href.indexOf( 'comment-page-' ) > 0 || location.href.indexOf( 'cpage=' ) > 0 ) {

						selector = '.reviews_tab a';
					} else if ( theme.hash === '#tab-additional_information' ) {
						selector = '.additional_information_tab a';
					} else {
						selector = '.card:first-child > .card-header a';
					}
					$tabs.find( selector ).trigger( 'click' );
				}, 100 );
			} )
		}

		/**
		 * Initialize woocommerce compatility
		 * 
		 * @since 1.0
		 * @param {string|jQuery} selector
		 */
		function initWooCompatibility( selector ) {

			// Initialize product gallery again for skeleton screen.
			if ( alpha_vars.skeleton_screen ) {
				// wc product gallery
				if ( $.fn.wc_product_gallery ) {
					$( selector + ' .woocommerce-product-gallery' ).each( function () {
						var $this = $( this );
						typeof $this.data( 'product_gallery' ) == 'undefined' && $this.wc_product_gallery();
					} )
				}
			}

			// Initialize variation form
			if ( $.fn.wc_variation_form && typeof wc_add_to_cart_variation_params !== 'undefined' ) {
				theme.$( selector, '.variations_form' ).each( function () {
					var $form = $( this );
					if ( theme.status != 'load' || $form.closest( '.summary' ).length ) {
						var data_a = jQuery._data( this, 'events' );
						if ( !data_a || !data_a[ 'show_variation' ] ) {
							$form.wc_variation_form();
						} else {
							theme.requestTimeout( function () {
								$form.trigger( 'check_variations' );
							}, 100 );
						}
					}
				} );
			}

			if ( alpha_vars.skeleton_screen && !theme.$body.hasClass( 'alpha-use-vendor-plugin' ) ) {
				// init - wc tab
				$( '.wc-tabs-wrapper, .woocommerce-tabs' ).trigger( 'init' );
				// init - wc rating
				theme.$( selector, '#rating' ).trigger( 'init' );
			} else {
				$( '.woocommerce-tabs.accordion' ).trigger( 'init' );

				// Compatibility with lazyload
				var $image = theme.$( '.woocommerce-product-gallery .wp-post-image' );
				if ( $image.length ) {
					if ( $image.attr( 'data-lazy' ) && $image.attr( 'data-o_src' ) && $image.attr( 'data-o_src' ).indexOf( 'lazy.png' ) >= 0 ) {
						$image.attr( 'data-o_src', $image.attr( 'data-lazy' ) );
					}

					if ( $image.attr( 'data-lazyset' ) && $image.attr( 'data-o_srcset' ) && $image.attr( 'data-o_srcset' ).indexOf( 'lazy.png' ) >= 0 ) {
						$image.attr( 'data-o_srcset', $image.attr( 'data-lazyset' ) );
					}
				}
			}
		}

		return function ( selector ) {
			if ( typeof selector == 'undefined' ) {
				selector = '';
			}

			initProductData();
			initWooCompatibility();


			// Single product page
			theme.createProductSingle( selector + '.product-single' );
			theme.initProductGallery();

			// Register events
			theme.$window.on( 'alpha_complete', function () {
				initAjaxAddToCart();
				// initVariableProduct();
				initGuideLink();
			} )
		}
	} )();

	/**
	 * Initialize shop functions
	 *
	 * @class Shop
	 * @since 1.0
	 * @return {void}
	 */
	theme.shop = ( function () {

		/**
		 * Initialize shop filter menu for horizontal layout (horizontal filter widgets)
		 * 
		 * @since 1.0
		 */
		function initSelectMenu() {

			function _initSelectMenu() {
				// show selected attributes after loading
				$( '.toolbox-horizontal .shop-sidebar .widget .chosen' ).each( function ( e ) {
					if ( $( this ).find( 'a' ).attr( 'href' ) == window.location.href ) {
						return;
					}

					$( '<a href="#" class="select-item">' + $( this ).find( 'a' ).text() + '<i class="' + alpha_vars.theme_icon_prefix + '-icon-times-solid"></i></a>' )
						.insertBefore( '.toolbox-horizontal + .select-items .filter-clean' )
						.attr( 'data-type', $( this ).closest( '.widget' ).attr( 'id' ).split( '-' ).slice( 0, -1 ).join( '-' ) )
						.data( 'link_id', $( this ).closest( '.widget' ).attr( 'id' ) )
						.data( 'link_idx', $( this ).index() );

					$( '.toolbox-horizontal + .select-items' ).fadeIn();
				} )
			}

			function openMenu( e ) {
				// close all select menu
				$( this ).parent().siblings().removeClass( 'opened' );
				$( this ).parent().toggleClass( 'opened' );
				e.stopPropagation();
			}

			function closeMenu( e ) {
				$( '.toolbox-horizontal .shop-sidebar .widget, .alpha-filters .select-ul' ).removeClass( 'opened' );
			}

			function stopPropagation( e ) {
				e.stopPropagation();
			}

			function onAddFilterItem( e ) {
				var $this = $( this );

				if ( $this.closest( '.widget' ).hasClass( 'yith-woo-ajax-reset-navigation' ) ) {
					return;
				}

				theme.doLoading( '.horizontal-sidebar .widget>*:not(.widget-title)', 'small' );

				if ( $this.closest( '.product-categories' ).length ) {
					$( '.toolbox-horizontal + .select-items .select-item' ).remove();
				}

				if ( $this.parent().hasClass( 'chosen' ) ) {
					$( '.toolbox-horizontal + .select-items .select-item' )
						.filter( function ( i, el ) {
							return $( el ).data( 'link_id' ) == $this.closest( '.widget' ).attr( 'id' ) &&
								$( el ).data( 'link_idx' ) == $this.closest( 'li' ).index();
						} )
						.fadeOut( function () {
							$( this ).remove();

							// if only clean all button remains
							if ( $( '.select-items' ).children().length < 2 ) {
								$( '.select-items' ).hide();
							}
						} )
				} else {
					var type = $this.closest( '.widget' ).attr( 'id' ).split( '-' ).slice( 0, -1 ).join( '-' );

					if ( 'alpha-price-filter' == type ) {
						$( '.toolbox-horizontal + .select-items' ).find( '[data-type="alpha-price-filter"]' ).remove();
						$this.closest( 'li' ).addClass( 'chosen' ).siblings().removeClass( 'chosen' );
					}

					$( '<a href="#" class="select-item">' + $this.text() + '<i class="' + alpha_vars.theme_icon_prefix + '-icon-times-solid"></i></a>' )
						.insertBefore( '.toolbox-horizontal + .select-items .filter-clean' )
						.hide().fadeIn()
						.attr( 'data-type', type )
						.data( 'link_id', $this.closest( '.widget' ).attr( 'id' ) )
						.data( 'link_idx', $this.closest( 'li' ).index() ); // link to anchor

					// if only clean all button remains
					if ( $( '.select-items' ).children().length >= 2 ) {
						$( '.select-items' ).show();
					}
				}
			}

			function onAddFiltersWidgetItem( e ) {
				e.preventDefault();
				e.stopPropagation();

				if ( 'or' == $( this ).closest( '.alpha-filter' ).attr( 'data-filter-query' ) ) {
					$( this ).closest( 'li' ).toggleClass( 'chosen' );
				} else {
					$( this ).closest( 'li' ).toggleClass( 'chosen' ).siblings().removeClass( 'chosen' );
				}

				var $btn_filter = $( this ).closest( '.alpha-filters' ).find( '.btn-filter' ),
					link = $btn_filter.attr( 'href' ),
					$filters = $( this ).closest( '.alpha-filters' );
				link = link.split( '/' );
				link[ link.length - 1 ] = '';

				$filters.length && $filters.find( '.alpha-filter' ).each( function ( index ) {
					var chosens = $( this ).find( '.chosen' );

					if ( chosens.length ) {
						var values = [],
							attr = $( this ).attr( 'data-filter-attr' );

						chosens.each( function () {
							values.push( $( this ).attr( 'data-value' ) );
						} )

						link[ link.length - 1 ] += 'filter_' + attr + '=' + values.join( ',' ) + '&query_type_' + attr + '=' + $( this ).attr( 'data-filter-query' ) + ( index != $filters.length ? '&' : '' );
					}
				} );

				link[ link.length - 1 ] = '?' + link[ link.length - 1 ];
				$btn_filter.attr( 'href', link.join( '/' ) );
			}

			function onRemoveFilterItem( e ) {
				e.preventDefault();
				var $this = $( this );
				var id = $this.data( 'link_id' );
				if ( id ) {
					var $link = $( '.toolbox-horizontal .shop-sidebar #' + id ).find( 'li' ).eq( $this.data( 'link_idx' ) ).children( 'a' );
					if ( $link.length ) {
						if ( $link.closest( '.product-categories' ).length ) {
							$this.siblings( '.filter-clean' ).trigger( 'click' );
						} else {
							$link.trigger( 'click' );
						}
					}
				}
			}

			function onCleanFilterItems( e ) {
				e.preventDefault();

				$( this ).parent( '.select-items' ).fadeOut( function () {
					$( this ).children( '.select-item' ).remove();
				} )
			}

			_initSelectMenu();

			theme.$body
				// show or hide select menu
				.on( 'click', '.toolbox-horizontal .shop-sidebar .widget-title, .alpha-filters .select-ul-toggle, .toolbox-horizontal .shop-sidebar .wp-block-group__inner-container > h2', openMenu )
				.on( 'click', '.toolbox-horizontal .shop-sidebar .widget-title + *, .toolbox-horizontal .shop-sidebar .wp-block-group__inner-container > h2 + *', stopPropagation ) // if click in popup area, not hide it
				.on( 'click', closeMenu )

				// if select item is clicked
				.on( 'click', '.toolbox-horizontal .shop-sidebar .widget a', onAddFilterItem )
				.on( 'click', '.toolbox-horizontal + .select-items .select-item', onRemoveFilterItem )
				.on( 'click', '.toolbox-horizontal + .select-items .filter-clean', onCleanFilterItems )

				// alpha filters widget / filter item is clicked
				.on( 'click', '.alpha-filters .select-ul a', onAddFiltersWidgetItem );
		}


		/**
		 * Ajax add to cart for variation products
		 * 
		 * @since 1.0
		 */
		var initProductsAttributeAction = function () {
			theme.$body
				.on( 'click', '.product-variation-wrapper button', function ( e ) {
					var $this = $( this ),
						$variation = $this.parent(),
						$wrapper = $this.closest( '.product-variation-wrapper' ),
						attr = 'attribute_' + String( $variation.data( 'attr' ) ),
						variationData = $wrapper.data( 'product_variations' ),
						attributes = $wrapper.data( 'product_attrs' ),
						attrValue = $this.attr( 'name' ),
						$price = $wrapper.closest( '.product-loop' ).find( '.price' ),
						priceHtml = $wrapper.data( 'price' );

					if ( $this.hasClass( 'disabled' ) ) {
						return;
					}
					// if ( $this.hasClass( 'active' ) ) {
					// 	$this.removeClass( 'active' )
					// 		.parent().next().val( '' ).change();
					// } else {
					// 	$this.addClass( 'active' ).siblings().removeClass( 'active' );
					// 	$this.parent().next().val( $this.attr( 'name' ) ).change();
					// }

					var suitableData = variationData,
						matchedData = variationData;

					// Get Attributes
					if ( undefined == attributes ) {
						attributes = [];
						$wrapper.find( '.product-variations' ).each( function () {
							attributes.push( 'attribute_' + String( $( this ).data( 'attr' ) ) );
						} );
						$wrapper.data( 'product_attrs', attributes );
					}

					// Save HTML
					if ( undefined == priceHtml ) {
						priceHtml = $price.html();
						$wrapper.data( 'price', priceHtml );
					}


					// Update Matched Array
					if ( attrValue == $wrapper.data( attr ) ) {
						$wrapper.removeData( attr );
						let tempArray = [];
						variationData.forEach( function ( item, index ) {
							var flag = true;
							attributes.forEach( function ( attr_item ) {
								if ( undefined != $wrapper.data( attr_item ) && $wrapper.data( attr_item ) != item[ 'attributes' ][ attr_item ] && "" != item[ 'attributes' ][ attr_item ] ) {
									flag = false;
								}
							} );
							if ( flag ) {
								tempArray.push( item );
							}
						} );

						matchedData = tempArray;
					} else {
						$wrapper.data( attr, attrValue );
						let tempArray = [];
						variationData.forEach( function ( item, index ) {
							var flag = true;
							attributes.forEach( function ( attr_item ) {
								if ( undefined != $wrapper.data( attr_item ) && $wrapper.data( attr_item ) != item[ 'attributes' ][ attr_item ] && "" != item[ 'attributes' ][ attr_item ] ) {
									flag = false;
								}
							} );
							if ( flag ) {
								tempArray.push( item );
							}
						} );

						matchedData = tempArray;
					}

					var showPrice = true;
					attributes.forEach( function ( attr_item ) {
						if ( attr != attr_item || ( attr_item == attr && undefined == $wrapper.data( attr ) ) ) {
							let $variation = $wrapper.find( '.' + attr_item.slice( 10 ) + ' > *:not(.guide-link)' );

							$variation.each( function () {
								var $this = $( this );
								if ( !$this.hasClass( 'select-box' ) ) {
									$this.addClass( 'disabled' );
								} else {
									$this.find( 'option' ).css( 'display', 'none' );
								}
							} )

							variationData.forEach( function ( item ) {
								let flag = true;
								attributes.forEach( function ( atr_item ) {
									if ( undefined != $wrapper.data( atr_item ) && attr_item != atr_item && item[ 'attributes' ][ atr_item ] != $wrapper.data( atr_item ) && "" != item[ 'attributes' ][ atr_item ] ) {
										flag = false;
									}
								} );
								if ( true == flag ) {
									if ( "" == item[ 'attributes' ][ attr_item ] ) {
										$variation.removeClass( 'disabled' );
										$variation.each( function () {
											var $this = $( this );
											if ( !$this.hasClass( 'select-box' ) ) {
												$this.removeClass( 'disabled' );
											} else {
												$this.find( 'option' ).css( 'display', '' );
											}
										} )
									} else {
										$variation.each( function () {
											var $this = $( this );
											if ( !$this.hasClass( 'select-box' ) ) {
												if ( $this.attr( 'name' ) == item[ 'attributes' ][ attr_item ] ) {
													$this.removeClass( 'disabled' );
												}
											} else {
												$this.find( 'option' ).each( function () {
													var $this = $( this );
													if ( $this.attr( 'value' ) == item[ 'attributes' ][ attr_item ] || $this.attr( 'value' ) == '' ) {
														$this.css( 'display', '' );
													}
												} );
											}
										} );
									}
								}
							} );
						}
						if ( undefined == $wrapper.data( attr_item ) ) {
							showPrice = false;
						}
					} );

					if ( true == showPrice && 1 == matchedData.length ) {
						$price.closest( '.product-loop' ).data( 'variation', matchedData[ 0 ][ 'variation_id' ] );
						$price.html( $( matchedData[ 0 ][ 'price_html' ] ).html() );
						$price.closest( '.product-loop' ).find( '.add_to_cart_button' )
							.removeClass( 'product_type_variable' )
							.addClass( 'product_type_simple' );
					} else {
						$price.html( priceHtml );
						$price.closest( '.product-loop' ).removeData( 'variation' )
							.find( '.add_to_cart_button' )
							.removeClass( 'product_type_simple' )
							.addClass( 'product_type_variable' );
					}
				} )
				.on( 'change', '.product-variation-wrapper select', function ( e ) {
					var $this = $( this ),
						$variation = $this.parent(),
						$wrapper = $this.closest( '.product-variation-wrapper' ),
						attr = $this.data( 'attribute_name' ),
						variationData = $wrapper.data( 'product_variations' ),
						attributes = $wrapper.data( 'product_attrs' ),
						attrValue = $this.val(),
						$price = $wrapper.closest( '.product-loop' ).find( '.price' ),
						priceHtml = $wrapper.data( 'price' );


					var suitableData = variationData,
						matchedData = variationData;

					// Get Attributes
					if ( undefined == attributes ) {
						attributes = [];
						$wrapper.find( '.product-variations' ).each( function () {
							attributes.push( 'attribute_' + String( $( this ).data( 'attr' ) ) );
						} );
						$wrapper.data( 'product_attrs', attributes );
					}

					// Save HTML
					if ( undefined == priceHtml ) {
						priceHtml = $price.html();
						$wrapper.data( 'price', priceHtml );
					}


					// Update Matched Array
					if ( "" == attrValue ) {
						$wrapper.removeData( attr );
						let tempArray = [];
						variationData.forEach( function ( item, index ) {
							var flag = true;
							attributes.forEach( function ( attr_item ) {
								if ( undefined != $wrapper.data( attr_item ) && $wrapper.data( attr_item ) != item[ 'attributes' ][ attr_item ] && "" != item[ 'attributes' ][ attr_item ] ) {
									flag = false;
								}
							} );
							if ( flag ) {
								tempArray.push( item );
							}
						} );

						matchedData = tempArray;
					} else {
						$wrapper.data( attr, attrValue );
						let tempArray = [];
						variationData.forEach( function ( item, index ) {
							var flag = true;
							attributes.forEach( function ( attr_item ) {
								if ( undefined != $wrapper.data( attr_item ) && $wrapper.data( attr_item ) != item[ 'attributes' ][ attr_item ] && "" != item[ 'attributes' ][ attr_item ] ) {
									flag = false;
								}
							} );
							if ( flag ) {
								tempArray.push( item );
							}
						} );

						matchedData = tempArray;
					}

					var showPrice = true;
					attributes.forEach( function ( attr_item ) {
						if ( attr != attr_item || ( attr_item == attr && undefined == $wrapper.data( attr ) ) ) {
							let $variation = $wrapper.find( '.' + attr_item.slice( 10 ) + ' > *' );

							$variation.each( function () {
								var $this = $( this );
								if ( !$this.hasClass( 'select-box' ) ) {
									$this.addClass( 'disabled' );
								} else {
									$this.find( 'option' ).css( 'display', 'none' );
								}
							} );

							variationData.forEach( function ( item ) {
								let flag = true;
								attributes.forEach( function ( atr_item ) {
									if ( undefined != $wrapper.data( atr_item ) && attr_item != atr_item && item[ 'attributes' ][ atr_item ] != $wrapper.data( atr_item ) && "" != item[ 'attributes' ][ atr_item ] ) {
										flag = false;
									}
								} );
								if ( true == flag ) {
									if ( "" == item[ 'attributes' ][ attr_item ] ) {
										$variation.removeClass( 'disabled' );
										$variation.each( function () {
											var $this = $( this );
											if ( !$this.hasClass( 'select-box' ) ) {
												$this.removeClass( 'disabled' );
											} else {
												$this.find( 'option' ).css( 'display', '' );
											}
										} );
									} else {
										$variation.each( function () {
											var $this = $( this );
											if ( !$this.hasClass( 'select-box' ) ) {
												if ( $this.attr( 'name' ) == item[ 'attributes' ][ attr_item ] ) {
													$this.removeClass( 'disabled' );
												}
											} else {
												$this.find( 'option' ).each( function () {
													var $this = $( this );
													if ( $this.attr( 'value' ) == item[ 'attributes' ][ attr_item ] || $this.attr( 'value' ) == '' ) {
														$this.css( 'display', '' );
													}
												} );
											}
										} );
									}
								}
							} );
						}
						if ( undefined == $wrapper.data( attr_item ) ) {
							showPrice = false;
						}
					} );

					if ( true == showPrice && 1 == matchedData.length ) {
						$price.closest( '.product-loop' ).data( 'variation', matchedData[ 0 ][ 'variation_id' ] );
						$price.html( $( matchedData[ 0 ][ 'price_html' ] ).html() );
						$price.closest( '.product-loop' ).find( '.add_to_cart_button' )
							.removeClass( 'product_type_variable' )
							.addClass( 'product_type_simple' );
					} else {
						$price.html( priceHtml );
						$price.closest( '.product-loop' ).removeData( 'variation' )
							.find( '.add_to_cart_button' )
							.removeClass( 'product_type_simple' )
							.addClass( 'product_type_variable' );
					}
				} )
				.on( 'click', '.product-loop.product-type-variable .add_to_cart_button', function ( e ) {
					var $this = $( this ),
						$variations = $this.closest( '.product' ).find( '.product-variation-wrapper' ),
						attributes = $variations.data( 'product_attrs' ),
						$product = $this.closest( '.product-loop' );

					if ( undefined != $product.data( 'variation' ) ) {
						let data = {
							action: "alpha_add_to_cart",
							product_id: $product.data( 'variation' ),
							quantity: 1
						};
						attributes.forEach( function ( item ) {
							data[ item ] = $variations.data( item );
						} );
						$.ajax(
							{
								type: 'POST',
								dataType: 'json',
								url: alpha_vars.ajax_url,
								data: data,
								success: function ( response ) {
									$( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $this ] );
								}
							}
						);
						e.preventDefault();
					}
				} );
		}

		/**
		 * Initialize products quickview action
		 * 
		 * @since 1.0
		 */
		function initProductsQuickview() {

			theme.$body.on( 'click', '.btn-quickview', function ( e ) {
				e.preventDefault();

				var $this = $( this );
				var ajax_data = {
					action: 'alpha_quickview',
					product_id: $this.data( 'product' )
				};
				var quickviewType = alpha_vars.quickview_type || 'loading';
				if ( quickviewType == 'zoom' && window.innerWidth < 768 ) {
					quickviewType = 'loading';
				}

				if ( $this.closest( '.shop_table' ).length ) {
					theme.doLoading( $this, 'small' );
				}

				function finishQuickView() {
					theme.createProductSingle( '.mfp-product .product-single' );
					if ( $this.closest( '.shop_table' ).length ) {
						theme.endLoading( $this );
					}
				}

				function openQuickview( quickviewType ) {
					theme.popup( {
						type: 'ajax',
						mainClass: 'mfp-product mfp-fade' + ( quickviewType == 'offcanvas' ? ' mfp-offcanvas' : '' ),
						items: {
							src: alpha_vars.ajax_url
						},
						ajax: {
							settings: {
								method: 'POST',
								data: ajax_data
							},
							cursor: 'mfp-ajax-cur', // CSS class that will be added to body during the loading (adds "progress" cursor)
							tError: '<div class="alert alert-warning alert-round alert-inline">' + alpha_vars.texts.popup_error + '<button type="button" class="btn btn-link btn-close"><i class="close-icon"></i></button></div>'
						},
						preloader: false,
						callbacks: {
							afterChange: function () {
								var skeletonTemplate;
								if ( alpha_vars.skeleton_screen ) {
									var extraClass = alpha_vars.quickview_thumbs == 'horizontal' ? '' : ' pg-vertical';
									if ( quickviewType == 'offcanvas' ) {
										skeletonTemplate = '<div class="product skeleton-body' + extraClass + '"><div class="skel-pro-gallery"></div><div class="skel-pro-summary" style="margin-top: 20px"></div></div>';;
									} else {
										skeletonTemplate = '<div class="product skeleton-body row"><div class="col-md-6' + extraClass + '"><div class="skel-pro-gallery"></div></div><div class="col-md-6"><div class="skel-pro-summary"></div></div></div>';
									}
								} else {
									skeletonTemplate = '<div class="product product-single"><div class="d-loading"><i></i></div></div>';
								}
								this.container.html( '<div class="mfp-content"></div><div class="mfp-preloader">' + skeletonTemplate + '</div>' );
								this.contentContainer = this.container.children( '.mfp-content' );
								this.preloader = false;
							},
							beforeClose: function () {
								this.container.empty();
							},
							ajaxContentAdded: function () {
								var self = this;
								this.wrap.imagesLoaded( function () {
									finishQuickView();
								} );

								// Move close button out of product because of product's overflow.
								this.wrap.find( '.mfp-close' ).appendTo( this.content );

								// Remove preloader
								setTimeout( function () {
									self.contentContainer.next( '.mfp-preloader' ).remove();
								}, 300 );
							}
						}
					} );
				}

				// 1. Quickview / Preload skeleton screen for "loading", "offcanvas".

				if ( alpha_vars.skeleton_screen && quickviewType != 'zoom' ) {
					openQuickview( quickviewType );

				} else if ( quickviewType == 'zoom' ) { // 2. Quickview / Zoomed Product

					var zoomLoadedData = '';
					function zoomInit() {
						var instance = $.magnificPopup.instance;
						if ( instance.isOpen && instance.content && instance.wrap.hasClass( 'zoom-start2' ) && !instance.wrap.hasClass( 'zoom-finish' ) && zoomLoadedData ) {

							var i = 1;
							var timer = theme.requestInterval( function () {
								instance.wrap.addClass( 'zoom-start3' );
								if ( instance.content ) {

									var $data = $( zoomLoadedData );
									var $gallery = $data.find( '.woocommerce-product-gallery' );
									var $summary = $data.find( '.summary' );
									var $product = instance.content.find( '.product-single' );
									$product.children( '.col-md-6:first-child' ).html( $gallery );
									$product.find( '.col-md-6 > .summary' ).remove();
									$product.attr( 'id', $data.attr( 'id' ) );
									$product.attr( 'class', $data.attr( 'class' ) );

									instance.content.css( 'clip-path', i < 30 ? 'inset(0 calc(' + ( ( 31 - i ) * 50 / 30 ) + '% - 20px) 0 0)' : 'none' );
									if ( i >= 30 ) {
										theme.deleteTimeout( timer );
										instance.wrap.addClass( 'zoom-finish' );
										$product.children( '.col-md-6:last-child' ).append( $summary );

										$( '.mfp-animated-image' ).remove();

										theme.requestTimeout( function () {
											instance.wrap.addClass( 'zoom-loaded mfp-anim-finish' );
											theme.endLoading( $product.children( '.col-md-6:last-child' ) );
											finishQuickView();
										}, 50 );
									}
									++i;
								} else {
									theme.deleteTimeout( timer );
								}
							}, 16 );
						}
					}

					var $image;
					if ( $this.parent( '.hotspot-product' ).length ) {
						$image = $this.parent().find( '.product-media img' );
					} else if ( $this.closest( '.shop_table' ).length ) {
						$image = $this.closest( 'tr' ).find( '.product-thumbnail img' );
					} else {
						$image = $this.closest( '.product' ).find( '.product-media img:first-child' );
					}
					if ( !$image.length ) {
						openQuickview( 'loading' );
						return;
					}
					var imageSrc = $image.attr( 'src' );

					$( '<img src="' + imageSrc + '">' ).imagesLoaded( function () {
						$this.data( 'magnificPoup' ) ||
							$this.attr( 'data-mfp-src', imageSrc )
								.magnificPopup( {
									type: 'image',
									mainClass: 'mfp-product mfp-zoom mfp-anim',
									preloader: false,
									item: {
										src: $image
									},
									closeOnBgClick: false,
									zoom: {
										enabled: true,
										duration: 550,
										easing: 'cubic-bezier(.55,0,.1,1)',
										opener: function () {
											return $image;
										}
									},
									callbacks: {
										beforeOpen: theme.defaults.popup.callbacks.beforeOpen,
										open: function () {
											var wrapper = '<div class="product-single product-quickview product row product-quickview-loading"><div class="col-md-6"></div><div class="col-md-6"></div></div>';

											if ( alpha_vars.quickview_thumbs != 'horizontal' && window.innerWidth >= 992 ) {
												this.content.addClass( 'vertical' );
											}

											this.content.find( 'figcaption' ).remove();
											if ( this.items[ 0 ] ) {
												var $wrap = this.items[ 0 ].img.wrap( wrapper );
												if ( !this.items[ 0 ].el.closest( '.product' ).find( '.woocommerce-placeholder' ).length ) {
													$wrap.after( '<div class="thumbs"><img src="' + this.items[ 0 ].img.attr( "src" ) + '" /><img src="' + this.items[ 0 ].img.attr( "src" ) + '" /><img src="' + this.items[ 0 ].img.attr( "src" ) + '" /><img src="' + this.items[ 0 ].img.attr( "src" ) + '" /></div>' );
												}
											}

											var self = this;
											setTimeout( function () {
												self.bgOverlay.removeClass( 'mfp-ready' );
											}, 16 );

											setTimeout( function () {
												self.wrap.addClass( 'zoom-start' );
												theme.requestFrame( function () {
													var $img = self.content.find( '.thumbs>img:first-child' );
													var w = $img.length ? $img.width() : 0;
													var h = $img.length ? $img.height() : 0;
													var i = 0;
													self.bgOverlay.addClass( 'mfp-ready' );
													var timer = theme.requestInterval( function () {
														if ( self.content ) {
															self.content.css(
																'clip-path',
																alpha_vars.quickview_thumbs != 'horizontal' && window.innerWidth >= 992 ?
																	'inset(' + ( 30 - i ) + 'px calc(50% + ' + ( 10 - i ) + 'px) ' + ( 30 - i ) + 'px ' + ( ( 30 - i ) * ( 30 + w ) / 30 ) + 'px)' :
																	'inset(' + ( 30 - i ) + 'px calc(50% + ' + ( 10 - i ) + 'px) ' + ( ( 30 - i ) * ( 30 + h ) / 30 ) + 'px ' + ( 30 - i ) + 'px)'
															);


															if ( i >= 30 ) {
																theme.deleteTimeout( timer );
																self.wrap.addClass( 'zoom-start2' );
																if ( !zoomLoadedData ) {
																	theme.doLoading( self.content.find( '.product > .col-md-6:first-child' ) );
																}
																zoomInit();
															} else {
																i += 3;
															}
														} else {
															theme.deleteTimeout( timer );
														}
													}, 16 );
												} );
											}, 560 );
										},
										beforeClose: function () {
											$this.removeData( 'magnificPopup' ).removeAttr( 'data-mfp-src' );
											$this.off( 'click.magnificPopup' );
											$( '.mfp-animated-image' ).remove();
										},
										close: theme.defaults.popup.callbacks.close
									}
								} );
						$this.magnificPopup( 'open' );
					} );

					// Get images loaded ajax content
					$.post( alpha_vars.ajax_url, ajax_data )
						.done( function ( data ) {
							$( data ).imagesLoaded( function () {
								zoomLoadedData = data;
								zoomInit();
							} );
						} );

				} else { // 3. Quickview / Loading Icon Inner Product

					theme.doLoading( $this.closest( '.product' ).find( '.product-media' ) );

					// Get images loaded ajax content
					$.post( alpha_vars.ajax_url, ajax_data )
						.done( function ( data ) {
							$( data ).imagesLoaded( function () {
								theme.popup( {
									type: 'inline',
									mainClass: 'mfp-product mfp-fade ' + ( quickviewType == 'offcanvas' ? 'mfp-offcanvas' : 'mfp-anim' ),
									items: {
										src: data
									},
									callbacks: {
										open: function () {
											var self = this;
											function finishLoad() {
												self.wrap.addClass( 'mfp-anim-finish' );
											}

											if ( quickviewType == 'offcanvas' ) {
												setTimeout( finishLoad, 316 );
											} else {
												theme.requestFrame( finishLoad );
											}

											finishQuickView();
										}
									}
								} )

								theme.endLoading( $this.closest( '.product' ).find( '.product-media' ) );
							} )
						} );
				}
			} );
		}

		/**
		 * Initialize products cart action
		 * 
		 * @since 1.0
		 */
		function initProductsCartAction() {
			theme.$body
				// Before product is added to cart
				.on( 'click', '.add_to_cart_button:not(.product_type_variable)', function ( e ) {
					$( '.minicart-icon' ).addClass( 'adding' );
					theme.doLoading( e.currentTarget, 'small' );
				} )

				// Off Canvas cart type
				.on( 'click', '.cart-offcanvas .cart-toggle', function ( e ) {
					if ( alpha_vars[ 'cart_show_qty' ] && $( document.body ).hasClass( 'woocommerce-cart' ) || $( document.body ).hasClass( 'woocommerce-checkout' ) ) {
						return;
					}
					$( this ).parent().toggleClass( 'opened' );
					e.preventDefault();
				} )
				.on( 'click', '.cart-offcanvas .btn-close', function ( e ) {
					e.preventDefault();
					$( this ).closest( '.cart-offcanvas' ).removeClass( 'opened' );
				} )
				.on( 'click', '.cart-offcanvas .cart-overlay', function ( e ) {
					$( this ).parent().removeClass( 'opened' );
				} )

				// After product is added to cart
				.on( 'added_to_cart', function ( e, fragments, cart_hash, $thisbutton ) {

					var $product = $thisbutton.closest( '.product' );

					// remove newly added "view cart" button.
					if ( typeof alpha_elementor != 'undefined' ) {
						// For elementor editor preview
						setTimeout( function () {
							$thisbutton.next( '.added_to_cart' ).remove();
						} );
					} else {
						$thisbutton.next( '.added_to_cart' ).remove();
					}

					// if not product single, then open minipopup
					if ( !$product.hasClass( 'product-single' ) ) {
						var link, image, title, price, id;

						if ( $product.length ) { // inside product element
							link = $product.find( '.product-media .woocommerce-loop-product__link' ).attr( 'href' );
							image = $product.find( '.product-media img:first-child' ).attr( 'src' );
							title = $product.find( '.woocommerce-loop-product__title a' ).text();
							price = $product.find( '.price' ).html();
							id = $thisbutton.data( 'product_id' );
							var $popup_product = $( '.minipopup-area' ).find( "#product-" + id );
						} else {
							$product = $thisbutton.closest( '.compare-basic-info' );
							link = $product.find( '.product-title' ).attr( 'href' );
							image = $product.find( '.product-media img' ).attr( 'src' );
							title = $product.closest( '.alpha-compare-table' ).find( '.compare-title .compare-value' ).eq( $thisbutton.closest( '.compare-value' ).index() - 1 ).find( '.product-title' ).html();
							price = $product.closest( '.alpha-compare-table' ).find( '.compare-price .compare-value' ).eq( $thisbutton.closest( '.compare-value' ).index() - 1 ).html();
						}

						if ( $popup_product && id == $popup_product.attr( 'data-product-id' ) ) {
							$popup_product.find( '.cart-count' ).html( parseInt( $popup_product.find( '.cart-count' ).html() ) + 1 );
						} else {
							theme.minipopup.open( {
								content: '<div class="minipopup-box">\
				<div class="product product-list-sm" data-product-id=' + id + ' id="product-' + id + '">\
					<figure class="product-media"><a href="' + link + '"><img src="' + image + '"></img></a></figure>\
					<div class="product-details"><a class="product-title" href="' + link + '"><span class="cart-count">' + $thisbutton[ 0 ].dataset.quantity + '</span> x ' + title + '</a>' + alpha_vars.texts.cart_suffix + '</div></div>\
					<div class="minipopup-footer">' + '<a href="' + alpha_vars.pages.cart + '" class="btn btn-sm btn-rounded">' + alpha_vars.texts.view_cart + '</a><a href="' + alpha_vars.pages.checkout + '" class="btn btn-sm btn-dark btn-rounded">' + alpha_vars.texts.view_checkout + '</a></div></div>'
							} );
						}
					}

					$( '.minicart-icon' ).removeClass( 'adding' );
				} )
				.on( 'added_to_cart ajax_request_not_sent.adding_to_cart', function ( e, f, c, $thisbutton ) {
					if ( typeof $thisbutton !== 'undefined' ) {
						theme.endLoading( $thisbutton );
					}
				} )
				.on( 'wc_fragments_refreshed', function ( e, f ) {
					theme.quantityInput( '.shop_table .qty' );

					setTimeout( function () {
						$( '.sticky-sidebar' ).trigger( 'recalc.pin' );
					}, 400 );
				} )

				// Refresh cart table when cart item is removed
				.off( 'click', '.widget_shopping_cart .remove' )
				.on( 'click', '.widget_shopping_cart .remove', function ( e ) {
					e.preventDefault();
					var $this = $( this );
					var cart_id = $this.data( "cart_item_key" );

					$.ajax(
						{
							type: 'POST',
							dataType: 'json',
							url: alpha_vars.ajax_url,
							data: {
								action: "alpha_cart_item_remove",
								nonce: alpha_vars.nonce,
								cart_id: cart_id
							},
							success: function ( response ) {
								var this_page = location.toString(),
									item_count = $( response.fragments[ 'div.widget_shopping_cart_content' ] ).find( '.mini_cart_item' ).length;

								this_page = this_page.replace( 'add-to-cart', 'added-to-cart' );
								$( document.body ).trigger( 'wc_fragment_refresh' );

								// Block widgets and fragments
								if ( item_count == 0 && ( $( 'body' ).hasClass( 'woocommerce-cart' ) || $( 'body' ).hasClass( 'woocommerce-checkout' ) ) ) {
									$( '.page-content' ).block();
								} else {
									$( '.shop_table.cart, .shop_table.review-order, .updating, .cart_totals' ).block();
								}

								// Unblock
								$( '.widget_shopping_cart, .updating' ).stop( true ).unblock();

								// Cart page elements
								if ( item_count == 0 && ( $( 'body' ).hasClass( 'woocommerce-cart' ) || $( 'body' ).hasClass( 'woocommerce-checkout' ) ) ) {
									$( '.page-content' ).load( this_page + ' .page-content:eq(0) > *', function () {
										$( '.page-content' ).unblock();
									} );
								} else {
									$( '.shop_table.cart' ).load( this_page + ' .shop_table.cart:eq(0) > *', function () {
										$( '.shop_table.cart' ).unblock();
										theme.quantityInput( '.shop_table .qty' );
									} );

									$( '.cart_totals' ).load( this_page + ' .cart_totals:eq(0) > *', function () {
										$( '.cart_totals' ).unblock();
									} );

									// Checkout page elements
									$( '.shop_table.review-order' ).load( this_page + ' .shop_table.review-order:eq(0) > *', function () {
										$( '.shop_table.review-order' ).unblock();
									} );
								}
							}
						}
					);
					return false;
				} )
				// Removing cart item from minicart
				.on( 'click', '.remove_from_cart_button', function ( e ) {
					theme.doLoading( $( this ).closest( '.mini_cart_item' ), 'small' );
				} );
		}

		/**
		 * Initialize products wishlist action
		 * 
		 * @since 1.0
		 */
		function initProductsWishlistAction() {
			function updateMiniWishList() {
				var $minilist = $( '.mini-basket-dropdown .widget_wishlist_content' );

				if ( !$minilist.length ) {
					return;
				}

				if ( !$minilist.find( '.w-loading' ).length ) {
					theme.doLoading( $minilist, 'small' );
				}

				$.ajax( {
					url: alpha_vars.ajax_url,
					data: {
						action: 'alpha_update_mini_wishlist'
					},
					type: 'post',
					success: function ( data ) {
						if ( $minilist.closest( '.mini-basket-dropdown' ).find( '.wish-count' ).length ) {
							$minilist.closest( '.mini-basket-dropdown' ).find( '.wish-count' ).text( $( data ).find( '.wish-count' ).text() );
						}
						$minilist.html( $( data ).find( '.widget_wishlist_content' ).html() );
					}
				} );
			};

			theme.$body
				// Add item to wishlist
				.on( 'click', '.add_to_wishlist', function ( e ) {
					theme.doLoading( $( e.currentTarget ).closest( '.yith-wcwl-add-to-wishlist' ), 'small' );
				} )
				// Remove from wishlist if item is already in wishlist
				.on( 'click', '.yith-wcwl-wishlistexistsbrowse a, .yith-wcwl-wishlistaddedbrowse a', function ( e ) {
					var $link = $( e.currentTarget ),
						$wcwlWrap = $link.closest( '.yith-wcwl-add-to-wishlist' ),
						product_id = $wcwlWrap.data( 'fragment-ref' ),
						fragmentOptions = $wcwlWrap.data( 'fragment-options' ),
						data = {
							action: yith_wcwl_l10n.actions.remove_from_wishlist_action,
							remove_from_wishlist: product_id,
							fragments: fragmentOptions,
							from: 'theme'
						};

					theme.doLoading( $wcwlWrap, 'small' );
					$.ajax( {
						url: yith_wcwl_l10n.ajax_url,
						data: data,
						method: 'post',
						complete: function () {
							theme.endLoading( $wcwlWrap );
						},
						success: function ( data ) {
							if ( fragmentOptions.in_default_wishlist ) {
								delete fragmentOptions.in_default_wishlist;
								$wcwlWrap.attr( JSON.stringify( fragmentOptions ) );
							}
							$wcwlWrap.removeClass( 'exists' );
							$wcwlWrap.find( '.yith-wcwl-wishlistexistsbrowse' ).addClass( 'yith-wcwl-add-button' ).removeClass( 'yith-wcwl-wishlistexistsbrowse' );
							$wcwlWrap.find( '.yith-wcwl-wishlistaddedbrowse' ).addClass( 'yith-wcwl-add-button' ).removeClass( 'yith-wcwl-wishlistaddedbrowse' );
							$link.attr( 'href', location.href + '?post_type=product&amp;add_to_wishlist=' + product_id );
							$link.attr( 'data-product-id', product_id );
							$link.attr( 'data-product-type', fragmentOptions.product_type );
							$link.attr( 'title', alpha_vars.texts.add_to_wishlist );
							$link.attr( 'data-title', alpha_vars.texts.add_to_wishlist );
							$link.addClass( 'add_to_wishlist single_add_to_wishlist' );
							// $link.html('<span>' + alpha_vars.texts.add_to_wishlist + '</span>');
							theme.$body.trigger( 'removed_from_wishlist' );
						}
					} );
					e.preventDefault();
				} )
				.on( 'added_to_wishlist', function () {
					$( '.wish-count' ).each(
						function () {
							$( this ).html( parseInt( $( this ).html() ) + 1 );
						}
					);
					updateMiniWishList();
				} )
				.on( 'removed_from_wishlist', function () {
					$( '.wish-count' ).each(
						function () {
							$( this ).html( parseInt( $( this ).html() ) - 1 );
						}
					);
					updateMiniWishList();
				} )
				.on( 'added_to_cart', function ( e, fragments, cart_hash, $button ) {
					if ( $button.closest( '#yith-wcwl-form' ).length ) {
						$( '.wish-count' ).each(
							function () {
								$( this ).html( parseInt( $( this ).html() ) - 1 );
							}
						)
					};
					updateMiniWishList();
				} )
				.on( 'click', '.wishlist-dropdown .wishlist-item .remove_from_wishlist', function ( e ) {
					e.preventDefault();

					var id = $( this ).attr( 'data-product_id' ),
						$product = $( '.yith-wcwl-add-to-wishlist.add-to-wishlist-' + id ),
						$table = $( '.wishlist_table #yith-wcwl-row-' + id + ' .remove_from_wishlist' );

					theme.doLoading( $( this ).closest( '.wishlist-item' ), 'small' );

					if ( $product.length ) {
						$product.find( 'a' ).trigger( 'click' );
					} else if ( $table.length ) {
						$table.trigger( 'click' );
					} else {
						$.ajax( {
							url: yith_wcwl_l10n.ajax_url,
							data: {
								action: yith_wcwl_l10n.actions.remove_from_wishlist_action,
								remove_from_wishlist: id,
								from: 'theme'
							},
							method: 'post',
							success: function ( data ) {
								theme.$body.trigger( 'removed_from_wishlist' );
							}
						} );
					}
				} )
				.on( 'click', '.wishlist-offcanvas > .wishlist', function ( e ) {
					$( this ).closest( '.wishlist-dropdown' ).toggleClass( 'opened' );
					e.preventDefault();
				} )
				.on( 'click', '.wishlist-offcanvas .btn-close', function ( e ) {
					e.preventDefault();
					$( this ).closest( '.wishlist-dropdown' ).removeClass( 'opened' );
				} )
				.on( 'click', '.wishlist-offcanvas .wishlist-overlay', function ( e ) {
					$( this ).closest( '.wishlist-dropdown' ).removeClass( 'opened' );
				} );
		}

		/**
		 * Initialize products hover in double touch
		 * 
		 * @since 1.0
		 */
		function initProductsHover() {
			if ( !$( 'html' ).hasClass( 'touchable' ) || !alpha_vars.prod_open_click_mob ) {
				return;
			}

			var isTouchFired = false;

			function _clickProduct( e ) {
				if ( isTouchFired && !$( this ).hasClass( 'hover-active' ) ) {
					e.preventDefault();
					$( '.hover-active' ).removeClass( 'hover-active' );
					$( this ).addClass( 'hover-active' );
				}
			}

			function _clickGlobal( e ) {
				isTouchFired = e.type == 'touchstart';
				$( e.target ).closest( '.hover-active' ).length || $( '.hover-active' ).removeClass( 'hover-active' );
			}

			theme.$body.on( 'click', '.product-wrap .product', _clickProduct );
			$( document ).on( 'click', _clickGlobal );
			document.addEventListener( 'touchstart', _clickGlobal, { passive: true } );
		}

		/**
		 * Initalize subpages
		 * 
		 * @since 1.0
		 */
		function initSubpages() {
			// Refresh sticky sidebar on shipping calculator in cart page
			theme.$body.on( 'click', '.shipping-calculator-button', function ( e ) {
				var btn = e.currentTarget;
				setTimeout( function () {
					$( btn ).closest( '.sticky-sidebar' ).trigger( 'recalc.pin' );
				}, 400 );
			} )

			if ( alpha_vars.cart_auto_update ) {
				theme.$body.on( 'click', '.shop_table .quantity-minus, .shop_table .quantity-plus', function () {
					$( '.shop_table button[name="update_cart"]' ).trigger( 'click' );
				} );
				theme.$body.on( 'keyup', '.shop_table .quantity .qty', function () {
					$( '.shop_table button[name="update_cart"]' ).trigger( 'click' );
				} );
			}
		}

		/**
		 * Set quantity
		 *
		 * @since 1.0
		 * @return {void}
		 */
		function handleQTY() {
			var $obj = $( this );
			if ( $obj.closest( '.quantity' ).next( '.add_to_cart_button[data-quantity]' ).length ) {
				var count = $obj.val();
				if ( count ) {
					$obj.closest( '.quantity' ).next( '.add_to_cart_button[data-quantity]' ).attr( 'data-quantity', count );
				}
			}
		}

		return {
			init: function () {
				this.removerId = 0;

				// Functions for products
				initProductsAttributeAction();
				initProductsQuickview();
				initProductsCartAction();
				initProductsWishlistAction();
				initProductsHover();

				// Functions for shop page
				initSelectMenu();
				initSubpages();

				// Functions for Alert
				this.initAlertAction();
				theme.call( this.initProducts.bind( this ), 500 );
			},

			/**
			 * Initialize products
			 * - rating tooltip
			 * - product types
			 * 
			 * @since 1.0
			 * @param {HTMLElement|jQuery|string} selector
			 * @return {void}
			 */
			initProducts: function ( selector ) {
				this.ratingTooltip( selector );
				this.initProductType( selector );
				// theme.quantityInput(theme.$(selector, '.qty'));
				// theme.$(selector, 'input.qty').off('change', handleQTY).on('change', handleQTY);
			},

			/**
			 * Initialize rating tooltips
			 * Find all .star-rating from selector, and initialize tooltip.
			 * 
			 * @since 1.0
			 * @param {HTMLElement|jQuery|string} selector
			 * @return {void}
			 */
			ratingTooltip: function ( selector ) {
				var ratingHandler = function () {
					var res = this.firstElementChild.getBoundingClientRect().width / this.getBoundingClientRect().width * 5;
					this.lastElementChild.innerText = res ? res.toFixed( 2 ) : res;
				}

				theme.$( selector, '.star-rating' ).each( function () {
					if ( this.lastElementChild && !this.lastElementChild.classList.contains( 'tooltiptext' ) ) {
						var span = document.createElement( 'span' );
						span.classList.add( 'tooltiptext' );
						span.classList.add( 'tooltip-top' );

						this.appendChild( span );
						this.addEventListener( 'mouseover', ratingHandler );
						this.addEventListener( 'touchstart', ratingHandler, { passive: true } );
					}
				} );
			},

			/**
			 * Initialize product types
			 * - popup type
			 *
			 * @since 1.0
			 * @param {HTMLElement|jQuery|string} selector
			 * @return {void}
			 */
			initProductType: function ( selector ) {
				theme.$( selector, '.product-popup .product-details' ).each( function ( e ) {
					var $this = $( this ),
						hidden_height = $this.find( '.product-hide-details' ).outerHeight( true );

					$this.height( $this.height() - hidden_height );
				} );

				theme.$( selector, '.product-popup' )
					.on( 'mouseenter touchstart', function ( e ) {
						var $this = $( this );
						var hidden_height = $this.find( '.product-hide-details' ).outerHeight( true );
						$this.find( '.product-details' ).css( 'transform', 'translateY(' + ( $this.hasClass( 'product-boxed' ) ? 11 - hidden_height : -hidden_height ) + 'px)' );
						$this.find( '.product-hide-details' ).css( 'transform', 'translateY(' + ( -hidden_height ) + 'px)' );
					} )
					.on( 'mouseleave touchleave', function ( e ) {
						var $this = $( this );
						$this.find( '.product-details' ).css( 'transform', 'translateY(0)' );
						$this.find( '.product-hide-details' ).css( 'transform', 'translateY(0)' );
					} );
			},

			/**
			 * Remove alerts automatically
			 *
			 * @since 1.0
			 * @return {void}
			 */
			initAlertAction: function () {
				this.removerId && clearTimeout( this.removerId );
				this.removerId = setTimeout( function () {
					$( '.woocommerce-page .main-content .alert:not(.woocommerce-info) .btn-close' ).not( ':hidden' ).trigger( 'click' );
				}, 10000 );
			}
		}
	} )();

	/**
	 * Initialize account
	 * @since 1.0
	 * @return {void}
	 */
	theme.initAccount = function () {
		/**
		 * Launch login form popup for both login and register buttons
		 * 
		 * @since 1.0
		 */
		function launchPopup( e ) {
			if ( this.classList.contains( 'logout' ) ) {
				return;
			}

			e.preventDefault();

			var isRegister = this.classList.contains( 'register' );
			theme.popup( {
				callbacks: {
					afterChange: function () {
						this.container.html( '<div class="mfp-content"></div><div class="mfp-preloader"><div class="login-popup"><div class="d-loading"><i></i></div></div></div>' );
						this.contentContainer = this.container.children( '.mfp-content' );
						this.preloader = false;
					},
					beforeClose: function () {
						this.container.empty();
					},
					ajaxContentAdded: function () {
						var self = this;
						if ( isRegister ) {
							this.wrap.find( '[href="signup"]' ).trigger( 'click' );
						}
						setTimeout( function () {
							self.contentContainer.next( '.mfp-preloader' ).remove();
						}, 200 );
					}
				}
			}, 'login' );
		}

		/**
		 * Check if user input validation
		 *
		 * @since 1.0
		 */
		function checkValidation( e ) {
			var $form = $( this ), isLogin = $form[ 0 ].classList.contains( 'login' );
			$form.find( 'p.submit-status' ).show().text( 'Please wait...' ).addClass( 'loading' );
			$form.find( 'button[type=submit]' ).attr( 'disabled', 'disabled' );
			$.ajax( {
				type: 'POST',
				dataType: 'json',
				url: alpha_vars.ajax_url,
				data: $form.serialize() + '&action=alpha_account_' + ( isLogin ? 'signin' : 'signup' ) + '_validate',
				success: function ( data ) {
					$form.find( 'p.submit-status' ).html( data.message.replace( '/<script.*?\/script>/s', '' ) ).removeClass( 'loading' );
					$form.find( 'button[type=submit]' ).removeAttr( 'disabled' );
					if ( data.loggedin === true ) {
						location.reload();
					}
				}
			} );
			e.preventDefault();
		}

		theme.$body
			.on( 'click', '.header .account > a:not(.logout), .header .account > .links > a:not(.logout)', launchPopup )
			.on( 'submit', '#customer_login form', checkValidation )
	}

	/**
	 * Initialize keydown events
	 * @since 1.0
	 * @return {void}
	 */
	theme.initKeyDown = function () {
		var $fullSearchElement = $( '.hs-fullscreen' ),
			$offCanvasElement = $( '.offcanvas-type' );

		if ( $fullSearchElement.length || $offCanvasElement.length ) {
			document.
				addEventListener( 'keydown', function ( e ) {
					var keyName = e.key;
					if ( 'Escape' == keyName ) {
						if ( $offCanvasElement.hasClass( 'opened' ) ) {
							$offCanvasElement.removeClass( 'opened' );
						}
						if ( $fullSearchElement.length ) {
							$fullSearchElement.find( '.hs-close' ).trigger( 'click' );
						}
					}
				} );
		}
	}

	/**
	 * Create slider object by using swiper js
	 * 
	 * @class Slider
	 * @since 1.0
	 */
	theme.slider = ( function () {

		function Slider( $el, options ) {
			return this.init( $el, options );
		}

		function onInitialized() {
			var $wrapper = $( this.slider.wrapperEl );
			var slider = this.slider;

			$wrapper.trigger( 'initialized.slider', slider );
			$wrapper.find( '.slider-slide:not(.slider-slide-active) .appear-animate' ).removeClass( 'appear-animate' ); // Prevent appear animation of inactive slides

			// Video
			$wrapper.find( 'video' )
				.removeAttr( 'style' )
				.on( 'ended', function () {
					var $this = $( this );
					if ( $this.closest( '.slider-slide' ).hasClass( 'slider-slide-active' ) ) {

						if ( true === slider.params.autoplay.enabled ) {
							if ( slider.params.loop && slider.slides.length === slider.activeIndex ) {
								this.loop = true;
								try {
									this.play();
								} catch ( e ) { }
							}
							slider.slideNext();
							slider.autoplay.start();
						} else {
							this.loop = true;
							try {
								this.play();
							} catch ( e ) { }
						}
					}
				} );

			sliderLazyload.call( this );
		}

		function onTranslated() {
			$( window ).trigger( 'appear.check' );

			var $wrapper = $( this.slider.wrapperEl );
			var slider = this.slider;

			// Video Play
			var $activeVideos = $wrapper.find( '.slider-slide-active video' );
			$wrapper.find( '.slider-slide:not(.slider-slide-active) video' ).each( function () {
				if ( !this.paused ) {
					slider.autoplay.start();
				}
				this.pause();
				this.currentTime = 0;
			} );

			if ( $activeVideos.length ) {
				var slider = $wrapper.data( 'slider' );
				if ( slider && slider.params && slider.params.autoplay.enabled ) {
					slider.autoplay.stop();
				}
				$activeVideos.each( function () {
					try {
						if ( this.paused ) {
							this.play();
						}
					} catch ( e ) { }
				} );
			}

			sliderLazyload.call( this );
		}

		function onSliderInitialized() {
			var self = this,
				$el = $( this.slider.wrapperEl );

			// carousel content animation
			$el.find( '.slider-slide-active .slide-animate' ).each( function () {
				var $animation_item = $( this ),
					settings = $animation_item.data( 'settings' ),
					duration,
					delay = settings._animation_delay ? settings._animation_delay : 0,
					aniName = settings._animation_name;

				if ( $animation_item.hasClass( 'animated-slow' ) ) {
					duration = 2000;
				} else if ( $animation_item.hasClass( 'animated-fast' ) ) {
					duration = 750;
				} else {
					duration = 1000;
				}

				$animation_item.css( 'animation-duration', duration + 'ms' );

				duration = duration ? duration : 750;

				var temp = theme.requestTimeout( function () {
					$animation_item.addClass( aniName );
					$animation_item.addClass( 'show-content' );
					self.timers.splice( self.timers.indexOf( temp ), 1 )
				}, ( delay ? delay : 0 ) );
			} );
		}

		function sliderLazyload() {
			if ( $.fn.lazyload ) {
				$( this.slider.wrapperEl ).find( '[data-lazy]' )
					.filter( function () {
						return !$( this ).data( '_lazyload_init' );
					} )
					.data( '_lazyload_init', 1 )
					.each( function () {
						$( this ).lazyload( theme.defaults.lazyload );
					} );
			}
		}

		function onSliderResized() {
			$( this.slider.wrapperEl ).find( '.slider-slide-active .slide-animate' ).each( function () {
				$( this )
					.addClass( 'show-content' )
					.css( {
						'animation-name': '',
						'animation-duration': '',
						'animation-delay': '',
					} );
			} );
		}

		function onSliderTranslate() {
			var self = this,
				$el = $( this.slider.wrapperEl );
			self.translateFlag = 1;
			self.prev = self.next;
			$el.find( '.slider-slide .slide-animate' ).each( function () {
				var $animation_item = $( this ),
					settings = $animation_item.data( 'settings' );
				if ( settings ) {
					$animation_item.removeClass( settings._animation_name + ' animated appear-animation-visible elementor-invisible appear-animate' );
				}
			} );
		}

		function onSliderTranslated() {
			var self = this,
				$el = $( this.slider.wrapperEl );
			if ( 1 != self.translateFlag ) {
				return;
			}

			$el.find( '.show-content' ).removeClass( 'show-content' );

			self.next = this.slider.activeIndex;
			if ( self.prev != self.next ) {
				$el.find( '.show-content' ).removeClass( 'show-content' );

				/* clear all animations that are running. */
				if ( $el.hasClass( "animation-slider" ) ) {
					for ( var i = 0; i < self.timers.length; i++ ) {
						theme.deleteTimeout( self.timers[ i ] );
					}
					self.timers = [];
				}

				$( this.slider.slides[ this.slider.activeIndex ] ).find( '.slide-animate' ).each( function () {
					var $animation_item = $( this ),
						settings = $animation_item.data( 'settings' ),
						duration,
						delay = settings._animation_delay ? settings._animation_delay : 0,
						aniName = settings._animation_name;

					if ( $animation_item.hasClass( 'animated-slow' ) ) {
						duration = 2000;
					} else if ( $animation_item.hasClass( 'animated-fast' ) ) {
						duration = 750;
					} else {
						duration = 1000;
					}

					$animation_item.css( {
						'animation-duration': duration + 'ms',
						'animation-delay': delay + 'ms',
						'transition-property': 'visibility, opacity',
						'transition-duration': duration + 'ms',
						'transition-delay': delay + 'ms',
					} ).addClass( aniName );

					if ( $animation_item.hasClass( 'maskLeft' ) ) {
						$animation_item.css( 'width', 'fit-content' );
						var width = $animation_item.width();
						$animation_item
							.css( 'width', 0 )
							.css( 'transition', 'width ' + ( duration ? duration : 750 ) + 'ms linear ' + ( delay ? delay : '0s' ) )
							.css( 'width', width );
					}


					duration = duration ? duration : 750;
					$animation_item.addClass( 'show-content' );

					var temp = theme.requestTimeout( function () {
						$animation_item.css( 'transition-property', '' );
						$animation_item.css( 'transition-delay', '' );
						$animation_item.css( 'transition-duration', '' );

						self.timers.splice( self.timers.indexOf( temp ), 1 )
					}, ( delay ? ( delay + 200 ) : 200 ) );
					self.timers.push( temp );
				} );
			} else {
				$el.find( '.slider-slide' ).eq( this.slider.activeIndex ).find( '.slide-animate' ).addClass( 'show-content' );
			}

			self.translateFlag = 0;
		}

		// Public Properties

		Slider.prototype.init = function ( $el, options ) {
			this.timers = [];
			this.translateFlag = 0;

			// # Extend settings
			var settings = $.extend( true, {}, theme.defaults.slider );
			$el.attr( 'class' ).split( ' ' ).forEach( function ( className ) {
				theme.defaults.sliderPresets[ className ] && $.extend( true, settings, theme.defaults.sliderPresets[ className ] );
			} );

			$.extend( true, settings, theme.parseOptions( $el.attr( 'data-slider-options' ) ), options );

			// # Set all video's loop as false
			$el.find( 'video' )
				.each( function () {
					this.loop = false;
				} );

			var $children = $el.children();
			var childrenCount = $children.length;
			if ( childrenCount ) {
				if ( $children.filter( '.row' ).length ) {
					$children.wrap( '<div class="slider-slide"></div>' );
					$children = $el.children();
				} else {
					$children.addClass( 'slider-slide' );
				}
			}

			// # Remove grid classes
			var cls = $el.attr( 'class' );
			var pattern = /gutter\-\w\w|cols\-\d|cols\-\w\w-\d/g;
			var match = cls.match( pattern ) || '';
			if ( match ) {
				match.push( 'row' );
				$el.data( 'slider-layout', match );
				$el.attr( 'class', cls.replace( pattern, '' ).replace( /\s+/, ' ' ) ).removeClass( 'row' );
			}

			// Display helper class for responsive navigation and pagination.
			var displayClass = [];
			if ( settings.breakpoints ) {
				var hideClasses = [ 'd-none', 'd-sm-none', 'd-md-none', 'd-lg-none', 'd-xl-none' ];
				var showClasses = [ 'd-block', 'd-sm-block', 'd-md-block', 'd-lg-block', 'd-xl-block' ];
				var bi = 0;
				for ( var i in settings.breakpoints ) {
					if ( childrenCount <= settings.breakpoints[ i ].slidesPerView ) {
						displayClass.push( hideClasses[ bi ] );
					} else if ( displayClass.length ) {
						displayClass.push( showClasses[ bi ] );
					}
					++bi;
				}
			}
			displayClass = ' ' + displayClass.join( ' ' );

			// Add navigation and pagination.
			var nav_dot = '';
			if ( !settings.dotsContainer && settings.pagination ) {
				nav_dot += '<div class="slider-pagination' + displayClass + '"></div>';
			}
			if ( settings.navigation ) {
				nav_dot += '<button class="slider-button slider-button-prev' + displayClass + '" aria-label="Prev"></button><button class="slider-button slider-button-next' + displayClass + '" aria-label="Next"></button>';
			}

			// Prepare slider
			$el.siblings( '.slider-button,.slider-pagination' ).remove();
			$el.parent().addClass( 'slider-container' + ( settings.statusClass ? ' ' + settings.statusClass : '' ) + ( $el.attr( 'data-slider-status' ) ? ' ' + $el.attr( 'data-slider-status' ) : '' ) )
				.parent().addClass( 'slider-relative' );
			$el.after( nav_dot );

			if ( !settings.dotsContainer && settings.pagination ) {
				settings.pagination = {
					clickable: true,
					el: $el.siblings( '.slider-pagination' )[ 0 ],
					bulletClass: 'slider-pagination-bullet',
					bulletActiveClass: 'active',
					modifierClass: 'slider-pagination-',
				}
			}
			if ( settings.navigation ) {
				settings.navigation = {
					prevEl: $el.siblings( '.slider-button-prev' )[ 0 ],
					nextEl: $el.siblings( '.slider-button-next' )[ 0 ],
					hideOnClick: true,
					disabledClass: 'disabled',
					hiddenClass: 'slider-button-hidden',
				}
			}

			// Prepare options for product thumbs carousel
			if ( $el.hasClass( 'product-thumbs' ) ) {
				var isVertical = $el.parent().parent().hasClass( 'pg-vertical' );
				if ( isVertical ) {
					settings.direction = 'vertical';
					settings.breakpoints = {
						0: {
							slidesPerView: 4,
							direction: 'horizontal'
						},
						992: {
							slidesPerView: 'auto',
							direction: 'vertical'
						}
					}
				}
				if ( $el.closest( '.container-fluid' ).length ) {
					if ( !settings.breakpoints ) {
						settings.breakpoints = {};
					}
					settings.breakpoints[ 1600 ] = isVertical ? {
						slidesPerView: 'auto',
						direction: 'vertical',
						spaceBetween: 20,
					} : { spaceBetween: 20 };

					if ( isVertical ) {
						settings.breakpoints[ 1600 ].slidesPerView = 'auto';
					}
				}
			}

			if ( $el.hasClass( 'product-single-carousel' ) ) {
				var $thumbs = $el.closest( '.product-gallery' ).find( '.product-thumbs' );
				settings.thumbs.swiper = $thumbs.data( 'slider' );
			}

			settings.legacy = false;

			// Setup slider
			this.slider = new ( theme.Swiper || Swiper )( $el[ 0 ].parentElement, settings );

			// # Register events for slider
			onInitialized.call( this );
			this.slider.on( 'resize', sliderLazyload.bind( this ) );
			this.slider.on( 'transitionEnd', onTranslated.bind( this ) );
			settings.onInitialized && settings.onInitialized.call( this.slider );

			// # Register animation slider
			if ( $el.hasClass( 'animation-slider' ) ) {
				onSliderInitialized.call( this );
				this.slider.on( 'resize', onSliderResized.bind( this ) );
				this.slider.on( 'transitionStart', onSliderTranslate.bind( this ) )
				this.slider.on( 'transitionEnd', onSliderTranslated.bind( this ) );
			}

			// # Run thumb dots
			if ( settings.dotsContainer && 'preview' != settings.dotsContainer ) {
				var slider = this.slider;
				theme.$body.on( 'click', settings.dotsContainer + ' button', function () {
					slider.slideTo( $( this ).index() );
				} );
				this.slider.on( 'transitionStart', function () {
					$( settings.dotsContainer ).children().removeClass( 'active' ).eq( this.realIndex ).addClass( 'active' );
				} )
			}

			// # Mount slider
			$el.trigger( 'initialize.slider', [ this.slider ] );
			$el.data( 'slider', this.slider );
		}

		return function ( selector, options, createOnly ) {
			theme.$( selector ).each( function () {

				var $this = $( this );

				// If disable mobile slider is enabled, return
				if ( theme.disableMobileSlider && ( $this.hasClass( 'products' ) || $this.hasClass( 'posts' ) ) ) {
					return;
				}

				// If slider is already created, return
				if ( $this.data( 'slider' ) ) {
					return;
				}

				// If slider has animated items
				var $anim_items = $this.find( '.elementor-invisible, .appear-animate' );
				if ( $anim_items.length ) {
					$this.addClass( 'animation-slider' );
					$anim_items.addClass( 'slide-animate' ).each( function () {
						var $this = $( this );
						var pre = $this.data( 'settings' );
						if ( pre ) {
							var settings = {
								'_animation_name': pre._animation ? pre._animation : pre.animation,
								'_animation_delay': Number( pre._animation_delay )
							};
							$this.removeClass( 'appear-animate' )
								.data( 'settings', settings )
								.attr( 'data-settings', JSON.stringify( settings ) );
						}
					} );
				}

				var runSlider = function () {
					// if in passive tab
					if ( selector == '.slider-wrapper' ) {
						var $pane = $this.closest( '.tab-pane' );
						if ( $pane.length && !$pane.hasClass( 'active' ) && $pane.closest( '.elementor-widget-' + alpha_vars.theme + '_widget_products_tab' ).length ) {
							return;
						}
					}

					// create slider
					new Slider( $this, options );
				}
				createOnly ? new runSlider : theme.call( runSlider );
			} );
		}
	} )();

	/**
	 * Initalize sliders and check their slide animations
	 * 
	 * @since 1.0
	 * @param {string} selector
	 * @return {void}
	 */
	theme.initSlider = function ( selector ) {

		// Is mobile slider disabled?
		theme.disableMobileSlider = theme.$body.hasClass( 'alpha-disable-mobile-slider' ) && ( 'ontouchstart' in document ) && ( theme.$window.width() < 1200 );

		// Initialize sliders
		theme.slider( selector );
	}

	/**
	 * Create quantity input object
	 * 
	 * @class QuantityInput
	 * @since 1.0
	 * @param {string} selector
	 * @return {void}
	 */
	theme.quantityInput = ( function () {

		function QuantityInput( $el ) {
			return this.init( $el );
		}

		QuantityInput.min = 1;
		QuantityInput.max = 1000000;

		QuantityInput.prototype.init = function ( $el ) {
			var self = this;

			self.$minus = false;
			self.$plus = false;
			self.$value = false;
			self.value = false;

			// call Events
			self.startIncrease = self.startIncrease.bind( self );
			self.startDecrease = self.startDecrease.bind( self );
			self.stop = self.stop.bind( self );

			// Variables
			self.min = parseInt( $el.attr( 'min' ) );
			self.max = parseInt( $el.attr( 'max' ) );

			self.min || ( $el.attr( 'min', self.min = QuantityInput.min ) )
			self.max || ( $el.attr( 'max', self.max = QuantityInput.max ) )

			// Add DOM elements and event listeners
			self.$value = $el.val( self.value = Math.max( parseInt( $el.val() ), 1 ) );
			self.$minus = $el.parent().find( '.quantity-minus' ).on( 'click', theme.preventDefault );
			self.$plus = $el.parent().find( '.quantity-plus' ).on( 'click', theme.preventDefault );

			if ( 'ontouchstart' in document ) {
				self.$minus.get( 0 ).addEventListener( 'touchstart', self.startDecrease, { passive: true } )
				self.$plus.get( 0 ).addEventListener( 'touchstart', self.startIncrease, { passive: true } )
			} else {
				self.$minus.on( 'mousedown', self.startDecrease )
				self.$plus.on( 'mousedown', self.startIncrease )
			}

			theme.$body.on( 'mouseup', self.stop )
				.on( 'touchend', self.stop );
		}

		QuantityInput.prototype.startIncrease = function ( e ) {
			var self = this;
			self.value = self.$value.val();
			self.value < self.max && ( self.$value.val( ++self.value ), self.$value.trigger( 'change' ) );
			self.increaseTimer = theme.requestTimeout( function () {
				self.speed = 1;
				self.increaseTimer = theme.requestInterval( function () {
					self.$value.val( self.value = Math.min( self.value + Math.floor( self.speed *= 1.05 ), self.max ) );
				}, 50 );
			}, 400 );
		}

		QuantityInput.prototype.stop = function ( e ) {
			( this.increaseTimer || this.decreaseTimer ) && this.$value.trigger( 'change' );
			this.increaseTimer && ( theme.deleteTimeout( this.increaseTimer ), this.increaseTimer = 0 );
			this.decreaseTimer && ( theme.deleteTimeout( this.decreaseTimer ), this.decreaseTimer = 0 );
		}

		QuantityInput.prototype.startDecrease = function ( e ) {
			var self = this;
			self.value = self.$value.val();
			self.value > self.min && ( self.$value.val( --self.value ), self.$value.trigger( 'change' ) );
			self.decreaseTimer = theme.requestTimeout( function () {
				self.speed = 1;
				self.decreaseTimer = theme.requestInterval( function () {
					self.$value.val( self.value = Math.max( self.value - Math.floor( self.speed *= 1.05 ), self.min ) );
				}, 50 );
			}, 400 );
		}

		return function ( selector ) {
			theme.$( selector ).each( function () {
				var $this = $( this );
				// if not initialized
				$this.data( 'quantityInput' ) ||
					$this.data( 'quantityInput', new QuantityInput( $this ) );
			} );
		}
	} )();

	/**
	 * @function floatSVG
	 * @param {string|jQuery} selector 
	 * @param {object} options
	 */
	theme.floatSVG = ( function () {
		function FloatSVG( svg, options ) {
			this.$el = $( svg );
			this.set( options );
			this.start();
		}

		FloatSVG.prototype.set = function ( options ) {
			this.options = $.extend( {
				delta: 15,
				speed: 10,
				size: 1,
			}, typeof options == 'string' ? JSON.parse( options ) : options );
		}

		FloatSVG.prototype.getDeltaY = function ( dx ) {
			return Math.sin( 2 * Math.PI * dx / this.width * this.options.size ) * this.options.delta;
		}

		FloatSVG.prototype.start = function () {
			this.update = this.update.bind( this );
			this.timeStart = Date.now() - parseInt( Math.random() * 100 );
			this.$el.find( 'path' ).each( function () {
				$( this ).data( 'original', this.getAttribute( 'd' ).replace( /([\d])\s*\-/g, '$1,-' ) );
			} );

			window.addEventListener( 'resize', this.update, { passive: true } );
			window.addEventListener( 'scroll', this.update, { passive: true } );
			theme.$window.on( 'check_float_svg', this.update );
			this.update();
		}

		FloatSVG.prototype.update = function () {
			var self = this;

			if ( this.$el.length && theme.isOnScreen( this.$el[ 0 ] ) ) {
				theme.requestTimeout( function () {
					self.draw();
				}, 16 );
			}
		}

		FloatSVG.prototype.draw = function () {
			var self = this,
				_dx = ( Date.now() - this.timeStart ) * this.options.speed / 200;
			this.width = this.$el.width();
			if ( !this.width ) {
				return;
			}
			this.$el.find( 'path' ).each( function () {
				var dx = _dx, dy = 0;
				this.setAttribute( 'd', $( this ).data( 'original' )
					.replace( /M([\d|\.]*),([\d|\.]*)/, function ( match, p1, p2 ) {
						if ( p1 && p2 ) {
							return 'M' + p1 + ',' + ( parseFloat( p2 ) + ( dy = self.getDeltaY( dx += parseFloat( p1 ) ) ) ).toFixed( 3 );
						}
						return match;
					} )
					.replace( /([c|C])[^A-Za-z]*/g, function ( match, p1 ) {
						if ( p1 ) {
							var v = match.slice( 1 ).split( ',' ).map( parseFloat );
							if ( v.length == 6 ) {
								if ( 'C' == p1 ) {
									v[ 1 ] += self.getDeltaY( _dx + v[ 0 ] );
									v[ 3 ] += self.getDeltaY( _dx + v[ 2 ] );
									v[ 5 ] += self.getDeltaY( dx = _dx + v[ 4 ] );
								} else {
									v[ 1 ] += self.getDeltaY( dx + v[ 0 ] ) - dy;
									v[ 3 ] += self.getDeltaY( dx + v[ 2 ] ) - dy;
									v[ 5 ] += self.getDeltaY( dx += v[ 4 ] ) - dy;
								}
								dy = self.getDeltaY( dx );

								return p1 + v.map( function ( v ) {
									return v.toFixed( 3 );
								} ).join( ',' );
							}
						}
						return match;
					} )
				);
			} );

			this.update();
		}

		return function ( selector ) {
			theme.$( selector ).each( function () {
				var $this = $( this ), float;
				if ( this.tagName == 'svg' ) {
					float = $this.data( 'float-svg' );
					if ( float ) {
						float.set( $this.attr( 'data-float-options' ) );
					} else {
						$this.data( 'float-svg', new FloatSVG( this, $this.attr( 'data-float-options' ) ) );
					}
				}
			} )
		};
	} )();



	/**
	 * Show edit page tooltip
	 * 
	 * @since 1.0
	 * @return {void}
	 */
	theme.showEditPageTooltip = function () {
		if ( $.fn.tooltip ) {
			$( '.alpha-edit-link' ).each( function () {
				var $this = $( this ),
					title = $this.data( 'title' );

				$this.next( '.alpha-block' ).addClass( 'alpha-has-edit-link' ).tooltip( {
					html: true,
					template: '<div class="tooltip alpha-tooltip-wrap" role="tooltip"><div class="arrow"></div><div class="tooltip-inner alpha-tooltip"></div></div>',
					trigger: 'manual',
					title: '<a href="' + $this.data( 'link' ) + '" target="_blank">' + title + '</a>',
					delay: 300
				} );
				var tooltipData = $this.next( '.alpha-block' ).data( 'bs.tooltip' );
				if ( tooltipData && tooltipData.element ) {
					$( tooltipData.element ).on( 'mouseenter.bs.tooltip', function ( e ) {
						tooltipData._enter( e );
					} );
					$( tooltipData.element ).on( 'mouseleave.bs.tooltip', function ( e ) {
						tooltipData._leave( e );
					} );
				}
			} );

			theme.$body.on( 'mouseenter mouseleave', '.tooltip[role="tooltip"]', function ( e ) {
				var $element = $( '.alpha-block[aria-describedby="' + $( this ).attr( 'id' ) + '"]' );
				if ( $element.length && $element.data( 'bs.tooltip' ) ) {
					var fn_name = 'mouseenter' == e.type ? '_enter' : '_leave';
					$element.data( 'bs.tooltip' )[ fn_name ]( false, $element.data( 'bs.tooltip' ) );
				}
			} );
		}
	}

	/**
	 * Live Search
	 * 
	 * @param {*} e 
	 * @param {*} $selector 
	 */
	theme.liveSearch = function ( e, $selector ) {
		var timeout = '',
			request = '',
			state = {
				requesting: false,
				open: false,
				prevResults: ''
			},
			minChars = 3;

		if ( !$.fn.devbridgeAutocomplete ) {
			return;
		}

		if ( 'undefined' == typeof $selector ) {
			$selector = $( '.search-wrapper' );
		} else {
			$selector = $selector;
		}

		$selector.each( function () {
			var $this = $( this ),
				isFullscreen = $this.hasClass( 'hs-fullscreen' ),
				$searchResult = $this.find( '.search-results' ),
				$searchResultContainer = $this.find( '.search-container' ),
				appendTo = isFullscreen ? $searchResult : $this.find( '.live-search-list' ),
				searchCat = $this.find( '.cats' ),
				postType = $this.find( 'input[name="post_type"]' ).val(),
				serviceUrl = alpha_vars.ajax_url + '?action=alpha_ajax_search&nonce=' + alpha_vars.nonce + ( postType ? '&post_type=' + postType : '' );

			if ( isFullscreen ) {

				function getResults() {

					// Deleted all chars / too few chars.
					var val = $this.find( 'input[type="search"]' ).val();
					if ( val.length == 0 || val.length < minChars ) {
						requestCheck();
						resetHeight();
						return;
					}

					request = $.ajax( {
						type: 'GET',
						url: serviceUrl,
						data: {
							query: val,
							posts_per_page: 21,
							cat: searchCat.length ? searchCat.val() : 0,
							isFullscreen: true
						},
						success: function ( response ) {

							state.requesting = false;

							// No results.
							if ( !response.suggestions ) {
								resetHeight();
							}

							if ( response.suggestions && response.suggestions !== state.prevResults ) {

								appendTo.html( response.suggestions );
								$this.imagesLoaded( function () {

									$searchResultContainer.css( {
										'max-height': parseInt( $searchResult.outerHeight() ) + 'px'
									} );

									setTimeout( function () {
										$this.closest( '.search-wrapper' ).addClass( 'results-shown' );
									}, 200 );

									// Desktop animation
									if ( window.innerWidth > 992 ) {

										appendTo.find( '.product, .post-wrap' ).css( {
											'opacity': '0',
											'transform': 'translateY(25px)',
											'transition': 'none'
										} );

										setTimeout( function () {
											appendTo.find( '.product, .post-wrap' ).css( {
												'transition': 'box-shadow 0.25s ease, opacity 0.55s cubic-bezier(0.2, 0.6, 0.4, 1), transform 0.55s cubic-bezier(0.2, 0.6, 0.4, 1)'
											} );
										}, 50 );


										appendTo.find( '.product, .post-wrap' ).each( function ( i ) {
											var $that = $( this );
											setTimeout( function () {
												$that.css( {
													'opacity': '1',
													'transform': 'translateY(0)'
												} )
											}, 50 + ( i * 60 ) );
										} );

									}

									state.open = true;
									state.prevResults = response.suggestions;
								} )

							}
						}
					} );

					state.requesting = true;
				}

				function requestCheck() {
					if ( state.requesting === true ) {
						request.abort();
						state.requesting = false;
					}
				};

				function resetHeight( $el ) {

					$searchResultContainer.css( {
						'max-height': ''
					} );

					setTimeout( function () {
						$this.closest( '.search-wrapper' ).removeClass( 'results-shown' );
					}, 400 );

					state.prevResults = '';
					state.open = false;
				}

				$this.find( 'input.form-control' ).on( 'keyup', function ( e ) {

					// Verify Key.
					var keysToSkip = [ 16, 91, 32, 37, 39, 17 ];

					if ( keysToSkip.indexOf( e.keyCode ) != -1 ) {
						return;
					}

					clearTimeout( timeout );
					timeout = setTimeout( function () {
						if ( state.requesting ) {
							return;
						}
						getResults();
					}, 400 );
				} );

				theme.$window.on( 'resize', function () {

					$this.find( '.search-container' ).css( {
						'max-height': ''
					} );

					if ( state.open === true ) {
						$this.find( '.search-container' ).css( {
							'max-height': parseInt( $searchResult.outerHeight() ) + 'px'
						} );
					}

				} );
				$this.find( '.close-overlay, .hs-close' ).on( 'click', function ( e ) {
					e.preventDefault();
					resetHeight();
					requestCheck();

					var closeTimeoutDur = ( $this.closest( '.search-wrapper' ).hasClass( 'results-shown' ) ) ? 800 : 400;
					setTimeout( function () {
						$this.find( 'input.form-control' ).val( '' );
					}, closeTimeoutDur );

					$( this ).closest( '.search-wrapper' ).removeClass( 'show' );
					$( 'body' ).css( 'overflow', '' );
					$( 'body' ).css( 'margin-right', '' );
				} );

			} else {
				$this.find( 'input[type="search"]' ).devbridgeAutocomplete( {
					minChars: minChars,
					appendTo: appendTo,
					triggerSelectOnValidInput: false,
					serviceUrl: serviceUrl,
					onSearchStart: function () {
						$this.addClass( 'skeleton-body' );
						appendTo.children().eq( 0 )
							.html( alpha_vars.skeleton_screen ? '<div class="skel-pro-search"></div><div class="skel-pro-search"></div><div class="skel-pro-search"></div>' : '<div class="d-loading"><i></i></div>' )
							.css( { position: 'relative', display: 'block' } );
					},
					onSelect: function ( item ) {
						if ( item.id != -1 ) {
							window.location.href = item.url;
						}
					},
					onSearchComplete: function ( q, suggestions ) {
						if ( !suggestions.length ) {
							appendTo.children().eq( 0 ).hide();
						}
					},
					beforeRender: function ( container ) {
						$( container ).removeAttr( 'style' );
					},
					formatResult: function ( item, currentValue ) {
						var pattern = '(' + $.Autocomplete.utils.escapeRegExChars( currentValue ) + ')',
							html = '';
						if ( item.img ) {
							html += '<img class="search-image" src="' + item.img + '">';
						}
						html += '<div class="search-info">';
						html += '<div class="search-name">' + item.value.replace( new RegExp( pattern, 'gi' ), '<strong>$1<\/strong>' ) + '</div>';
						if ( item.price ) {
							html += '<span class="search-price">' + item.price + '</span>';
						}
						html += '</div>';

						return html;
					}
				} );

				if ( searchCat.length ) {
					var searchForm = $this.find( 'input[type="search"]' ).devbridgeAutocomplete();
					searchCat.on( 'change', function ( e ) {
						if ( searchCat.val() && searchCat.val() != '0' ) {
							searchForm.setOptions( {
								serviceUrl: serviceUrl + '&cat=' + searchCat.val()
							} );
						} else {
							searchForm.setOptions( {
								serviceUrl: serviceUrl
							} );
						}

						searchForm.hide();
						searchForm.onValueChange();
					} );
				}
			}
		} );
	}

	/**
	 * Alpha Theme Async Setup
	 * 
	 * Initialize Method which runs asynchronously after document has been loaded
	 * 
	 * @since 1.0
	 */
	theme.initAsync = function () {
		theme.appearAnimate( '.appear-animate' );            // Runs appear animations
		if ( alpha_vars.resource_disable_elementor && typeof elementorFrontend != 'object' ) {
			theme.appearAnimate( '.elementor-invisible' );            // Runs appear animations
			theme.countTo( '.elementor-counter-number' );             // Runs counter
		}
		theme.minipopup.init();                              // Initialize minipopup
		theme.stickyContent( '.sticky-content:not(.mobile-icon-bar):not(.sticky-toolbox)' ); // Initialize sticky content
		theme.stickyContent( '.mobile-icon-bar', theme.defaults.stickyMobileBar );		 // Initialize sticky mobile bar
		theme.stickyContent( '.sticky-toolbox', theme.defaults.stickyToolbox );			 // Initialize sticky toolbox
		theme.shop.init();                                   // Initialize shop
		theme.initProductSingle();                           // Initialize single product
		theme.initSlider( '.slider-wrapper' );               // Initialize slider
		theme.sidebar( 'left-sidebar' );                     // Initialize left sidebar
		theme.sidebar( 'right-sidebar' );                    // Initialize right sidebar
		theme.sidebar( 'top-sidebar' );                      // Initialize horizontal filter widgets
		theme.quantityInput( '.qty' );                       // Initialize quantity input
		theme.playableVideo( '.post-video' );                // Initialize playable video
		theme.accordion( '.card-header > a' );               // Initialize accordion
		theme.tab( '.nav-tabs:not(.alpha-comment-tabs)' );   // Initialize tab
		theme.alert( '.alert' );                             // Initialize alert
		theme.parallax( '.parallax' );                       // Initialize parallax
		theme.countTo( '.count-to' );                        // Initialize countTo
		theme.progressbarInit( '.progress-wrapper' );		 // Initialize progressbars
		theme.countdown( '.product-countdown, .countdown' ); // Initialize countdown
		theme.menu.init();                                   // Initialize menus
		theme.initPopups();                                  // Initialize popups: login, register, play video, newsletter popup
		theme.initAccount();                                 // Initialize account popup
		theme.initScrollTopButton();                         // Initialize scroll top button.
		theme.initScrollTo();                                // Initialize scroll top button.
		theme.initContactForms();                            // Initialize contact forms
		theme.initSearchForm();                              // Initialize search form
		theme.initVideoPlayer();							 // Initialize VideoPlayer
		theme.initAjaxLoadPost();							 // Initialize AjaxLoadPost
		theme.floatSVG( '.float-svg' );                      // Floating SVG
		theme.initElementor();							     // Compatibility with Elementor
		theme.initVendorCompatibility();                     // Compatibility with Vendor Plugins
		theme.initFloatingElements();						 // Initialize floating widgets
		theme.initAdvancedMotions();						 // Initialize scrolling widgets
		theme.initKeyDown();                                 // Initialize keydown events
		theme.liveSearch();                                  // Live Search
		// Setup Events
		theme.$window.on( 'resize', theme.onResize );

		// Complete!
		theme.status == 'load' && ( theme.status = 'complete' );
		theme.$window.trigger( 'alpha_complete' );

		// For admin
		theme.showEditPageTooltip();
	}
} )( jQuery );