<?php

namespace AffiliateX\Amazon\Admin;

defined( 'ABSPATH' ) || exit;

use AffiliateX\Amazon\AmazonConfig;
use AffiliateX\Amazon\Api\AmazonApiValidator;
use Exception;
use WP_REST_Request;

/**
 * Amazon settings handler
 *
 * @package AffiliateX
 */
class AmazonSettings {
	use \AffiliateX\Helpers\ResponseHelper;
	use \AffiliateX\Helpers\OptionsHelper;

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register WP api endpoints
	 *
	 * @return void
	 */
	public function register_routes(): void {
		register_rest_route(
			'affiliatex/v1/api',
			'/save-amazon-settings',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'save_settings' ),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			)
		);

		register_rest_route(
			'affiliatex/v1/api',
			'/get-amazon-settings',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_settings' ),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			)
		);

		register_rest_route(
			'affiliatex/v1/api',
			'/get-amazon-countries',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_countries' ),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			)
		);

		register_rest_route(
			'affiliatex/v1/api',
			'/get-amazon-status',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_amazon_status' ),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			)
		);

		register_rest_route(
			'affiliatex/v1/api',
			'/get-usage-stats',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_usage_stats' ),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			)
		);
	}

	/**
	 * Sanitize settings fields
	 *
	 * @param array $params
	 * @return array
	 */
	private function sanitize_settings_fields( array $params ): array {
		$attributes = array();

		$attributes['external_api'] = isset( $params['external_api'] ) ? (bool) $params['external_api'] : false;

		// Handle API keys based on external_api setting
		if ( AmazonConfig::is_external_api_from_settings( $attributes ) ) {
			// When using external API, save whatever is provided (even empty values)
			$attributes['api_key']    = isset( $params['api_key'] ) ? sanitize_text_field( $params['api_key'] ) : '';
			$attributes['api_secret'] = isset( $params['api_secret'] ) ? sanitize_text_field( $params['api_secret'] ) : '';
		} else {
			// When using Amazon API, only save if provided and not empty
			$attributes['api_key']    = isset( $params['api_key'] ) && ! empty( $params['api_key'] ) ? sanitize_text_field( $params['api_key'] ) : '';
			$attributes['api_secret'] = isset( $params['api_secret'] ) && ! empty( $params['api_secret'] ) ? sanitize_text_field( $params['api_secret'] ) : '';
		}

		$attributes['country']               = isset( $params['country'] ) && ! empty( $params['country'] ) ? sanitize_text_field( $params['country'] ) : '';
		$attributes['tracking_id']           = isset( $params['tracking_id'] ) && ! empty( $params['tracking_id'] ) ? sanitize_text_field( $params['tracking_id'] ) : '';
		$attributes['language']              = isset( $params['language'] ) && ! empty( $params['language'] ) ? sanitize_text_field( $params['language'] ) : '';
		$attributes['update_frequency']      = isset( $params['update_frequency'] ) ? sanitize_text_field( $params['update_frequency'] ) : '';
		$attributes['geolocation']           = isset( $params['geolocation'] ) ? (bool) $params['geolocation'] : false;
		$attributes['geolocation_countries'] = isset( $params['geolocation_countries'] ) ? array_map( 'sanitize_text_field', $params['geolocation_countries'] ) : array();

		$has_any_value = ! empty( $attributes['api_key'] ) ||
						! empty( $attributes['api_secret'] ) ||
						! empty( $attributes['tracking_id'] );

		if ( AmazonConfig::is_external_api_from_settings( $attributes ) ) {
			if ( empty( $attributes['tracking_id'] ) ) {
				$this->send_json_error( __( 'Tracking ID is required', 'affiliatex' ) );
			}

			if ( empty( $attributes['country'] ) ) {
				$this->send_json_error( __( 'Country is required', 'affiliatex' ) );
			}
		} elseif ( $has_any_value ) {
			if ( empty( $attributes['api_key'] ) ) {
				$this->send_json_error( __( 'API key is required', 'affiliatex' ) );
			}

			if ( empty( $attributes['api_secret'] ) ) {
				$this->send_json_error( __( 'API secret is required', 'affiliatex' ) );
			}

			if ( empty( $attributes['country'] ) ) {
				$this->send_json_error( __( 'Country is required', 'affiliatex' ) );
			}

			if ( empty( $attributes['tracking_id'] ) ) {
				$this->send_json_error( __( 'Tracking ID is required', 'affiliatex' ) );
			}

			if ( $attributes['geolocation'] ) {
				if ( empty( $attributes['geolocation_countries'] ) ) {
					$this->send_json_error( __( 'Please setup at least one store for geolocation or disable it.', 'affiliatex' ) );
				} else {
					foreach ( $attributes['geolocation_countries'] as $tracking_id ) {
						if ( empty( $tracking_id ) ) {
							$this->send_json_error( __( 'Tracking ID is required for all geolocation stores.', 'affiliatex' ) );
						}
					}
				}
			}
		}

		return $attributes;
	}

	/**
	 * Save Amazon settings from API response
	 *
	 * @param \WP_REST_Request $request
	 * @return void
	 */
	public function save_settings( \WP_REST_Request $request ): void {
		try {
			$params     = json_decode( $request->get_body(), true );
			$attributes = $this->sanitize_settings_fields( $params );

			$all_empty = empty( $attributes['api_key'] ) &&
						empty( $attributes['api_secret'] ) &&
						empty( $attributes['tracking_id'] );

			$this->set_option( 'amazon_settings', $attributes );

			if ( ! $all_empty ) {
				if ( AmazonConfig::is_external_api_from_settings( $attributes ) ) {
					if ( ! empty( $attributes['tracking_id'] ) && ! empty( $attributes['country'] ) ) {
						$this->set_option( 'amazon_activated', true );
					} else {
						$this->set_option( 'amazon_activated', false );
					}
				} else {
					$validator = new AmazonApiValidator();

					if ( ! $validator->is_credentials_valid() ) {
						$errors = $validator->get_errors();

						$this->set_option( 'amazon_activated', false );
						$this->send_json_error(
							__( 'Invalid credentials', 'affiliatex' ),
							array(
								'invalid_api_key' => true,
								'errors'          => $errors,
							)
						);
					}

					$this->set_option( 'amazon_activated', true );
				}
			} else {
				$this->set_option( 'amazon_activated', false );
			}

			$this->send_json_success( __( 'Settings saved successfully', 'affiliatex' ) );
		} catch ( Exception $e ) {
			$this->send_json_error( $e->getMessage() );
		}
	}

	/**
	 * Get Amazon settings
	 *
	 * @return void
	 */
	public function get_settings(): void {
		try {
			$defaults = array(
				'api_key'               => '',
				'api_secret'            => '',
				'tracking_id'           => '',
				'country'               => 'us',
				'language'              => 'en_US',
				'update_frequency'      => 'daily',
				'external_api'          => false,
				'geolocation'           => false,
				'geolocation_countries' => array(),
			);

			$settings = $this->get_option( 'amazon_settings', array() );
			$settings = wp_parse_args( $settings, $defaults );

			$this->send_json_plain_success( $settings );

		} catch ( Exception $e ) {
			$this->send_json_error( $e->getMessage() );
		}
	}

	/**
	 * Get Amazon countries through API request
	 *
	 * @return void
	 */
	public function get_countries(): void {
		try {
			$configs = new AmazonConfig();

			$this->send_json_plain_success( $configs->countries );

		} catch ( Exception $e ) {
			$this->send_json_error( $e->getMessage() );
		}
	}

	/**
	 * Responses to API if Amazon is activated or not
	 *
	 * @return void
	 */
	public function get_amazon_status(): void {
		try {
			$configs = new AmazonConfig();
			$errors  = array();

			if ( ! $configs->is_active() ) {
				$validator = new AmazonApiValidator();
				$errors    = $validator->get_errors();

				if ( ! $validator->is_credentials_valid() ) {
					$this->send_json_plain_success(
						array(
							'activated'      => $configs->is_active(),
							'empty_settings' => $configs->is_settings_empty(),
							'errors'         => $errors,
						)
					);
				}
			}

			$this->send_json_plain_success(
				array(
					'activated'      => $configs->is_active(),
					'empty_settings' => $configs->is_settings_empty(),
					'errors'         => $errors,
				)
			);
		} catch ( Exception $e ) {
			$this->send_json_error( $e->getMessage() );
		}
	}

	/**
	 * Get usage statistics with fallback values
	 *
	 * @return void
	 */
	public function get_usage_stats(): void {
		try {
			$license_key = '';
			$site_url    = wp_parse_url( site_url(), PHP_URL_HOST );

			if ( function_exists( 'affiliatex_fs' ) && affiliatex_fs()->is_registered() ) {
				$license = affiliatex_fs()->_get_license();
				if ( is_object( $license ) ) {
					$license_key = $license->secret_key;
				}
			}

			if ( empty( $license_key ) ) {
				$this->send_json_plain_success(
					array(
						'show_usage' => true,
						'error'      => true,
						'message'    => __( 'No valid license found', 'affiliatex' ),
					)
				);
				return;
			}

			$response = wp_remote_post(
				AFFILIATEX_EXTERNAL_API_ENDPOINT . '/wp-json/affiliatex-proxy/v1/usage-stats',
				array(
					'headers'   => array(
						'Content-Type' => 'application/json',
					),
					'body'      => wp_json_encode(
						array(
							'license_key' => $license_key,
							'domain'      => $site_url,
						)
					),
					'timeout'   => 30,
					'sslverify' => false,
				)
			);

			if ( is_wp_error( $response ) ) {
				$this->send_json_plain_success(
					array(
						'show_usage' => true,
						'error'      => true,
						'message'    => __( 'Failed to fetch usage statistics', 'affiliatex' ),
					)
				);
				return;
			}

			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body, true );

			if ( ! $data || ! is_array( $data ) ) {
				$this->send_json_plain_success(
					array(
						'show_usage' => true,
						'error'      => true,
						'message'    => __( 'Invalid response from usage API', 'affiliatex' ),
					)
				);
				return;
			}

			if ( isset( $data['code'] ) && $data['code'] === 'rate_limit_exceeded' ) {
				$this->send_json_plain_success(
					array(
						'show_usage'          => true,
						'rate_limit_exceeded' => true,
						'limit'               => $data['data']['limit'] ?? 0,
						'reset_at'            => $data['data']['reset_at'] ?? '',
						'reset_timestamp'     => $data['data']['reset_timestamp'] ?? 0,
					)
				);
				return;
			}

			// Ensure we have valid numeric values, with defaults that make sense
			$limit     = isset( $data['limit'] ) && is_numeric( $data['limit'] ) ? (int) $data['limit'] : 3000;
			$used      = isset( $data['used'] ) && is_numeric( $data['used'] ) ? (int) $data['used'] : 0;
			$remaining = isset( $data['remaining'] ) && is_numeric( $data['remaining'] ) ? (int) $data['remaining'] : $limit - $used;

			$reset_date = new \DateTime( 'first day of next month' );
			$reset_date->setTime( 0, 0, 0 );
			$fallback_reset_at        = $reset_date->format( 'Y-m-d\TH:i:s\Z' );
			$fallback_reset_timestamp = $reset_date->getTimestamp();

			$this->send_json_plain_success(
				array(
					'show_usage'      => true,
					'limit'           => $limit,
					'used'            => $used,
					'remaining'       => $remaining,
					'reset_at'        => $data['reset_at'] ?? $fallback_reset_at,
					'reset_timestamp' => $data['reset_timestamp'] ?? $fallback_reset_timestamp,
				)
			);

		} catch ( Exception $e ) {
			$this->send_json_error( $e->getMessage() );
		}
	}
}
