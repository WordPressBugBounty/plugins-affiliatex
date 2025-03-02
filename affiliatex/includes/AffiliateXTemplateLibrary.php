<?php
/**
 * Template Library Handler
 *
 * @package AffiliateX
 */

if (!defined('ABSPATH')) {
    exit;
}

class AffiliateXTemplateLibrary {
    /**
     * The single instance of the class.
     */
    protected static $instance = null;

    /**
     * Option name for storing templates
     */
    const TEMPLATE_OPTION_KEY = 'affiliatex_template_library';

    /**
     * Domain for template library
     */
    const TEMPLATE_LIBRARY_DOMAIN = 'https://affiliatexblocks.com';

    /**
     * Main Instance.
     */
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor.
     */
    public function __construct() {
        add_action('init', array($this, 'schedule_template_update'));
        add_action('affiliatex_daily_template_update', array($this, 'update_template_library'));
        add_action('wp_ajax_nopriv_get_template_library', array($this, 'get_template_library'));
        add_action('wp_ajax_get_template_library', array($this, 'get_template_library'));
        
        // Check if templates exist, if not fetch them immediately
        if (empty(get_option(self::TEMPLATE_OPTION_KEY))) {
            $this->update_template_library();
        }
    }

    /**
     * Schedule daily template update
     */
    public function schedule_template_update() {
        if (!wp_next_scheduled('affiliatex_daily_template_update')) {
            wp_schedule_event(time(), 'daily', 'affiliatex_daily_template_update');
        }
    }

    /**
     * Update template library from remote source
     */
    public function update_template_library() {
        $response = wp_remote_get(self::TEMPLATE_LIBRARY_DOMAIN . '/template-library.json');

        if (is_wp_error($response)) {
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        if (empty($body)) {
            return false;
        }

        $data = json_decode($body, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            update_option(self::TEMPLATE_OPTION_KEY, $data);
            return true;
        }

        return false;
    }

    /**
     * Ajax handler for getting template library
     */
    public function get_template_library() {
        check_ajax_referer('affiliatex_ajax_nonce', 'nonce');

        $templates = get_option(self::TEMPLATE_OPTION_KEY, array());
        
        if (empty($templates)) {
            // If no templates in database, try to fetch them
            $this->update_template_library();
            $templates = get_option(self::TEMPLATE_OPTION_KEY, array());
        }

        wp_send_json_success($templates);
    }
}

AffiliateXTemplateLibrary::instance();
