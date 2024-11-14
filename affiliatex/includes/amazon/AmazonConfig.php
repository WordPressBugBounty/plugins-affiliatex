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
     * Amazon Countries
     *
     * @var array
     */
    public $countries = [
        'au' => [
            'label' => 'Australia',
            'host' => 'webservices.amazon.com.au',
            'region' => 'us-west-2'
        ],
        'be' => [
            'label' => 'Belgium',
            'host' => 'webservices.amazon.be',
            'region' => 'eu-west-1'
        ],
        'br' => [
            'label' => 'Brazil',
            'host' => 'webservices.amazon.com.br',
            'region' => 'us-east-1'
        ],
        'ca' => [
            'label' => 'Canada',
            'host' => 'webservices.amazon.ca',
            'region' => 'us-east-1'
        ],
        'eg' => [
            'label' => 'Egypt',
            'host' => 'webservices.amazon.eg',
            'region' => 'eu-west-1'
        ],
        'fr' => [
            'label' => 'France',
            'host' => 'webservices.amazon.fr',
            'region' => 'eu-west-1'
        ],
        'de' => [
            'label' => 'Germany',
            'host' => 'webservices.amazon.de',
            'region' => 'eu-west-1'
        ],
        'in' => [
            'label' => 'India',
            'host' => 'webservices.amazon.in',
            'region' => 'eu-west-1'
        ],
        'it' => [
            'label' => 'Italy',
            'host' => 'webservices.amazon.it',
            'region' => 'eu-west-1'
        ],
        'jp' => [
            'label' => 'Japan',
            'host' => 'webservices.amazon.co.jp',
            'region' => 'eu-west-2'
        ],
        'mx' => [
            'label' => 'Mexico',
            'host' => 'webservices.amazon.com.mx',
            'region' => 'us-east-1'
        ],
        'nl' => [
            'label' => 'Netherlands',
            'host' => 'webservices.amazon.nl',
            'region' => 'eu-west-1'
        ],
        'pl' => [
            'label' => 'Poland',
            'host' => 'webservices.amazon.pl',
            'region' => 'eu-west-1'
        ],
        'sg' => [
            'label' => 'Singapore',
            'host' => 'webservices.amazon.sg',
            'region' => 'us-east-2'
        ],
        'sa' => [
            'label' => 'Saudi Arabia',
            'host' => 'webservices.amazon.sa',
            'region' => 'eu-west-1'
        ],
        'es' => [
            'label' => 'Spain',
            'host' => 'webservices.amazon.es',
            'region' => 'eu-west-1'
        ],
        'se' => [
            'label' => 'Sweden',
            'host' => 'webservices.amazon.se',
            'region' => 'eu-west-1'
        ],
        'tr' => [
            'label' => 'Turkey',
            'host' => 'webservices.amazon.com.tr',
            'region' => 'eu-west-1'
        ],
        'ae' => [
            'label' => 'United Arab Emirates',
            'host' => 'webservices.amazon.ae',
            'region' => 'eu-west-1'
        ],
        'uk' => [
            'label' => 'United Kingdom',
            'host' => 'webservices.amazon.co.uk',
            'region' => 'eu-west-1'
        ],
        'us' => [
            'label' => 'United States',
            'host' => 'webservices.amazon.com',
            'region' => 'us-east-1'
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
        return empty($this->api_key) || empty($this->api_secret) || empty($this->country) || empty($this->tracking_id);
    }
}
