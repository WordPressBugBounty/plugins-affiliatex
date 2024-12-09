<?php

namespace AffiliateX\Amazon\Api;

defined( 'ABSPATH' ) or exit;

/**
 * Amazon API credential validator
 * 
 * @package AffiliateX
 */
class AmazonApiValidator extends AmazonApiBase
{
    /**
     * Stores API response
     *
     * @var Array|Boolean
     */
    private $result;

    protected function get_path(): string
    {
        return '/paapi5/searchitems';
    }

    protected function get_params(): array
    {
        return [
            "Keywords" => "Shoes",
        ];
    }

    protected function get_target(): string
    {
        return 'SearchItems';
    }

    /**
     * Check if credentials are valid, checks API keys and secret
     *
     * @return boolean
     */
    public function is_credentials_valid() : bool
    {
        $this->result = $this->get_result();

        if($this->result === false){
            return false;
        }

        if(isset($this->result['Errors']) && count($this->result['Errors']) > 0){
            return false;
        }

        return true;
    }

    /**
     * Get errors from API response
     *
     * @return array|bool
     */
    public function get_errors()
    {
        if(!isset($this->result['Errors']) && is_array($this->result['Errors']) && count($this->result['Errors']) === 0){
            return false;
        }

        return isset($this->result['Errors']) ? $this->result['Errors'] : [];
    }
}
