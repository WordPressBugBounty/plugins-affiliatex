<?php

namespace AffiliateX\Elementor\Controls;

use Elementor\Control_Text;

class TextControl extends Control_Text {

	public function get_type() {
		return 'affiliatex_text';
	}

	protected function get_default_settings() {
		return [
            'label_block' => true,
            'amazon_button' => true,
            'repeater_name' => null,
            'inner_repeater_name' => null,
		];
	}

	public function content_template() {
		include AFFILIATEX_PLUGIN_DIR . '/templates/elementor/controls/text-content.php';
	}
}
