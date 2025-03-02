<?php

namespace AffiliateX;

use AffiliateX\Elementor\Widgets\ButtonWidget;

defined('ABSPATH') || exit;

/**
 * Elementor Widgets class
 *
 * @package AffiliateX
 */
class AffiliateXWidgets
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init()
    {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            return;
        }

        // Initialize Elementor integration
        require_once AFFILIATEX_PLUGIN_DIR . '/includes/elementor/ElementorManager.php';

        $widgets = [
            'ButtonWidget' => ButtonWidget::class,
        ];

        new \AffiliateX\Elementor\ElementorManager($widgets);
    }
}
