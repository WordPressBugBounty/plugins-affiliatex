<?php
namespace AffiliateX\Elementor\Widgets;

defined('ABSPATH') || exit;

use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use AffiliateX\Helpers\Elementor\WidgetHelper;
use Affiliatex\Traits\ProductComparisonRenderTrait;
use AffiliateX\Elementor\ControlsManager;

class ProductComparisonWidget extends ElementorBase
{
    use ProductComparisonRenderTrait;

    public function get_title()
    {
        return __('AffiliateX Product Comparison', 'affiliatex');
    }

    public function get_icon()
    {
        return 'affx-icon-product-comparison';
    }

    public function get_keywords()
    {
        return [
            "product",
            "comparison",
            "AffiliateX"
        ];
    }

    protected function _register_controls()
    {
        ///////////////////////////////////////////////////
        // CONENT TAB
        ///////////////////////////////////////////////////
        /**************************************************************
         * General Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_pc_general_settings',
            [
                'label' => __('General Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'pcRibbon',
            [
                'label'        => __('Enable Ribbon', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'affiliatex'),
                'label_off'    => __('No', 'affiliatex'),
                'return_value' => 'true',
                'default'      => 'true'
            ]
        );

        $this->add_control(
            'pcImage',
            [
                'label'        => __('Enable Images', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'affiliatex'),
                'label_off'    => __('No', 'affiliatex'),
                'return_value' => 'true',
                'default'      => 'true'
            ]
        );

        $this->add_control(
            'pcTitle',
            [
                'label'        => __('Enable Title', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'affiliatex'),
                'label_off'    => __('No', 'affiliatex'),
                'return_value' => 'true',
                'default'      => 'true'
            ]
        );

        $this->add_control(
            'pcPrice',
            [
                'label'        => __('Enable Prices', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'affiliatex'),
                'label_off'    => __('No', 'affiliatex'),
                'return_value' => 'true',
                'default'      => 'true'
            ]
        );

        $this->add_control(
            'pcRating',
            [
                'label'        => __('Enable Ratings', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'affiliatex'),
                'label_off'    => __('No', 'affiliatex'),
                'return_value' => 'true',
                'default'      => 'true'
            ]
        );

        $this->add_control(
            'pcTitleColumn',
            [
                'label'        => __('Enable Title Column', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default'      => 'true'
            ]
        );

        $this->add_control(
            'matchCardHeights',
            [
                'label'        => __('Match Card Heights', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default'      => 'false',
                'description'  => __('Make all product cards the same height and align buttons at the bottom.', 'affiliatex'),
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Title Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_pc_title_settings',
            [
                'label' => __('Title Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'pcTitle' => 'true'
                ]
            ]
        );

        $this->add_control(
            'pcTitleTag',
            [
                'label'   => __('Title Tag', 'affiliatex'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h2' => __('Heading (H2)', 'affiliatex'),
                    'h3' => __('Heading (H3)', 'affiliatex'),
                    'h4' => __('Heading (H4)', 'affiliatex'),
                    'h5' => __('Heading (H5)', 'affiliatex'),
                    'h6' => __('Heading (H6)', 'affiliatex')
                ],
                'condition' => [
                    'pcTitle' => 'true'
                ]
            ]
        );

        $this->add_control(
            'pcTitleAlign',
            [
                'label'     => __('Title Alignment', 'affiliatex'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'affiliatex'),
                        'icon'  => 'fa fa-align-left'
                    ],
                    'center' => [
                        'title' => __('Center', 'affiliatex'),
                        'icon'  => 'fa fa-align-center'
                    ],
                    'right'  => [
                        'title' => __('Right', 'affiliatex'),
                        'icon'  => 'fa fa-align-right'
                    ]
                ],
                'default'   => 'center',
                'toggle'    => false,
                'render_type' => 'template',
                'selectors' => [
                    $this->select_element('product-title') => 'text-align: {{VALUE}};'
                ],
                'condition' => [
                    'pcTitle' => 'true'
                ]
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Button Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_button_settings_section',
            [
                'label' => __('Button Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'pcButton',
            [
                'label'        => __('Enable Button', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'affiliatex'),
                'label_off'    => __('No', 'affiliatex'),
                'return_value' => 'true',
                'default'      => 'true'
            ]
        );

        $this->add_control(
            'pcButtonIcon',
            [
                'label'        => __('Enable Icon', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'affiliatex'),
                'label_off'    => __('No', 'affiliatex'),
                'return_value' => 'true',
                'default'      => 'true',
                'condition'    => [
                    'pcButton' => 'true'
                ]
            ]
        );

        $this->add_control(
            'buttonIcon',
            [
                'label'     => __('Button Icon', 'affiliatex'),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-angle-right',
                    'library' => 'fa-solid'
                ],
                'condition' => [
                    'pcButton'     => 'true',
                    'pcButtonIcon' => 'true'
                ]
            ]
        );

        $this->add_control(
            'buttonIconAlign',
            [
                'label'     => __('Icon Alignment', 'affiliatex'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'  => [
                        'title' => __('Left', 'affiliatex'),
                        'icon'  => 'fa fa-align-left'
                    ],
                    'right' => [
                        'title' => __('Right', 'affiliatex'),
                        'icon'  => 'fa fa-align-right'
                    ]
                ],
                'default'   => 'right',
                'toggle'    => false,
                'condition' => [
                    'pcButton'     => 'true',
                    'pcButtonIcon' => 'true'
                ]
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Products
         **************************************************************/
        $this->start_controls_section(
            'affx_pc_products_section',
            [
                'label' => __('Products Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'productComparisonTable',
            [
                'label'       => __('Products', 'affiliatex'),
                'type'        => Controls_Manager::REPEATER,
                'title_field' => '{{{ title }}}',
                'fields'      => [
                    [
                        'name'        => 'title',
                        'label'       => __('Title', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'repeater_name' => 'productComparisonTable',
                        'default'     => __('Product Title', 'affiliatex'),
                    ],
                    [
                        'name'  => 'productImageType',
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
                        ],
                        'toggle' => false,
                    ],
                    [
                        'name'    => 'imageUrl',
                        'label'   => __('Image', 'affiliatex'),
                        'type'    => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src()
                        ],
                        'condition' => [
                            'productImageType' => 'default',
                        ],
                    ],
                    [
                        'name'  => 'productImageExternal',
                        'label'       => __('External Image URL', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'repeater_name' => 'productComparisonTable',
                        'condition'   => [
                            'productImageType' => 'external',
                        ],
                    ],
                    [
                        'name'  => 'ribbonText',
                        'label' => __('Ribbon Text', 'affiliatex'),
                        'type'  => Controls_Manager::TEXT,
                    ],
                    [
                        'name'    => 'price',
                        'label'   => __('Price', 'affiliatex'),
                        'type'    => ControlsManager::TEXT,
                        'default' => '$59.00',
                        'repeater_name' => 'productComparisonTable',
                    ],
                    [
                        'name'    => 'rating',
                        'label'   => __('Rating', 'affiliatex'),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 4,
                        'options' => [
                            1 => 1,
                            2 => 2,
                            3 => 3,
                            4 => 4,
                            5 => 5
                        ],
                    ],
                    [
                        'name'    => 'button',
                        'label'   => __('Button Text', 'affiliatex'),
                        'type'    => Controls_Manager::TEXT,
                        'default' => 'Buy Now',
                    ],
                    [
                        'name'  => 'buttonURL',
                        'label' => __('Button URL', 'affiliatex'),
                        'type'  => ControlsManager::TEXT,
                        'repeater_name' => 'productComparisonTable',
                    ],
                    [
                        'name'  => 'btnOpenInNewTab',
                        'label' => esc_html__('Open Link In New Tab', 'affiliatex'),
                        'type' => Controls_Manager::SWITCHER,
                        'return_value' => 'true',
                        'default' => 'false',
                    ],
                    [
                        'name'  => 'btnRelNoFollow',
                        'label' => esc_html__('Add Rel="Nofollow"?', 'affiliatex'),
                        'type' => Controls_Manager::SWITCHER,
                        'return_value' => 'true',
                        'default' => 'false',
                    ],
                    [
                        'name'  => 'btnRelSponsored',
                        'label' => esc_html__('Add Rel="Sponsored"?', 'affiliatex'),
                        'type' => Controls_Manager::SWITCHER,
                        'return_value' => 'true',
                        'default' => 'false',
                    ],
                    [
                        'name'  => 'btnDownload',
                        'label' => esc_html__('Download Button', 'affiliatex'),
                        'type' => Controls_Manager::SWITCHER,
                        'return_value' => 'true',
                        'default' => 'false',
                    ],
                ],
                'default'     => [
                    [
                        'title'      => __('Product Title', 'affiliatex'),
                        'imageUrl'   => [
                            'url' => Utils::get_placeholder_image_src()
                        ],
                        'ribbonText' => 'Our Pick',
                        'price'      => '$59.00',
                        'rating'     => 4,
                        'button'     => 'Buy Now',
                        'buttonURL'  => ''
                    ],
                    [
                        'title'      => __('Product Title', 'affiliatex'),
                        'imageUrl'   => [
                            'url' => Utils::get_placeholder_image_src()
                        ],
                        'ribbonText' => '',
                        'price'      => '$59.00',
                        'rating'     => 4,
                        'button'     => 'Buy Now',
                        'buttonURL'  => ''
                    ]
                ]
            ]
        );

        $specsRepeater = new \Elementor\Repeater();

        $specsRepeater->add_control(
            'spec',
            [
                'label' => __('Text', 'affiliatex'),
                'type'  => ControlsManager::TEXT,
                'default' => 'Specification',
                'repeater_name' => 'comparisonSpecs',
                'inner_repeater_name' => 'inner_rows',
            ]
        );

        $rowsRepeater = new \Elementor\Repeater();

        $rowsRepeater->add_control(
            'title',
            [
                'label' => __('Title', 'affiliatex'),
                'type'  => \Elementor\Controls_Manager::TEXT,
                'default' => 'Title',
            ]
        );

        $rowsRepeater->add_control(
            'inner_rows',
            [
                'label'   => __('Specifications', 'affiliatex'),
                'type'    => \Elementor\Controls_Manager::REPEATER,
                'title_field' => '{{{ spec }}}',
                'fields'  => $specsRepeater->get_controls(),
                'default' => [
                    [
                        'spec' => __('Specification', 'affiliatex'),
                    ],
                    [
                        'spec' => __('Specification', 'affiliatex'),
                    ],
                ],
            ]
        );

        // Add the outer repeater to the main control
        $this->add_control(
            'comparisonSpecs',
            [
                'label'  => __('Comparision Rows', 'affiliatex'),
                'type'   => \Elementor\Controls_Manager::REPEATER,
                'fields' => $rowsRepeater->get_controls(),
                'title_field' => '{{ title }}',
                'classes' => 'affx-nested-repeater',
                'default'     => [
                    [
                        'row_label'  => __('Title', 'affiliatex'),
                        'inner_rows' => [
                            [
                                'spec' => __('Specification', 'affiliatex'),
                            ],
                            [
                                'spec' => __('Specification', 'affiliatex'),
                            ],
                        ],
                    ],
                ],
            ]
        );

        // Amazon Attributes Configuration
        $this->add_control(
            'amazonAttributes',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => [
                    [
                        'field' => 'title',
                        'blockField' => [
                            'name' => 'title',
                            'type' => 'text',
                            'repeaterName' => 'productComparisonTable',
                            'defaults' => [
                                'title' => __('Product Title', 'affiliatex'),
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'field' => 'display_price',
                        'blockField' => [
                            'name' => 'price',
                            'type' => 'text',
                            'repeaterName' => 'productComparisonTable',
                            'defaults' => [
                                'price' => '$59.00',
                            ],
                            'conditions' => [
                                'pcPrice' => 'true',
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'field' => 'images',
                        'blockField' => [
                            'name' => 'productImageExternal',
                            'type' => 'image',
                            'repeaterName' => 'productComparisonTable',
                            'defaults' => [
                                'productImageExternal' => '',
                            ],
                            'conditions' => [
                                'pcImage' => 'true',
                            ],
                        ],
                        'type' => 'image',
                    ],
                    [
                        'field' => 'url',
                        'blockField' => [
                            'name' => 'buttonURL',
                            'type' => 'link',
                            'repeaterName' => 'productComparisonTable',
                            'defaults' => [
                            'buttonURL' => '',
                            ],
                            'conditions' => [
                                'pcButton' => 'true',
                            ],
                        ],
                        'type' => 'link',
                    ],
                    [
                        'field' => 'features',
                        'blockField' => [
                            'name' => 'spec',
                            'type' => 'text',
                            'repeaterName' => 'comparisonSpecs',
                            'innerRepeaterName' => 'inner_rows',
                            'defaults' => [
                                'spec' => __('Specification', 'affiliatex'),
                            ],
                        ],
                        'type' => 'text',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        ///////////////////////////////////////////////////
        // STYLE TAB
        ///////////////////////////////////////////////////
        /**************************************************************
         * Border Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_pc_border_section',
            [
                'label' => __('Border', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'border',
                'label'          => __('Border', 'affiliatex'),
                'responsive'     => true,
                'selector'       => WidgetHelper::select_multiple_elements([
                    $this->select_element('container'),
                    $this->select_element('table-headings'),
                    $this->select_element('table-cells')
                ]),
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
            ]
        );

        $this->add_responsive_control(
            'borderRadius',
            [
                'label'      => __('Border Radius', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    $this->select_element('container') => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'boxShadow',
                'selector'       => $this->select_element('wrapper'),
                'label'          => __('Box Shadow', 'affiliatex'),
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Color Settings Section
         **************************************************************/
        $this->start_controls_section(
            'affx_pc_colors_section',
            [
                'label' => __('Colors', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'ribbonColor',
            [
                'label'     => __('Ribbon Background Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#F13A3A',
                'selectors' => [
                    $this->select_element('product-ribbon') => 'background-color: {{VALUE}};',
                    $this->select_element('product-ribbon') . '::before' => 'background-color: {{VALUE}};',
                    $this->select_element('product-ribbon') . '::after' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'pcRibbon' => 'true'
                ]
            ]
        );

        $this->add_control(
            'ribbonTextColor',
            [
                'label'     => __('Ribbon Text Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    $this->select_element('product-ribbon') => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'pcRibbon' => 'true'
                ]
            ]
        );

        $this->add_control(
            'titleColor',
            [
                'label'     => __('Title Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#262B33',
                'selectors' => [
                    $this->select_element('product-title') => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'pcTitle' => 'true'
                ]
            ]
        );

        $this->add_control(
            'priceColor',
            [
                'label'     => __('Price Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#262B33',
                'selectors' => [
                    $this->select_element('product-price') => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'pcPrice' => 'true'
                ]
            ]
        );

        $this->add_control(
            'starColor',
            [
                'label'   => __('Star Color', 'affiliatex'),
                'type'    => Controls_Manager::COLOR,
                'default' => '#FFB800',
                'condition' => [
                    'pcRating' => 'true'
                ]
            ]
        );

        $this->add_control(
            'starInactiveColor',
            [
                'label'   => __('Inactive Star Color', 'affiliatex'),
                'type'    => Controls_Manager::COLOR,
                'default' => '#A3ACBF',
                'condition' => [
                    'pcRating' => 'true'
                ]
            ]
        );

        $this->add_control(
            'tableRowBgColor',
            [
                'label'     => __('Alternate Table Row Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#F5F7FA',
                'selectors' => [
                    $this->select_element('table-alternate-row') => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'contentColor',
            [
                'label'     => __('Content Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#292929',
                'selectors' => [
                    $this->select_element('product-content') => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'pcButtonColorsLabel',
            [
                'label' => esc_html__('Button', 'affiliatex'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'buttonTextColor',
            [
                'label'     => __('Button Text Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    $this->select_element('button') => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'pcButton' => 'true'
                ]
            ]
        );

        $this->add_control(
            'buttonTextHoverColor',
            [
                'label'     => __('Button Text Hover Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    $this->select_element('button:hover') => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'pcButton' => 'true'
                ]
            ]
        );

        $this->add_control(
            'buttonBgColor',
            [
                'label'     => __('Button Background Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#2670FF',
                'selectors' => [
                    $this->select_element('button') => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'pcButton' => 'true'
                ]
            ]
        );

        $this->add_control(
            'buttonBgHoverColor',
            [
                'label'     => __('Button Background Hover Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#084ACA',
                'selectors' => [
                    $this->select_element('button:hover') => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'pcButton' => 'true'
                ]
            ]
        );

        $this->add_control(
            'pcBackgroundLabel',
            [
                'label' => esc_html__('Background', 'affiliatex'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'bgColorSolid',
                'label'          => __('Background Color', 'affiliatex'),
                'types'          => ['classic', 'gradient'],
                'exclude'        => ['image'],
                'selector'       => $this->select_element('container'),
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                        'options' => [
                            'classic' => [
                                'title' => esc_html__('Color', 'affiliatex'),
                                'icon' => 'eicon-paint-brush',
                            ],
                            'gradient' => [
                                'title' => esc_html__('Gradient', 'affiliatex'),
                                'icon' => 'eicon-barcode',
                            ],
                        ]
                    ],
                    'color'      => [
                        'default' => '#FFFFFF',
                        'label' => __('Background Color', 'affiliatex'),
                    ],
                    'gradient'   => [
                        'default' => 'linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%)'
                    ],
                ]
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Typography Section
         **************************************************************/
        $this->start_controls_section(
            'affx_pc_typography_section',
            [
                'label' => __('Typography', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'titleTypography',
                'label'          => __('Title Typography', 'affiliatex'),
                'selector'       => $this->select_element('product-title'),
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
                    'pcTitle' => 'true'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'ribbonTypography',
                'label'          => __('Ribbon Typography', 'affiliatex'),
                'selector'       => $this->select_element('product-ribbon'),
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
                            'size' => '13'
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
                    'pcRibbon' => 'true'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'priceTypography',
                'label'          => __('Pricing Typography', 'affiliatex'),
                'selector'       => $this->select_element('product-price'),
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
                    'font_style' => [
                        'default' => 'normal'
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20'
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
                    'pcPrice' => 'true'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'buttonTypography',
                'label'          => __('Button Typography', 'affiliatex'),
                'selector'       => $this->select_element('button'),
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
                            'size' => '16'
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
                    'pcButton' => 'true'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'contentTypography',
                'label'          => __('Content Typography', 'affiliatex'),
                'selector'       => $this->select_element('product-table'),
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
                ]
            ]
        );
        $this->end_controls_section();

        /**************************************************************
         * Spacing Section
         **************************************************************/
        $this->start_controls_section(
            'affx_pc_spacing_section',
            [
                'label' => __('Spacing', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'imagePadding',
            [
                'label'      => __('Image Padding', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'pt'],
                'selectors'  => [
                    $this->select_element('product-image') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false

                ],
                'condition' => [
                    'pcImage' => 'true'
                ]
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label'      => __('Margin', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'pt'],
                'selectors'  => [
                    $this->select_element('container') => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '30',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false

                ]
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label'      => __('Padding', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'pt'],
                'selectors'  => [
                    WidgetHelper::select_multiple_elements([
                        $this->select_element('table-headings'),
                        $this->select_element('table-cells')
                    ]) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'      => '24',
                    'right'    => '24',
                    'bottom'   => '24',
                    'left'     => '24',
                    'unit'     => 'px',
                    'isLinked' => false
                ]
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Button Styling
         **************************************************************/
        $this->start_controls_section(
            'affx_pc_button_style_section',
            [
                'label'     => __('Button', 'affiliatex'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pcButton' => 'true'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'buttonBorder',
                'label'     => __('Button Border', 'affiliatex'),
                'responsive' => true,
                'selector'  => $this->select_element('button'),
                'condition' => [
                    'pcButton' => 'true'
                ]
            ]
        );

        $this->add_responsive_control(
            'buttonRadius',
            [
                'label'      => __('Border Radius', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'pt'],
                'selectors'  => [
                    $this->select_element('button') => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'condition'  => [
                    'pcButton' => 'true'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'buttonShadow',
                'label'     => __('Box Shadow', 'affiliatex'),
                'selector'  => $this->select_element('button'),
                'condition' => [
                    'pcButton' => 'true'
                ]
            ]
        );

        $this->add_responsive_control(
            'buttonPadding',
            [
                'label'      => __('Padding', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'pt'],
                'selectors'  => [
                    $this->select_element('button') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'      => '10',
                    'right'    => '10',
                    'bottom'   => '10',
                    'left'     => '10',
                    'unit'     => 'px',
                    'isLinked' => false

                ],
                'condition'  => [
                    'pcButton' => 'true'
                ]
            ]
        );

        $this->add_responsive_control(
            'buttonMargin',
            [
                'label'      => __('Margin', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    $this->select_element('button') => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false

                ],
                'condition'  => [
                    'pcButton' => 'true'
                ]
            ]
        );
        
        $this->end_controls_section();
    }
}
