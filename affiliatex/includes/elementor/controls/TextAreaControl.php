<?php

namespace AffiliateX\Elementor\Controls;

use Elementor\Control_Textarea;
use Elementor\Modules\DynamicTags\Module as TagsModule;

class TextAreaControl extends Control_Textarea {

	public function get_type() {
		return 'affiliatex_textarea';
	}

	protected function get_default_settings() {
		return [
            'label_block' => true,
            'rows' => 4,
            'placeholder' => '',
            'ai' => [
                'active' => false,
                'type' => 'textarea',
            ],
            'dynamic' => [
                'categories' => [ TagsModule::TEXT_CATEGORY ],
            ],
            'amazon_button' => true,
            'repeater_name' => null,
            'inner_repeater_name' => null,
		];
	}

	public function content_template() {
		include AFFILIATEX_PLUGIN_DIR . '/templates/elementor/controls/textarea-content.php';
	}
}