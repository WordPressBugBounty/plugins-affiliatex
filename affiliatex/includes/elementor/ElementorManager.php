<?php
namespace AffiliateX\Elementor;

/**
 * Elementor Manager Class.
 * 
 * This class is responsible for enqueuing the assets for the Elementor editor.
 * 
 * @package AffiliateX\Elementor
 * @since 1.0.0
 * @version 1.0.0
 */
class ElementorManager {
    /**
     * Constructor.
     * 
     * @since 1.0.0
     * @version 1.0.0
     */
    public function __construct() {
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('elementor/icons_manager/additional_tabs', [$this, 'add_custom_icons_tab']);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_custom_icons_css']);
    }

    /**
     * Enqueue Assets.
     * 
     * @since 1.0.0
     * @version 1.0.0
     */
    public function enqueue_assets(){
        if (affx_is_elementor_editor()) {
            wp_enqueue_script(
                'affiliatex-elementor-editor',
                AFFILIATEX_PLUGIN_URL . '/build/elementorEditor.js',
                ['jquery', 'affiliatex'],
                AFFILIATEX_VERSION
            );
        }
    }

    /**
     * Add custom icons tab to Elementor icon picker
     */
    public function add_custom_icons_tab($tabs) {
        $tabs['affiliatex-icons'] = [
            'name' => 'affiliatex-icons',
            'label' => __('AffiliateX Icons', 'affiliatex'),
            'url' => AFFILIATEX_PLUGIN_URL . 'assets/css/custom-icons.css',
            'enqueue' => [AFFILIATEX_PLUGIN_URL . 'assets/css/custom-icons.css'],
            'prefix' => 'affx-',
            'displayPrefix' => 'affx',
            'labelIcon' => 'affx-button',
            'ver' => AFFILIATEX_VERSION,
            'fetchJson' => AFFILIATEX_PLUGIN_URL . 'assets/js/custom-icons.json',
            'native' => true,
        ];
        return $tabs;
    }

    /**
     * Enqueue custom icons CSS
     */
    public function enqueue_custom_icons_css() {
        wp_enqueue_style(
            'affiliatex-custom-icons',
            AFFILIATEX_PLUGIN_URL . 'assets/css/custom-icons.css',
            [],
            AFFILIATEX_VERSION
        );
    }
}