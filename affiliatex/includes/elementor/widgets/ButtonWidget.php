<?php

namespace AffiliateX\Elementor\Widgets;

use AffiliateX\Helpers\Elementor\WidgetHelper;
use AffiliateX\Traits\ButtonRenderTrait;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (! class_exists('\Elementor\Widget_Base')) {
    return;
}

class ButtonWidget extends ElementorBase
{
    use ButtonRenderTrait;

    protected function get_slug(): string
    {
        return 'buttons';
    }

    public function get_title()
    {
        return __('AffiliateX Button', 'affiliatex');
    }

    public function get_icon()
    {
        return 'affx-icon-button';
    }

    public function get_keywords()
    {
        return [
            "Buttons",
            "AffiliateX Buttons",
            "AffiliateX"
        ];
    }

    protected function register_controls()
    {
        WidgetHelper::generate_fields(
            $this,
            $this->get_button_elementor_fields(),
            'btn'
        );
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        echo $this->render_button($settings);
    }
}
