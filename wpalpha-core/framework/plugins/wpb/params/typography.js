/**
 * Alpha Typography
 *
 * @since 1.0
 */
jQuery( '.alpha-wpb-typography-container .alpha-wpb-typography-toggle' ).on( 'click', function ( e ) {
    var $this = jQuery( this );
    $this.parent().toggleClass( 'show' );
    $this.next().slideToggle( 300 );
} );
jQuery( document.body ).on( 'change', '.alpha-wpb-typography-container .alpha-vc-font-family', function ( e ) {
    var $this = jQuery( this ),
        $control = $this.closest( '.alpha-wpb-typography-container' ),
        $form = $control.next(),
        $variants = $control.find( '.alpha-vc-font-variants' ),
        $status = $control.find( '.alpha-wpb-typography-toggle p' ),
        font = $this.val(),
        variants = $this.find( 'option[value="' + font + '"]' ).data( 'variants' ),
        html = '';

    variants.forEach( item => {
        html += '<option value="' + item + '">' + item + '</option>';
    } );
    $variants.html( html );

    var data = {
        family: $this.val(),
        variant: $variants.val(),
        size: $control.find( '.alpha-vc-font-size' ).val(),
        line_height: $control.find( '.alpha-vc-line-height' ).val(),
        letter_spacing: $control.find( '.alpha-vc-letter-spacing' ).val(),
        text_transform: $control.find( '.alpha-vc-text-transform' ).val()
    };

    $form.val( JSON.stringify( data ) );

    $status.text( data.family + ' | ' + data.variant + ' | ' + data.size );
} ).on( 'change', '.alpha-wpb-typography-container .alpha-vc-font-variants, .alpha-wpb-typography-container .alpha-vc-font-size, .alpha-wpb-typography-container .alpha-vc-letter-spacing, .alpha-wpb-typography-container .alpha-vc-line-height, .alpha-wpb-typography-container .alpha-vc-text-transform', function ( e ) {
    var $this = jQuery( this ),
        $control = $this.closest( '.alpha-wpb-typography-container' ),
        $status = $control.find( '.alpha-wpb-typography-toggle p' ),
        $form = $control.next();

    var data = {
        family: $control.find( '.alpha-vc-font-family' ).val(),
        variant: $control.find( '.alpha-vc-font-variants' ).val(),
        size: $control.find( '.alpha-vc-font-size' ).val(),
        line_height: $control.find( '.alpha-vc-line-height' ).val(),
        letter_spacing: $control.find( '.alpha-vc-letter-spacing' ).val(),
        text_transform: $control.find( '.alpha-vc-text-transform' ).val()
    };

    $form.val( JSON.stringify( data ) );
    $status.text( data.family + ' | ' + data.variant + ' | ' + data.size );
} );