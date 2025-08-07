<?php

namespace AffiliateX\Amazon;

defined('ABSPATH') or exit;

use AffiliateX\Helpers\OptionsHelper;

/**
 * This class manages and output Amazon configurations
 * 
 * @package AffiliateX
 */
class AmazonConfig
{
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
     * Amazon Countries
     *
     * @var array
     */
    public $countries = [
        'au' => [
            'label' => 'Australia',
            'host' => 'webservices.amazon.com.au',
            'region' => 'us-west-2',
            'languages' => ['en_AU'],
            'currency' => 'AUD',
            'currency_symbol' => 'A$'
        ],
        'be' => [
            'label' => 'Belgium',
            'host' => 'webservices.amazon.be',
            'region' => 'eu-west-1',
            'languages' => ['fr_BE', 'nl_BE', 'en_GB'],
            'currency' => 'EUR',
            'currency_symbol' => '€'
        ],
        'br' => [
            'label' => 'Brazil',
            'host' => 'webservices.amazon.com.br',
            'region' => 'us-east-1',
            'languages' => ['pt_BR'],
            'currency' => 'BRL',
            'currency_symbol' => 'R$'
        ],
        'ca' => [
            'label' => 'Canada',
            'host' => 'webservices.amazon.ca',
            'region' => 'us-east-1',
            'languages' => ['en_CA', 'fr_CA'],
            'currency' => 'CAD',
            'currency_symbol' => 'C$'
        ],
        'eg' => [
            'label' => 'Egypt',
            'host' => 'webservices.amazon.eg',
            'region' => 'eu-west-1',
            'languages' => ['en_AE', 'ar_AE'],
            'currency' => 'EGP',
            'currency_symbol' => 'ج.م'
        ],
        'fr' => [
            'label' => 'France',
            'host' => 'webservices.amazon.fr',
            'region' => 'eu-west-1',
            'languages' => ['fr_FR'],
            'currency' => 'EUR',
            'currency_symbol' => '€'
        ],
        'de' => [
            'label' => 'Germany',
            'host' => 'webservices.amazon.de',
            'region' => 'eu-west-1',
            'languages' => ['de_DE', 'cs_CZ', 'en_GB', 'nl_NL', 'pl_PL', 'tr_TR'],
            'currency' => 'EUR',
            'currency_symbol' => '€'
        ],
        'in' => [
            'label' => 'India',
            'host' => 'webservices.amazon.in',
            'region' => 'eu-west-1',
            'languages' => ['en_IN', 'hi_IN', 'kn_IN', 'ml_IN', 'ta_IN', 'te_IN'],
            'currency' => 'INR',
            'currency_symbol' => '₹'
        ],
        'it' => [
            'label' => 'Italy',
            'host' => 'webservices.amazon.it',
            'region' => 'eu-west-1',
            'languages' => ['it_IT'],
            'currency' => 'EUR',
            'currency_symbol' => '€'
        ],
        'jp' => [
            'label' => 'Japan',
            'host' => 'webservices.amazon.co.jp',
            'region' => 'eu-west-2',
            'languages' => ['ja_JP', 'en_US', 'zh_CN'],
            'currency' => 'JPY',
            'currency_symbol' => '¥'
        ],
        'mx' => [
            'label' => 'Mexico',
            'host' => 'webservices.amazon.com.mx',
            'region' => 'us-east-1',
            'languages' => ['es_MX'],
            'currency' => 'MXN',
            'currency_symbol' => 'MX$'
        ],
        'nl' => [
            'label' => 'Netherlands',
            'host' => 'webservices.amazon.nl',
            'region' => 'eu-west-1',
            'languages' => ['nl_NL'],
            'currency' => 'EUR',
            'currency_symbol' => '€'
        ],
        'pl' => [
            'label' => 'Poland',
            'host' => 'webservices.amazon.pl',
            'region' => 'eu-west-1',
            'languages' => ['pl_PL', 'en_GB'],
            'currency' => 'PLN',
            'currency_symbol' => 'zł'
        ],
        'sg' => [
            'label' => 'Singapore',
            'host' => 'webservices.amazon.sg',
            'region' => 'us-east-2',
            'languages' => ['en_SG'],
            'currency' => 'SGD',
            'currency_symbol' => 'S$'
        ],
        'sa' => [
            'label' => 'Saudi Arabia',
            'host' => 'webservices.amazon.sa',
            'region' => 'eu-west-1',
            'languages' => ['en_AE', 'ar_AE'],
            'currency' => 'SAR',
            'currency_symbol' => 'ر.س'
        ],
        'es' => [
            'label' => 'Spain',
            'host' => 'webservices.amazon.es',
            'region' => 'eu-west-1',
            'languages' => ['es_ES'],
            'currency' => 'EUR',
            'currency_symbol' => '€'
        ],
        'se' => [
            'label' => 'Sweden',
            'host' => 'webservices.amazon.se',
            'region' => 'eu-west-1',
            'languages' => ['sv_SE'],
            'currency' => 'SEK',
            'currency_symbol' => 'kr'
        ],
        'tr' => [
            'label' => 'Turkey',
            'host' => 'webservices.amazon.com.tr',
            'region' => 'eu-west-1',
            'languages' => ['tr_TR'],
            'currency' => 'TRY',
            'currency_symbol' => '₺'
        ],
        'ae' => [
            'label' => 'United Arab Emirates',
            'host' => 'webservices.amazon.ae',
            'region' => 'eu-west-1',
            'languages' => ['en_AE', 'ar_AE'],
            'currency' => 'AED',
            'currency_symbol' => 'د.إ'
        ],
        'uk' => [
            'label' => 'United Kingdom',
            'host' => 'webservices.amazon.co.uk',
            'region' => 'eu-west-1',
            'languages' => ['en_GB'],
            'currency' => 'GBP',
            'currency_symbol' => '£'
        ],
        'us' => [
            'label' => 'United States',
            'host' => 'webservices.amazon.com',
            'region' => 'us-east-1',
            'languages' => ['en_US', 'de_DE', 'es_US', 'ko_KR', 'pt_BR', 'zh_CN', 'zh_TW'],
            'currency' => 'USD',
            'currency_symbol' => '$'
        ]
    ];

