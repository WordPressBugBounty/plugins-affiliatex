<?php

namespace AffiliateX\Amazon\Admin;

defined('ABSPATH') or exit;

use AffiliateX\Amazon\AmazonConfig;
use AffiliateX\Amazon\Api\AmazonApiValidator;
use Exception;

/**
 * Amazon settings handler
 * 
 * @package AffiliateX
 */
class AmazonSettings{
    use \AffiliateX\Helpers\ResponseHelper;
    use \AffiliateX\Helpers\OptionsHelper;
    
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * Register WP api endpoints
     *
     * @return void
     */
    public function register_routes() : void
    {
        register_rest_route('affiliatex/v1/api', '/save-amazon-settings', [
            'methods' => 'POST',
            'callback' => [ $this, 'save_settings' ],
            'permission_callback' => function(){
                return current_user_can('manage_options');
            }
        ]);

        register_rest_route('affiliatex/v1/api', '/get-amazon-settings', [
            'methods' => 'GET',
            'callback' => [$this, 'get_settings'],
            'permission_callback' => function(){
                return current_user_can('manage_options');
            }
        ]);

        register_rest_route('affiliatex/v1/api', '/get-amazon-countries', [
            'methods' => 'GET',
            'callback' => [$this, 'get_countries'],
            'permission_callback' => function(){
                return current_user_can('manage_options');
            }
        ]);

        register_rest_route('affiliatex/v1/api', '/get-amazon-status', [
            'methods' => 'GET',
            'callback' => [$this, 'get_amazon_status'],
            'permission_callback' => function(){
                return current_user_can('manage_options');
            }
        ]);
    }

    /**
     * Sanitize settings fields
     *
     * @param array $params
     * @return array
     */
    private function sanitize_settings_fields(array $params) : array
    {
        $attributes = [];

        $attributes['api_key'] = isset($params['api_key']) && !empty($params['api_key']) ? sanitize_text_field($params['api_key']) : '';
        $attributes['api_secret'] = isset($params['api_secret']) && !empty($params['api_secret']) ? sanitize_text_field($params['api_secret']) : '';
        $attributes['country'] = isset($params['country']) && !empty($params['country']) ? sanitize_text_field($params['country']) : '';
        $attributes['tracking_id'] = isset($params['tracking_id']) && !empty($params['tracking_id']) ? sanitize_text_field($params['tracking_id']) : '';   

        // Check if any field has a value
        $has_any_value = !empty($attributes['api_key']) || 
                        !empty($attributes['api_secret']) || 
                        !empty($attributes['tracking_id']);

        // Only validate if at least one field has a value
        if ($has_any_value) {
            if(empty($attributes['api_key'])){
                $this->send_json_error(__('API key is required', 'affiliatex'));
            }

            if(empty($attributes['api_secret'])){
                $this->send_json_error(__('API secret is required', 'affiliatex'));
            }

            if(empty($attributes['country'])){
                $this->send_json_error(__('Country is required', 'affiliatex'));
            }

            if(empty($attributes['tracking_id'])){
                $this->send_json_error(__('Tracking ID is required', 'affiliatex'));
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
    public function save_settings(\WP_REST_Request $request) : void
    {
        try{
            $params = json_decode($request->get_body(), true);        
            $attributes = $this->sanitize_settings_fields($params);
            
            // Check if all fields are empty
            $all_empty = empty($attributes['api_key']) && 
                        empty($attributes['api_secret']) && 
                        empty($attributes['tracking_id']);
;

            $this->set_option('amazon_settings', $attributes);
            
            // Only validate with Amazon API if at least one field has a value
            if (!$all_empty) {
                $validator = new AmazonApiValidator();

                if(!$validator->is_credentials_valid()){
                    $errors = $validator->get_errors();

                    $this->set_option('amazon_activated', false);
                    $this->send_json_error(__('Invalid credentials', 'affiliatex'), [
                        'invalid_api_key' => true,
                        'errors' => $errors
                    ]);
                }

                $this->set_option('amazon_activated', true);
            } else {
                // If all fields are empty, deactivate Amazon integration
                $this->set_option('amazon_activated', false);
            }

            $this->send_json_success(__('Settings saved successfully', 'affiliatex'));
        }catch(Exception $e){
            $this->send_json_error($e->getMessage());
        }
    }

    /**
     * Get Amazon settings
     *
     * @return void
     */
    public function get_settings() : void
    {
        try{
            $defaults = [
                'api_key' => '',
                'api_secret' => '',
                'tracking_id' => '',
                'country' => 'us'
            ];

            $settings = $this->get_option('amazon_settings', []);
            $settings = wp_parse_args($settings, $defaults);

            $this->send_json_plain_success($settings);

        }catch(Exception $e){
            $this->send_json_error($e->getMessage());
        }
    }

    /**
     * Get Amazon countries through API request
     *
     * @return void
     */
    public function get_countries() : void
    {
        try{
            $configs = new AmazonConfig();

            $this->send_json_plain_success($configs->countries);

        }catch(Exception $e){
            $this->send_json_error($e->getMessage());
        }
    }

    /**
     * Responses to API if Amazon is activated or not
     *
     * @return void
     */
    public function get_amazon_status() : void
    {
        try{
            $configs = new AmazonConfig();
            $errors = [];

            if(!$configs->is_active()){
                $validator = new AmazonApiValidator();
                $errors = $validator->get_errors();

                if(!$validator->is_credentials_valid()){
                    $this->send_json_plain_success([
                        'activated' => $configs->is_active(),
                        'empty_settings' => $configs->is_settings_empty(),
                        'errors' => $errors
                    ]);
                }

            }

            $this->send_json_plain_success(
                [
                    'activated' => $configs->is_active(),
                    'empty_settings' => $configs->is_settings_empty(),
                    'errors' => $errors
                ]
            );
        }catch(Exception $e){
            $this->send_json_error($e->getMessage());
        }
    }
}
