<?php
/**
 * Alpha Multi Select
 *
 * adds multi select control for element option
 * follow below example of alpha_multiselect control
 *
 * array(
 *      'type'       => 'alpha_multiselect',
 *      'heading'    => esc_html__( 'Show Information', 'alpha-core' ),
 *      'param_name' => 'show_info',
 *      'value'      => array(
 *          esc_html__( 'Category', 'alpha-core' ) => 'category',
 *          esc_html__( 'Label', 'alpha-core' )    => 'label',
 *          esc_html__( 'Price', 'alpha-core' )    => 'price',
 *          esc_html__( 'Rating', 'alpha-core' )   => 'rating',
 *          esc_html__( 'Attribute', 'alpha-core' ) => 'attribute',
 *          esc_html__( 'Add To Cart', 'alpha-core' ) => 'addtocart',
 *          esc_html__( 'Compare', 'alpha-core' )  => 'compare',
 *          esc_html__( 'Quickview', 'alpha-core' ) => 'quickview',
 *          esc_html__( 'Wishlist', 'alpha-core' ) => 'wishlist',
 *          esc_html__( 'Short Description', 'alpha-core' ) => 'short_desc',
 *      ),
 *      'dependency' => array(
 *          'element'            => 'follow_theme_option',
 *          'value_not_equal_to' => 'yes',
 *      ),
 * ),
 *
 *
 * @since 1.0
 *
 * @param array $settings
 * @param string $value
 *
 * @return string
 */
function alpha_multiselect_callback( $settings, $value ) {
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$class      = 'alpha-wpb-multiselect-container';

	if ( empty( $value ) ) {
		$value = array();
	} elseif ( ! is_array( $value ) ) {
		$value = explode( ',', $value );
	}

	$html .= '<select name="' . $settings['param_name'] . '" class="alpha-multiselect-container wpb_vc_param_value wpb-input wpb-select ' . esc_attr( $settings['param_name'] ) . ' ' . $type . '" value="' . esc_attr( $value ) . '"  multiple="true">';

	if ( ! empty( $settings['value'] ) ) {
		foreach ( $settings['value'] as $option_label => $option_value ) {
			$selected            = '';
			$option_value_string = (string) $option_value;
			if ( ! empty( $value ) && in_array( $option_value_string, $value ) ) {
				$selected = 'selected="selected"';
			}
			$option_class = str_replace( '#', 'hash-', $option_value );
			$html        .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '" ' . $selected . '>' . htmlspecialchars( $option_label ) . '</option>';
		}
	}
	$html .= '</select>';

	return $html;
}

vc_add_shortcode_param( 'alpha_multiselect', 'alpha_multiselect_callback' );
