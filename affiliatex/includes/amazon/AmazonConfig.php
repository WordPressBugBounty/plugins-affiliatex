<?php

namespace AffiliateX\Amazon;

defined( 'ABSPATH' ) || exit;

use AffiliateX\Helpers\OptionsHelper;

/**
 * This class manages and output Amazon configurations
 *
 * @package AffiliateX
 */
class AmazonConfig {

	use OptionsHelper;

	/**
	 * Amazon API key
	 *
	 * @var string
	 */
	public $api_key;

	/**
	 * Amazon API secret
	 *
	 * @var string
	 */
	public $api_secret;

	/**
	 * Amazon Tracking ID
	 *
	 * @var string
	 */
	public $tracking_id;

	/**
	 * Amazon Country code
	 *
	 * @var string
	 */
	public $country;

	/**
	 * Amazon Host
	 *
	 * @var string
	 */
	public $host;

	/**
	 * Amazon Region
	 *
	 * @var string
	 */
	public $region;

	/**
	 * Amazon Country Name/Title
	 *
	 * @var string
	 */
	public $country_name;

	/**
	 * Amazon Language
	 *
	 * @var string
	 */
	public $language;

	/**
	 * Amazon Update Frequency
	 *
	 * @var string
	 */
	public $update_frequency;

	/**
	 * Use External API instead of Amazon API
	 *
	 * @var bool
	 */
	public $use_external_api;

	/**
	 * Geolocation enabled
	 *
	 * @var bool
	 */
	private $geolocation_enabled;

	/**
	 * Geolocation countries
	 *
	 * @var array
	 */
	private $geolocation_countries;

