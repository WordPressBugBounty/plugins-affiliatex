<?php

namespace AffiliateX\Migration;

defined('ABSPATH') || exit;

use AffiliateX\Migration\Migrations\RemoveNoticeLayout3;

/**
 * Migration Manager Class
 * 
 * Provides migration utilities for AffiliateX
 * 
 * @since 1.3.8
 * @package AffiliateX\Migration
 */
class MigrationManager
{
    public function __construct()
    {
        add_action('init', [$this, 'run_migrations']);
    }

    /**
     * Run migrations sequentially.
     */
    public function run_migrations() {        
        try {
            $migrations = [
                RemoveNoticeLayout3::class,
            ];
            
            foreach ($migrations as $migration_class) {
                if (class_exists($migration_class)) {
                    $migration_class::execute();
                }
            }
        }
        catch (\Exception $e) {
            error_log('AffiliateX Migration failed: ' . $e->getMessage());
        }
    }
}

new MigrationManager();
