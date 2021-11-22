<?php
/**
 * Single Prodcut Counter Render
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

wp_enqueue_script( 'jquery-count-to' );

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'starting_number'         => 0,
			'ending_number'           => 'sale',
			'adding_number'           => 0,
			'prefix'                  => '',
			'suffix'                  => '',
			'duration'                => 0,
			'thousand_separator'      => 'yes',
			'thousand_separator_char' => '',
			'title'                   => esc_html__( 'Sale Products', 'alpha-core' ),
		),
		$atts
	)
);

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-sp-counter-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

if ( false == is_int( $starting_number ) || false == is_int( $adding_number ) || false == is_int( $duration ) ) {
	$starting_number = intval( $starting_number );
	$adding_number   = intval( $adding_number );
	$duration        = intval( $duration );
}
?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {

	global $product;

	if ( 'sale' == $ending_number ) {
		$count_to = $product->get_total_sales();
	} else {
		$count_to = $product->get_stock_quantity();
	}

	if ( $adding_number ) {
		$count_to += $adding_number;
	}

	$counter_attrs = array(
		'class'           => 'wpb-sp-counter-number count-to',
		'data-speed'      => $duration,
		'data-to-value'   => $count_to,
		'data-from-value' => $starting_number,
	);

	if ( ! empty( $thousand_separator ) ) {
		$delimiter                       = empty( $thousand_separator_char ) ? ',' : $thousand_separator_char;
		$counter_attrs['data-delimiter'] = $thousand_separator_char;
	}

	$counter_attrs_html = '';
	foreach ( $counter_attrs as $key => $value ) {
		$counter_attrs_html .= $key . '="' . $value . '" ';
	}
	?>
	<div class = "wpb-sp-counter-number-wrapper counter">
		<?php
		echo '<span class="wpb-sp-counter-number-prefix">' . alpha_escaped( $prefix ) . '</span>';
		echo '<span ' . alpha_escaped( $counter_attrs_html ) . '>' . alpha_escaped( $starting_number ) . '</span>';
		echo '<span class="wpb-sp-counter-number-suffix">' . alpha_escaped( $suffix ) . '</span>';
		?>
	</div>
	<?php if ( $title ) : ?>
		<div class="wpb-sp-counter-title"><?php echo alpha_escaped( $title ); ?></div>
	<?php endif; ?>
	<?php
	do_action( 'alpha_single_product_builder_unset_preview' );
}
?>
</div>
<?php
