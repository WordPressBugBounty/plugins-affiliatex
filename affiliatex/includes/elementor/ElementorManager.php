<?php
namespace AffiliateX\Elementor;

class ElementorManager {
    private $widgets = [];

    public function __construct($widgets = []) {
        $this->widgets = $widgets;

        // Register widgets
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        
        // Register category
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);

        // Enqueue main styles
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_styles']);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_styles']);

        // Register Font Awesome
        add_action('wp_enqueue_scripts', [$this, 'register_font_awesome']);
    }

    public function register_widgets($widgets_manager) {
        foreach ($this->widgets as $widget) {
            $widgets_manager->register(new $widget());
        }
    }

    public function add_elementor_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'affiliatex',
            [
                'title' => __('AffiliateX', 'affiliatex'),
                'icon' => 'fa fa-plug',
                'active' => true,
                'position' => 1
            ]
        );
    }

    public function enqueue_styles() {
        // Enqueue the main compiled CSS file
        wp_enqueue_style(
            'affiliatex-blocks-style',
            AFFILIATEX_PLUGIN_URL . 'build/style-index.css',
            [],
            AFFILIATEX_VERSION
        );
    }

    public function register_font_awesome() {
        wp_register_style(
            'fontawesome',
            AFFILIATEX_PLUGIN_URL . 'assets/dist/fontawesome/css/all.min.css',
            [],
            AFFILIATEX_VERSION
        );

        wp_register_script(
            'fontawesome-all',
            AFFILIATEX_PLUGIN_URL . 'assets/dist/fontawesome/js/all.min.js',
            [],
            AFFILIATEX_VERSION,
            true
        );
    }
} 