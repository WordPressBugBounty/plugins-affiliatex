<?php

namespace AffiliateX\Traits;

use AffiliateX\Elementor\ControlsManager;
use AffiliateX\Helpers\ElementorHelper;
use AffiliateX\Helpers\AffiliateX_Helpers;
use AffiliateX\Helpers\Elementor\ChildHelper;
use AffiliateX\Helpers\Elementor\WidgetHelper;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AffiliateX\Traits\ButtonRenderTrait;
use Elementor\Group_Control_Background;

/**
 * This trait is a channel for share rendering methods between Gutenberg and Elementor
 *
 * @package AffiliateX
 */
trait SingleProductRenderTrait
{
    use ButtonRenderTrait;

    protected function get_elements(): array
    {
        return [
            'wrapper'      => 'affx-single-product-wrapper',
            'title'        => 'affx-single-product-title',
            'subtitle'     => 'affx-single-product-subtitle',
            'content'      => 'affx-single-product-content',
            'image'        => 'affx-sp-img-wrapper',
            'ribbon'       => 'affx-sp-ribbon-title',
            'price'        => 'affx-sp-price',
            'price-marked' => 'affx-sp-marked-price',
            'price-sale'   => 'affx-sp-sale-price',
            'list'         => 'affiliatex-list',
        ];
    }

