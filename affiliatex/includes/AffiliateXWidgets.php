<?php

namespace AffiliateX;

use AffiliateX\Elementor\WidgetManager;
use AffiliateX\Elementor\Widgets\ButtonWidget;
use AffiliateX\Elementor\Widgets\CtaWidget;
use AffiliateX\Elementor\Widgets\ProsAndConsWidget;
use AffiliateX\Elementor\Widgets\NoticeWidget;
use AffiliateX\Elementor\Widgets\ProductComparisonWidget;
use AffiliateX\Elementor\Widgets\ProductTableWidget;
use AffiliateX\Elementor\Widgets\SingleProductWidget;
use AffiliateX\Elementor\Widgets\VerdictWidget;
use AffiliateX\Elementor\Widgets\SpecificationsWidget;
use AffiliateX\Elementor\Widgets\VersusLineWidget;

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
        add_action('elementor/init', [$this, 'init']);
    }

    public function init()
    {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            return;
        }

        // Initialize Elementor integration
        require_once AFFILIATEX_PLUGIN_DIR . '/includes/elementor/WidgetManager.php';

        $widgets = [
            'ButtonWidget' => ButtonWidget::class,
            'CtaWidget' => CtaWidget::class,
            'NoticeWidget' => NoticeWidget::class,
            'ProductComparisonWidget' => ProductComparisonWidget::class,
            'ProductTableWidget' => ProductTableWidget::class,
            'ProsAndConsWidget' => ProsAndConsWidget::class,
            'SingleProductWidget' => SingleProductWidget::class,
            'SpecificationsWidget' => SpecificationsWidget::class,
            'VerdictWidget' => VerdictWidget::class,
            'VersusLineWidget' => VersusLineWidget::class,
        ];

        new WidgetManager($widgets);
    }
}
