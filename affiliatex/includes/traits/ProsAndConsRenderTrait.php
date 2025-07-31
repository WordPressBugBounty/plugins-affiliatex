<?php

namespace AffiliateX\Traits;

defined('ABSPATH') || exit;

use AffiliateX\Helpers\ElementorHelper;
use AffiliateX\Helpers\AffiliateX_Helpers;
use AffiliateX\Helpers\Elementor\ChildHelper;

/**
 * This trait is a channel for share rendering methods between Gutenberg and Elementor
 *
 * @package AffiliateX
 */
trait ProsAndConsRenderTrait
{
    use ButtonRenderTrait;

    protected function get_slug(): string
    {
        return 'pros-and-cons';
    }

    protected function get_fields(): array
    {
        return [
            'block_id' => '',
            'prosTitle' => 'Pros',
            'consTitle' => 'Cons',
            'prosIcon' => [
                'name' => 'check-circle',
                'value' => 'far fa-circle-check'
            ],
            'consIcon' => [
                'name' => 'times-circle',
                'value' => 'far fa-circle-xmark'
            ],
            'titleTag1' => 'p',
            'layoutStyle' => 'layout-type-1',
            'prosListItems' => [],
            'consListItems' => [],
            'prosContent' => '',
            'consContent' => '',
            'prosContentType' => 'list',
            'consContentType' => 'list',
            'prosListType' => 'unordered',
            'consListType' => 'unordered',
            'prosListIcon' => [
                'name' => 'thumb-up-simple',
                'value' => 'far fa-thumbs-up'
            ],
            'consListIcon' => [
                'name' => 'thumb-down-simple',
                'value' => 'far fa-thumbs-down'
            ],
            'prosunorderedType' => 'icon',
            'consunorderedType' => 'icon',
            'prosIconStatus' => true,
            'consIconStatus' => true
        ];
    }

    /**
     * Parse attributes
     *
     * @param array $attributes
     * @return array
     */
    protected function parse_attributes(array $attributes): array
    {
        $defaults = $this->get_fields();

        return wp_parse_args($attributes, $defaults);
    }

    /**
     * Core render function
     *
     * @param array $attributes
     * @param string $content
     * @return string
     */
    public function render_template(array $attributes, $content = ''): string
    {
        $attributes = $this->parse_attributes($attributes);
        extract($attributes);

        if ( self::IS_ELEMENTOR ) {
            // Elementor Context.
            $wrapper_attributes = sprintf(
                " id='affiliatex-pros-cons-style-%s' class='%s'",
                $block_id,
                'affx-pros-cons-wrapper'
            );
        } else {
            // Gutenberg Context.
            $wrapper_attributes = get_block_wrapper_attributes(array(
                'id' => "affiliatex-pros-cons-style-$block_id",
                'class' => 'affx-pros-cons-wrapper',
            ));
        }

        $inner_wrapper_classes = "$layoutStyle";

        if (isset($contentAlignment)) {
            $inner_wrapper_classes .= " content-align-$contentAlignment";
        }


        $titleTag1 = AffiliateX_Helpers::validate_tag($titleTag1, 'p');

        if ('list' == $prosContentType || 'amazon' == $prosContentType) {
            $prosList = AffiliateX_Helpers::render_list(
                array(
                    'listType' => $prosListType,
                    'unorderedType' => $prosUnorderedType,
                    'listItems' => $prosListItems,
                    'iconName' => $prosIcon['value'],
                )
            );
        }

        if ('list' == $consContentType || 'amazon' == $consContentType) {
            $consList = AffiliateX_Helpers::render_list(
                array(
                    'listType' => $consListType,
                    'unorderedType' => $consUnorderedType,
                    'listItems' => $consListItems,
                    'iconName' => $consIcon['value'],
                )
            );
        }

        ob_start();
        include $this->get_template_path();
        return ob_get_clean();
    }
}
