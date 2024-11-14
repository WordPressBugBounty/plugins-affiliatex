<?php

namespace AffiliateX\Amazon;

use AffiliateX\Amazon\Admin\AmazonSettings;

defined('ABSPATH') or exit;

/**
 * This controller is responsible to initialize all Amazon classes and methods
 * 
 * @package AffiliateX
 */
class AmazonController{
    public function __construct() {
        new AmazonSettings();
    }
}
