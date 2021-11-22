<?php
if ( ! function_exists( 'alpha_get_wpb_design_controls' ) ) {
	function alpha_get_wpb_design_controls() {
		return array(
			array(
				'type'       => 'css_editor',
				'heading'    => esc_html__( 'CSS box', 'alpha-core' ),
				'param_name' => 'css',
				'group'      => esc_html__( 'Design Options', 'alpha-core' ),
			),
		);
	}
}
