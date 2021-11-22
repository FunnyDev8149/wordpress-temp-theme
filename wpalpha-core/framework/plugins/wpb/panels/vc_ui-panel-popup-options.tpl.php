<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$popup_options = get_post_meta( get_the_ID(), 'popup_options', true );
if ( $popup_options && ! is_array( $popup_options ) ) {
	$popup_options = json_decode( $popup_options, true );
}
if ( ! $popup_options ) {
	$popup_options = array(
		'width'               => '600',
		'h_pos'               => 'center',
		'v_pos'               => 'center',
		'border'              => '',
		'top'                 => '',
		'right'               => '',
		'bottom'              => '',
		'left'                => '',
		'popup_animation'     => '',
		'popup_anim_duration' => 400,
	);
}
?>

<div class="vc_ui-font-open-sans vc_ui-panel-window vc_media-xs vc_ui-panel vc_ui-alpha-panel" data-vc-panel=".vc_ui-panel-header-header" data-vc-ui-element="panel-alpha-popup-options" id="vc_ui-panel-alpha-popup-options">
	<div class="vc_ui-panel-window-inner">
		<?php
		vc_include_template(
			'editors/popups/vc_ui-header.tpl.php',
			array(
				'title'            => ALPHA_DISPLAY_NAME . esc_html__( ' Popup Options', 'js_composer' ),
				'controls'         => array( 'minimize', 'close' ),
				'header_css_class' => 'vc_ui-alpha-popup-options-header-container',
				'content_template' => '',
			)
		);
		?>
		<div class="vc_ui-panel-content-container">
			<div class="vc_ui-panel-content vc_properties-list vc_edit_form_elements" data-vc-ui-element="panel-content">
				<div class="vc_row">
					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Popup Width', 'alpha-core' ); ?></div>
						<div class="edit_form_line">
							<input name="popup_width" class="wpb-textinput" type="number" value="<?php echo esc_attr( $popup_options['width'] ); ?>" id="vc_popup-width-field" placeholder="<?php esc_attr_e( 'Default value is 600px.', 'alpha-core' ); ?>">
						</div>
					</div>

					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Horizontal Position', 'alpha-core' ); ?></div>
						<div class="edit_form_line">
							<select name="popup_h_pos" class="wpb-textinput" type="number" id="vc_popup-h_pos-field">
								<option value="flex-start" <?php selected( 'flex-start' == $popup_options['h_pos'] ); ?>><?php esc_html_e( 'Left', 'alpha-core' ); ?></option>
								<option value="center" <?php selected( 'center' == $popup_options['h_pos'] ); ?>><?php esc_html_e( 'Center', 'alpha-core' ); ?></option>
								<option value="flex-end" <?php selected( 'flex-end' == $popup_options['h_pos'] ); ?>><?php esc_html_e( 'Right', 'alpha-core' ); ?></option>
							</select>
						</div>
					</div>
					
					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Vertical Position', 'alpha-core' ); ?></div>
						<div class="edit_form_line">
							<select name="popup_v_pos" class="wpb-textinput" type="number" id="vc_popup-v_pos-field">
								<option value="flex-start" <?php selected( 'flex-start' == $popup_options['v_pos'] ); ?>><?php esc_html_e( 'Top', 'alpha-core' ); ?></option>
								<option value="center" <?php selected( 'center' == $popup_options['v_pos'] ); ?>><?php esc_html_e( 'Middle', 'alpha-core' ); ?></option>
								<option value="flex-end" <?php selected( 'flex-end' == $popup_options['v_pos'] ); ?>><?php esc_html_e( 'Bottom', 'alpha-core' ); ?></option>
							</select>
						</div>
					</div>
					
					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Border Radius', 'alpha-core' ); ?></div>
						<div class="edit_form_line">
							<input name="popup_border" class="wpb-textinput" type="number" value="<?php echo esc_attr( $popup_options['border'] ); ?>" id="vc_popup-border-field" placeholder="<?php esc_attr_e( '0px', 'alpha-core' ); ?>">
						</div>
					</div>

					<div class="vc_col-xs-12 vc_column wpb_edit_form_elements wpb_el_type_alpha_dimension">
						<div class="wpb_element_label"><?php esc_html_e( 'Margin', 'alpha-core' ); ?></div>
						<div class="edit_form_line">
							<div class="alpha-wpb-dimension-container">
								<div class="alpha-wpb-dimension-wrap top">
									<input type="text" class="wpb-textinput alpha-wpb-dimension" name="popup_margin_top" value="<?php echo esc_attr( $popup_options['top'] ); ?>" id="vc_popup-margin-top-field">
									<label><?php esc_html_e( 'Top', 'alpha-core' ); ?></label>
								</div>
								<div class="alpha-wpb-dimension-wrap right">
									<input type="text" class="wpb-textinput alpha-wpb-dimension" name="popup_margin_right" value="<?php echo esc_attr( $popup_options['right'] ); ?>" id="vc_popup-margin-right-field">
									<label><?php esc_html_e( 'Right', 'alpha-core' ); ?></label>
								</div>
								<div class="alpha-wpb-dimension-wrap bottom">
									<input type="text" class="wpb-textinput alpha-wpb-dimension" name="popup_margin_bottom" value="<?php echo esc_attr( $popup_options['bottom'] ); ?>" id="vc_popup-margin-bottom-field">
									<label><?php esc_html_e( 'Bottom', 'alpha-core' ); ?></label>
								</div>
								<div class="alpha-wpb-dimension-wrap left">
									<input type="text" class="wpb-textinput alpha-wpb-dimension" name="popup_margin_left" value="<?php echo esc_attr( $popup_options['left'] ); ?>" id="vc_popup-margin-left-field">
									<label><?php esc_html_e( 'Left', 'alpha-core' ); ?></label>
								</div>
							</div>
						</div>
					</div>

					<?php $animations = alpha_get_animations( 'in' ); ?>
					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Popup Animation', 'alpha-core' ); ?></div>
						<div class="edit_form_line">
							<select name="popup_animation" class="wpb-textinput" type="number" id="vc_popup-animation-field">

								<?php foreach ( $animations as $key => $value ) { ?>
									<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key == $popup_options['popup_animation'] ); ?>><?php echo esc_html( $value ); ?></option>
								<?php } ?>

							</select>
						</div>
					</div>

					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Animation Duration (ms)', 'alpha-core' ); ?></div>
						<div class="edit_form_line">
							<input name="popup_anim_duration" class="wpb-textinput" type="number" value="<?php echo esc_attr( $popup_options['popup_anim_duration'] ); ?>" id="vc_popup-anim-duration-field">
						</div>
					</div>

					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label" style="font-weight: 400; max-width: 400px;"><?php echo sprintf( esc_html__( 'Please add two classes - "show-popup popup-id-ID" to any elements you want to show this popup on click. %1$se.g) show-popup popup-id-725%2$s', 'alpha-core' ), '<b>', '</b>' ); ?></div>
					</div>
				</div>
			</div>
		</div>
		<!-- param window footer-->
		<?php
		vc_include_template(
			'editors/popups/vc_ui-footer.tpl.php',
			array(
				'controls' => array(
					array(
						'name'        => 'save',
						'label'       => esc_html__( 'Save changes', 'js_composer' ),
						'css_classes' => 'vc_ui-button-fw',
						'style'       => 'action',
					),
				),
			)
		);
		?>
	</div>
</div>