	/**
	 * Amazon Countries
	 *
	 * @var array
	 */
	public $countries = array(
		'au' => array(
			'label'           => 'Australia',
			'host'            => 'webservices.amazon.com.au',
			'region'          => 'us-west-2',
			'languages'       => array( 'en_AU' ),
			'currency'        => 'AUD',
			'currency_symbol' => 'A$',
			'domain'          => 'amazon.com.au',
		),
		'be' => array(
			'label'           => 'Belgium',
			'host'            => 'webservices.amazon.com.be',
			'region'          => 'eu-west-1',
			'languages'       => array( 'fr_BE', 'nl_BE', 'en_GB' ),
			'currency'        => 'EUR',
			'currency_symbol' => '€',
			'domain'          => 'amazon.com.be',
		),
		'br' => array(
			'label'           => 'Brazil',
			'host'            => 'webservices.amazon.com.br',
			'region'          => 'us-east-1',
			'languages'       => array( 'pt_BR' ),
			'currency'        => 'BRL',
			'currency_symbol' => 'R$',
			'domain'          => 'amazon.com.br',
		),
		'ca' => array(
			'label'           => 'Canada',
			'host'            => 'webservices.amazon.ca',
			'region'          => 'us-east-1',
			'languages'       => array( 'en_CA', 'fr_CA' ),
			'currency'        => 'CAD',
			'currency_symbol' => 'C$',
			'domain'          => 'amazon.ca',
		),
		'eg' => array(
			'label'           => 'Egypt',
			'host'            => 'webservices.amazon.eg',
			'region'          => 'eu-west-1',
			'languages'       => array( 'en_AE', 'ar_AE' ),
			'currency'        => 'EGP',
			'currency_symbol' => 'ج.م',
			'domain'          => 'amazon.eg',
		),
		'fr' => array(
			'label'           => 'France',
			'host'            => 'webservices.amazon.fr',
			'region'          => 'eu-west-1',
			'languages'       => array( 'fr_FR' ),
			'currency'        => 'EUR',
			'currency_symbol' => '€',
			'domain'          => 'amazon.fr',
		),
		'de' => array(
			'label'           => 'Germany',
			'host'            => 'webservices.amazon.de',
			'region'          => 'eu-west-1',
			'languages'       => array( 'de_DE', 'cs_CZ', 'en_GB', 'nl_NL', 'pl_PL', 'tr_TR' ),
			'currency'        => 'EUR',
			'currency_symbol' => '€',
			'domain'          => 'amazon.de',
		),
		'in' => array(
			'label'           => 'India',
			'host'            => 'webservices.amazon.in',
			'region'          => 'eu-west-1',
			'languages'       => array( 'en_IN', 'hi_IN', 'kn_IN', 'ml_IN', 'ta_IN', 'te_IN' ),
			'currency'        => 'INR',
			'currency_symbol' => '₹',
			'domain'          => 'amazon.in',
		),
		'it' => array(
			'label'           => 'Italy',
			'host'            => 'webservices.amazon.it',
			'region'          => 'eu-west-1',
			'languages'       => array( 'it_IT' ),
			'currency'        => 'EUR',
			'currency_symbol' => '€',
			'domain'          => 'amazon.it',
		),
		'jp' => array(
			'label'           => 'Japan',
			'host'            => 'webservices.amazon.co.jp',
			'region'          => 'eu-west-2',
			'languages'       => array( 'ja_JP', 'en_US', 'zh_CN' ),
			'currency'        => 'JPY',
			'currency_symbol' => '¥',
			'domain'          => 'amazon.co.jp',
		),
		'mx' => array(
			'label'           => 'Mexico',
			'host'            => 'webservices.amazon.com.mx',
			'region'          => 'us-east-1',
			'languages'       => array( 'es_MX' ),
			'currency'        => 'MXN',
			'currency_symbol' => 'MX$',
			'domain'          => 'amazon.com.mx',
		),
		'nl' => array(
			'label'           => 'Netherlands',
			'host'            => 'webservices.amazon.nl',
			'region'          => 'eu-west-1',
			'languages'       => array( 'nl_NL' ),
			'currency'        => 'EUR',
			'currency_symbol' => '€',
			'domain'          => 'amazon.nl',
		),
		'pl' => array(
			'label'           => 'Poland',
			'host'            => 'webservices.amazon.pl',
			'region'          => 'eu-west-1',
			'languages'       => array( 'pl_PL', 'en_GB' ),
			'currency'        => 'PLN',
			'currency_symbol' => 'zł',
			'domain'          => 'amazon.pl',
		),
		'sg' => array(
			'label'           => 'Singapore',
			'host'            => 'webservices.amazon.sg',
			'region'          => 'us-east-2',
			'languages'       => array( 'en_SG' ),
			'currency'        => 'SGD',
			'currency_symbol' => 'S$',
			'domain'          => 'amazon.sg',
		),
		'sa' => array(
			'label'           => 'Saudi Arabia',
			'host'            => 'webservices.amazon.sa',
			'region'          => 'eu-west-1',
			'languages'       => array( 'en_AE', 'ar_AE' ),
			'currency'        => 'SAR',
			'currency_symbol' => 'ر.س',
			'domain'          => 'amazon.sa',
		),
		'es' => array(
			'label'           => 'Spain',
			'host'            => 'webservices.amazon.es',
			'region'          => 'eu-west-1',
			'languages'       => array( 'es_ES' ),
			'currency'        => 'EUR',
			'currency_symbol' => '€',
			'domain'          => 'amazon.es',
		),
		'se' => array(
			'label'           => 'Sweden',
			'host'            => 'webservices.amazon.se',
			'region'          => 'eu-west-1',
			'languages'       => array( 'sv_SE' ),
			'currency'        => 'SEK',
			'currency_symbol' => 'kr',
			'domain'          => 'amazon.se',
		),
		'tr' => array(
			'label'           => 'Turkey',
			'host'            => 'webservices.amazon.com.tr',
			'region'          => 'eu-west-1',
			'languages'       => array( 'tr_TR' ),
			'currency'        => 'TRY',
			'currency_symbol' => '₺',
			'domain'          => 'amazon.com.tr',
		),
		'ae' => array(
			'label'           => 'United Arab Emirates',
			'host'            => 'webservices.amazon.ae',
			'region'          => 'eu-west-1',
			'languages'       => array( 'en_AE', 'ar_AE' ),
			'currency'        => 'AED',
			'currency_symbol' => 'د.إ',
			'domain'          => 'amazon.ae',
		),
		'uk' => array(
			'label'           => 'United Kingdom',
			'host'            => 'webservices.amazon.co.uk',
			'region'          => 'eu-west-1',
			'languages'       => array( 'en_GB' ),
			'currency'        => 'GBP',
			'currency_symbol' => '£',
			'domain'          => 'amazon.co.uk',
		),
		'us' => array(
			'label'           => 'United States',
			'host'            => 'webservices.amazon.com',
			'region'          => 'us-east-1',
			'languages'       => array( 'en_US', 'de_DE', 'es_US', 'ko_KR', 'pt_BR', 'zh_CN', 'zh_TW' ),
			'currency'        => 'USD',
			'currency_symbol' => '$',
			'domain'          => 'amazon.com',
		),
	);

	public function __construct() {
		$configs      = $this->get_option( 'amazon_settings' );
		$country_data = $this->get_country_data( $configs['country'] ?? 'us' );

		$this->api_key               = isset( $configs['api_key'] ) ? $configs['api_key'] : '';
		$this->api_secret            = isset( $configs['api_secret'] ) ? $configs['api_secret'] : '';
		$this->tracking_id           = isset( $configs['tracking_id'] ) ? $configs['tracking_id'] : '';
		$this->country               = isset( $configs['country'] ) ? $configs['country'] : 'us';
		$this->host                  = $country_data['host'];
		$this->region                = $country_data['region'];
		$this->country_name          = $country_data['label'];
		$this->language              = isset( $configs['language'] ) ? $configs['language'] : 'en_US';
		$this->update_frequency      = isset( $configs['update_frequency'] ) ? $configs['update_frequency'] : 'daily';
		$this->use_external_api      = isset( $configs['external_api'] ) ? (bool) $configs['external_api'] : false;
		$this->geolocation_enabled   = isset( $configs['geolocation'] ) ? (bool) $configs['geolocation'] : false;
		$this->geolocation_countries = isset( $configs['geolocation_countries'] ) ? $configs['geolocation_countries'] : array();
	}

