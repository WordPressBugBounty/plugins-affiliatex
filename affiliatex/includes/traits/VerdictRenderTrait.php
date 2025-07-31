<?php

namespace AffiliateX\Traits;

use AffiliateX\Helpers\AffiliateX_Helpers;

/**
 * This trait is a channel for share rendering methods between Gutenberg and Elementor
 *
 * @package AffiliateX
 */
trait VerdictRenderTrait
{
    use ButtonRenderTrait;

    protected function get_slug(): string
    {
        return 'verdict';
    }

    /**
     * Inner button config
     *
     * @var array
     */
    protected static $inner_button_config = [
        'name_prefix' => 'button_child',
        'label_prefix' => 'Button',
        'index' => null,
        'is_child' => true,
        'conditions' => ['verdictLayout' => 'layoutTwo'],
        'defaults' => [
            'button_label' => 'Buy Now',
            'buttonAlignment' => 'center',
        ],
    ];

    protected static $inner_pros_and_cons_config = [
        'name_prefix' => 'pros_and_cons_child',
        'label_prefix' => 'Pros and Cons',
        'index' => null,
        'is_child' => true,
        'conditions' => ['verdictLayout' => 'layoutOne'],
        'defaults' => [
            'margin' => [
                'unit' => 'px',
                'top' => '0',
                'right' => '0',
                'bottom' => '0',
                'left' => '0',
                'isLinked' => false
            ],
        ],
    ];

    /**
     * Get default fields
     *
     * @return array
     */
    protected function get_fields(): array
    {
        return [
            'block_id' => '',
            'verdictTitle' => 'Verdict Title.',
            'verdictContent' => 'Start creating Verdict in seconds, and convert more of your visitors into leads.',
            'verdictLayout' => 'layoutOne',
            'verdictTitleTag' => 'h3',
            'contentAlignment' => 'center',
            'verdictBorder' => [
                'width' => '1',
                'style' => 'solid',
                'color' => [
                    'color' => '#E6ECF7',
                ],
            ],
            'verdictBoxShadow' => [
                'enable' => false,
                'h_offset' => 0,
                'v_offset' => 5,
                'blur' => 20,
                'spread' => 0,
                'inset' => false,
                'color' => [
                    'color' => 'rgba(210,213,218,0.2)',
                ],
            ],
            'edProsCons' => true,
            'edVerdictRatings' => true,
            'edUserRatings' => true,
            'userRatingLabel' => 'User Ratings:',
            'userRatingContent' => 'No ratings received yet.',
            'verdictRatings' => '',
            'verdictRatingColor' => '#FFD700',
            'verdictRatingInactiveColor' => '#808080',
            'verdictRatingStarSize' => 25,
            'edverdictTotalScore' => true,
            'verdictTotalScore' => 8.5,
            'ratingContent' => 'Our Score',
            'scoreTextColor' => '#FFFFFF',
            'scoreBgTopColor' => '#2670FF',
            'scoreBgBotColor' => '#262B33',
            'edRatingsArrow' => true,
            'verdictArrowColor' => '#2670FF',
            'verdictTitleColor' => '#060C0E',
            'verdictContentColor' => '#292929',
            'ratingAlignment' => 'left',
            'verdictBgType' => 'solid',
            'verdictBgColorSolid' => '#FFFFFF',
            'verdictBgColorGradient' => [
                'gradient' => 'linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%)',
            ],
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
    public function render_template(array $attributes, string $content): string
    {
        $attributes = $this->parse_attributes($attributes);
        extract($attributes);

        if ( self::IS_ELEMENTOR ) {
            // Elementor Context.
            $wrapper_attributes = '';
        } else {
            // Gutenberg Context.
            $wrapper_attributes = get_block_wrapper_attributes(array(
                'id' => "affiliatex-verdict-style-$block_id",
            ));
        }

        $verdictTitleTag = AffiliateX_Helpers::validate_tag($verdictTitleTag, 'h2');

        $layoutClass = '';
        if ($verdictLayout === 'layoutOne') {
            $layoutClass = ' verdict-layout-1';
        } elseif ($verdictLayout === 'layoutTwo') {
            $layoutClass = ' verdict-layout-2';
        }

        if (str_contains($content, $layoutClass)) {
            return $content;
        }

        $ratingClass = $edverdictTotalScore ? ' number-rating' : '';
        $arrowClass = $edRatingsArrow ? ' display-arrow' : '';
        $innerBlocksContentHtml = $content ?? '';

        if ('layoutOne' == $verdictLayout) {
            if (!$edProsCons) {
                $innerBlocksContentHtml = '';
            }
        }

        ob_start();
        include $this->get_template_path();
        return ob_get_clean();
    }
}
