<?php

namespace AffiliateX\Blocks;

defined('ABSPATH') or exit;

/**
 * Base class for all Gutenberg blocks
 * 
 * @package AffiliateX
 */
abstract class BaseBlock
{
    /**
     * Blocks assets path
     *
     * @var string
     */
    protected $blocks_path = '/build/blocks/';

    /**
     * PHP template path
     *
     * @var string
     */
    protected $template_path = AFFILIATEX_PLUGIN_DIR . '/templates/blocks/';

    /**
     * Hook actions and initiates the block
     */
    public function __construct()
    {
        $this->blocks_path .= $this->get_slug() . '/';

        add_action('init', [$this, 'register_block']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_editor_assets']);
    }

    /**
     * Register block in Gutenberg
     *
     * @return void
     */
    public function register_block() : void
    {
        register_block_type_from_metadata(AFFILIATEX_PLUGIN_DIR . $this->blocks_path, [
            'render_callback' => [$this, 'render'],
        ]);
    }

    /**
     * Enqueue assets used for rendering the block in editor context
     *
     * @return void
     */
    public function enqueue_editor_assets() : void
    {
		wp_enqueue_script('affiliatex-blocks-' . $this->get_slug(), plugin_dir_url( AFFILIATEX_PLUGIN_FILE ) . $this->blocks_path . '/index.js', array('affiliatex'), AFFILIATEX_VERSION, true);
    }

    /**
     * Get frontend template path
     *
     * @return string
     */
    public function get_template_path() : string
    {
        return $this->template_path . $this->get_slug() . '.php';
    }

    protected function parse_attributes(array $attributes) : array
    {
        $fields = $this->get_fields();
        $attributes = AffiliateX_Customization_Helper::apply_customizations($attributes);
        $attributes = wp_parse_args($attributes, $fields);

        return $attributes;
    }

    /**
     * Get block slug to identify template, metadata and assets path
     *
     * @return string
     */
    abstract protected function get_slug() : string;

    /**
     * Extract block attributes and render from template
     *
     * @return string
     */
    abstract public function render(array $attributes, string $content) : string;

    /**
     * Returns array of fields, organized by key and default value pair (key => default_value)
     *
     * @return array
     */
    abstract protected function get_fields() : array;

    protected function enqueue_styles() {
        wp_enqueue_style(
            'affiliatex-button-style',
            AFFILIATEX_PLUGIN_URL . 'assets/css/buttons.css',
            [],
            AFFILIATEX_VERSION
        );
    }
}
