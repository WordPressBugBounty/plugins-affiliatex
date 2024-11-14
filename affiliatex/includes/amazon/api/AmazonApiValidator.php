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
        $result = $this->get_result();

        if($result === false){
            return false;
        }

        if(isset($result['Errors']) && count($result['Errors']) > 0){
            return false;
        }

        return true;
    }
}
