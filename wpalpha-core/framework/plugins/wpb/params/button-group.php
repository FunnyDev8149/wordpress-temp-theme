<?php
/**
 * Alpha WPBakery ButtonGroup Callback
 *
 * adds button-choose control supporting label, icon and image
 * follow below example of alpha_button_group control
 * order of options' priority is 'image' > 'color' > 'icon' > 'label'
 *
 * if all type options are omited, it will automatically change to label type
 * and 'title' option will be worked as 'lable' option
 *
 * array(
 *      'type'        => 'alpha_button_group',
 *      'heading'     => __( 'Alignment', 'alpha-core' ),
 *      'param_name'  => 'button_align',
 *      'value'       => array(
 *          'left' => array(
 *              'title' => esc_html__( 'Left', 'alpha-core' ), // tooltip text
 *              'color' => 'var(--alpha-primary-color, #2879FE)',
 *              'icon'  => 'fas fa-align-left',
 *              'label' => esc_html__( 'Left', 'alpha-core' ),
 *          ),
 *          'center' => array(
 *              'title' => esc_html__( 'Center', 'alpha-core' ), // tooltip text
 *              'color' => 'var(--alpha-secondary-color, #d26e4b)',
 *              'icon'  => 'fas fa-align-center',
 *              'label' => esc_html__( 'Center', 'alpha-core' ),
 *          ),
 *          'right' => array(
 *              'title' => esc_html__( 'Right', 'alpha-core' ), // tooltip text
 *              'color' => 'var(--alpha-success-color, #a8c26e)',
 *              'icon'  => 'fas fa-align-right',
 *              'label' => esc_html__( 'Right', 'alpha-core' ),
 *          ),
 *          'inline' => array(
 *              'title' => esc_html__( 'Inline', 'alpha-core' ), // tooltip text
 *              'color' => '#fff',
 *              'icon'  => 'fas fa-arrows-alt-h',
 *              'label' => esc_html__( 'Inline', 'alpha-core' ),
 *          )
 *      ),
 *      'std' => 'left',
 *      'description' => '',
 *      'group'       => 'General',
 *  ),
 *
 * @since 1.0
 *
 * @param array $settings
 * @param string $value
 *
 * @return string
 */
function alpha_button_group_callback( $settings, $value ) {
	$param_name    = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type          = isset( $settings['type'] ) ? $settings['type'] : '';
	$values        = isset( $settings['value'] ) ? $settings['value'] : array();
	$is_responsive = isset( $settings['responsive'] ) ? $settings['responsive'] : false;
	$button_width  = isset( $settings['button_width'] ) ? $settings['button_width'] : '';

	$class = 'alpha-wpb-button-group';
	$attr  = '';

	if ( empty( $values ) ) {
		return;
	}

	if ( is_array( $value ) ) { // if std value does not exist
		$value = array_keys( $values )[0];
	}

	if ( '/' == $value ) {
		$value = '';
	}

	if ( $is_responsive ) {
		$class .= ' alpha-responsive-control';
		$attr  .= "data-width='xl'";

		if ( null == json_decode( $value, true ) ) {
			$value = array( 'xl' => $value );
		} else {
			$value = json_decode( $value, true );
		}
	}

	$keys = array_keys( $values[ array_keys( $values )[0] ] );
	if ( in_array( 'image', $keys ) ) {
		$class .= ' image-button';
	} elseif ( in_array( 'color', $keys ) ) {
		$class .= ' color-button';
	} elseif ( in_array( 'icon', $keys ) ) {
		$class .= ' icon-button';
	} elseif ( in_array( 'label', $keys ) ) {
		$class .= ' label-button';
	}

	$class .= ' ' . $value;

	$html  = '';
	$html .= '<div class="' . esc_attr( $class ) . '"' . ( $attr ? ' ' . $attr : '' ) . '>';

	$html .= '<ul class="options-wrapper">';
	foreach ( $values as $key => $options ) {
		$label  = '';
		$style  = '';
		$o_keys = array_keys( $options );

		if ( in_array( 'image', $o_keys ) ) {
			$label = '<img src="' . esc_url( $options['image'] ) . '" />';
		} elseif ( in_array( 'color', $o_keys ) ) {
			$style = 'background-color: ' . esc_attr( $options['color'] );
		} elseif ( in_array( 'icon', $o_keys ) ) {
			$label = '<i class="' . esc_attr( $options['icon'] ) . '"></i>';
		} elseif ( in_array( 'label', $o_keys ) ) {
			$label = esc_html( $options['label'] );
		} else {
			$label = esc_html( $options['title'] );
		}

		if ( $button_width ) {
			$style .= 'width: ' . $button_width . 'px;';
		}

		$html .= '<li attr-value="' . esc_attr( $key ) . '"' . ( ( is_array( $value ) ? $value['xl'] : $value ) == $key ? ' class="active"' : '' ) . ' title="' . esc_attr( $options['title'] ) . '"' . ( $style ? ' style="' . $style . '"' : '' ) . '>' . $label . '</li>';
	}
	$html .= '</ul>';

	if ( $is_responsive ) {
		ob_start();
		?>
		<div class="alpha-responsive-dropdown">
			<a class="alpha-responsive-toggle" title="Toggle Responsive Option"><i class="vc-composer-icon vc-c-icon-layout_default"></i></a>
			<ul class="alpha-responsive-span">
				<li data-width="xl" title=">= 1200px" class="active" data-size="100%"><i class="vc-composer-icon vc-c-icon-layout_default"></i></li>
				<li data-width="lg" title=">= 992px" data-size="1024px"><i class="vc-composer-icon vc-c-icon-layout_landscape-tablets"></i></li>
				<li data-width="md" title=">= 768px" data-size="768px"><i class="vc-composer-icon vc-c-icon-layout_portrait-tablets"></i></li>
				<li data-width="sm" title=">= 576px" data-size="480px"><i class="vc-composer-icon vc-c-icon-layout_landscape-smartphones"></i></li>
				<li data-width="xs" title="< 576px" data-size="320px"><i class="vc-composer-icon vc-c-icon-layout_portrait-smartphones"></i></li>
			</ul>
		</div>
		<?php
		$html .= ob_get_clean();
	}

	$html .= '</div>';
	$html .= '<input type="hidden" name="' . esc_attr( $param_name ) . '" class="wpb_vc_param_value ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $type ) . '_field" value=\'' . ( is_array( $value ) ? json_encode( $value ) : $value ) . '\' />';
	return $html;
}

vc_add_shortcode_param( 'alpha_button_group', 'alpha_button_group_callback', ALPHA_CORE_PLUGINS_URI . '/wpb/params/button-group.js' );
