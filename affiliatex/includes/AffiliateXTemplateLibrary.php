<?php
/**
 * Template Library Handler
 *
 * @package AffiliateX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Template Library Handler
 *
 * @package AffiliateX
 */
class AffiliateXTemplateLibrary {
	/**
	 * The single instance of the class.
	 *
	 * @var AffiliateXTemplateLibrary|null
	 */
	protected static $instance = null;

	/**
	 * Option name for storing templates
	 */
	const TEMPLATE_OPTION_KEY = 'affiliatex_template_library';

	/**
	 * Option name for storing Elementor templates
	 */
	const ELEMENTOR_TEMPLATE_OPTION_KEY = 'affiliatex_elementor_template_library';

	/**
	 * Domain for template library
	 */
	const TEMPLATE_LIBRARY_DOMAIN = 'https://affiliatexblocks.com';

	/**
	 * Transient key to store template auto fetch cooldown flag.
	 */
	const AUTOFETCH_TRANSIENT_KEY = 'affiliatex_template_auto_fetch_cooldown';

	/**
	 * Main Instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'schedule_template_update' ) );
		add_action( 'init', array( $this, 'maybe_fetch_missing_templates' ) );
		add_action( 'affiliatex_daily_template_update', array( $this, 'update_template_library' ) );
		add_action( 'wp_ajax_nopriv_get_template_library', array( $this, 'get_template_library' ) );
		add_action( 'wp_ajax_get_template_library', array( $this, 'get_template_library' ) );

		// Elementor template endpoints
		add_action( 'wp_ajax_get_elementor_template_library', array( $this, 'get_elementor_template_library' ) );
	}

	/**
	 * Check if templates exist, if not fetch them immediately (rate-limited to once per hour).
	 */
	public function maybe_fetch_missing_templates() {
		$recently_fetched = get_transient( self::AUTOFETCH_TRANSIENT_KEY );

		if ( $recently_fetched ) {
			return;
		}

		if ( empty( get_option( self::TEMPLATE_OPTION_KEY ) ) ) {
			$this->update_template_library();
		}

		if ( empty( get_option( self::ELEMENTOR_TEMPLATE_OPTION_KEY ) ) ) {
			$this->update_elementor_template_library();
		}

		set_transient( self::AUTOFETCH_TRANSIENT_KEY, true, HOUR_IN_SECONDS );
	}

	/**
	 * Schedule daily template update
	 */
	public function schedule_template_update() {
		if ( ! wp_next_scheduled( 'affiliatex_daily_template_update' ) ) {
			wp_schedule_event( time(), 'daily', 'affiliatex_daily_template_update' );
		}
	}

	/**
	 * Update template library from remote source
	 */
	public function update_template_library() {
		return $this->update_templates_from_remote( '/template-library.json', self::TEMPLATE_OPTION_KEY );
	}

	/**
	 * Ajax handler for getting template library
	 */
	public function get_template_library() {
		$this->get_templates_ajax( self::TEMPLATE_OPTION_KEY, 'update_template_library' );
	}

	/**
	 * Update Elementor template library from remote source
	 */
	public function update_elementor_template_library() {
		return $this->update_templates_from_remote( '/elementor-template-library.json', self::ELEMENTOR_TEMPLATE_OPTION_KEY );
	}

	/**
	 * Ajax handler for getting Elementor template library
	 */
	public function get_elementor_template_library() {
		$this->get_templates_ajax( self::ELEMENTOR_TEMPLATE_OPTION_KEY, 'update_elementor_template_library' );
	}

	/**
	 * Generic method to handle template library AJAX requests
	 *
	 * @param string $option_key The option key to retrieve templates from
	 * @param string $update_method The method name to call if templates are empty
	 */
	private function get_templates_ajax( $option_key, $update_method ) {
		check_ajax_referer( 'affiliatex_ajax_nonce', 'nonce' );

		$templates = get_option( $option_key, array() );

		if ( empty( $templates ) ) {
			// If no templates in database, try to fetch them
			$this->$update_method();
			$templates = get_option( $option_key, array() );
		}

		wp_send_json_success( $templates );
	}

	/**
	 * Generic method to update templates from remote source
	 *
	 * @param string $json_file The JSON file path on the remote server
	 * @param string $option_key The option key to store templates
	 * @return bool True on success, false on failure
	 */
	private function update_templates_from_remote( $json_file, $option_key ) {
		$response = wp_remote_get( self::TEMPLATE_LIBRARY_DOMAIN . $json_file );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
		if ( empty( $body ) ) {
			return false;
		}

		$data = json_decode( $body, true );

		if ( json_last_error() === JSON_ERROR_NONE ) {
			update_option( $option_key, $data );
			return true;
		}

		return false;
	}

	/**
	 * Check if Elementor templates exist
	 */
	public function has_elementor_templates() {
		$templates = get_option( self::ELEMENTOR_TEMPLATE_OPTION_KEY, array() );
		return ! empty( $templates );
	}
}

AffiliateXTemplateLibrary::instance();
