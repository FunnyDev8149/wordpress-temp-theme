/**
 * Alpha Plugin - Alpha WPBakery Admin
 * 
 * @package Alpha Core FrameWork
 * @since 1.0
 */
jQuery( document ).ready( function ( $ ) {
	'use strict';

	var themeWPBakeryAdmin = {
		init: function () {
			// Backend Ajax Save
			$( 'body' ).on( 'click', '#publish', themeWPBakeryAdmin.ajaxSave );

			document.addEventListener( 'keydown', themeWPBakeryAdmin.keySave );
			setTimeout( function () {
				if ( jQuery( '#vc_inline-frame' ).length > 0 ) {
					jQuery( '#vc_inline-frame' )[ 0 ].contentWindow.document.addEventListener( 'keydown', themeWPBakeryAdmin.keySave );
				}
			}, 1000 );

			themeWPBakeryAdmin.addEditWrapperClass();
			themeWPBakeryAdmin.initElementControls();
			themeWPBakeryAdmin.initShortcodes();
			themeWPBakeryAdmin.initAddonOptions();
		},
		ajaxSave: function ( e ) {
			// var editor = $('#wpb_visual_composer');
			// if (editor.length > 0 && 'block' == editor.css('display')) {
			// 	e.preventDefault();

			// 	var content = $('#content').val();

			// 	if (0 == content.indexOf('<p>')) {
			// 		content = content.slice(3, -5);
			// 	}

			// 	var data = {
			// 		action: 'vc_save',
			// 		post_id: $('#post_ID').val(),
			// 		vc_inline: true,
			// 		_vcnonce: window.vcAdminNonce,
			// 		vc_post_custom_css: $('#vc_post-custom-css').val() ? $('#vc_post-custom-css').val() : '',
			// 		content: content,
			// 		pageCss: $('#alpha-post-layout-meta-box #page_css').length ? $('#alpha-post-layout-meta-box #page_css').val() : ''
			// 	};

			// 	var $popup_panel = $('#vc_ui-panel-alpha-popup-options');
			// 	if ($popup_panel.length) {
			// 		var width = $popup_panel.find('#vc_popup-width-field').val(),
			// 			transform = $popup_panel.find('#vc_popup-transform-field').val(),
			// 			top = $popup_panel.find('#vc_popup-position-top-field').val(),
			// 			right = $popup_panel.find('#vc_popup-position-right-field').val(),
			// 			bottom = $popup_panel.find('#vc_popup-position-bottom-field').val(),
			// 			left = $popup_panel.find('#vc_popup-position-left-field').val(),
			// 			animation = $popup_panel.find('#vc_popup-animation-field').val(),
			// 			duration = $popup_panel.find('#vc_popup-anim-duration-field').val();

			// 		data.alpha_popup_options = {
			// 			width: (width ? width : 600),
			// 			top: (top ? top : 'auto'),
			// 			right: (right ? right : 'auto'),
			// 			bottom: (bottom ? bottom : 'auto'),
			// 			left: (left ? left : 'auto'),
			// 			transform: (transform ? transform : 't-mc'),
			// 			animation: animation,
			// 			anim_duration: (duration ? duration : 400)
			// 		}
			// 	}

			// 	// backend editor does not need edit area option, this is just for structure.
			// 	var $edit_area_panel = $('#vc_ui-panel-alpha-edit-area-size');
			// 	if ($edit_area_panel.length) {
			// 		if ($wrapper.find('#vc_edit-area-width-field').length > 0) {
			// 			var width = $wrapper.find('#vc_edit-area-width-field').val();
			// 			data.alpha_edit_area_width = width;
			// 		}
			// 	}

			// 	$.ajax({
			// 		url: alpha_wpb_admin_vars.ajax_url,
			// 		data: data,
			// 		type: 'post',
			// 		success: function (response) {
			// 			if (response['success']) {
			// 				var $alert = $('<div class="wpb-alert wpb-alert-success">Successfully Updated</div>');
			// 				$('body').append($alert);
			// 				$('#wpb-save-post').html('Update');
			// 				var timerId = setTimeout(function () {
			// 					$alert.fadeOut(600, function () {
			// 						$alert.remove();
			// 					});
			// 				}, 3500);
			// 				$alert.on('click', function (e) {
			// 					clearTimeout(timerId);
			// 					$alert.fadeOut(600, function () {
			// 						$alert.remove();
			// 					});
			// 				})
			// 			}
			// 		}
			// 	}).fail(function (response) {
			// 		var $alert = $('<div class="wpb-alert wpb-alert-fail">Update Failed!</div>');
			// 		$('body').append($alert);
			// 		$('#wpb-save-post').html('Update');
			// 		var timerId = setTimeout(function () {
			// 			$alert.fadeOut(600, function () {
			// 				$alert.remove();
			// 			});
			// 		}, 3500);
			// 		$alert.on('click', function (e) {
			// 			clearTimeout(timerId);
			// 			$alert.fadeOut(600, function () {
			// 				$alert.remove();
			// 			});
			// 		})
			// 	});
			// }
		},
		keySave: function ( e ) {
			var keyName = e.key;
			if ( keyName === 'Control' ) {
				return;
			}
			if ( e.ctrlKey ) {
				if ( 's' == keyName || 'S' == keyName ) {
					if ( $( 'body' ).hasClass( 'vc_inline-shortcode-edit-form' ) ) {
						$( '#vc_button-update' ).trigger( 'click' );
					} else {
						var content = $( '#content' ).val();
						if ( content ) {
							if ( 0 == content.indexOf( '<p>' ) ) {
								content = content.slice( 3, -5 );
							}

							var data = {
								action: 'vc_save',
								post_id: $( '#post_ID' ).val(),
								vc_inline: true,
								_vcnonce: window.vcAdminNonce,
								vc_post_custom_css: $( '#vc_post-custom-css' ).val() ? $( '#vc_post-custom-css' ).val() : '',
								content: content,
								pageCss: $( '#alpha-post-layout-meta-box #page_css' ).length ? $( '#alpha-post-layout-meta-box #page_css' ).val() : ''
							};

							var $popup_options = $( '#alpha_popup_options' );
							if ( $popup_options.length && $popup_options.val() ) {
								data.alpha_popup_options = $popup_options.val();
							}

							$.ajax( {
								url: alpha_wpb_admin_vars.ajax_url,
								data: data,
								type: 'post',
								success: function ( response ) {
									if ( response[ 'success' ] ) {
										var $alert = $( '<div class="wpb-alert wpb-alert-success">Successfully Updated</div>' );
										$( 'body' ).append( $alert );
										$( '#wpb-save-post' ).html( 'Update' );
										var timerId = setTimeout( function () {
											$alert.fadeOut( 600, function () {
												$alert.remove();
											} );
										}, 3500 );
										$alert.on( 'click', function ( e ) {
											clearTimeout( timerId );
											$alert.fadeOut( 600, function () {
												$alert.remove();
											} );
										} )
									}
								}
							} ).fail( function ( response ) {
								var $alert = $( '<div class="wpb-alert wpb-alert-fail">Update Failed!</div>' );
								$( 'body' ).append( $alert );
								$( '#wpb-save-post' ).html( 'Update' );
								var timerId = setTimeout( function () {
									$alert.fadeOut( 600, function () {
										$alert.remove();
									} );
								}, 3500 );
								$alert.on( 'click', function ( e ) {
									clearTimeout( timerId );
									$alert.fadeOut( 600, function () {
										$alert.remove();
									} );
								} )
							} );
						}
						e.preventDefault();
					}
				}
			}
		},
		initElementControls: function () {
			$( 'body' ).on( 'click', '.vc_edit-form-tab .wpb_el_type_alpha_accordion_header', function () {
				$( this ).siblings( '.wpb_el_type_alpha_accordion_header' ).removeClass( 'opened' );

				if ( $( this ).hasClass( 'opened' ) ) {
					$( this ).removeClass( 'opened' );
					$( this ).siblings( '.vc_column:not(.wpb_el_type_alpha_accordion_header)' ).removeClass( 'show' );
				} else {
					$( this ).addClass( 'opened' );
					$( this ).siblings().removeClass( 'show' );

					var $next = $( this ).next();
					while ( $next.length && !$next.hasClass( 'wpb_el_type_alpha_accordion_header' ) ) {
						$next.addClass( 'show' );
						$next = $next.next();
					}
				}
			} )
			$( 'body' ).on( 'click', '#vc_ui-panel-edit-element .vc_ui-tabs-line .vc_ui-tabs-line-trigger', function () {
				var $accordion_header = $( '#vc_ui-panel-edit-element .vc_edit-form-tab.vc_active .wpb_el_type_alpha_accordion_header' ).eq( 0 );
				if ( $accordion_header.length && !$accordion_header.hasClass( 'opened' ) ) {
					$accordion_header.trigger( 'click' );
				}
			} )

			if ( $( '#vc_ui-panel-alpha-popup-options' ).length ) {
				$( '#vc_post-custom-css' ).after( '<input type="hidden" name="alpha_popup_options" id="alpha_popup_options" value="" autocomplete="off">' );
			}
			if ( !$( document.body ).hasClass( 'block-editor-page' ) && $( '#vc_ui-panel-post-settings .custom_css' ).length ) {
				$( '#alpha-post-layout-meta-box #page_css' ).attr( 'disabled', 'disabled' );
				var page_css = $( '#alpha-post-layout-meta-box #page_css' ).val();
				if ( page_css ) {
					$( '#vc_post-custom-css' ).val( page_css + $( '#vc_post-custom-css' ).val() );
					$( '#alpha-post-layout-meta-box #page_css' ).val( '' );
				}
			}
		},
		initAddonOptions: function () {
			$( 'body' ).on( 'click', '#vc_ui-panel-alpha-popup-options [data-vc-ui-element="button-save"]', function () {
				var $popup_panel = $( '#vc_ui-panel-alpha-popup-options' );

				var width = $popup_panel.find( '#vc_popup-width-field' ).val(),
					hPos = $popup_panel.find( '#vc_popup-h_pos-field' ).val(),
					vPos = $popup_panel.find( '#vc_popup-v_pos-field' ).val(),
					border = $popup_panel.find( '#vc_popup-border-field' ).val(),
					top = $popup_panel.find( '#vc_popup-margin-top-field' ).val(),
					right = $popup_panel.find( '#vc_popup-margin-right-field' ).val(),
					bottom = $popup_panel.find( '#vc_popup-margin-bottom-field' ).val(),
					left = $popup_panel.find( '#vc_popup-margin-left-field' ).val(),
					animation = $popup_panel.find( '#vc_popup-animation-field' ).val(),
					duration = $popup_panel.find( '#vc_popup-anim-duration-field' ).val();

				var options = {
					width: ( width ? width : 600 ),
					h_pos: ( hPos ? hPos : 'center' ),
					v_pos: ( vPos ? vPos : 'center' ),
					border: ( border ? border : '0' ),
					top: ( top ? top : '' ),
					right: ( right ? right : '' ),
					bottom: ( bottom ? bottom : '' ),
					left: ( left ? left : '' ),
					popup_animation: animation,
					popup_anim_duration: ( duration ? duration : 400 )
				};

				$( '#alpha_popup_options' ).val( JSON.stringify( options ) );
			} );
		},
		addEditWrapperClass: function () {
			if ( alpha_core_vars && alpha_core_vars.template_type ) {
				$( '#visual_composer_content' ).addClass( 'wpb-alpha-' + alpha_core_vars.template_type + '-builder' );
			}
		},
		initShortcodes: function () {
			if ( $( 'body' ).hasClass( 'vc_inline-shortcode-edit-form' ) ) {
				var gcd = function ( $a, $b ) {
					while ( $b ) {
						var $r = $a % $b;
						$a = $b;
						$b = $r; z
					}
					return $a;
				};

				var get_creative_grid_item_css = function ( $id, $layout, $height, $height_ratio ) {
					if ( 'undefined' == typeof $layout ) {
						return;
					}
					var $height_ary = [ 'h-1', 'h-1-2', 'h-1-3', 'h-2-3', 'h-1-4', 'h-3-4', 'h-1-5', 'h-2-5', 'h-3-5', 'h-4-5' ];
					var $deno = [];
					var $numer = [];
					var $style = '';
					var $ws = { 'w': [], 'w-l': [], 'w-m': [], 'w-s': [] };
					var $hs = { 'h': [], 'h-l': [], 'h-m': [] };

					$style += '<style scope="">';
					$layout.map( function ( $grid_item ) {
						Object.entries( $grid_item ).forEach( function ( $info ) {
							if ( 'size' == $info[ 0 ] ) {
								return;
							}

							var $num = $info[ 1 ].split( '-' );
							if ( undefined != $num[ 1 ] && -1 == $deno.indexOf( $num[ 1 ] ) ) {
								$deno.push( $num[ 1 ] );
							}
							if ( -1 == $numer.indexOf( $num[ 0 ] ) ) {
								$numer.push( $num[ 0 ] );
							}

							if ( ( 'w' == $info[ 0 ] || 'w-l' == $info[ 0 ] || 'w-m' == $info[ 0 ] || 'w-s' == $info[ 0 ] ) && -1 == $ws[ $info[ 0 ] ].indexOf( $info[ 1 ] ) ) {
								$ws[ $info[ 0 ] ].push( $info[ 1 ] );
							} else if ( ( 'h' == $info[ 0 ] || 'h-l' == $info[ 0 ] || 'h-m' == $info[ 0 ] ) && -1 == $hs[ $info[ 0 ] ].indexOf( $info[ 1 ] ) ) {
								$hs[ $info[ 0 ] ].push( $info[ 1 ] );
							}
						} );
					} );
					Object.entries( $ws ).forEach( function ( $w ) {
						if ( !$w[ 1 ].length ) {
							return;
						}

						if ( 'w-xl' == $w[ 0 ] ) {
							$style += '@media (max-width: 1199px) {';
						} else if ( 'w-l' == $w[ 0 ] ) {
							$style += '@media (max-width: 991px) {';
						} else if ( 'w-m' == $w[ 0 ] ) {
							$style += '@media (max-width: 767px) {';
						} else if ( 'w-s' == $w[ 0 ] ) {
							$style += '@media (max-width: 575px) {';
						}

						$w[ 1 ].map( function ( $item ) {
							var $opts = $item.split( '-' );
							var $width = ( undefined == $opts[ 1 ] ? 100 : ( 100 * $opts[ 0 ] / $opts[ 1 ] ).toFixed( 4 ) );
							$style += '.' + $id + ' .grid-item.' + $w[ 0 ] + '-' + $item + '{flex:0 0 ' + $width + '%;width:' + $width + '%}';
						} )

						if ( 'w-xl' == $w[ 0 ] || 'w-l' == $w[ 0 ] || 'w-m' == $w[ 0 ] || 'w-s' == $w[ 0 ] ) {
							$style += '}';
						}
					} );
					Object.entries( $hs ).forEach( function ( $h ) {
						if ( !$h[ 1 ].length ) {
							return;
						}

						$h[ 1 ].map( function ( $item ) {
							var $opts = $item.split( '-' ), $value;
							if ( undefined != $opts[ 1 ] ) {
								$value = $height * $opts[ 0 ] / $opts[ 1 ];
							} else {
								$value = $height;
							}
							if ( 'h' == $h[ 0 ] ) {
								$style += '.' + $id + ' .h-' + $item + '{height:' + $value.toFixed( 2 ) + 'px}';
								$style += '@media (max-width: 767px) {';
								$style += '.' + $id + ' .h-' + $item + '{height:' + ( $value * $height_ratio / 100 ).toFixed( 2 ) + 'px}';
								$style += '}';
							} else if ( 'h-xl' == $h[ 0 ] ) {
								$style += '@media (max-width: 1199px) {';
								$style += '.' + $id + ' .h-xl-' + $item + '{height:' + $value.toFixed( 2 ) + 'px}';
								$style += '}';
								$style += '@media (max-width: 767px) {';
								$style += '.' + $id + ' .h-xl-' + $item + '{height:' + ( $value * $height_ratio / 100 ).toFixed( 2 ) + 'px}';
								$style += '}';
							} else if ( 'h-l' == $h[ 0 ] ) {
								$style += '@media (max-width: 991px) {';
								$style += '.' + $id + ' .h-l-' + $item + '{height:' + $value.toFixed( 2 ) + 'px}';
								$style += '}';
								$style += '@media (max-width: 767px) {';
								$style += '.' + $id + ' .h-l-' + $item + '{height:' + ( $value * $height_ratio / 100 ).toFixed( 2 ) + 'px}';
								$style += '}';
							} else if ( 'h-m' == $h[ 0 ] ) {
								$style += '@media (max-width: 767px) {';
								$style += '.' + $id + ' .h-m-' + $item + '{height:' + ( $value * $height_ratio / 100 ).toFixed( 2 ) + 'px}';
								$style += '}';
							} else if ( 'h-s' == $h[ 0 ] ) {
								$style += '@media (max-width: 575px) {';
								$style += '.' + $id + ' .h-s-' + $item + '{height:' + $value.toFixed( 2 ) + 'px}';
								$style += '}';
							}
						} )
					} );
					var $lcm = 1;
					$deno.map( function ( $value ) {
						$lcm = $lcm * $value / gcd( $lcm, $value );
					} );
					var $gcd = $numer[ 0 ];
					$numer.map( function ( $value ) {
						$gcd = gcd( $gcd, $value );
					} );
					var $sizer = Math.floor( 100 * $gcd / $lcm * 10000 ) / 10000;
					$style += '.' + $id + '.grid' + '>.grid-space{flex: 0 0 ' + ( $sizer < 0.01 ? 100 : $sizer ) + '%;width:' + ( $sizer < 0.01 ? 100 : $sizer ) + '%}';
					$style += '</style>';
					return $style;
				};

				var refreshCarousel = function ( modelId ) {
					var Alpha = document.getElementById( 'vc_inline-frame' ).contentWindow.theme,
						jQuery = document.getElementById( 'vc_inline-frame' ).contentWindow.jQuery;

					var $carousel = jQuery( '[data-model-id=' + modelId + ']' ).closest( '.slider-wrapper' );
					if ( $carousel.data( 'slider' ) ) {
						$carousel.data( 'slider' ).destroy();
						$carousel.removeData( 'slider' );
					}
					Alpha.slider( $carousel );
				}

				var refreshMasonry = function ( $masonry, modelId, startId, endId ) {
					if ( !$masonry.length ) {
						return;
					}
					var Alpha = document.getElementById( 'vc_inline-frame' ).contentWindow.theme,
						jQuery = document.getElementById( 'vc_inline-frame' ).contentWindow.jQuery;

					var preset = $masonry.data( 'creative-preset' ),
						layout = $masonry.data( 'creative-layout' );

					if ( 'undefined' == typeof layout ) {
						layout = [];
					}

					for ( var i = startId; i <= endId; i++ ) {
						var $item = $masonry.children( '.vc_element' ).eq( i ).children( '.vc_element-container' ),
							cls = $item.attr( 'class' ),
							item = $item.data( 'creative-item' ),
							grid = {},
							w_arr = [ 'w', 'w-xl', 'w-l', 'w-m', 'w-s' ],
							h_arr = [ 'h', 'h-xl', 'h-l', 'h-m', 'h-s' ];

						if ( preset[ i ] ) {
							grid = preset[ i ];
						} else {
							grid[ 'w' ] = '1-4';
							grid[ 'w-l' ] = '1-2';
							grid[ 'h' ] = '1-3';
						}

						for ( var j = 0; j < 5; j++ ) {
							if ( item[ w_arr[ j ] ] ) {
								for ( var k = j; k < 5; k++ ) {
									grid[ w_arr[ k ] ] = item[ w_arr[ j ] ];
								}
							}
						}
						for ( var j = 0; j < 5; j++ ) {
							if ( item[ h_arr[ j ] ] && 'preset' != item[ h_arr[ j ] ] && 'child' != item[ h_arr[ j ] ] ) {
								grid[ h_arr[ j ] ] = item[ h_arr[ j ] ];
							}
						}

						var cls = $item.parent( '.vc_wpb_' + alpha_admin_vars.theme + '_masonry_item' ).attr( 'class' );
						cls = cls.match( /(grid-item .* grid-item-end-class)/g );
						if ( cls ) {
							$item.parent( '.vc_wpb_' + alpha_admin_vars.theme + '_masonry_item' ).removeClass( cls[ 0 ] );
						}
						$item.removeAttr( 'data-creative-item' );

						cls = 'grid-item ';
						Object.entries( grid ).forEach( function ( item ) {
							cls += item[ 0 ] + '-' + item[ 1 ] + ' ';
						} );
						cls += 'grid-item-end-class';

						$item.parent( '.vc_wpb_' + alpha_admin_vars.theme + '_masonry_item' ).addClass( cls ).attr( 'data-creative-item', JSON.stringify( grid ) );

						layout[ i ] = grid;

						// Set Order Data
						var b_arr = [ '', '-xl', '-lg', '-md', '-sm' ];
						for ( var j = 0; j < b_arr.length; j++ ) {
							$item.parent().attr( 'data-creative-order' + b_arr[ j ], ( undefined == $item.attr( 'data-creative-order' + b_arr[ j ] ) ? $item.parent().index() + 1 : $item.attr( 'data-creative-order' + b_arr[ j ] ) ) );
						}
					}

					$masonry.data( 'creative-layout', layout );
					$masonry.children( '.grid-space' ).remove();
					$masonry.append( $( '<div class="grid-space"></div>' ) );

					$masonry.before( 'style' ).remove();
					$masonry.before( get_creative_grid_item_css(
						$masonry.data( 'creative-id' ),
						$masonry.data( 'creative-layout' ),
						$masonry.data( 'creative-height' ),
						$masonry.data( 'creative-height-ratio' ) ) );

					if ( $masonry.data( 'isotope' ) ) {
						$masonry.isotope( 'destroy' );
					}
					if ( $masonry.hasClass( 'grid-float' ) ) {
						$masonry.children( '.grid-item' ).each( function () {
							$( this ).css( { position: '', left: '', top: '' } );
						} )
					}
					Alpha.isotopes( $masonry );

					var slider = $masonry.find( '.slider-wrapper' ).data( 'slider' );
					slider && slider.update();
					$( window ).trigger( 'resize' );
				}

				if ( window.InlineShortcodeView ) {
					var origin_func = window.InlineShortcodeView.prototype.destroy;
					window.InlineShortcodeView.prototype.destroy = function ( e ) {
						vc.events.trigger( "shortcodeView:destroy", this.model );
						e && e.preventDefault && e.preventDefault(), e && e.stopPropagation && e.stopPropagation(), vc.showMessage( window.sprintf( window.i18nLocale.inline_element_deleted, this.model.setting( "name" ) ) ), this.model.destroy();
					}
				}

				window.vc.events.on( 'shortcodeView:ready', function ( e ) {
					if ( !e.view || !e.view.$el ) {
						return;
					}

					var Alpha = document.getElementById( 'vc_inline-frame' ).contentWindow.theme,
						jQuery = document.getElementById( 'vc_inline-frame' ).contentWindow.jQuery;

					var shortcode = e.attributes.shortcode,
						$container = e.view.$el,
						modelId = e.view.model.attributes.id;

					if ( "wpb_" + alpha_admin_vars.theme + "_masonry_item" == shortcode ) {
						var $masonry = jQuery( '[data-model-id=' + modelId + ']' ).parent( '.alpha-masonry-container' );
						refreshMasonry( $masonry, modelId, $container.index(), $container.siblings( '.grid-item' ).length );
					} else if ( "wpb_" + alpha_admin_vars.theme + "_masonry" == shortcode ) {
						var $masonry = jQuery( '[data-model-id=' + modelId + ']' ).children( '.alpha-masonry-container' );
						refreshMasonry( $masonry, modelId, 0, $container.children( '.vc_element-container' ).children( '.vc_element' ).length - 1 );
					} else if ( "wpb_" + alpha_admin_vars.theme + "_carousel" == shortcode ) {
						var $carousel = jQuery( '[data-model-id=' + modelId + ']' ).children( '.alpha-carousel-container' ).children( '.slider-wrapper' );

						$carousel.children( '.slider-slide:not(.slider-slide-duplicate)' ).each( function () {
							$carousel.append( $( this ).children() );
						} );
						$carousel.siblings( '.slider-button, .slider-pagination' ).remove();

						Alpha.slider( $carousel );
					} else if ( "wpb_" + alpha_admin_vars.theme + "_tab" == shortcode ) {
						var $navs = $container.children( '.alpha-tab-container' ).children( '.tab' ).children( '.nav-tabs' );
						$container.children( '.alpha-tab-container' ).children( '.tab' ).children( '.tab-content' ).children().each( function () {
							$navs.append( $( '<li class="nav-item"><a class="nav-link' + ( $( this ).hasClass( 'active' ) ? ' active' : '' ) + '" href="#" target="_blank">' + $( this ).children( '.alpha-tab-item-container' ).data( 'tab-title' ) + '</a></li>' ) )
						} );
					} else if ( "wpb_" + alpha_admin_vars.theme + "_tab_item" == shortcode ) {
						$container.children( '.alpha-tab-item-container' ).removeClass( 'tab-pane' );
						$container.addClass( 'tab-pane' );

						if ( $container.siblings( '.active' ).length ) {
							$container.children( '.alpha-tab-item-container' ).removeClass( 'active' );
						}

						if ( $container.children( '.alpha-tab-item-container' ).hasClass( 'active' ) ) {
							$container.addClass( 'active' );
						}

						if ( true == e.attributes.cloned ) { // cloned
							$container.closest( '.tab' ).find( '.nav-tabs' ).children( '.nav-item' ).eq( $container.index() - 1 ).after( $( '<li class="nav-item"><a class="nav-link" href="#" target="_blank">' + $container.children( '.alpha-tab-item-container' ).data( 'tab-title' ) + '</a></li>' ) );
						} else if ( !$container.closest( '.tab' ).find( '.nav-tabs > .nav-item' ).eq( $container.index() - 1 ).length ) { // new
							$container.closest( '.tab' ).find( '.nav-tabs' ).append( $( '<li class="nav-item"><a class="nav-link" href="#" target="_blank">' + $container.children( '.alpha-tab-item-container' ).data( 'tab-title' ) + '</a></li>' ) );
						} else { // existing
							$container.closest( '.tab' ).find( '.nav-tabs > .nav-item' ).eq( $container.index() ).children( '.nav-link' ).text( $container.children( '.alpha-tab-item-container' ).data( 'tab-title' ) );
						}
					} else if ( 'wpb_' + alpha_admin_vars.theme + '_accordion' == shortcode ) {
						var icon = $container.children( '.alpha-accordion-container' ).data( 'accordion-icon' ),
							active_icon = $container.children( '.alpha-accordion-container' ).data( 'accordion-active-icon' );

						$container.find( ' > .alpha-accordion-container > .accordion > .card' ).each( function () {
							var $header = $( this ).find( '> .alpha-accordion-item-container > .card-header > a' );

							$header.find( '.toggle-icon' ).remove();

							if ( icon ) {
								$header.append( $( '<span class="toggle-icon closed"><i class="' + icon + '"></i></span>' ) );
							}
							if ( active_icon ) {
								$header.append( $( '<span class="toggle-icon opened"><i class="' + active_icon + '"></i></span>' ) );
							}
						} );
					} else if ( 'wpb_' + alpha_admin_vars.theme + '_accordion_item' == shortcode ) {
						var icon = $container.closest( '.alpha-accordion-container' ).data( 'accordion-icon' ),
							active_icon = $container.closest( '.alpha-accordion-container' ).data( 'accordion-active-icon' ),
							$header = $container.find( ' > .alpha-accordion-item-container > .card-header > a' ),
							$accordion = $container.closest( '.accordion' );

						$container.addClass( 'card' );
						$container.children( '.alpha-accordion-item-container' ).removeClass( 'card' );

						if ( icon && !$header.children( '.closed' ).length ) {
							$header.append( $( '<span class="toggle-icon closed"><i class="' + icon + '"></i></span>' ) );
						}
						if ( active_icon && !$header.children( '.opened' ).length ) {
							$header.append( $( '<span class="toggle-icon opened"><i class="' + active_icon + '"></i></span>' ) );
						}
						if ( !$accordion.find( '> .card > .alpha-accordion-item-container > .card-header > .collapse' ).length ) {
							$header.addClass( 'collapse' ).removeClass( 'expand' );
							$header.parent( '.card-header' ).siblings( '.card-body' ).removeClass( 'collapsed' ).addClass( 'expanded' );
						}
					}

					if ( $container.parent().hasClass( 'slider-slide' ) || $container.parent().hasClass( 'slider-wrapper' ) ) { // if carousel item
						refreshCarousel( modelId );
					}
				} );
				window.vc.events.on( 'shortcodeView:destroy', function ( e ) {
					var shortcode = e.attributes.shortcode,
						$container = e.view.$el,
						modelId = e.view.model.attributes.id;

					if ( "wpb_" + alpha_admin_vars.theme + "_tab_item" == shortcode ) {
						var idx = $container.index();
						$container.closest( '.tab' ).children( '.nav-tabs' ).children( '.nav-item' ).eq( idx ).remove();

						if ( $container.hasClass( 'active' ) ) {
							$container.closest( '.tab' ).children( '.nav-tabs' ).children( '.nav-item:first-child' ).find( 'a' ).addClass( 'active' );
							$container.parent().children( '.tab-pane:nth-child(' + ( 0 == idx ? 2 : 1 ) + ')' ).addClass( 'active' );
						}
					}

					if ( $container.parent().hasClass( 'slider-slide' ) ) {
						refreshCarousel( modelId );
					}
				} )
			}
		}
	};

	// Setup Alpha Elementor Admin
	themeWPBakeryAdmin.init();
} );