<?php

namespace AffiliateX\Elementor\Widgets;

use AffiliateX\Blocks\AffiliateX_Customization_Helper;
use AffiliateX\Helpers\Elementor\WidgetHelper;

defined('ABSPATH') || exit;

/**
 * AffiliateX Elementor Base Class
 *
 * @package AffiliateX
 */
abstract class ElementorBase extends \Elementor\Widget_Base
{
    /**
     * Elementor Flag.
     *
     * @var bool
     */
    protected const IS_ELEMENTOR = true;

    /**
     * Get widget slug to define assets
     *
     * @return string
     */
    abstract protected function get_slug(): string;

    /**
     * PHP template path
     *
     * @var string
     */
    protected $template_path = AFFILIATEX_PLUGIN_DIR . '/templates/blocks/';


    /**
     * Get widget child slugs, applicable for nested widgets only
     *
     * @return array
     */
    protected function get_child_slugs(): array
    {
        return [];
    }

    public function get_categories(): array
    {
        return ['affiliatex'];
    }

    public function get_name(): string
    {
        return 'affiliatex-' . $this->get_slug();
    }

    public function get_script_depends()
    {
        return ['fontawesome-all'];
    }

    public function get_style_depends()
    {
        $handle = sprintf('affiliatex-%s-style', $this->get_slug());

        wp_register_style(
            'affiliatex-public',
            plugin_dir_url(AFFILIATEX_PLUGIN_FILE) . 'build/publicCSS.css',
            [],
            AFFILIATEX_VERSION
        );

        wp_register_style(
            $handle,
            AFFILIATEX_PLUGIN_URL . sprintf('build/blocks/%s/style-index.css', $this->get_slug()),
            [],
            AFFILIATEX_VERSION
        );

        if (!empty($this->get_child_slugs())) {
            foreach ($this->get_child_slugs() as $child_slug) {
                $child_handle = sprintf('affiliatex-%s-style', $child_slug);
                wp_register_style(
                    $child_handle,
                    AFFILIATEX_PLUGIN_URL . sprintf('build/blocks/%s/style-index.css', $child_slug),
                    [],
                    AFFILIATEX_VERSION
                );
            }
        }

        return array_merge(
            [
                $handle,
                'fontawesome',
                'affiliatex-public'
            ],
            array_map(function ($child_slug) {
                return sprintf('affiliatex-%s-style', $child_slug);
            }, $this->get_child_slugs())
        );
    }

    protected function get_fields(): array
    {
        return [];
    }

    protected function get_elements(): array
    {
        return [];
    }

    protected function parse_attributes(array $attributes): array
    {
        $fields = $this->get_fields();
        $attributes = AffiliateX_Customization_Helper::apply_customizations($attributes);
        $attributes = wp_parse_args($attributes, $fields);
        $attributes['wrapper_class'] = WidgetHelper::get_wrapper_class($this->get_slug());

        return $attributes;
    }

    /**
     * Get frontend template path
     *
     * @return string
     */
    public function get_template_path(): string
    {
        return $this->template_path . $this->get_slug() . '.php';
    }

    /**
     * Select element
     *
     * @param string|array $element
     * @return string
     */
    protected function select_element($element): string
    {
        if (is_string($element) && $element) {
            return sprintf('{{WRAPPER}} .%s', $this->get_elements()[$element] ?? '');
        } elseif (is_array($element) && 2 == count($element) && is_string($element[0]) && is_string($element[1])) {
            return $this->select_element($element[0]) . $element[1];
        }

        return '{{WRAPPER}} ';
    }

    /**
     * Returns Multiple element selectors combined in single string.
     * 
     * @param array $elements Element Selector defined in $this->get_elements().
     * @return string
     */
    protected function select_elements(array $elements): string
    {
        return implode(
            ',',
            array_map(
                fn ($element) => $this->select_element($element),
                $elements
            )
        );
    }
}
