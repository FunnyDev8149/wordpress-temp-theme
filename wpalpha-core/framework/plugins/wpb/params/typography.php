<?php
/**
 * Alpha Typography Callback
 *
 * adds typography control for element option
 * follow below example of alpha_typography control
 *
 * array(
 *      'type'       => 'alpha_typography',
 *      'heading'    => __( 'Button Typography', 'alpha-core' ),
 *      'param_name' => 'btn_font',
 *      'group'      => 'Style',
 *      'selectors'  => array(
 *          '{{WRAPPER}}.btn'
 *      )
 * ),
 *
 * @since 1.0
 *
 * @param array $settings
 * @param string $value
 *
 * @return string
 */
function alpha_typography_callback( $settings, $value ) {
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$class      = 'alpha-wpb-typography-container';
	$typography = array(
		'family'  => 'Default',
		'variant' => 'Default',
	);
	if ( ! empty( $value ) ) {
		$typography = json_decode( $value, true );
	}

	$text_transform = array(
		'none'       => esc_html__( 'None', 'alpha-core' ),
		'lowercase'  => esc_html__( 'Lowercase', 'alpha-core' ),
		'uppercase'  => esc_html__( 'Uppercase', 'alpha-core' ),
		'capitalize' => esc_html__( 'Capitalize', 'alpha-core' ),
		'inherit'    => esc_html__( 'Inherit', 'alpha-core' ),
	);
	if ( class_exists( 'Kirki_Fonts' ) ) {
		$fonts   = Kirki_Fonts::get_google_fonts();
		$fonts[] = array(
			'label'    => 'Inherit',
			'variants' => array(
				'100',
				'100italic',
				'200',
				'200italic',
				'300',
				'300italic',
				'500',
				'500italic',
				'600',
				'600italic',
				'700',
				'700italic',
				'800',
				'800italic',
				'900',
				'900italic',
				'italic',
				'regular',
			),
		);
		$fonts[] = array(
			'label'    => 'Default',
			'variants' => array(
				'100',
				'100italic',
				'200',
				'200italic',
				'300',
				'300italic',
				'500',
				'500italic',
				'600',
				'600italic',
				'700',
				'700italic',
				'800',
				'800italic',
				'900',
				'900italic',
				'italic',
				'regular',
				'Default',
			),
		);
	}

	$html = '<div class="' . esc_attr( $class ) . '">';
	ob_start();
	?>

	<div class="alpha-wpb-typography-toggle">
		<p><?php echo esc_html__( ! empty( $typography ) ? 'Family: ' . $typography['family'] . ' | Variant: ' . $typography['variant'] . ' | Size: ' . $typography['size'] : 'Default' ); ?></p>
	</div>
	<div class="alpha-wpb-typography-controls" style="display: none;">
		<div class="alpha-wpb-typoraphy-form">
			<div class="wpb_element_label"><?php esc_html_e( 'Font Family', 'alpha-core' ); ?></div>
			<div class="alpha-vc-font-family-container">
				<select class="alpha-vc-font-family">
					<?php
					if ( ! empty( $fonts ) ) {
						foreach ( $fonts as $font_data ) :
							$is_active = false;
							if ( $font_data['label'] == $typography['family'] ) {
								$is_active = true;
								$variants  = $font_data['variants'];
							}
							?>
							<option value="<?php echo esc_attr( $font_data['label'] ); ?>"
								data-variants="<?php echo esc_attr( json_encode( $font_data['variants'] ) ); ?>"
								<?php echo esc_attr( $is_active ? 'selected' : '' ); ?>><?php echo esc_html( $font_data['label'] ); ?></option>
							<?php
						endforeach;
					}
					?>
				</select>
			</div>
		</div>
		<div class="alpha-wpb-typoraphy-form">
			<div class="wpb_element_label"><?php esc_html_e( 'Font Variants', 'alpha-core' ); ?></div>
			<div class="alpha-vc-font-variants-container">
				<select class="alpha-vc-font-variants">
					<?php
					if ( ! empty( $variants ) ) {
						foreach ( $variants as $variant ) :
							?>
							<option value="<?php echo esc_attr( $variant ); ?>"
							<?php echo esc_attr( $variant == $typography['variant'] ? 'selected' : '' ); ?>><?php echo esc_html( $variant ); ?></option>
							<?php
						endforeach;
					}
					?>
				</select>
			</div>
		</div>
		<div class="alpha-wpb-typoraphy-form cols-2">
			<div class="wpb_element_label"><?php esc_html_e( 'Font Size', 'alpha-core' ); ?></div>
			<div class="alpha-vc-font-size-container">
				<input type="string" name="font-size" class="alpha-vc-font-size" value="<?php echo esc_attr( $typography['size'] ); ?>" />
			</div>
		</div>
		<div class="alpha-wpb-typoraphy-form cols-2">
			<div class="wpb_element_label"><?php esc_html_e( 'Line Height', 'alpha-core' ); ?></div>
			<div class="alpha-vc-line-height-container">
				<input type="string" name="line-height" class="alpha-vc-line-height" value="<?php echo esc_attr( $typography['line_height'] ); ?>"  />
			</div>
		</div>
		<div class="alpha-wpb-typoraphy-form cols-2">
			<div class="wpb_element_label"><?php esc_html_e( 'Letter Spacing', 'alpha-core' ); ?></div>
			<div class="alpha-vc-letter-spacing-container">
				<input type="string" name="letter-spacing" class="alpha-vc-letter-spacing" value="<?php echo esc_attr( $typography['letter_spacing'] ); ?>"  />
			</div>
		</div>
		<div class="alpha-wpb-typoraphy-form cols-2">
			<div class="wpb_element_label"><?php esc_html_e( 'Text Transform', 'alpha-core' ); ?></div>
			<div class="alpha-vc-text-transform-container">
				<select type="string" name="text-transform" class="alpha-vc-text-transform">
					<?php
					foreach ( $text_transform as $key => $label ) {
						?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $key == $typography['text_transform'] ? 'selected' : '' ); ?>><?php echo esc_html( $label ); ?></option>
						<?php
					}
					?>
				</select>
			</div>
		</div>
	</div>

	<?php
	$html .= ob_get_clean();
	$html .= '</div>';
	$html .= '<input type="hidden" name="' . esc_attr( $param_name ) . '" class="wpb_vc_param_value ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $type ) . '_field" value="' . esc_attr( $value ) . '" ' . ' />';

	return $html;
}
vc_add_shortcode_param( 'alpha_typography', 'alpha_typography_callback', ALPHA_CORE_PLUGINS_URI . '/wpb/params/typography.js' );