	/**
	 * Returns the country set in amazon config.
	 */
	public function get_country(): string {
		return $this->country;
	}

	/**
	 * Get country data: region, host, country name
	 *
	 * @param string $country
	 * @return array
	 */
	protected function get_country_data( string $country ): array {
		return isset( $this->countries[ $country ] ) ? $this->countries[ $country ] : $this->countries['us'];
	}

	/**
	 * Determines if Amazon connection is active
	 *
	 * @return boolean
	 */
	public function is_active(): bool {
		return $this->is_settings_empty() === false && $this->get_option( 'amazon_activated', false );
	}

	/**
	 * Determines if settings are empty
	 *
	 * @return boolean
	 */
	public function is_settings_empty(): bool {
		if ( $this->is_using_external_api() ) {
			return empty( $this->country ) || empty( $this->tracking_id );
		}

		return empty( $this->api_key ) || empty( $this->api_secret ) || empty( $this->country ) || empty( $this->tracking_id );
	}

	/**
	 * Check if using external API instead of Amazon API
	 *
	 * @return boolean
	 */
	public function is_using_external_api(): bool {
		return $this->use_external_api === true;
	}

	/**
	 * Check if using Amazon API directly
	 *
	 * @return boolean
	 */
	public function is_using_amazon_api(): bool {
		return ! $this->is_using_external_api();
	}

	/**
	 * Static helper to check if settings indicate external API usage
	 *
	 * @param array $settings
	 * @return boolean
	 */
	public static function is_external_api_from_settings( array $settings ): bool {
		return isset( $settings['external_api'] ) && $settings['external_api'] === true;
	}

	/**
	 * Check if geolocation is enabled
	 *
	 * @return boolean
	 */
	public function is_geolocation_enabled(): bool {
		return $this->geolocation_enabled === true;
	}

	/**
	 * Get geolocation countries
	 *
	 * @return array
	 */
	public function get_geolocation_countries(): array {
		return $this->geolocation_countries;
	}

	/**
	 * Get Amazon language
	 *
	 * @return string
	 */
	public function get_language(): string {
		return $this->language;
	}

	/**
	 * Get currency symbol for current country
	 *
	 * @return string
	 */
	public function get_currency_symbol(): string {
		$country_data = $this->get_country_data( $this->country );
		return $country_data['currency_symbol'] ?? '$';
	}

	/**
	 * Get currency code for current country
	 *
	 * @return string
	 */
	public function get_currency_code(): string {
		$country_data = $this->get_country_data( $this->country );
		return $country_data['currency'] ?? 'USD';
	}

	/**
	 * Format price with correct currency symbol based on marketplace
	 *
	 * @param string $display_price The price string from API (e.g. "$29.99")
	 * @return string Correctly formatted price
	 */
	public function format_price_for_marketplace( string $display_price ): string {
		if ( empty( $display_price ) ) {
			return $display_price;
		}

		$correct_symbol = $this->get_currency_symbol();
		$numeric_value  = preg_replace( '/^[^\d]*/', '', $display_price );
		$numeric_value  = preg_replace( '/[^\d.,\s]*$/', '', $numeric_value );

		if ( empty( $numeric_value ) ) {
			return $display_price;
		}

		return $correct_symbol . $numeric_value;
	}

	/**
	 * Get currency symbol for specific country
	 *
	 * @param string $country
	 * @return string
	 */
	public function get_currency_symbol_for_country( string $country ): string {
		$country_data = $this->get_country_data( $country );
		return $country_data['currency_symbol'] ?? '$';
	}

	/**
	 * Transform Amazon URL to use country-specific domain
	 *
	 * @param string $url The original Amazon URL (e.g. from DetailPageURL)
	 * @param string $country The country code to use (optional)
	 * @return string URL with country-specific domain
	 */
	public function transform_url_for_marketplace( string $url, string $country = null ): string {
		if ( empty( $url ) ) {
			return $url;
		}

		$country = $country ?? $this->country;

		$target_domain = $this->countries[ $country ]['domain'] ?? 'amazon.com';

		return preg_replace(
			'/https?:\/\/(www\.)?amazon\.[a-z]+(?:\.[a-z]+)?/',
			'https://' . $target_domain,
			$url
		);
	}
}
