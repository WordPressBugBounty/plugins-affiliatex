<?php

namespace AffiliateX\Helpers;

defined('ABSPATH') or exit;

/**
 * Migration Helper Class.
 *
 * @since 1.3.8
 * @package AffiliateX\Helpers
 */
class MigrationHelper {
    
    /**
     * Get all Elementor posts.
     */
    public static function get_elementor_posts($meta_query = array()) {
        $args = array(
            'post_type' => array('page', 'post', 'elementor_library'),
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array_merge(
                array(
                    array(
                        'key' => '_elementor_data',
                        'compare' => 'EXISTS'
                    ),
                ),
                $meta_query
            ),
        );

        $posts = get_posts($args);
        
        foreach ($posts as $post) {
            $post->elementor_data = self::get_elementor_data($post->ID);
        }

        return $posts;
    }

    
    /**
     * Get the Elementor data for a post.
     */
    public static function get_elementor_data( $post_id ) {
        $elementor_data = get_post_meta($post_id, '_elementor_data', true);
                
        if (empty($elementor_data) || $elementor_data === '[]') {
            return false;
        }

        $elements_data = json_decode($elementor_data, true);
        
        if (!is_array($elements_data)) {
            return false;
        }

        return $elements_data;
    }

    
    /**
     * Update the Elementor data for a post.
     */
    public static function update_elementor_data( $post_id, $elementor_data ) {
        return update_post_meta($post_id, '_elementor_data', wp_slash(json_encode($elementor_data)));
    }

    
    /**
     * Migrate elementor widget attribute
     * 
     * @param array $elements
     * @param array $configs Migration configs [
     *  [
     *      'widget_type' => 'widget_type',
     *      'attribute_name' => 'attribute_name',
     *      'old_value' => 'old_value',
     *      'new_value' => 'new_value'
     *  ]
     * ]
     * @param bool $has_changes
     * @return array
     */
    public static function migrate_elementor_widget_attribute( $elements, $configs, &$has_changes ) {
        if (!is_array($elements)) {
            return $elements;
        }

        foreach ($elements as &$element) {
            foreach ($configs as $config) {
                if (isset($element['widgetType']) && $element['widgetType'] === $config['widget_type']) {
                    if (isset($element['settings'][$config['attribute_name']]) && $element['settings'][$config['attribute_name']] === $config['old_value']) {
                        $element['settings'][$config['attribute_name']] = $config['new_value'];
                        $has_changes = true;
                    }
                }
            }
            
            if (isset($element['elements']) && is_array($element['elements'])) {
                $element['elements'] = self::migrate_elementor_widget_attribute($element['elements'], $configs, $has_changes);
            }
        }
        
        return $elements;
    }

    /**
     * Migrate elementor widget attributes in posts
     * 
     * @param array $migration_configs Migration configs [
     *  [
     *      'widget_type' => 'widget_type',
     *      'attribute_name' => 'attribute_name',
     *      'old_value' => 'old_value',
     *      'new_value' => 'new_value'
     *  ]
     * ]
     * @return void
     */
    public static function migrate_elementor_posts_widget_attributes($elementor_posts, $migration_configs) {
        if (!empty($elementor_posts)) {
            foreach ($elementor_posts as $post) {
                try {
                    if (!$post->elementor_data) {
                        continue;
                    }

                    $has_changes = false;

                    $updated_elements = self::migrate_elementor_widget_attribute($post->elementor_data, $migration_configs, $has_changes);

                    if ($has_changes) {
                        self::update_elementor_data($post->ID, $updated_elements);
                    }

                } catch (\Exception $e) {
                    error_log("AffiliateX Migration Error for post ID {$post->ID}: " . $e->getMessage());
                }
            }
        }
    }

    
    /**
     * Get all posts that use Gutenberg blocks
     */
    public static function get_gutenberg_posts( $query = '' ) {
        $args = array(
            'post_type' => array('page', 'post'),
            'post_status' => 'publish',
            'posts_per_page' => -1,
            's' => $query,
            'search_columns' => array('post_content')
        );

        return get_posts($args);
    }

    
    /**
     * Migrate Gutenberg block attribute in post content
     */
    public static function migrate_gutenberg_block_attribute($content, $configs, &$has_changes) {
        $blocks = parse_blocks($content);
        
        $updated_blocks = self::update_block_attribute($blocks, $configs, $has_changes);
        
        return serialize_blocks($updated_blocks);
    }

    
    /**
     * Recursively update Gutenberg blocks
     * 
     * @param array $blocks
     * @param array $configs Migration configs [
     *  [
     *      'block_name' => 'block_name',
     *      'attribute_name' => 'attribute_name',
     *      'old_value' => 'old_value',
     *      'new_value' => 'new_value'
     *  ]
     * ]
     * @param bool $has_changes
     * @return array
     */
    private static function update_block_attribute($blocks, $configs, &$has_changes) {
        if (!is_array($blocks)) {
            return $blocks;
        }

        foreach ($blocks as &$block) {
            foreach ($configs as $config) {
                if (isset($block['blockName']) && $block['blockName'] === $config['block_name']) {
                    if (isset($block['attrs'][$config['attribute_name']]) && 
                        $block['attrs'][$config['attribute_name']] === $config['old_value']) {
                        
                        $block['attrs'][$config['attribute_name']] = $config['new_value'];
                        $has_changes = true;
                    }
                }
            }
            
            // Recursively check inner blocks
            if (isset($block['innerBlocks']) && is_array($block['innerBlocks'])) {
                $block['innerBlocks'] = self::update_block_attribute($block['innerBlocks'], $configs, $has_changes);
            }
        }
        
        return $blocks;
    }


    /**
     * Update Gutenberg data
     */
    public static function update_gutenberg_data($post, $content) {
        return wp_update_post([
            'ID' => $post->ID,
            'post_content' => $content
        ]);
    }

    /**
     * Migrate Gutenberg block attributes in posts
     * 
     * @param array $migration_configs Migration configs [
     *  [
     *      'block_name' => 'block_name',
     *      'attribute_name' => 'attribute_name',
     *      'old_value' => 'old_value',
     *      'new_value' => 'new_value'
     *  ]
     * ]
     * @return void
     */
    public static function migrate_gutenberg_posts_block_attributes($gutenberg_posts, $migration_configs) {
        if (!empty($gutenberg_posts)) {
            foreach ($gutenberg_posts as $post) {
                try {
                    $post_content = $post->post_content;
                    
                    if (empty($post_content)) {
                        continue;
                    }

                    $has_changes = false;
                    $updated_content = MigrationHelper::migrate_gutenberg_block_attribute($post_content, $migration_configs, $has_changes);

                    if ($has_changes) {
                        MigrationHelper::update_gutenberg_data($post, $updated_content);
                    }

                } catch (\Exception $e) {
                    error_log("AffiliateX Block Migration Error for post ID {$post->ID}: " . $e->getMessage());
                }
            }
        }
    }
}