    /**
     * Inner button config
     *
     * @var array
     */
    protected static $inner_button_config =  [
        'name_prefix'  => 'button_child',
        'label_prefix' => 'Button',
        'index'        => null,
        'is_child'     => true,
        'conditions'   => ['edButton' => 'true'],
        'defaults'     => [
            'button_label' => 'Buy Now',
            'buttonMargin' => [
                'top'    => 16,
                'left'   => 0,
                'right'  => 0,
                'bottom' => 0,
                'unit' => 'px'
            ]
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
            'block_id'               => '',
            'productLayout'          => 'layoutOne',
            'productTitle'           => 'Title',
            'productTitleTag'        => 'h2',
            'productContent'         => 'You can have short product description here. It can be added as and enable/disable toggle option from which user can have control on it.',
            'productSubTitle'        => 'Subtitle',
            'productSubTitleTag'     => 'h3',
            'productContentType'     => 'paragraph',
            'ContentListType'        => 'unordered',
            'productContentList'     => [],
            'productImageAlign'      => 'left',
            'productSalePrice'       => '$49',
            'productPrice'           => '$59',
            'productIconList'        => [
                'name'  => 'check-circle-outline',
                'value' => 'far fa-check-circle'
            ],
            'ratings'                => 5,
            'edRatings'              => false,
            'edTitle'                => true,
            'edSubTitle'             => false,
            'edContent'              => true,
            'edPricing'              => false,
            'PricingType'            => 'picture',
            'productRatingColor'     => '#FFB800',
            'ratingInactiveColor'    => '#808080',
            'ratingContent'          => 'Our Score',
            'ratingStarSize'         => 25,
            'edButton'               => false,
            'edProductImage'         => false,
            'edRibbon'               => false,
            'productRibbonLayout'    => 'one',
            'ribbonText'             => 'Sale',
            'ribbonAlign'            => 'left',
            'ImgUrl'                 => '',
            'numberRatings'          => '8.5',
            'edFullBlockLink'        => false,
            'blockUrl'               => '',
            'blockOpenInNewTab'      => false,
            'productRatingAlign'     => 'right',
            'productStarRatingAlign' => 'left',
            'productImageType'       => 'default',
            'productImageExternal'   => '',
            'productImageSiteStripe' => '',
            'productPricingAlign'    => 'left'
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
     * Render stars
     *
     * @param [type] $ratings
     * @param [type] $productRatingColor
     * @param [type] $ratingInactiveColor
     * @param [type] $ratingStarSize
     * @return string
     */
    private function render_pb_stars($ratings, $productRatingColor, $ratingInactiveColor, $ratingStarSize): string
    {
        $stars = '';

        for ($i = 1; $i <= 5; $i++) {
            $color = ($i <= $ratings) ? $productRatingColor : $ratingInactiveColor;
            $stars .= sprintf(
                '<span style="color:%s;width:%dpx;height:%dpx;display:inline-flex;">
                    <svg fill="currentColor" width="%d" height="%d" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                    </svg>
                </span>',
                esc_attr($color),
                esc_attr($ratingStarSize),
                esc_attr($ratingStarSize),
                esc_attr($ratingStarSize),
                esc_attr($ratingStarSize)
            );
        }

        return $stars;
    }

    /**
     * Elementor controls array.
     */
    public function get_sp_elementor_controls($config = []) {
        $defaults = $this->get_fields();
        
        $layoutSettings = [
            'affx_sp_layout_settings' => [
                'label'  => __('Layout Settings', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_CONTENT,
                'fields' => [
                    'productLayout' => [
                        'label'   => __('Product Layout', 'affiliatex'),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'layoutOne',
                        'options' => [
                            'layoutOne'   => __('Layout One', 'affiliatex'),
                            'layoutTwo'   => __('Layout Two', 'affiliatex'),
                            'layoutThree' => __('Layout Three', 'affiliatex'),
                        ],
                    ],
                ],
            ]
        ];

        $hiddenLayoutSettings = [];

        if ( isset($config['is_child']) && $config['is_child']){
            $layoutSettings = [];

            $hiddenLayoutSettings = [
                'productLayout' => [
                    'type'    => Controls_Manager::HIDDEN,
                    'default' => 'layoutTwo'
                ],
            ];
        }

        return array_merge($layoutSettings, [
            'affx_sp_ribbon_settings' => [
                'label'  => __('Ribbon Settings', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_CONTENT,
                'fields' => array_merge($hiddenLayoutSettings, [
                    'edRibbon' => [
                        'label'        => __('Enable Ribbon', 'affiliatex'),
                        'type'         => Controls_Manager::SWITCHER,
                        'label_on'     => __('Yes', 'affiliatex'),
                        'label_off'    => __('No', 'affiliatex'),
                        'return_value' => 'true',
                        'default'      => 'false',
                    ],
                    'productRibbonLayout' => [
                        'label'     => __('Ribbon Layout', 'affiliatex'),
                        'type'      => Controls_Manager::SELECT,
                        'default'   => 'one',
                        'options'   => [
                            'one' => __('Ribbon One', 'affiliatex'),
                            'two' => __('Ribbon Two', 'affiliatex'),
                        ],
                        'condition' => [
                            'edRibbon' => 'true',
                        ],
                    ],
                    'ribbonAlign' => [
                        'label'     => __('Ribbon Alignment', 'affiliatex'),
                        'type'      => Controls_Manager::CHOOSE,
                        'default'   => 'left',
                        'options'   => [
                            'left'  => [
                                'title' => esc_html__('Left', 'affiliatex'),
                                'icon'  => 'eicon-text-align-left',
                            ],
                            'right' => [
                                'title' => esc_html__('Right', 'affiliatex'),
                                'icon'  => 'eicon-text-align-right',
                            ],
                        ],
                        'toggle' => false,
                        'condition' => [
                            'edRibbon'      => 'true',
                            'productLayout' => ['layoutOne', 'layoutTwo'],
                        ],
                    ],
                    'ribbonText' => [
                        'label'       => __('Ribbon Text', 'affiliatex'),
                        'type'        => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default'     => __('Sale', 'affiliatex'),
                        'condition'   => [
                            'edRibbon' => 'true',
                        ],
                    ],
                ]),
            ],

            'affx_sp_general_settings' => [
                'label'  => __('General Settings', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_CONTENT,
                'fields' => [
                    'edButton' => [
                        'label'        => __('Enable Button', 'affiliatex'),
                        'type'         => Controls_Manager::SWITCHER,
                        'label_on'     => __('Yes', 'affiliatex'),
                        'label_off'    => __('No', 'affiliatex'),
                        'return_value' => 'true',
                        'default'      => 'true',
                    ],
                    'buttonDirection' => [
                        'label'     => __('Buttons Direction', 'affiliatex'),
                        'type'      => Controls_Manager::CHOOSE,
                        'default'   => 'column',
                        'options'   => [
                            'row' => [
                                'title' => esc_html__('Row', 'affiliatex'),
                                'icon'  => 'eicon-arrow-right',
                            ],
                            'column'  => [
                                'title' => esc_html__('Column', 'affiliatex'),
                                'icon'  => 'eicon-arrow-down',
                            ],
                        ],
                        'toggle' => false,
                        'condition' => [
                            'edButton' => 'true',
                        ],
                    ],
                    'buttonsGap' => [
                        'label'     => esc_html__('Buttons Gap', 'affiliatex'),
                        'type'      => Controls_Manager::NUMBER,
                        'min'       => 0,
                        'max'       => 50,
                        'step'      => 1,
                        'default'   => 10,
                        'condition' => [
                            'edButton' => 'true',
                        ],
                    ],
                    'edProductImage' => [
                        'label'        => __('Enable Product Image', 'affiliatex'),
                        'type'         => Controls_Manager::SWITCHER,
                        'label_on'     => __('Yes', 'affiliatex'),
                        'label_off'    => __('No', 'affiliatex'),
                        'return_value' => 'true',
                        'default'      => 'true',
                    ],
                    'productImageAlign' => [
                        'label'     => __('Image Alignment', 'affiliatex'),
                        'type'      => Controls_Manager::CHOOSE,
                        'default'   => 'left',
                        'options'   => [
                            'left'  => [
                                'title' => esc_html__('Left', 'affiliatex'),
                                'icon'  => 'eicon-text-align-left',
                            ],
                            'right' => [
                                'title' => esc_html__('Right', 'affiliatex'),
                                'icon'  => 'eicon-text-align-right',
                            ],
                        ],
                        'toggle' => false,
                        'condition' => [
                            'edProductImage' => 'true',
                            'productLayout!' => 'layoutTwo',
                        ],
                    ],
                    'productImageWidth' => [
                        'label'   => esc_html__('Image Width', 'affiliatex'),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'inherit',
                        'options' => [
                            'inherit' => esc_html__('Inherit', 'affiliatex'),
                            'custom'  => esc_html__('Custom', 'affiliatex'),
                        ],
                        'condition' => [
                            'edProductImage' => 'true',
                            'productLayout!' => 'layoutTwo',
                        ],
                    ],
                    'productImageCustomWidth' => [
                        'label'     => esc_html__('Custom Image Width ( % )', 'affiliatex'),
                        'type'      => Controls_Manager::NUMBER,
                        'min'       => 0,
                        'max'       => 100,
                        'step'      => 1,
                        'default'   => 45,
                        'selectors' => [
                            $this->select_element('wrapper') . '.product-layout-1 .affx-sp-img-wrapper' => 'flex: 0 0 {{VALUE}}%',
                            $this->select_element('wrapper') . '.product-layout-3 .affx-sp-img-wrapper' => 'flex: 0 0 {{VALUE}}%',
                        ],
                        'condition' => [
                            'edProductImage' => 'true',
                            'productLayout!' => 'layoutTwo',
                            'productImageWidth' => 'custom',
                        ],
                    ],
                    'productImageType' => [
                        'label'     => __('Image Source', 'affiliatex'),
                        'type'      => Controls_Manager::CHOOSE,
                        'default'   => 'default',
                        'options'   => [
                            'default'    => [
                                'title' => __('Upload', 'affiliatex'),
                                'icon'  => 'eicon-kit-upload',
                            ],
                            'external'   => [
                                'title' => __('External', 'affiliatex'),
                                'icon'  => 'eicon-external-link-square',
                            ],
                            'sitestripe' => [
                                'title' => __('SiteStripe', 'affiliatex'),
                                'icon'  => 'eicon-stripe-button',
                            ],
                        ],
                        'toggle' => false,
                        'condition' => [
                            'edProductImage' => 'true',
                        ],
                    ],
                    'ImgUrl' => [
                        'label'     => __('Image', 'affiliatex'),
                        'type'      => Controls_Manager::MEDIA,
                        'default'   => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'condition' => [
                            'edProductImage'   => 'true',
                            'productImageType' => 'default',
                        ],
                    ],
                    'productImageExternal' => [
                        'label'       => __('External Image URL', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'label_block' => true,
                        'amazon_button' => true,
                        'condition'   => [
                            'productImageType' => 'external',
                        ],
                    ],
                    'productImageSiteStripe' => [
                        'label'       => __('SiteStripe Markup', 'affiliatex'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'label_block' => true,
                        'placeholder' => 'Enter SiteStripe Markup',
                        'condition'   => [
                            'productImageType' => 'sitestripe',
                        ],
                    ],
                ],
            ],

            'affx_sp_link_settings' => [
                'label'  => __('Link Settings', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_CONTENT,
                'fields' => [
                    'edFullBlockLink' => [
                        'label'        => __('Make Whole Block Clickable', 'affiliatex'),
                        'type'         => Controls_Manager::SWITCHER,
                        'return_value' => 'true',
                        'default'      => 'false',
                    ],
                    'blockUrl' => [
                        'label'       => __('Link URL', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'label_block' => true,
                        'placeholder' => __('Enter link URL', 'affiliatex'),
                        'condition'   => [
                            'edFullBlockLink' => 'true',
                        ],
                    ],
                    'blockOpenInNewTab' => [
                        'label'        => __('Open link in new tab', 'affiliatex'),
                        'type'         => Controls_Manager::SWITCHER,
                        'return_value' => 'true',
                        'default'      => 'false',
                        'condition'   => [
                            'edFullBlockLink' => 'true',
                        ],
                    ],
                ],
            ],

            'affx_sp_title_settings' => [
                'label'  => __('Title Settings', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_CONTENT,
                'fields' => [
                    'edTitle' => [
                        'label'        => __('Enable Title', 'affiliatex'),
                        'type'         => Controls_Manager::SWITCHER,
                        'label_on'     => __('Yes', 'affiliatex'),
                        'label_off'    => __('No', 'affiliatex'),
                        'return_value' => 'true',
                        'default'      => 'true',
                    ],
                    'productTitle' => [
                        'label'       => __('Product Title', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'label_block' => true,
                        'default'     => __('Title', 'affiliatex'),
                        'amazon_button' => true,
                        'condition'   => [
                            'edTitle' => 'true',
                        ],
                    ],
                    'productTitleTag' => [
                        'label'     => __('Product Heading Tag', 'affiliatex'),
                        'type'      => Controls_Manager::SELECT,
                        'default'   => 'h2',
                        'options'   => [
                            'h2' => __('Heading 2 (h2)', 'affiliatex'),
                            'h3' => __('Heading 3 (h3)', 'affiliatex'),
                            'h4' => __('Heading 4 (h4)', 'affiliatex'),
                            'h5' => __('Heading 5 (h5)', 'affiliatex'),
                            'h6' => __('Heading 6 (h6)', 'affiliatex'),
                            'p'  => __('Paragraph (p)', 'affiliatex'),
                        ],
                        'condition' => [
                            'edTitle' => 'true',
                        ],
                    ],
                    'productTitleAlign' => [
                        'label'     => __('Title Alignment', 'affiliatex'),
                        'type'      => Controls_Manager::CHOOSE,
                        'default'   => 'left',
                        'options'   => [
                            'left'   => [
                                'title' => esc_html__('Left', 'affiliatex'),
                                'icon'  => 'eicon-text-align-left',
                            ],
                            'center' => [
                                'title' => esc_html__('Center', 'affiliatex'),
                                'icon'  => 'eicon-text-align-center',
                            ],
                            'right'  => [
                                'title' => esc_html__('Right', 'affiliatex'),
                                'icon'  => 'eicon-text-align-right',
                            ],
                        ],
                        'toggle' => false,
                        'condition' => [
                            'edTitle' => 'true',
                        ],
                        'selectors' => [
                            $this->select_element('title') => 'text-align: {{VALUE}};',
                        ],
                    ],
                ],
            ],

            'affx_sp_subtitle_settings' => [
                'label'  => __('Subtitle Settings', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_CONTENT,
                'fields' => [
                    'edSubtitle' => [
                        'label'        => __('Enable Subtitle', 'affiliatex'),
                        'type'         => Controls_Manager::SWITCHER,
                        'label_on'     => __('Yes', 'affiliatex'),
                        'label_off'    => __('No', 'affiliatex'),
                        'return_value' => 'true',
                        'default'      => 'false',
                    ],
                    'productSubTitle' => [
                        'label'       => __('Product Subtitle', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'default'     => __('Subtitle', 'affiliatex'),
                        'placeholder' => __('Enter Product Subtitle', 'affiliatex'),
                        'amazon_button' => true,
                        'condition'   => [
                            'edSubtitle' => 'true',
                        ],
                    ],
                    'productSubTitleTag' => [
                        'label'   => __('Product Subtitle Tag', 'affiliatex'),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'h6',
                        'options' => [
                            'h2' => __('Heading 2 (h2)', 'affiliatex'),
                            'h3' => __('Heading 3 (h3)', 'affiliatex'),
                            'h4' => __('Heading 4 (h4)', 'affiliatex'),
                            'h5' => __('Heading 5 (h5)', 'affiliatex'),
                            'h6' => __('Heading 6 (h6)', 'affiliatex'),
                            'p'  => __('Paragraph (p)', 'affiliatex'),
                        ],
                        'condition' => [
                            'edSubtitle' => 'true',
                        ],
                    ],
                    'productSubtitleAlign' => [
                        'label'     => __('Sub Title Alignment', 'affiliatex'),
                        'type'      => Controls_Manager::CHOOSE,
                        'default'   => 'left',
                        'options'   => [
                            'left' => [
                                'title' => __('Left', 'affiliatex'),
                                'icon'  => 'eicon-text-align-left',
                            ],
                            'center' => [
                                'title' => __('Center', 'affiliatex'),
                                'icon'  => 'eicon-text-align-center',
                            ],
                            'right' => [
                                'title' => __('Right', 'affiliatex'),
                                'icon'  => 'eicon-text-align-right',
                            ],
                        ],
                        'toggle' => false,
                        'selectors' => [
                            $this->select_element('subtitle') => 'text-align: {{VALUE}};',
                        ],
                        'condition' => [
                            'edSubtitle' => 'true',
                        ],
                    ],
                ],
            ],

            'affx_sp_rating_settings' => [
                'label'  => __('Rating Settings', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_CONTENT,
                'fields' => [
                    'edRatings' => [
                        'label'        => __('Enable Rating', 'affiliatex'),
                        'type'         => Controls_Manager::SWITCHER,
                        'label_on'     => __('Yes', 'affiliatex'),
                        'label_off'    => __('No', 'affiliatex'),
                        'return_value' => 'true',
                        'default'      => 'false',
                    ],
                    'PricingType' => [
                        'label'   => __('Rating Type', 'affiliatex'),
                        'type'    => Controls_Manager::CHOOSE,
                        'options' => [
                            'picture' => [
                                'title' => __('Star rating', 'affiliatex'),
                                'icon'  => 'eicon-star',
                            ],
                            'number' => [
                                'title' => __('Score box', 'affiliatex'),
                                'icon'  => 'eicon-section',
                            ],
                        ],
                        'toggle'    => false,
                        'default'   => 'picture',
                        'condition' => [
                            'edRatings' => 'true',
                        ],
                    ],
                    'ratings' => [
                        'label'   => __('Ratings', 'affiliatex'),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 5,
                        'options' => [
                            1 => 1,
                            2 => 2,
                            3 => 3,
                            4 => 4,
                            5 => 5,
                        ],
                        'condition' => [
                            'edRatings'   => 'true',
                            'PricingType' => 'picture',
                        ],
                    ],
                    'ratingStarSize' => [
                        'label'      => __('Star Rating size', 'affiliatex'),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px'],
                        'range'      => [
                            'px' => [
                                'min'  => 0,
                                'max'  => 100,
                                'step' => 5,
                            ],
                        ],
                        'default' => [
                            'unit' => 'px',
                            'size' => 25,
                        ],
                        'condition' => [
                            'edRatings'   => 'true',
                            'PricingType' => 'picture',
                        ],
                    ],
                    'productStarRatingAlign' => [
                        'label'   => __('Rating Alignment', 'affiliatex'),
                        'type'    => Controls_Manager::CHOOSE,
                        'default' => 'left',
                        'options' => [
                            'left' => [
                                'title' => __('Left', 'affiliatex'),
                                'icon'  => 'eicon-text-align-left',
                            ],
                            'center' => [
                                'title' => __('Center', 'affiliatex'),
                                'icon'  => 'eicon-text-align-center',
                            ],
                            'right' => [
                                'title' => __('Right', 'affiliatex'),
                                'icon'  => 'eicon-text-align-right',
                            ],
                        ],
                        'toggle' => false,
                        'condition' => [
                            'edRatings'   => 'true',
                            'PricingType' => 'picture',
                        ],
                    ],
                    'numberRatings' => [
                        'label'       => __('Rating Number', 'affiliatex'),
                        'type'        => Controls_Manager::NUMBER,
                        'label_block' => true,
                        'default'     => 8.5,
                        'condition'   => [
                            'edRatings'   => 'true',
                            'PricingType' => 'number',
                        ],
                    ],
                    'ratingContent' => [
                        'label'       => __('Rating Content', 'affiliatex'),
                        'type'        => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default'     => 'Our Score',
                        'condition'   => [
                            'edRatings'   => 'true',
                            'PricingType' => 'number',
                        ],
                    ],
                    'productRatingAlign' => [
                        'label'   => __('Rating Alignment', 'affiliatex'),
                        'type'    => Controls_Manager::CHOOSE,
                        'default' => 'left',
                        'options' => [
                            'left' => [
                                'title' => __('Left', 'affiliatex'),
                                'icon'  => 'eicon-text-align-left',
                            ],
                            'right' => [
                                'title' => __('Right', 'affiliatex'),
                                'icon'  => 'eicon-text-align-right',
                            ],
                        ],
                        'toggle' => false,
                        'condition' => [
                            'edRatings'   => 'true',
                            'PricingType' => 'number',
                        ],
                    ],
                ],
            ],

            'affx_sp_pricing_settings' => [
                'label'  => __('Pricing Settings', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_CONTENT,
                'fields' => [
                    'edPricing' => [
                        'label'        => __('Enable Pricing', 'affiliatex'),
                        'type'         => Controls_Manager::SWITCHER,
                        'label_on'     => __('Yes', 'affiliatex'),
                        'label_off'    => __('No', 'affiliatex'),
                        'return_value' => 'true',
                        'default'      => '',
                    ],
                    'productPrice' => [
                        'label'       => __('Product Marked Price', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'label_block' => true,
                        'default'     => '$59',
                        'amazon_button' => true,
                        'condition'   => [
                            'edPricing' => 'true',
                        ],
                    ],
                    'productSalePrice' => [
                        'label'       => __('Product Sale Price', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'label_block' => true,
                        'default'     => '$49',
                        'amazon_button' => true,
                        'condition'   => [
                            'edPricing' => 'true',
                        ],
                    ],
                    'productPricingAlign' => [
                        'label'     => __('Pricing Alignment', 'affiliatex'),
                        'type'      => Controls_Manager::CHOOSE,
                        'default'   => 'left',
                        'options'   => [
                            'left'   => [
                                'title' => esc_html__('Left', 'affiliatex'),
                                'icon'  => 'eicon-text-align-left',
                            ],
                            'center' => [
                                'title' => esc_html__('Center', 'affiliatex'),
                                'icon'  => 'eicon-text-align-center',
                            ],
                            'right'  => [
                                'title' => esc_html__('Right', 'affiliatex'),
                                'icon'  => 'eicon-text-align-right',
                            ],
                        ],
                        'toggle' => false,
                        'condition' => [
                            'edPricing' => 'true',
                        ],
                    ],
                ],
            ],

            'affx_sp_content_settings' => [
                'label'  => __('Content Settings', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_CONTENT,
                'fields' => [
                    'edContent' => [
                        'label'        => __('Enable Content', 'affiliatex'),
                        'type'         => Controls_Manager::SWITCHER,
                        'return_value' => 'true',
                        'default'      => 'true',
                    ],
                    'productContentType' => [
                        'label'     => __('Content Type', 'affiliatex'),
                        'type'      => Controls_Manager::CHOOSE,
                        'default'   => 'paragraph',
                        'options'   => [
                            'paragraph' => [
                                'title' => esc_html__('Paragraph', 'affiliatex'),
                                'icon'  => 'eicon-editor-paragraph',
                            ],
                            'list' => [
                                'title' => esc_html__('List', 'affiliatex'),
                                'icon'  => 'eicon-bullet-list',
                            ],
                            'amazon' => [
                                'title' => esc_html__('Amazon', 'affiliatex'),
                                'icon'  => 'fa-brands fa-amazon',
                            ],
                        ],
                        'toggle' => false,
                        'condition' => [
                            'edContent' => 'true',
                        ],
                    ],
                    'productContent' => [
                        'label'       => __('Product Content', 'affiliatex'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'label_block' => true,
                        'default'     => 'You can have short product description here. It can be added as and enable/disable toggle option from which user can have control on it.',
                        'condition'   => [
                            'edContent' => 'true',
                            'productContentType' => 'paragraph',
                        ],
                    ],
                    'productContentListAmazon' => [
                        'type' => ControlsManager::TEXT,
                        'label' => __('Amazon Product Content', 'affiliatex'),
                        'default' => '',
                        'disabled' => true,
                        'placeholder' => __('Click on the button to connect product', 'affiliatex'),
                        'condition' => [
                            'edContent' => 'true',
                            'productContentType' => 'amazon',
                        ],
                    ],
                    'productContentList' => [
                        'type'    => Controls_Manager::REPEATER,
                        'label'   => __('Product Content List', 'affiliatex'),
                        'title_field' => '{{{ content }}}',
                        'fields'  => [
                            [
                                'name'    => 'content',
                                'label'   => __('List Item', 'affiliatex'),
                                'type'    => Controls_Manager::TEXT,
                                'default' => 'Product List Item',
                            ],
                        ],
                        'default' => [
                            [
                                'content' => 'Product List Item',
                            ],
                        ],
                        'condition' => [
                            'edContent' => 'true',
                            'productContentType' => 'list',
                        ],
                    ],
                    'ContentListType' => [
                        'label'     => __('List Type', 'affiliatex'),
                        'type'      => Controls_Manager::CHOOSE,
                        'default'   => 'unordered',
                        'options'   => [
                            'unordered' => [
                                'title' => esc_html__('Unordered', 'affiliatex'),
                                'icon'  => 'eicon-editor-list-ul',
                            ],
                            'ordered' => [
                                'title' => esc_html__('Ordered', 'affiliatex'),
                                'icon'  => 'eicon-editor-list-ol',
                            ],
                        ],
                        'toggle' => false,
                        'condition' => [
                            'edContent' => 'true',
                            'productContentType' => ['list', 'amazon'],
                        ],
                    ],
                    'productIconList' => [
                        'label'       => __('Product Icon List', 'affiliatex'),
                        'type'        => Controls_Manager::ICONS,
                        'label_block' => true,
                        'default'     => [
                            'value'   => 'far fa-check-circle',
                            'library' => 'fa-regular',
                        ],
                        'render_type' => 'template',
                        'condition'   => [
                            'edContent' => 'true',
                            'productContentType' => ['list', 'amazon'],
                            'ContentListType' => 'unordered',
                        ],
                    ],
                    'productContentAlign' => [
                        'label'     => __('Content Alignment', 'affiliatex'),
                        'type'      => Controls_Manager::CHOOSE,
                        'default'   => 'left',
                        'options'   => [
                            'left'   => [
                                'title' => esc_html__('Left', 'affiliatex'),
                                'icon'  => 'eicon-text-align-left',
                            ],
                            'center' => [
                                'title' => esc_html__('Center', 'affiliatex'),
                                'icon'  => 'eicon-text-align-center',
                            ],
                            'right'  => [
                                'title' => esc_html__('Right', 'affiliatex'),
                                'icon'  => 'eicon-text-align-right',
                            ],
                        ],
                        'toggle' => false,
                        'selectors' => [
                            $this->select_element('content') => 'justify-content: {{VALUE}};',
                            $this->select_element(['content', ' p']) => 'text-align: {{VALUE}};',
                            $this->select_element(['content', ' li']) => 'justify-content: {{VALUE}};',
                        ],
                        'condition' => [
                            'edContent' => 'true',
                        ],
                    ],
                ],
            ],

            'affx_sp_style_general' => [
                'label' => __('Colors', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'fields' => [
                    'productTitleColor' => [
                        'label'     => __('Title Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#060c0e',
                        'selectors' => [
                            $this->select_element('title') => 'color: {{VALUE}}'
                        ],
                        'condition' => [
                            'edTitle' => 'true'
                        ]
                    ],
                    'productSubtitleColor' => [
                        'label'     => __('Subtitle Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#A3ACBF',
                        'selectors' => [
                            $this->select_element('subtitle') => 'color: {{VALUE}}'
                        ],
                        'condition' => [
                            'edSubtitle' => 'true'
                        ]
                    ],
                    'productContentColor' => [
                        'label'     => __('Content Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#292929',
                        'selectors' => [
                            $this->select_elements([
                                'content',
                                ['content', ' p'],
                                ['content', ' li'],
                            ]) => 'color: {{VALUE}}'
                        ],
                        'condition' => [
                            'edContent' => 'true'
                        ]
                    ],
                    'iconColor' => [
                        'label'     => __('Icon Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#24B644',
                        'selectors' => [
                            $this->select_element('list') . ' li::before' => 'color: {{VALUE}}',
                            $this->select_element('list') . ' li > i' => 'color: {{VALUE}}'
                        ],
                        'condition' => [
                            'productContentType' => ['list', 'amazon']
                        ]
                    ],
                    'productBackground' => [
                        'type'      => Group_Control_Background::get_type(),
                        'name'      => 'productBackground',
                        'label'     => __('Background', 'affiliatex'),
                        'types'     => ['classic', 'gradient'],
                        'selector'  => $this->select_element('wrapper'),
                        'exclude'   => ['image'],
                        'fields_options' => [
                            'background' => [
                                'default' => 'classic',
                                'options' => [
                                    'classic' => [
                                        'title' => esc_html__('Color', 'elementor'),
                                        'icon'  => 'eicon-paint-brush',
                                    ],
                                    'gradient' => [
                                        'title' => esc_html__('Gradient', 'elementor'),
                                        'icon'  => 'eicon-barcode',
                                    ],
                                ]
                            ],
                            'color' => [
                                'label' => __('Background Color', 'affiliatex'),
                            ],
                            'image' => [
                                'label' => __('Background Image', 'affiliatex'),
                            ]
                        ]
                    ],
                    'affx_sp_style_pricing' => [
                        'label'     => esc_html__('Pricing', 'affiliatex'),
                        'type'      => Controls_Manager::HEADING,
                        'separator' => 'before',
                        'condition' => [
                            'edPricing' => 'true'
                        ]
                    ],
                    'pricingHoverColor' => [
                        'label'     => __('Sale Price Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#A3ACBF',
                        'selectors' => [
                            $this->select_element( 'price-marked') => 'color: {{VALUE}}'
                        ],
                        'condition' => [
                            'edPricing' => 'true'
                        ]
                    ],
                    'pricingColor' => [
                        'label'     => __('Marked Price Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#262B33',
                        'selectors' => [
                            $this->select_element( 'price-sale') => 'color: {{VALUE}}'
                        ],
                        'condition' => [
                            'edPricing' => 'true'
                        ]
                    ],
                    'affx_sp_style_ratings' => [
                        'label'     => esc_html__('Ratings', 'affiliatex'),
                        'type'      => Controls_Manager::HEADING,
                        'separator' => 'before',
                        'condition' => [
                            'edRatings' => 'true'
                        ]
                    ],
                    'productRateNumberColor' => [
                        'label'     => __('Score Box Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            $this->select_element('wrapper') . ' .affx-rating-box span.num' => 'color: {{VALUE}}',
                        ],
                        'condition' => [
                            'edRatings'   => 'true',
                            'PricingType' => 'number'
                        ]
                    ],
                    'productRateContentColor' => [
                        'label'     => __('Content Rating Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            $this->select_element('wrapper') . ' .affx-rating-box span.label' => 'color: {{VALUE}}',
                        ],
                        'condition' => [
                            'edRatings'   => 'true',
                            'PricingType' => 'number'
                        ]
                    ],
                    'productRateNumBgColor' => [
                        'label'     => __('Score Box Background Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#2670FF',
                        'selectors' => [
                            $this->select_element('wrapper') . ' .affx-rating-box .num' => 'background-color: {{VALUE}}',
                        ],
                        'condition' => [
                            'edRatings'   => 'true',
                            'PricingType' => 'number'
                        ]
                    ],
                    'productRateContentBgColor' => [
                        'label'     => __('Content Rating Background Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#262B33',
                        'selectors' => [
                            $this->select_element('wrapper') . ' .affx-rating-box span.label' => 'background-color: {{VALUE}}',
                            $this->select_element('wrapper') . ' .affx-rating-box span.label::before' => 'border-bottom-color: {{VALUE}}',
                        ],
                        'condition' => [
                            'edRatings'   => 'true',
                            'PricingType' => 'number'
                        ]
                    ],
                    'productRatingColor' => [
                        'label'     => __('Rating Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#FFB800',
                        'condition' => [
                            'edRatings'   => 'true',
                            'PricingType' => 'picture'
                        ]
                    ],
                    'ratingInactiveColor' => [
                        'label'     => __('Inactive Rating Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#808080',
                        'condition' => [
                            'edRatings'   => 'true',
                            'PricingType' => 'picture'
                        ]
                    ],
                    'affx_sp_style_ribbon' => [
                        'label'     => esc_html__('Ribbon', 'affiliatex'),
                        'type'      => Controls_Manager::HEADING,
                        'separator' => 'before',
                        'condition' => [
                            'edRibbon' => 'true'
                        ]
                    ],
                    'ribbonColor' => [
                        'label'     => __('Ribbon Text Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#fff',
                        'selectors' => [
                            $this->select_element('ribbon') => 'color: {{VALUE}}',
                        ],
                        'condition' => [
                            'edRibbon' => 'true'
                        ]
                    ],
                    'ribbonBGColor' => [
                        'label'     => __('Ribbon Background Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ff0000',
                        'selectors' => [
                            $this->select_element('ribbon')              => 'background-color: {{VALUE}}',
                            $this->select_element('ribbon') . '::before' => 'border-bottom-color: {{VALUE}}!important;',
                            $this->select_element('wrapper') . ' .ribbon-align-right .affx-sp-ribbon-title::before' => ' border-right-color: {{VALUE}}!important',
                        ],
                        'condition' => [
                            'edRibbon' => 'true'
                        ]
                    ],
                ]
            ],

            'affx_sp_typography' => [
                'label'  => __('Typography', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_STYLE,
                'fields' => [
                    'productTitleTypography' => [
                        'type'      => Group_Control_Typography::get_type(),
                        'label'     => __('Product Title', 'affiliatex'),
                        'selector'  => $this->select_element('title'),
                        'fields_options' => [
                            'typography'  => [
                                'default' => 'custom'
                            ],
                            'font_family' => [
                                'default' => ''
                            ],
                            'font_weight' => [
                                'default' => '500'
                            ],
                            'font_size'   => [
                                'default' => [
                                    'unit' => 'px',
                                    'size' => '24'
                                ]
                            ],
                            'line_height' => [
                                'default' => [
                                    'unit' => 'custom',
                                    'size' => 1.33,
                                ],
                            ],
                            'letter_spacing' => [
                                'default' => [
                                    'unit' => 'em',
                                    'size' => 0,
                                ],
                            ],
                            'text_transform' => [
                                'default' => 'none',
                            ],
                            'text_decoration' => [
                                'default' => 'none',
                            ],
                        ],
                        'condition' => [
                            'edTitle' => 'true',
                        ],
                    ],
                    'productSubtitleTypography' => [
                        'type'      => Group_Control_Typography::get_type(),
                        'label'     => __('Product Subtitle', 'affiliatex'),
                        'selector'  => $this->select_element('subtitle'),
                        'fields_options' => [
                            'typography'  => [
                                'default' => 'custom'
                            ],
                            'font_family' => [
                                'default' => ''
                            ],
                            'font_weight' => [
                                'default' => '500'
                            ],
                            'font_size'   => [
                                'default' => [
                                    'unit' => 'px',
                                    'size' => '18'
                                ]
                            ],
                            'line_height' => [
                                'default' => [
                                    'unit' => 'custom',
                                    'size' => 1.5,
                                ],
                            ],
                            'letter_spacing' => [
                                'default' => [
                                    'unit' => 'em',
                                    'size' => 0,
                                ],
                            ],
                            'text_transform' => [
                                'default' => 'none',
                            ],
                            'text_decoration' => [
                                'default' => 'none',
                            ],
                        ],
                        'condition' => [
                            'edSubtitle' => 'true',
                        ],
                    ],
                    'pricingTypography' => [
                        'type'      => Group_Control_Typography::get_type(),
                        'label'     => __('Product Price', 'affiliatex'),
                        'selector'  => $this->select_element('price'),
                        'fields_options' => [
                            'typography'  => [
                                'default' => 'custom'
                            ],
                            'font_family' => [
                                'default' => ''
                            ],
                            'font_weight' => [
                                'default' => '400'
                            ],
                            'font_size'   => [
                                'default' => [
                                    'unit' => 'px',
                                    'size' => '22'
                                ]
                            ],
                            'line_height' => [
                                'default' => [
                                    'unit' => 'custom',
                                    'size' => 1.65,
                                ],
                            ],
                            'letter_spacing' => [
                                'default' => [
                                    'unit' => 'em',
                                    'size' => 0,
                                ],
                            ],
                            'text_transform' => [
                                'default' => 'none',
                            ],
                            'text_decoration' => [
                                'default' => 'none',
                            ],
                        ],
                        'condition' => [
                            'edPricing' => 'true',
                        ],
                    ],
                    'productContentTypography' => [
                        'type'      => Group_Control_Typography::get_type(),
                        'label'     => __('Product Content', 'affiliatex'),
                        'selector'  => $this->select_element('content'),
                        'fields_options' => [
                            'typography'  => [
                                'default' => 'custom'
                            ],
                            'font_family' => [
                                'default' => ''
                            ],
                            'font_weight' => [
                                'default' => '400'
                            ],
                            'font_size'   => [
                                'default' => [
                                    'unit' => 'px',
                                    'size' => '18'
                                ]
                            ],
                            'line_height' => [
                                'default' => [
                                    'unit' => 'custom',
                                    'size' => 1.65,
                                ],
                            ],
                            'letter_spacing' => [
                                'default' => [
                                    'unit' => 'em',
                                    'size' => 0,
                                ],
                            ],
                            'text_transform' => [
                                'default' => 'none',
                            ],
                            'text_decoration' => [
                                'default' => 'none',
                            ],
                        ],
                        'condition' => [
                            'edContent' => 'true',
                        ],
                    ],
                    'ribbonContentTypography' => [
                        'type'      => Group_Control_Typography::get_type(),
                        'label'     => __('Product Ribbon', 'affiliatex'),
                        'selector'  => $this->select_element('ribbon'),
                        'fields_options' => [
                            'typography'  => [
                                'default' => 'custom'
                            ],
                            'font_family' => [
                                'default' => ''
                            ],
                            'font_weight' => [
                                'default' => '400'
                            ],
                            'font_size'   => [
                                'default' => [
                                    'unit' => 'px',
                                    'size' => '17'
                                ]
                            ],
                            'line_height' => [
                                'default' => [
                                    'unit' => 'custom',
                                    'size' => 1.65,
                                ],
                            ],
                            'letter_spacing' => [
                                'default' => [
                                    'unit' => 'em',
                                    'size' => 0,
                                ],
                            ],
                            'text_transform' => [
                                'default' => 'none',
                            ],
                            'text_decoration' => [
                                'default' => 'none',
                            ],
                        ],
                        'condition' => [
                            'edRibbon' => 'true',
                        ],
                    ],
                    'numRatingTypography' => [
                        'type'      => Group_Control_Typography::get_type(),
                        'label'     => __('Score Box', 'affiliatex'),
                        'selector'  => $this->select_element('rating-number'),
                        'fields_options' => [
                            'typography'  => [
                                'default' => 'custom'
                            ],
                            'font_family' => [
                                'default' => ''
                            ],
                            'font_weight' => [
                                'default' => '400'
                            ],
                            'font_size'   => [
                                'default' => [
                                    'unit' => 'px',
                                    'size' => '36'
                                ]
                            ],
                            'line_height' => [
                                'default' => [
                                    'unit' => 'custom',
                                    'size' => 1.65,
                                ],
                            ],
                            'letter_spacing' => [
                                'default' => [
                                    'unit' => 'em',
                                    'size' => 0,
                                ],
                            ],
                            'text_transform' => [
                                'default' => 'none',
                            ],
                            'text_decoration' => [
                                'default' => 'none',
                            ],
                        ],
                        'condition' => [
                            'edRatings'   => 'true',
                            'PricingType' => 'number',
                        ],
                    ],
                ],
            ],

            'affx_sp_spacing' => [
                'label'  => __('Spacing', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_STYLE,
                'fields' => [
                    'imagePadding' => [
                        'label'      => __('Image Padding', 'affiliatex'),
                        'type'       => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%', 'em', 'rem', 'pt'],
                        'default'    => [
                            'unit'     => 'px',
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '0',
                            'left'     => '0',
                            'isLinked' => false,
                        ],
                        'selectors'  => [
                            $this->select_element('image') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ],
                    'contentMargin' => [
                        'label'      => __('Margin', 'affiliatex'),
                        'type'       => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%', 'em', 'rem', 'pt'],
                        'default'    => [
                            'unit'     => 'px',
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '30',
                            'left'     => '0',
                            'isLinked' => false,
                        ],
                        'selectors'  => [
                            $this->select_element('wrapper') => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ],
                    'contentSpacing' => [
                        'label'      => __('Padding', 'affiliatex'),
                        'type'       => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%', 'em', 'rem', 'pt'],
                        'default'    => [
                            'unit'     => 'px',
                            'top'      => '30',
                            'right'    => '25',
                            'bottom'   => '30',
                            'left'     => '25',
                            'isLinked' => false,
                        ],
                        'selectors'  => [
                            $this->select_element('wrapper') . '.product-layout-1 .affx-sp-content-wrapper' => 'padding-top: {{TOP}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}};',
                            $this->select_element('wrapper') . '.product-layout-2 .title-wrapper' => 'padding-top: {{TOP}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}};',
                            $this->select_element('wrapper') . '.product-layout-2 .affx-single-product-content' => 'padding-right: {{RIGHT}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}};',
                            $this->select_element('wrapper') . '.product-layout-2 .button-wrapper' => 'padding-bottom: {{BOTTOM}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}};',
                            $this->select_element('wrapper') . '.product-layout-3 .affx-sp-inner' => 'padding-top: {{TOP}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}};',
                        ],
                    ],
                ],
            ],

            'affx_sp_style_border' => [
                'label'  => __('Border', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_STYLE,
                'fields' => [
                    'productBorder' => [
                        'type'           => \Elementor\Group_Control_Border::get_type(),
                        'name'           => 'productBorder',
                        'responsive' => true,
                        'selector'       => $this->select_element('wrapper'),
                        'fields_options' => [
                            'border' => [
                                'default' => 'solid'
                            ],
                            'color'  => [
                                'default' => '#E6ECF7'
                            ],
                            'width'  => [
                                'default' => [
                                    'isLinked' => true,
                                    'unit'     => 'px',
                                    'top'      => '1',
                                    'right'    => '1',
                                    'bottom'   => '1',
                                    'left'     => '1'
                                ]
                            ]
                        ]
                    ],
                    'productBorderRadius' => [
                        'label'       => esc_html__('Border Radius', 'affiliatex'),
                        'type'        => Controls_Manager::DIMENSIONS,
                        'size_units'  => ['px', '%', 'em', 'rem', 'custom'],
                        'default'     => [
                            'top'      => 0,
                            'right'    => 0,
                            'bottom'   => 0,
                            'left'     => 0,
                            'unit'     => 'px',
                            'isLinked' => false,
                        ],
                        'selectors'   => [
                            $this->select_element('wrapper') => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ],
                    'productImageBorderRadius' => [
                        'label'       => esc_html__('Image Border Radius', 'affiliatex'),
                        'type'        => Controls_Manager::DIMENSIONS,
                        'size_units'  => ['px', '%'],
                        'default'     => [
                            'top'      => 0,
                            'right'    => 0,
                            'bottom'   => 0,
                            'left'     => 0,
                            'unit'     => 'px',
                            'isLinked' => false,
                        ],
                        'selectors'   => [
                            $this->select_element('wrapper') . ' .affx-sp-img-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            $this->select_element('wrapper') . ' .affx-sp-img-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                        'condition' => [
                            'edProductImage' => 'true',
                        ],
                    ],
                    'productShadow' => [
                        'type'           => \Elementor\Group_Control_Box_Shadow::get_type(),
                        'name'           => 'productShadow',
                        'selector'       => $this->select_element('wrapper'),
                        'field_options'  => [
                            'box_shadow_type' => [
                                'default' => 'no'
                            ],
                            'box_shadow'      => [
                                'default' => [
                                    'v_offset' => 5,
                                    'h_offset' => 0,
                                    'blur'     => 20,
                                    'spread'   => 0,
                                    'color'    => 'rgba(93, 113, 147, 0.2)',
                                    'inset'    => false
                                ]
                            ]
                        ]
                    ]
                ],
            ],
            'affx_sp_style_divider' => [
                'label'  => __('Divider', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_STYLE,
                'fields' => [
                    'edDivider' => [
                        'label'        => esc_html__('Enable Divider', 'affiliatex'),
                        'type'         => Controls_Manager::SWITCHER,
                        'label_on'     => esc_html__('On', 'affiliatex'),
                        'label_off'    => esc_html__('Off', 'affiliatex'),
                        'return_value' => 'true',
                        'default'      => 'false',
                    ],
                    'productDividerStyle' => [
                        'label'     => esc_html__('Divider Style', 'affiliatex'),
                        'type'      => Controls_Manager::SELECT,
                        'default'   => 'solid',
                        'options'   => [
                            'none'   => esc_html__('None', 'affiliatex'),
                            'solid'  => esc_html__('Solid', 'affiliatex'),
                            'dashed' => esc_html__('Dashed', 'affiliatex'),
                            'dotted' => esc_html__('Dotted', 'affiliatex'),
                            'double' => esc_html__('Double', 'affiliatex'),
                            'groove' => esc_html__('Groove', 'affiliatex'),
                        ],
                        'selectors' => [
                            $this->select_element('wrapper') . ' .title-wrapper' => 'border-bottom-style: {{VALUE}};',
                        ],
                        'condition' => [
                            'edDivider' => 'true'
                        ]
                    ],
                    'productDividerWidth' => [
                        'label'     => esc_html__('Divider Width', 'affiliatex'),
                        'type'      => Controls_Manager::SLIDER,
                        'size_units'=> ['px'],
                        'range'     => [
                            'px' => [
                                'min'  => 0,
                                'max'  => 5,
                                'step' => 1,
                            ]
                        ],
                        'default'   => [
                            'unit' => 'px',
                            'size' => 1,
                        ],
                        'selectors' => [
                            $this->select_element('wrapper') . ' .title-wrapper' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                        ],
                        'condition' => [
                            'edDivider' => 'true'
                        ]
                    ],
                    'productDividerColor' => [
                        'label'     => esc_html__('Divider Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            $this->select_element('wrapper') . ' .title-wrapper' => 'border-color: {{VALUE}}',
                        ],
                        'condition' => [
                            'edDivider' => 'true'
                        ]
                    ],
                    'amazonAttributes' => [
                        'type' => Controls_Manager::HIDDEN,
                        'default' => [
                            [
                                'field' => 'title',
                                'blockField' => [
                                    'name' => 'productTitle',
                                    'type' => 'text',
                                    'defaults' => [
                                        'productTitle' => $defaults['productTitle'],
                                    ],
                                ],
                                'type' => 'text',
                            ],
                            [
                                'field' => 'features',
                                'blockField' => [
                                    'name' => 'productContentListAmazon',
                                    'type' => 'list',
                                    'string' => 'productContent',
                                    'list' => 'productContentList',
                                    'defaults' => [
                                        'productContentListAmazon' => '',
                                        'productContentType' => 'list',
                                    ],
                                    'conditions' => [
                                        'productContentType' => 'amazon',
                                    ],
                                ],
                                'type' => 'list',
                            ],
                            [
                                'field' => 'display_price',
                                'blockField' => [
                                    'name' => 'productSalePrice',
                                    'type' => 'text',
                                    'format' => 'price',
                                    'defaults' => [
                                        'productSalePrice' => $defaults['productSalePrice'],
                                    ],
                                    'conditions' => [
                                        'edPricing' => 'true',
                                    ],
                                ],
                                'type' => 'text',
                            ],
                            [
                                'field' => 'regular_display_price',
                                'blockField' => [
                                    'name' => 'productPrice',
                                    'type' => 'text',
                                    'format' => 'price',
                                    'defaults' => [
                                        'productPrice' => $defaults['productPrice'],
                                    ],
                                    'conditions' => [
                                        'edPricing' => 'true',
                                    ],
                                ],
                                'type' => 'text',
                            ],
                            [
                                'field' => 'images',
                                'blockField' => [
                                    'name' => 'productImageExternal',
                                    'type' => 'image',
                                    'defaults' => [
                                        'productImageExternal' => $defaults['productImageExternal'],
                                        'productImageType' => 'default',
                                    ],
                                    'conditions' => [
                                        'productImageType' => 'external',
                                    ],
                                ],
                                'type' => 'image',
                            ],
                            [
                                'field' => 'url',
                                'blockField' => [
                                    'name' => 'button_child_buttonURL',
                                    'type' => 'link',
                                    'defaults' => [
                                        'button_child_buttonURL' => '',
                                    ],
                                    'conditions' => [
                                        'blockUrl' => '[@copy]'
                                    ],
                                ],
                                'type' => 'link',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Render for Elementor
     *
     * @return void
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->render_sp($settings);
    }

    /**
     * Suffix added so it is easy to be called from other blocks.
     * @param mixed $settings
     * @param mixed $child_attributes
     * @return void
     */
    public function render_sp($settings, $child_attributes = null){
        $attributes                   = $this->parse_attributes($settings);
        $attributes                   = WidgetHelper::process_attributes($attributes);
        $attributes['block_id']       = $this->get_id();
        $attributes['ImgUrl']         = $settings['ImgUrl']['url'] ?? $settings['ImgUrl'];
        $attributes['ratingStarSize'] = $attributes['ratingStarSize']['size'] ?? 25;

        if (!empty($attributes['productContentListAmazon'])) {
            $attributes['productContentList'] = $attributes['productContentListAmazon'];
        } elseif (! empty($attributes['productContentList']) && is_array($attributes['productContentList'])) {
            $attributes['productContentList'] = ElementorHelper::extract_list_items($attributes['productContentList']);
        }

        if (! empty($attributes['productIconList'])) {
            $attributes['productIconList'] = ElementorHelper::extract_icon($attributes['productIconList']);
        }

        $button_child    = '';

        if (isset($attributes['edButton'])) {
            if(!$child_attributes){
                $child_attributes = ChildHelper::extract_attributes($attributes, self::$inner_button_config);
            }

            ob_start();
            $this->render_button($child_attributes);
            $button_child = ob_get_clean();
        }

        echo $this->render_sp_template($attributes, $button_child);
    }

    /**
     * Core render function
     *
     * @param array $attributes
     * @param string $content
     * @return string
     */
    public function render_sp_template(array $attributes, string $content = '') : string
    {
        $attributes = $this->parse_attributes($attributes);
        extract($attributes);

        if(is_array($productContentList) && count($productContentList) > 0 && isset($productContentList[0]['list']) && is_string($productContentList[0]['list']) && has_shortcode($productContentList[0]['list'], 'affiliatex-product')){
            $productContentList = do_shortcode($productContentList[0]['list']);
            $productContentList = json_decode($productContentList, true);
        }

        if(self::IS_ELEMENTOR){
            $wrapper_attributes = sprintf(
                'id="%s" class="%s" data-widget-type="%s"',
                "affiliatex-single-product-style-$block_id",
                "affx-amazon-item",
                "affiliatex-single-product"
            );
        } else {
            $wrapper_attributes = get_block_wrapper_attributes(array(
                'id' => "affiliatex-single-product-style-$block_id",
            ));
        }

        $wrapper_attributes = AffiliateX_Helpers::add_clickable_attributes($wrapper_attributes, $edFullBlockLink, $blockUrl, $blockOpenInNewTab);
        $productTitleTag    = AffiliateX_Helpers::validate_tag($productTitleTag, 'h2');
        $productSubTitleTag = AffiliateX_Helpers::validate_tag($productSubTitleTag, 'h3');

        $layoutClass = '';
        if ($productLayout === 'layoutOne') {
            $layoutClass = ' product-layout-1';
        } elseif ($productLayout === 'layoutTwo') {
            $layoutClass = ' product-layout-2';
        } elseif ($productLayout === 'layoutThree') {
            $layoutClass = ' product-layout-3';
        }

        if (str_contains($content, $layoutClass)) {
            return str_replace('app/src/images/fallback', 'src/images/fallback', $content);
        }

        $ratingClass = '';

        if ($PricingType === 'picture') {
            $ratingClass = 'star-rating';
        } elseif ($PricingType === 'number') {
            $ratingClass = 'number-rating';
        }

        $imageAlign   = $edProductImage ? 'image-' . $productImageAlign : '';
        $ribbonLayout = '';

        if ($productRibbonLayout === 'one') {
            $ribbonLayout = ' ribbon-layout-one';
        } elseif ($productRibbonLayout === 'two') {
            $ribbonLayout = ' ribbon-layout-two';
        }

        $imageClass = !$edProductImage ? 'no-image' : '';
        $productRatingNumberClass = $PricingType === 'number' ? 'rating-align-' . $productRatingAlign : '';
        $ImageURL = $productImageType === 'default' ? $ImgUrl : $productImageExternal;
        $isSiteStripe = 'sitestripe' === $productImageType && '' !== $productImageSiteStripe ? true : false;
        $productImage = AffiliateX_Helpers::affiliatex_get_media_image_html($ImgID ?? 0, $ImageURL, $ImgAlt ?? '', $isSiteStripe, $productImageSiteStripe);

        $buttonDirection = $buttonDirection ?? 'column';
        $buttonsGap = $buttonsGap ?? 10;

        $list = '';

        if( $edContent && isset($productContentList) && !empty($productContentList) ) {
            $list = AffiliateX_Helpers::render_list(
                array(
                    'listType' => $ContentListType,
                    'unorderedType' => 'icon',
                    'listItems' => $productContentList ?? [],
                    'iconName' => isset($productIconList['value']) ? $productIconList['value'] : '',
                )
            );
        }

        ob_start();
        // Directly include the template file instead of get_template_path() to make it work as child widget.
        include AFFILIATEX_PLUGIN_DIR . '/templates/blocks/single-product.php';
        $output = ob_get_clean();

        return $output;
    }
}