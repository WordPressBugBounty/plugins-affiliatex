<?php
namespace AffiliateX\Elementor;

use AffiliateX\Elementor\Controls\TextControl;

/**
 * Widget Manager Class.
 * 
 * This class is responsible for registering the widgets for Elementor.
 * 
 * @package AffiliateX\Elementor
 * @since 1.0.0
 * @version 1.0.0
 */
class WidgetManager {
    /**
     * Widgets.
     * 
     * @var array
     */
    private $widgets = [];
    
    /**
     * Constructor.
     * 
     * @param array $widgets
     * @since 1.0.0
     * @version 1.0.0
     */
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

    /**
     * Register Widgets.
     * 
     * @param $widgets_manager
     * @since 1.0.0
     * @version 1.0.0
     */
    public function register_widgets($widgets_manager) {
        foreach ($this->widgets as $widget) {
            $widgets_manager->register(new $widget());
        }
    }

    /**
     * Add Elementor Widget Categories.
     * 
     * @param $elements_manager
     * @since 1.0.0
     * @version 1.0.0
     */
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

    /**
     * Enqueue Styles.
     * 
     * @since 1.0.0
     * @version 1.0.0
     */
    public function enqueue_styles() {
        // Enqueue compiled CSS for elementor editor control styles.
        wp_enqueue_style(
            'affiliatex-elementor-editor-style',
            AFFILIATEX_PLUGIN_URL . 'build/elementorEditorCSS.css',
            ['wp-components'],
            AFFILIATEX_VERSION
        );
    }

    /**
     * Register Font Awesome.
     * 
     * @since 1.0.0
     * @version 1.0.0
     */
    public function register_font_awesome() {
        wp_register_style(
            'fontawesome',
            AFFILIATEX_PLUGIN_URL . 'build/fontawesome.css',
            [],
            AFFILIATEX_VERSION
        );

        wp_register_script(
            'fontawesome-all',
            AFFILIATEX_PLUGIN_URL . 'build/fontawesome.js',
            [],
            AFFILIATEX_VERSION,
            true
        );
    }
} 