<?php

namespace AffiliateX\Traits;

use AffiliateX\Helpers\AffiliateX_Helpers;
use AffiliateX\Helpers\Elementor\ChildHelper;
use AffiliateX\Helpers\Elementor\WidgetHelper;

defined('ABSPATH') or exit;

/**
 * Cta Render Trait
 * 
 * @package AffiliateX
 */
trait CtaRenderTrait
{
    /**
     * Child button 1 config
     *
     * @var array
     */
    protected static $button1_config = [
        'name_prefix'  => 'button_child1',
        'label_prefix' => 'Button',
        'index'        => 1,
        'is_child'     => true,
        'conditions'   => ['edButtons' => 'true'],
        'wrapper'      => 'affx-btn-wrapper',
        'defaults'     => [
            'button_label' => 'Buy Now',
            'buttonMargin' => [
                'top'    => 0,
                'right'  => 0,
                'bottom' => 0,
                'left'   => 0,
                'unit'   => 'px'
            ]
        ]
    ];

    /**
     * Child button 2 config
     *
     * @var array
     */
    protected static $button2_config = [
        'name_prefix'  => 'button_child2',
        'label_prefix' => 'Button',
        'index'        => 2,
        'is_child'     => true,
        'wrapper'      => 'affx-btn-wrapper',
        'conditions'   => [
            'edButtons'   => 'true',
            'edButtonTwo' => 'true'
        ],
        'defaults'     => [
            'button_label'            => 'More Details',
            'button_background' => [
                'color' => [
                    'default' => '#FFB800',
                ],
            ],
            'buttonMargin'            => [
                'top'    => 0,
                'right'  => 0,
                'bottom' => 0,
                'left'   => 0,
                'unit'   => 'px'
            ]
        ]
    ];

    protected function get_elements(): array
    {
        return [
            'wrapper'         => 'affblk-cta-wrapper > div',
            'title'           => 'affliatex-cta-title',
            'content'         => 'affliatex-cta-content',
            'buttons'         => 'button-wrapper',
            'image'           => 'image-wrapper',
            'content_wrapper' => 'content-wrapper'
        ];
    }

    protected function get_slug(): string
    {
        return 'cta';
    }

    protected function get_fields(): array
    {
        return [
            'block_id'           => '',
            'ctaTitle'           => 'Call to Action Title.',
            'ctaTitleTag'        => 'h2',
            'ctaContent'         => 'Start creating CTAs in seconds, and convert more of your visitors into leads.',
            'ctaBGType'          => 'color',
            'ctaLayout'          => 'layoutOne',
            'ctaAlignment'       => 'center',
            'columnReverse'      => false,
            'ctaButtonAlignment' => 'center',
            'edButtons'          => true
        ];
    }

    /**
     * Elementor render
     *
     * @return void
     */
    protected function render(): void
    {
        $attributes               = $this->get_settings_for_display();
        $attributes               = WidgetHelper::process_attributes($attributes);
        $attributes['block_id'] = $this->get_id();

        $button1 = '';
        $button2 = '';

        if (isset($attributes['edButtons']) && $attributes['edButtons'] === true) {
            $child_attributes = ChildHelper::extract_attributes($attributes, self::$button1_config);

            ob_start();
            $this->render_button($child_attributes);
            $button1 = ob_get_clean();
        }

        if (isset($attributes['edButtons']) && isset($attributes['edButtonTwo']) && $attributes['edButtonTwo'] === true) {
            $child_attributes = ChildHelper::extract_attributes($attributes, self::$button2_config);

            ob_start();
            $this->render_button($child_attributes);
            $button2 = ob_get_clean();
        }

        if ( isset($attributes['ctaContent']) && json_decode($attributes['ctaContent']) ) {
            $attributes['ctaContent'] = AffiliateX_Helpers::render_list(
                array(
                    'listType' => 'ordered',
                    'unorderedType' => 'icon',
                    'listItems' => json_decode($attributes['ctaContent'], true) ?? [],
                    'iconName' => '',
                )
            );
        }

        echo $this->render_template($attributes, $button1 . $button2);
    }

    /**
     * Core render template
     *
     * @param array $attributes
     * @param string $content
     * @return string
     */
    public function render_template(array $attributes, string $content = ''): string
    {
        $attributes = $this->parse_attributes($attributes);
        extract($attributes);

        $wrapper_attributes = 'class="affblk-cta-wrapper"';

        if ( self::IS_ELEMENTOR ) {
            $wrapper_attributes = sprintf(
                'class="affblk-cta-wrapper %s" id="affiliatex-style-%s"',
                $attributes['wrapper_class'] ?? '',
                $attributes['block_id']
            );
        }  else {
            // Use get_block_wrapper_attributes to get the class names and other attributes.
            $wrapper_attributes = get_block_wrapper_attributes([
                'class' => "affblk-cta-wrapper " . ( $attributes['wrapper_class'] ?? '' ),
                'id'    => "affiliatex-style-$block_id"
            ]);
        }


        $layoutClass        = ($ctaLayout === 'layoutOne') ? ' layout-type-1' : (($ctaLayout === 'layoutTwo') ? ' layout-type-2' : '');
        $columnReverseClass = ($columnReverse && $ctaLayout !== 'layoutOne') ? ' col-reverse' : '';
        $bgClass            = ( isset( $attributes['ctaBGType_background'] ) && $attributes['ctaBGType_background'] == 'image' ) ? ' img-opacity' : ' bg-color';
        $ctaTitleTag        = AffiliateX_Helpers::validate_tag($ctaTitleTag, 'h2');

        if (str_contains($content, $layoutClass)) {
            return $content;
        }

        $inlineImageWrapperStyles = '';
        if (isset($attributes['imageType']) && $attributes['imageType'] === 'external' && !empty($attributes['imageExternal'])) {
            $inlineImageWrapperStyles = 'style="background-image: url(' . esc_url($attributes['imageExternal']) . ')"';
        }

        ob_start();
        include $this->get_template_path();

        return ob_get_clean();
    }
}