    public function __construct()
    {
        $configs = $this->get_option('amazon_settings');
        $country_data = $this->get_country_data($configs['country'] ?? 'us');
        
        $this->api_key = isset($configs['api_key']) ? $configs['api_key'] : '';
        $this->api_secret = isset($configs['api_secret']) ? $configs['api_secret'] : '';
        $this->tracking_id = isset($configs['tracking_id']) ? $configs['tracking_id'] : '';
        $this->country = isset($configs['country']) ? $configs['country'] : 'us';
        $this->host = $country_data['host'];
        $this->region = $country_data['region'];
        $this->country_name = $country_data['label'];
        $this->language = isset($configs['language']) ? $configs['language'] : 'en_US';
        $this->update_frequency = isset($configs['update_frequency']) ? $configs['update_frequency'] : 'daily';
        $this->use_external_api = isset($configs['external_api']) ? (bool) $configs['external_api'] : false;
    }

    /**
     * Get country data: region, host, country name
     *
     * @param string $country
     * @return array
     */
    protected function get_country_data(string $country) : array
    {
        return isset($this->countries[$country]) ? $this->countries[$country] : $this->countries['us'];
    }

    /**
     * Determines if Amazon connection is active
     *
     * @return boolean
     */
    public function is_active() : bool
    {
        return $this->is_settings_empty() === false && $this->get_option('amazon_activated', false);
    }

    /**
     * Determines if settings are empty
     *
     * @return boolean
     */
    public function is_settings_empty() : bool
    {
        if ($this->is_using_external_api()) {
            return empty($this->country) || empty($this->tracking_id);
        }
        
        return empty($this->api_key) || empty($this->api_secret) || empty($this->country) || empty($this->tracking_id);
    }

    /**
     * Check if using external API instead of Amazon API
     *
     * @return boolean
     */
    public function is_using_external_api() : bool
    {
        return $this->use_external_api === true;
    }

    /**
     * Check if using Amazon API directly
     *
     * @return boolean
     */
    public function is_using_amazon_api() : bool
    {
        return !$this->is_using_external_api();
    }

    /**
     * Static helper to check if settings indicate external API usage
     *
     * @param array $settings
     * @return boolean
     */
    public static function is_external_api_from_settings(array $settings) : bool
    {
        return isset($settings['external_api']) && $settings['external_api'] === true;
    }

    /**
     * Get Amazon language
     *
     * @return string
     */
    public function get_language() : string
    {
        return $this->language;
    }

    /**
     * Get currency symbol for current country
     *
     * @return string
     */
    public function get_currency_symbol() : string
    {
        $country_data = $this->get_country_data($this->country);
        return $country_data['currency_symbol'] ?? '$';
    }

    /**
     * Get currency code for current country
     *
     * @return string
     */
    public function get_currency_code() : string
    {
        $country_data = $this->get_country_data($this->country);
        return $country_data['currency'] ?? 'USD';
    }

    /**
     * Format price with correct currency symbol based on marketplace
     *
     * @param string $display_price The price string from API (e.g. "$29.99")
     * @return string Correctly formatted price
     */
    public function format_price_for_marketplace(string $display_price) : string
    {
        if (empty($display_price)) {
            return $display_price;
        }

        $correct_symbol = $this->get_currency_symbol();
        $numeric_value  = preg_replace('/^[^\d]*/', '', $display_price);
        $numeric_value  = preg_replace('/[^\d.,\s]*$/', '', $numeric_value);
        
        if (empty($numeric_value)) {
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
    public function get_currency_symbol_for_country(string $country) : string
    {
        $country_data = $this->get_country_data($country);
        return $country_data['currency_symbol'] ?? '$';
    }
}
