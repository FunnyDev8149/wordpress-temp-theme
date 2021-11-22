/**
 * Alpha Elementor Admin
 * 
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
jQuery( document ).ready( function ( $ ) {
    'use strict';

    var themeElementorAdmin = {
        init: function () {
            this.initCustomCSS();
            this.initCustomJS();
            this.addStudioButtons();
            this.initArchiveSinglePreview();

            elementor.on( 'panel:init', function () {
                elementor.panel.currentView.on( 'set:page', themeElementorAdmin.panelChange );
                elementor.channels.editor.on( 'section:activated', themeElementorAdmin.removeControls );
            } );
        },
        initCustomCSS: function () {
            // custom page css
            var custom_css = elementor.settings.page.model.get( 'page_css' );

            setTimeout( function () {
                typeof custom_css != 'undefined' && elementorFrontend.hooks.doAction( 'refresh_page_css', custom_css );
            }, 1000 );

            $( document.body ).on( 'input', 'textarea[data-setting="page_css"]', function ( e ) {
                if ( $( this ).closest( '.elementor-control' ).siblings( '.elementor-control-_alpha_custom_css' ).length ) {
                    elementor.settings.page.model.set( 'page_css', $( this ).val() );

                    $( '#elementor-panel-saver-button-publish' ).removeClass( 'elementor-disabled' );
                    $( '#elementor-panel-saver-button-save-options' ).removeClass( 'elementor-disabled' );
                }

                elementorFrontend.hooks.doAction( 'refresh_page_css', $( this ).val() );
            } )
        },
        initCustomJS: function () {
            // custom page css
            var custom_js = elementor.settings.page.model.get( 'page_js' );

            $( document.body ).on( 'input', 'textarea[data-setting="page_js"]', function ( e ) {
                if ( $( this ).closest( '.elementor-control' ).siblings( '.elementor-control-_alpha_custom_js' ).length ) {
                    elementor.settings.page.model.set( 'page_js', $( this ).val() );

                    $( '#elementor-panel-saver-button-publish' ).removeClass( 'elementor-disabled' );
                    $( '#elementor-panel-saver-button-save-options' ).removeClass( 'elementor-disabled' );
                }
            } )
        },
        addStudioButtons: function () {
            // Add Studio Block Button
            var addSectionTmpl = document.getElementById( 'tmpl-elementor-add-section' );
            if ( addSectionTmpl ) {
                addSectionTmpl.textContent = addSectionTmpl.textContent.replace(
                    '<div class="elementor-add-section-area-button elementor-add-template-button',
                    '<div class="elementor-add-section-area-button elementor-studio-section-button" ' +
                    'onclick="window.parent.runStudio(this);" ' +
                    'title="Alpha Studio"><i class="alpha-mini-logo"></i><i class="eicon-insert"></i></div>' +
                    '<div class="elementor-add-section-area-button elementor-add-template-button' );
            }
        },
        panelChange: function ( panel ) {
            if ( "_alpha_section_custom_css" == panel.activeSection || "_alpha_section_custom_js" == panel.activeSection ) {
                var oldName = panel.activeSection.replaceAll( '_section', '' ),
                    newName = oldName.replaceAll( '_alpha_custom', 'page' );

                if ( $( '.elementor-control-' + newName ).length ) {
                    return;
                }

                var $newControl = $( '.elementor-control-' + oldName ).clone().removeClass( 'elementor-control-' + oldName ).addClass( 'elementor-control-' + newName );

                $newControl.insertAfter( $( '.elementor-control-' + oldName ) );
                $newControl.find( 'textarea' ).attr( 'data-setting', newName ).val( elementor.settings.page.model.get( newName ) );

                if ( newName == 'page_css' ) {
                    $( '.elementor-control-page_js' ).remove();
                } else {
                    $( '.elementor-control-page_css' ).remove();
                }
            } else if ( "alpha_custom_css_settings" == panel.activeSection ) {
                $( '.elementor-control-page_css' ).val( elementor.settings.page.model.get( 'page_css' ) );
            } else if ( "alpha_custom_js_settings" == panel.activeSection ) {
                $( '.elementor-control-page_js' ).val( elementor.settings.page.model.get( 'page_js' ) );
            }
        },
        removeControls: function ( activeSection ) {
            if ( "_alpha_section_custom_css" != activeSection && "_alpha_section_custom_js" != activeSection ) {
                $( '.elementor-control-page_css, .elementor-control-page_js' ).remove();
            } else {
                var oldName = activeSection.replaceAll( '_section', '' ),
                    newName = oldName.replaceAll( '_alpha_custom', 'page' ),
                    $newControl = $( '.elementor-control-' + oldName ).clone().removeClass( 'elementor-control-' + oldName ).addClass( 'elementor-control-' + newName );

                $newControl.insertAfter( $( '.elementor-control-' + oldName ) );
                $newControl.find( 'textarea' ).attr( 'data-setting', newName ).val( elementor.settings.page.model.get( newName ) );

                if ( newName == 'page_css' ) {
                    $( '.elementor-control-page_js' ).remove();
                } else {
                    $( '.elementor-control-page_css' ).remove();
                }
            }
        },
        initArchiveSinglePreview: function () {
            $( document )
                .on( 'click', '.elementor-control-archive_preview_apply .elementor-button', function ( e ) {
                    $.post( alpha_core_vars.ajax_url, {
                        action: 'alpha_archive_builder_preview_apply',
                        nonce: alpha_core_vars.nonce,
                        post_id: ElementorConfig.document.id,
                        mode: $( '.elementor-control-archive_preview_type select' ).val(),
                    }, function () {
                        elementor.reloadPreview();
                    } );
                } )
                .on( 'click', '.elementor-control-single_preview_apply .elementor-button', function ( e ) {
                    $.post( alpha_core_vars.ajax_url, {
                        action: 'alpha_single_builder_preview_apply',
                        nonce: alpha_core_vars.nonce,
                        post_id: ElementorConfig.document.id,
                        mode: $( '.elementor-control-single_preview_type select' ).val(),
                    }, function () {
                        elementor.reloadPreview();
                    } );
                } )
        }
    }

    // Setup Alpha Elementor Admin
    elementor.on( 'frontend:init', themeElementorAdmin.init.bind( themeElementorAdmin ) );
} );