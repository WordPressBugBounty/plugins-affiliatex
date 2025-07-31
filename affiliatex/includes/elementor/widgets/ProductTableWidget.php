<?php

namespace AffiliateX\Elementor\Widgets;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use AffiliateX\Traits\ButtonRenderTrait;
use AffiliateX\Helpers\Elementor\WidgetHelper;
use AffiliateX\Traits\ProductTableRenderTrait;
use Elementor\Utils;
use AffiliateX\Elementor\ControlsManager;

class ProductTableWidget extends ElementorBase
{
    use ProductTableRenderTrait;
    use ButtonRenderTrait;

    protected function get_child_slugs(): array
    {
        return array( 'buttons' );
    }

    public function get_title()
    {
        return __('AffiliateX Product Table', 'affiliatex');
    }

    public function get_icon()
    {
        return 'affx-icon-product-table';
    }

    public function get_keywords()
    {
        return [
            "product",
            "table",
            "AffiliateX"
        ];
    }

    /**
     * Child button 1 config
     *
     * @var array
     */
    protected static $button1_config = array(
        'name_prefix'  => 'button_child1',
        'label_prefix' => 'Button',
        'index'        => 1,
        'is_child'     => true,
        'conditions'   => array( 'edButtons' => 'true' ),
        'wrapper'      => 'affx-btn-wrapper',
        'defaults'     => array(
            'button_label' => 'Buy Now',
            'buttonMargin' => array(
                'top'    => 0,
                'right'  => 0,
                'bottom' => 0,
                'left'   => 0,
                'unit'   => 'px',
            ),
        ),
    );

    /**
     * Child button 2 config
     *
     * @var array
     */
    protected static $button2_config = array(
        'name_prefix'  => 'button_child2',
        'label_prefix' => 'Button',
        'index'        => 2,
        'is_child'     => true,
        'wrapper'      => 'affx-btn-wrapper',
        'conditions'   => array(
            'edButtons'   => 'true',
            'edButtonTwo' => 'true',
        ),
        'defaults'     => array(
            'button_label'            => 'More Details',
            'button_background_color' => '#FFB800',
            'buttonMargin'            => array(
                'top'    => 0,
                'right'  => 0,
                'bottom' => 0,
                'left'   => 0,
                'unit'   => 'px',
            ),
        ),
    );

    protected function get_elements(): array
    {
        return array(
            'wrapper'          => 'affx-pdt-table-wrapper',
            'title'            => 'affx-pdt-table-wrapper .affx-pdt-name',
            'button'           => 'affx-pdt-table-wrapper .affiliatex-button',
            'primary-button'   => 'affx-pdt-table-wrapper .affiliatex-button.primary',
            'secondary-button' => 'affx-pdt-table-wrapper .affiliatex-button.secondary',
            'image'            => 'image-wrapper',
            'star-rating'      => 'star-rating-single-wrap',
            'circle-rating'    => 'affx-circle-progress-container .affx-circle-inside',
            'table'            => 'affx-pdt-table-wrapper',
            'table-single'     => 'affx-pdt-table-single',
            'price'            => 'affx-pdt-table-wrapper .affx-pdt-price-wrap',
            'image-container'  => 'affx-pdt-table-wrapper .affx-pdt-img-container',
        );
    }

    	public function get_elementor_controls( $params = array()) {
            $defaults = $this->get_fields();

		return [
			'layout_settings_section' => [
				'label' => __('Layout Settings', 'affiliatex'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'fields' => [
					'layoutStyle' => [
						'label' => __('Choose Layout', 'affiliatex'),
						'type' => Controls_Manager::SELECT,
						'default' => $defaults['layoutStyle'],
						'options' => [
							'layoutOne' => __('Layout One', 'affiliatex'),
							'layoutTwo' => __('Layout Two', 'affiliatex'),
							'layoutThree' => __('Layout Three', 'affiliatex'),
						],
					],
				]
			],

			'general_settings_section' => [
				'label' => __('General Settings', 'affiliatex'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'fields' => [
                    'edImage' => [
						'label' => __('Enable Image', 'affiliatex'),
						'type' => Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => $defaults['edImage'] ? 'true' : 'false',
					],
                    'edRibbon' => [
						'label' => __('Enable Ribbon', 'affiliatex'),
						'type' => Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => $defaults['edRibbon'] ? 'true' : 'false',
					],
                    'edProductName' => [
						'label' => __('Enable Product Name', 'affiliatex'),
						'type' => Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => $defaults['edProductName'] ? 'true' : 'false',
					],
                    'edRating' => [
						'label' => __('Enable Rating', 'affiliatex'),
						'type' => Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => $defaults['edRating'] ? 'true' : 'false',
					],
                    'edPrice' => [
						'label' => __('Enable Price', 'affiliatex'),
						'type' => Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => $defaults['edPrice'] ? 'true' : 'false',
					],
                    'edCounter' => [
						'label' => __('Enable Counter', 'affiliatex'),
						'type' => Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => $defaults['edCounter'] ? 'true' : 'false',
					],
				]
			],

			'product_name_settings_section' => [
				'label' => __('Title Settings', 'affiliatex'),
				'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'edProductName' => 'true'
                ],
				'fields' => [
                    'imageColTitle' => [
						'label' => esc_html__('Image Column Title', 'affiliatex'),
						'type' => Controls_Manager::TEXT,
						'default' => $defaults['imageColTitle'],
                        'condition' => [
                            'edImage' => 'true',
                        ],
					],
					'productColTitle' => [
						'label' => esc_html__('Product Column Title', 'affiliatex'),
						'type' => Controls_Manager::TEXT,
                        'default' => $defaults['productColTitle'],
						'condition' => [
                            'edProductName' => 'true',
                        ],
					],
					'featuresColTitle' => [
						'label' => esc_html__('Features Column Title', 'affiliatex'),
						'type' => Controls_Manager::TEXT,
                        'default' => $defaults['featuresColTitle'],
					],
					'ratingColTitle' => [
						'label' => esc_html__('Rating Column Title', 'affiliatex'),
						'type' => Controls_Manager::TEXT,
                        'default' => $defaults['ratingColTitle'],
						'condition' => [
                            'edRating' => 'true',
                        ],
					],
					'priceColTitle' => [
						'label' => esc_html__('Price Column Title', 'affiliatex'),
						'type' => Controls_Manager::TEXT,
                        'default' => $defaults['priceColTitle'],
					],
                    'productNameTag' => [
						'label' => __('Product Name Tag', 'affiliatex'),
						'type' => Controls_Manager::SELECT,
						'options' => [
                            'h2' => 'H2',
							'h3' => 'H3',
							'h4' => 'H4',
							'h5' => 'H5',
							'h6' => 'H6',
							'p' => 'Paragraph (p)',
						],
                        'default' => $defaults['productNameTag'],
                        'condition' => [
                            'edProductName' => 'true'
                        ],
					],
                ],
            ],

			'product_settings_section' => [
				'label' => __('Products Settings', 'affiliatex'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'fields' => [
					'productContentType' => [
						'label' => __('Content Type', 'affiliatex'),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
                            'paragraph' => [
                                'title' => __('Paragraph', 'affiliatex'),
                                'icon' => 'eicon-editor-paragraph',
                            ],
							'list' => [
								'title' => __('List', 'affiliatex'),
								'icon' => 'eicon-editor-list-ul',
							],
						],
						'default' => $defaults['productContentType'],
						'toggle' => false,
					],
                    'productTable' => [
                        'label'   => __( 'Products List', 'affiliatex' ),
                        'type'    => Controls_Manager::REPEATER,
                        'title_field' => '{{{ name }}}',
                        'fields'  => [
                            'imageType' => [
                                'name'  => 'imageType',
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
                            'imageUrl' => [
                                'name'        => 'imageUrl',
                                'label'       => __('Image', 'affiliatex'),
                                'type'        => Controls_Manager::MEDIA,
                                'render_type' => 'template',
                                'default'     => [
                                    'url' => Utils::get_placeholder_image_src()
                                ],
                                'condition' => [
                                    'imageType' => 'default',
                                ],
                            ],
                            'imageExternal' => [
                                'name'  => 'imageExternal',
                                'label'       => __('External Image URL', 'affiliatex'),
                                'type'        => ControlsManager::TEXT,
                                'repeater_name' => 'productTable',
                                'condition'   => [
                                    'imageType' => 'external',
                                ],
                            ],
                            'ribbon' => [
                                'name'    => 'ribbon',
                                'label'   => __( 'Ribbon Text', 'affiliatex' ),
                                'type'    => Controls_Manager::TEXT,
                                'default' => '',
                            ],
                            'name' => [
                                'name'    => 'name',
                                'label'   => __( 'Product Name', 'affiliatex' ),
                                'type'    => ControlsManager::TEXT,
                                'default' => $defaults['productTable'][0]['name'],
                                'repeater_name' => 'productTable',
                            ],
                            'features' => [
                                'name'    => 'features',
                                'label'   => __( 'Product Features', 'affiliatex' ),
                                'type'    => Controls_Manager::TEXTAREA,
                                'default' => $defaults['productTable'][0]['features'],
                                'repeater_name' => 'productTable',
                            ],
                            'featuresListType' => [
                                'name' => 'featuresListType',
                                'label' => esc_html__('Features List Type', 'affiliatex'),
                                'type' => Controls_Manager::CHOOSE,
                                'options' => [
                                    'list' => [
                                        'title' => esc_html__('List', 'affiliatex'),    
                                        'icon' => 'eicon-editor-list-ul',
                                    ],
                                    'amazon' => [
                                        'title' => esc_html__('Amazon', 'affiliatex'),
                                        'icon' => 'fa-brands fa-amazon',
                                    ], 
                                ],
                                'default' => 'list',
                                'toggle' => false,
                            ],
                            'featuresList' => [
                                'name'    => 'featuresList',
                                'label'   => __( 'Features List', 'affiliatex' ),
                                'type'    => Controls_Manager::REPEATER,
                                'fields' => [
                                    '_id' => [
                                        'name' => '_id',
                                        'type' => Controls_Manager::HIDDEN,
                                        'default' => '',
                                    ],

                                    'content' => [
                                        'name' => 'content',
                                        'type' => Controls_Manager::TEXT,
                                        'label' => __('List Item', 'affiliatex'),
                                        'default' => 'Enter new item',
                                    ],
                                ],
                                'title_field' => '{{ content }}',
                                'classes' => 'affx-nested-repeater',
                                'default'     => [
                                    [
                                        'content' => 'Enter new item',
                                    ],
                                ],
                                'condition' => [
                                    'featuresListType' => 'list',
                                ],
                            ],
                            'featuresListAmazon' => [
                                'name' => 'featuresListAmazon',
                                'label' => esc_html__('Amazon Features List', 'affiliatex'),
                                'type' => ControlsManager::TEXT,
                                'disabled' => true,
                                'placeholder' => __('Click on the button to connect product', 'affiliatex'),
                                'repeater_name' => 'productTable',
                                'condition' => [
                                    'featuresListType' => 'amazon',
                                ],
                            ],
                            'rating' => [
                                'name'    => 'rating',
                                'label'   => __( 'Rating', 'affiliatex' ),
                                'type'    => Controls_Manager::NUMBER,
                                'default' => $defaults['productTable'][0]['rating'],
                                'min'     => 1,
                                'max'     => 10,
                            ],
                            'offerPrice' => [
                                'name'    => 'offerPrice',
                                'label'   => __( 'Offer Price', 'affiliatex' ),
                                'type'    => ControlsManager::TEXT,
                                'default' => $defaults['productTable'][0]['offerPrice'],
                                'repeater_name' => 'productTable',
                            ],
                            'regularPrice' => [
                                'name'    => 'regularPrice',
                                'label'   => __( 'Regular Price', 'affiliatex' ),
                                'type'    => ControlsManager::TEXT,
                                'default' => $defaults['productTable'][0]['regularPrice'],
                                'repeater_name' => 'productTable',
                            ],
                            'primaryButtonRepeaterLabel' => [
                                'name' => 'primaryButtonRepeaterLabel',
                                'label' => esc_html__('Primary Button', 'affiliatex'),
                                'type' => Controls_Manager::HEADING,
                                'separator' => 'after',
                            ],
                            'button1' => [
                                'name'    => 'button1',
                                'label'   => __( 'Button 1 Text', 'affiliatex' ),
                                'type'    => Controls_Manager::TEXT,
                                'default' => $defaults['productTable'][0]['button1'],
                                'separator' => 'before',
                            ],
                            'button1URL' => [
                                'name'  => 'button1URL',
                                'label' => __( 'Button 1 URL', 'affiliatex' ),
                                'type'  => ControlsManager::TEXT,
                                'repeater_name' => 'productTable',
                                'placeholder' => 'https://example.com',
                            ],
                            'btn1RelNoFollow' => [
                                'name'    => 'btn1RelNoFollow',
                                'label'   => __( 'Button 1 Rel NoFollow', 'affiliatex' ),
                                'type'    => Controls_Manager::SWITCHER,
                                'return_type' => 'true',
                                'default' => $defaults['productTable'][0]['btn1RelNoFollow'] ? 'true' : 'false',
                            ],
                            'btn1RelSponsored' => [
                                'name'    => 'btn1RelSponsored',
                                'label'   => __( 'Button 1 Rel Sponsored', 'affiliatex' ),
                                'type'    => Controls_Manager::SWITCHER,
                                'return_type' => 'true',
                                'default' => $defaults['productTable'][0]['btn1RelSponsored'] ? 'true' : 'false',
                            ],
                            'btn1OpenInNewTab' => [
                                'name'    => 'btn1OpenInNewTab',
                                'label'   => __( 'Button 1 Open in New Tab', 'affiliatex' ),
                                'type'    => Controls_Manager::SWITCHER,
                                'return_type' => 'true',
                                'default' => $defaults['productTable'][0]['btn1OpenInNewTab'] ? 'true' : 'false',
                            ],
                            'btn1Download' => [
                                'name'    => 'btn1Download',
                                'label'   => __( 'Button 1 Download', 'affiliatex' ),
                                'type'    => Controls_Manager::SWITCHER,
                                'return_type' => 'true',
                                'default' => $defaults['productTable'][0]['btn1Download'] ? 'true' : 'false',
                            ],
                            'secondaryButtonRepeaterLabel' => [
                                'name' => 'secondaryButtonRepeaterLabel',
                                'label' => esc_html__('Secondary Button', 'affiliatex'),
                                'type' => Controls_Manager::HEADING,
                                'separator' => 'after',
                            ],
                            'button2' => [
                                'name'    => 'button2',
                                'label'   => __( 'Button 2 Text', 'affiliatex' ),
                                'type'    => Controls_Manager::TEXT,
                                'default' => $defaults['productTable'][0]['button2'],
                            ],
                            'button2URL' => [
                                'name'  => 'button2URL',
                                'label' => __( 'Button 2 URL', 'affiliatex' ),
                                'type'  => ControlsManager::TEXT,
                                'repeater_name' => 'productTable',
                                'placeholder' => 'https://www.example.com',
                            ],
                            'btn2RelNoFollow' => [
                                'name'    => 'btn2RelNoFollow',
                                'label'   => __( 'Button 2 Rel NoFollow', 'affiliatex' ),
                                'type'    => Controls_Manager::SWITCHER,
                                'return_type' => 'true',
                                'default' => $defaults['productTable'][0]['btn2RelNoFollow'] ? 'true' : 'false',
                            ],
                            'btn2RelSponsored' => [
                                'name'    => 'btn2RelSponsored',
                                'label'   => __( 'Button 2 Rel Sponsored', 'affiliatex' ),
                                'type'    => Controls_Manager::SWITCHER,
                                'return_type' => 'true',
                                'default' => $defaults['productTable'][0]['btn2RelSponsored'] ? 'true' : 'false',
                            ],
                            'btn2OpenInNewTab' => [
                                'name'    => 'btn2OpenInNewTab',
                                'label'   => __( 'Button 2 Open in New Tab', 'affiliatex' ),
                                'type'    => Controls_Manager::SWITCHER,
                                'return_type' => 'true',
                                'default' => $defaults['productTable'][0]['btn2OpenInNewTab'] ? 'true' : 'false',
                            ],
                            'btn2Download' => [
                                'name'    => 'btn2Download',
                                'label'   => __( 'Button 2 Download', 'affiliatex' ),
                                'type'    => Controls_Manager::SWITCHER,
                                'return_type' => 'true',
                                'default' => $defaults['productTable'][0]['btn2Download'] ? 'true' : 'false',
                            ],
                        ],
                        'default' => [
                            [
                                'imageUrl'         => Utils::get_placeholder_image_src(),
                                'ribbon'           => $defaults['productTable'][0]['ribbon'],
                                'name'             => $defaults['productTable'][0]['name'],
                                'features'         => $defaults['productTable'][0]['features'],
                                'featuresList'     => [
                                    [
                                        'content' => 'Enter new item',
                                    ],
                                ],
                                'offerPrice'       => $defaults['productTable'][0]['offerPrice'],
                                'regularPrice'     => $defaults['productTable'][0]['regularPrice'],
                                'rating'           => $defaults['productTable'][0]['rating'],
                                'button1'          => $defaults['productTable'][0]['button1'],
                                'button1URL'       => $defaults['productTable'][0]['button1URL'],
                                'btn1RelNoFollow'  => $defaults['productTable'][0]['btn1RelNoFollow'] ? 'true' : 'false',
                                'btn1RelSponsored' => $defaults['productTable'][0]['btn1RelSponsored'] ? 'true' : 'false',
                                'btn1OpenInNewTab' => $defaults['productTable'][0]['btn1OpenInNewTab'] ? 'true' : 'false',
                                'btn1Download'     => $defaults['productTable'][0]['btn1Download'] ? 'true' : 'false',
                                'button2'          => $defaults['productTable'][0]['button2'],
                                'button2URL'       => $defaults['productTable'][0]['button2URL'],
                                'btn2RelNoFollow'  => $defaults['productTable'][0]['btn2RelNoFollow'] ? 'true' : 'false',
                                'btn2RelSponsored' => $defaults['productTable'][0]['btn2RelSponsored'] ? 'true' : 'false',
                                'btn2OpenInNewTab' => $defaults['productTable'][0]['btn2OpenInNewTab'] ? 'true' : 'false',
                                'btn2Download'     => $defaults['productTable'][0]['btn2Download'] ? 'true' : 'false',
                            ],
                        ],
                    ],
					'contentListType' => [
						'label' => __('List Type', 'affiliatex'),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'unordered' => [
								'title' => __('Unordered', 'affiliatex'),
								'icon' => 'eicon-editor-list-ul',
							],
							'ordered' => [
								'title' => __('Ordered', 'affiliatex'),
								'icon' => 'eicon-editor-list-ol',
							],
						],
						'toggle' => false,
						'default' => $defaults['contentListType'],
						'condition' => [
							'productContentType' => 'list',
						],
					],
					'productIconList' => [
						'label' => __('List Icon', 'affiliatex'),
						'type' => Controls_Manager::ICONS,
						'default' => [
							'value' => $defaults['productIconList']['value'],
							'library' => 'fa-regular',
						],
						'condition' => [
							'productContentType' => 'list',
							'contentListType' => 'unordered',
						],
					],
				],
			],


			'primary_button_settings_section' => [
				'label' => __('Primary Button Settings', 'affiliatex'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'fields' => [
					'edButton1' => [
						'label' => __('Enable Primary Button', 'affiliatex'),
						'type' => Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => $defaults['edButton1'] ? 'true' : 'false',
					],
					'edButton1Icon' => [
						'label' => __('Enable Icon', 'affiliatex'),
						'type' => Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => $defaults['edButton1Icon'] ? 'true' : 'false',
                        'condition' => [
                            'edButton1' => 'true',
                        ]
					],
					'button1Icon' => [
						'type' => Controls_Manager::ICONS,
						'default' => [
							'value' => $defaults['button1Icon']['value'],
							'library' => 'fa-regular',
						],
						'condition' => [
							'edButton1' => 'true',
							'edButton1Icon' => 'true',
						],
					],
                    'button1IconAlign' => [
						'label' => __('Icon Alignment', 'affiliatex'),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'left' => [
								'title' => __('Left', 'affiliatex'),
								'icon' => 'eicon-text-align-left',
							],
							'right' => [
								'title' => __('Right', 'affiliatex'),
								'icon' => 'eicon-text-align-right',
							],
						],
						'default' => $defaults['button1IconAlign'],
						'toggle' => false,
						'condition' => [
							'edButton1' => 'true',
							'edButton1Icon' => 'true',
						]
					],
				],
			],

			'secondary_button_settings_section' => [
				'label' => __('Secondary Button Settings', 'affiliatex'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'fields' => [
					'edButton2' => [
						'label' => __('Enable Secondary Button', 'affiliatex'),
						'type' => Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => $defaults['edButton2'] ? 'true' : 'false',
					],
					'edButton2Icon' => [
						'label' => __('Enable Icon', 'affiliatex'),
						'type' => Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => $defaults['edButton2Icon'] ? 'true' : 'false',
                        'condition' => [
                            'edButton2' => 'true',
                        ]
					],
					'button2Icon' => [
						'type' => Controls_Manager::ICONS,
						'default' => [
							'value' => $defaults['button2Icon']['value'],
							'library' => 'fa-regular',
						],
						'condition' => [
							'edButton2' => 'true',
							'edButton2Icon' => 'true',
						],
					],
                    'button2IconAlign' => [
						'label' => __('Icon Alignment', 'affiliatex'),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'left' => [
								'title' => __('Left', 'affiliatex'),
								'icon' => 'eicon-text-align-left',
							],
							'right' => [
								'title' => __('Right', 'affiliatex'),
								'icon' => 'eicon-text-align-right',
							],
						],
						'default' => $defaults['button2IconAlign'],
						'toggle' => false,
						'condition' => [
							'edButton2' => 'true',
							'edButton2Icon' => 'true',
						]
					],
				],
			],

			'border_settings_section' => [
				'label' => __('Border Settings', 'affiliatex'),
				'tab' => Controls_Manager::TAB_STYLE,
				'fields' => [
                    'primaryButtonBorderLabel' => [
                        'label' => esc_html__('Primary Button', 'affiliatex'),
                        'type' => Controls_Manager::HEADING,
                        'separator' => 'after',
                        'condition' => [
                            'edButton1' => 'true',
                        ],
                    ],
					'button1Border' => [
						'label' => __('Border', 'affiliatex'),
						'type' => Group_Control_Border::get_type(),
						'selector' => $this->select_element('primary-button'),
						'fields_options' => [
							'border' => [
								'default' => $defaults['button1Border']['style'],
								'label' => __('Border Type', 'affiliatex'),
							],
							'color' => [
								'default' => $defaults['button1Border']['color']['color'],
								'label' => __('Border Color', 'affiliatex'),
							],
							'width' => [
								'default' => [
									'isLinked' => false,
									'unit' => 'px',
									'top' => $defaults['button1Border']['width'],
									'right' => $defaults['button1Border']['width'],
									'bottom' => $defaults['button1Border']['width'],
									'left' => $defaults['button1Border']['width']
								],
								'label' => __('Border Width', 'affiliatex'),
							]
						],
						'separator' => 'before',
						'condition' => [
                            'edButton1' => 'true',
						]
					],
					'button1Radius' => [
						'label' => __('Border Radius', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'rem', 'em'],
						'default' => [
							'top' => '0',
							'right' => '0',
							'bottom' => '0',
							'left' => '0',
							'unit' => 'px',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_element('primary-button') => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						],
						'condition' => [
                            'edButton1' => 'true',
						]
					],
					'button1Shadow' => [
						'type' => Group_Control_Box_Shadow::get_type(),
						'selector' => $this->select_element('primary-button'),
						'label' => __('Box Shadow', 'affiliatex'),
						'fields_options' => [
							'box_shadow_type' => [
								'default' => $defaults['button1Shadow']['enable'] ? 'enable' : '',
							],
							'box_shadow' => [
								'default' => [
									'vertical' => $defaults['button1Shadow']['v_offset'],
									'horizontal' => $defaults['button1Shadow']['h_offset'],
									'blur' => $defaults['button1Shadow']['blur'],
									'spread' => $defaults['button1Shadow']['spread'],
									'color' => $defaults['button1Shadow']['color']['color'],
									'inset' => $defaults['button1Shadow']['inset'],
                                ],
							]
                        ],
                        'condition' => [
                            'edButton1' => 'true',
                        ],
                    ],
                    'secondaryButtonBorderLabel' => [
                        'label' => esc_html__('Secondary Button', 'affiliatex'),
                        'type' => Controls_Manager::HEADING,
                        'separator' => 'after',
                        'condition' => [
                            'edButton2' => 'true',
                        ],
                    ],
					'button2Border' => [
						'label' => __('Border', 'affiliatex'),
						'type' => Group_Control_Border::get_type(),
						'selector' => $this->select_element('secondary-button'),
						'fields_options' => [
							'border' => [
								'default' => $defaults['button2Border']['style'],
								'label' => __('Border Type', 'affiliatex'),
							],
							'color' => [
								'default' => $defaults['button2Border']['color']['color'],
								'label' => __('Border Color', 'affiliatex'),
							],
							'width' => [
								'default' => [
									'isLinked' => false,
									'unit' => 'px',
									'top' => $defaults['button2Border']['width'],
									'right' => $defaults['button2Border']['width'],
									'bottom' => $defaults['button2Border']['width'],
									'left' => $defaults['button2Border']['width'],
								],
								'label' => __('Border Width', 'affiliatex'),
							]
						],
						'separator' => 'before',
						'condition' => [
                            'edButton2' => 'true',
						]
					],
					'button2Radius' => [
						'label' => __('Border Radius', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'rem', 'em'],
						'default' => [
							'top' => '0',
							'right' => '0',
							'bottom' => '0',
							'left' => '0',
							'unit' => 'px',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_element('secondary-button') => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						],
						'condition' => [
                            'edButton2' => 'true',
						]
					],
					'button2Shadow' => [
						'type' => Group_Control_Box_Shadow::get_type(),
						'selector' => $this->select_element('secondary-button'),
						'label' => __('Box Shadow', 'affiliatex'),
						'fields_options' => [
							'box_shadow_type' => [
								'default' => $defaults['button2Shadow']['enable'] ? 'enable' : '',
							],
							'box_shadow' => [
								'default' => [
									'vertical' => $defaults['button2Shadow']['v_offset'],
									'horizontal' => $defaults['button2Shadow']['h_offset'],
									'blur' => $defaults['button2Shadow']['blur'],
									'spread' => $defaults['button2Shadow']['spread'],
									'color' => $defaults['button2Shadow']['color']['color'],
									'inset' => $defaults['button2Shadow']['inset'],
                                ],
							]
                        ],
                        'condition' => [
                            'edButton2' => 'true',
                        ],
                    ],
                    'border' => [
						'label' => __('Border', 'affiliatex'),
						'type' => Group_Control_Border::get_type(),
						'selector' => $this->select_elements([
                            ['table', ':not(.layout-3)'],
                            'table-single'
                        ]),
						'fields_options' => [
							'border' => [
								'default' => 'none',
								'label' => __('Border Type', 'affiliatex'),
							],
							'color' => [
								'default' => '#dddddd',
								'label' => __('Border Color', 'affiliatex'),
							],
							'width' => [
								'default' => [
									'isLinked' => false,
									'unit' => 'px',
									'top' => $defaults['button1Border']['width'],
									'right' => $defaults['button1Border']['width'],
									'bottom' => $defaults['button1Border']['width'],
									'left' => '1'
								],
								'label' => __('Border Width', 'affiliatex'),
							]
						],
						'separator' => 'before',
						'condition' => [
						]
					],
					'borderRadius' => [
						'label' => __('Border Radius', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'rem', 'em'],
						'default' => [
							'top' => '0',
							'right' => '0',
							'bottom' => '0',
							'left' => '0',
							'unit' => 'px',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_elements([
                                ['table', ':not(.layout-3)'],
                                'table-single'
                            ]) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						],
						'condition' => [
						]
					],
					'boxShadow' => [
						'type' => Group_Control_Box_Shadow::get_type(),
						'selector' => $this->select_elements([
                            ['table', ':not(.layout-3)'],
                            'table-single'
                        ]),
						'label' => __('Box Shadow', 'affiliatex'),
						'fields_options' => [
							'box_shadow_type' => [
								'default' => $defaults['boxShadow']['enable'] ? 'enable' : '',
							],
							'box_shadow' => [
								'default' => [
									'vertical' => $defaults['boxShadow']['v_offset'],
									'horizontal' => $defaults['boxShadow']['h_offset'],
									'blur' => $defaults['boxShadow']['blur'],
									'spread' => $defaults['boxShadow']['spread'],
									'color' => $defaults['boxShadow']['color']['color'],
									'inset' => $defaults['boxShadow']['inset'],
								]
							]
						]
                    ],
                ],
			],

			'colors_setting_section' => [
				'label' => __('Colors', 'affiliatex'),
				'tab' => Controls_Manager::TAB_STYLE,
				'fields' => [
					'ribbonColorSettingsLabel' => [
						'label' => esc_html__('Ribbon', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
                        'condition' => [
                            'edRibbon' => 'true',
                        ]
					],
					'ribbonColor' => [
						'label' => __('Text Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['ribbonColor'],
						'selectors' => [
							$this->select_element(['table', ' .affx-pdt-ribbon']) => 'color: {{VALUE}}',
						],
						'condition' => [
                            'edRibbon' => 'true',
                        ],
					],
					'ribbonBgColor' => [
						'label' => __('Background Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['ribbonBgColor'],
						'selectors' => [
							$this->select_elements([
                                ['table', ' .affx-pdt-ribbon'],
                                ['table', ' .affx-pdt-ribbon::before']
                            ]) => 'background: {{VALUE}}',
						],
						'condition' => [
                            'edRibbon' => 'true',
                        ],
					],
					'counterColorSettingsLabel' => [
						'label' => esc_html__('Counter', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
                        'condition' => [
                            'edCounter' => 'true',
                        ]
					],
					'counterColor' => [
						'label' => __('Text Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['counterColor'],
						'selectors' => [
							$this->select_element(['table', ' .affx-pdt-counter']) => 'color: {{VALUE}}',
						],
						'condition' => [
                            'edCounter' => 'true',
                        ],
					],
					'counterBgColor' => [
						'label' => __('Background Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['counterBgColor'],
						'selectors' => [
							$this->select_element(['table', ' .affx-pdt-counter']) => 'background: {{VALUE}}',
						],
						'condition' => [
                            'edCounter' => 'true',
                        ],
					],
					'ratingColorSettingsLabel' => [
						'label' => esc_html__('Rating', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
                        'condition' => [
                            'edRating' => 'true',
                            'layoutStyle' => 'layoutOne',
                        ]
					],
					'ratingColor' => [
						'label' => __('Text Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['ratingColor'],
						'selectors' => [
							$this->select_element('star-rating') => 'color: {{VALUE}}',
						],
						'condition' => [
                            'edRating' => 'true',
                            'layoutStyle' => 'layoutOne',
                        ],
					],
					'ratingBgColor' => [
						'label' => __('Background Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['ratingBgColor'],
						'selectors' => [
							$this->select_element('star-rating') => 'background: {{VALUE}}',
						],
						'condition' => [
                            'edRating' => 'true',
                            'layoutStyle' => 'layoutOne',
                        ],
					],
					'rating2ColorSettingsLabel' => [
						'label' => esc_html__('Rating', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
                        'condition' => [
                            'edRating' => 'true',
                            'layoutStyle' => 'layoutTwo',
                        ]
					],
					'rating2Color' => [
						'label' => __('Text Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['rating2Color'],
						'selectors' => [
							$this->select_element('circle-rating') => 'color: {{VALUE}}',
						],
						'condition' => [
                            'edRating' => 'true',
                            'layoutStyle' => 'layoutTwo',
                        ],
					],
					'rating2BgColor' => [
						'label' => __('Background Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['rating2BgColor'],
						'selectors' => [
							$this->select_element(['wrapper', ' .circle-wrap .circle-mask .fill']) => 'background: {{VALUE}}',
						],
						'condition' => [
                            'edRating' => 'true',
                            'layoutStyle' => 'layoutTwo',
                        ],
					],
					'starRatingColorSettingsLabel' => [
						'label' => esc_html__('Rating', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
                        'condition' => [
                            'edRating' => 'true',
                            'layoutStyle' => 'layoutThree',
                        ]
					],
					'starColor' => [
						'label' => __('Star Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['starColor'],
						'condition' => [
                            'edRating' => 'true',
                            'layoutStyle' => 'layoutThree',
                        ],
					],
					'starInactiveColor' => [
						'label' => __('Star Inactive Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['starInactiveColor'],
						'condition' => [
                            'edRating' => 'true',
                            'layoutStyle' => 'layoutThree',
                        ],
					],
					'tableHeaderColorSettingsLabel' => [
						'label' => esc_html__('Table Header', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
                        'condition' => [
                            'layoutStyle!' => 'layoutThree',
                        ]
					],
					'tableHeaderColor' => [
						'label' => __('Text Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['tableHeaderColor'],
						'selectors' => [
							$this->select_element(['table', ' .affx-pdt-table thead td']) => 'color: {{VALUE}}',
						],
						'condition' => [
                            'layoutStyle!' => 'layoutThree',
                        ],
					],
					'tableHeaderBgColor' => [
						'label' => __('Background Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['tableHeaderBgColor'],
						'selectors' => [
							$this->select_element(['table', ' .affx-pdt-table thead td']) => 'background: {{VALUE}}; border-color: {{VALUE}}',
						],
						'condition' => [
                            'layoutStyle!' => 'layoutThree',
                        ],
					],
					'button1TextColorSettingsLabel' => [
						'label' => esc_html__('Primary Button Text', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
                        'condition' => [
                            'edButton1' => 'true',
                        ]
					],
					'button1TextColor' => [
						'label' => __('Text Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['button1TextColor'],
						'selectors' => [
							$this->select_element('primary-button') => 'color: {{VALUE}}',
						],
						'condition' => [
                            'edButton1' => 'true',
                        ],
					],
					'button1TextHoverColor' => [
						'label' => __('Text Hover Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['button1TextHoverColor'],
						'selectors' => [
							$this->select_element(['primary-button', ':hover']) => 'color: {{VALUE}}',
						],
						'condition' => [
                            'edButton1' => 'true',
                        ],
					],
					'button1ColorSettingsLabel' => [
						'label' => esc_html__('Primary Button', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
                        'condition' => [
                            'edButton1' => 'true',
                        ]
					],
					'button1BgColor' => [
						'label' => __('Background Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['button1BgColor'],
						'selectors' => [
							$this->select_element('primary-button') => 'background: {{VALUE}}',
						],
						'condition' => [
                            'edButton1' => 'true',
                        ],
					],
					'button1BgHoverColor' => [
						'label' => __('Background Hover Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['button1BgHoverColor'],
						'selectors' => [
							$this->select_element(['primary-button', ':hover']) => 'background: {{VALUE}}',
						],
						'condition' => [
                            'edButton1' => 'true',
                        ],
					],
					'button1borderHoverColor' => [
						'label' => __('Border Hover Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['button1borderHoverColor'],
						'selectors' => [
							$this->select_element(['primary-button', ':hover']) => 'border-color: {{VALUE}}',
						],
						'condition' => [
                            'edButton1' => 'true',
                        ],
					],
					'button2TextColorSettingsLabel' => [
						'label' => esc_html__('Secondary Button Text', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
                        'condition' => [
                            'edButton2' => 'true',
                        ]
					],
					'button2TextColor' => [
						'label' => __('Text Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['button2TextColor'],
						'selectors' => [
							$this->select_element('secondary-button') => 'color: {{VALUE}}',
						],
						'condition' => [
                            'edButton2' => 'true',
                        ],
					],
					'button2TextHoverColor' => [
						'label' => __('Text Hover Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['button2TextHoverColor'],
						'selectors' => [
							$this->select_element(['secondary-button', ':hover']) => 'color: {{VALUE}}',
						],
						'condition' => [
                            'edButton2' => 'true',
                        ],
					],
					'button2ColorSettingsLabel' => [
						'label' => esc_html__('Secondary Button', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
                        'condition' => [
                            'edButton2' => 'true',
                        ]
					],
					'button2BgColor' => [
						'label' => __('Background Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['button2BgColor'],
						'selectors' => [
							$this->select_element('secondary-button') => 'background: {{VALUE}}',
						],
						'condition' => [
                            'edButton2' => 'true',
                        ],
					],
					'button2BgHoverColor' => [
						'label' => __('Background Hover Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['button2BgHoverColor'],
						'selectors' => [
							$this->select_element(['secondary-button', ':hover']) => 'background: {{VALUE}}',
						],
						'condition' => [
                            'edButton2' => 'true',
                        ],
					],
                    'button2borderHoverColor' => [
						'label' => __('Border Hover Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['button2borderHoverColor'],
						'selectors' => [
							$this->select_element(['secondary-button', ':hover']) => 'border-color: {{VALUE}}',
						],
						'condition' => [
                            'edButton2' => 'true',
                        ],
					],
					'priceColor' => [
						'label' => __('Price Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['priceColor'],
						'selectors' => [
							$this->select_element('price') => 'color: {{VALUE}}',
						],
						'condition' => [
                            'edPrice' => 'true',
                        ],
					],
					'titleColor' => [
						'label' => __('Title Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['titleColor'],
						'selectors' => [
							$this->select_element('title') => 'color: {{VALUE}}',
						],
					],
					'contentColor' => [
						'label' => __('Content Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['contentColor'],
						'selectors' => [
							$this->select_elements([
                                'wrapper',
                                ['table', ' p'],
                                ['table', ' li'],
                            ]) => 'color: {{VALUE}}',
						],
					],
					'productIconColor' => [
						'label' => __('List Icon Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => $defaults['productIconColor'],
						'selectors' => [
							$this->select_elements([
                                ['table', ' .afx-icon-list li:before'],
                                ['table', ' .afx-icon-list li i'],
                            ]) => 'color: {{VALUE}}',
						],
						'condition' => [
                            'productContentType' => 'list',
                        ],
					],
					'bgColor' => [
						'type' => Group_Control_Background::get_type(),
						'types' => ['classic', 'gradient'],
						'selector' => $this->select_elements([
                            ['table', ':not(.layout-3)'],
                            ['table', ' .affx-pdt-table'],
                            'table-single',
                        ]),
						'exclude' => ['image'],
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
								],
								'label' => __('Background Type', 'affiliatex'),
								'toggle' => false,
							],
							'color' => [
								'label' => __('Background Color', 'affiliatex'),
								'default' => $defaults['bgColorSolid'],
							],
							'color_b' => [
								'default' => '#A9B8C3',
							],
							'color_b_stop' => [
								'default' => [
									'unit' => '%',
									'size' => 60,
								]
							],
							'gradient_angle' => [
								'default' => [
									'unit' => 'deg',
									'size' => '135'
								]
							],
						]
					],
				]
			],

			'typography_settings_section' => [
				'label' => __('Typography', 'affiliatex'),
				'tab' => Controls_Manager::TAB_STYLE,
				'fields' => [
					'ribbonTypography' => [
						'label' => __('Ribbon Typography', 'affiliatex'),
						'type' => Group_Control_Typography::get_type(),
						'selector' => $this->select_element(['table', ' .affx-pdt-ribbon']),
						'fields_options' => [
							'typography' => [
								'default' => 'custom'
							],
							'font_family' => [
								'default' => ''
							],
							'font_weight' => [
								'default' => '400'
							],
							'font_size' => [
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
                            'edRibbon' => 'true',
                        ]
					],
					'counterTypography' => [
						'label' => __('Counter Typography', 'affiliatex'),
						'type' => Group_Control_Typography::get_type(),
						'selector' => $this->select_element(['table', ' .affx-pdt-counter']),
						'fields_options' => [
							'typography' => [
								'default' => 'custom'
							],
							'font_family' => [
								'default' => ''
							],
							'font_weight' => [
								'default' => '400'
							],
							'font_size' => [
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
                            'edCounter' => 'true',
                        ],
					],
					'ratingTypography' => [
						'label' => __('Rating Typography', 'affiliatex'),
						'type' => Group_Control_Typography::get_type(),
						'selector' => $this->select_element('star-rating'),
						'fields_options' => [
							'typography' => [
								'default' => 'custom'
							],
							'font_family' => [
								'default' => ''
							],
							'font_weight' => [
								'default' => '400'
							],
							'font_size' => [
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
                            'edRating' => 'true',
                            'layoutStyle' => 'layoutOne',
                        ],
					],
					'rating2Typography' => [
						'label' => __('Rating Typography', 'affiliatex'),
						'type' => Group_Control_Typography::get_type(),
						'selector' => $this->select_element('circle-rating'),
						'fields_options' => [
							'typography' => [
								'default' => 'custom'
							],
							'font_family' => [
								'default' => ''
							],
							'font_weight' => [
								'default' => '400'
							],
							'font_size' => [
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
                            'edRating' => 'true',
                            'layoutStyle' => 'layoutTwo',
                        ],
					],
					'priceTypography' => [
						'label' => __('Price Typography', 'affiliatex'),
						'type' => Group_Control_Typography::get_type(),
						'selector' => $this->select_element('price'),
						'fields_options' => [
							'typography' => [
								'default' => 'custom'
							],
							'font_family' => [
								'default' => ''
							],
							'font_weight' => [
								'default' => '400'
							],
							'font_size' => [
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
                            'edPrice' => 'true',
                        ],
					],
					'buttonTypography' => [
						'label' => __('Button Typography', 'affiliatex'),
						'type' => Group_Control_Typography::get_type(),
						'selector' => $this->select_element('button'),
						'fields_options' => [
							'typography' => [
								'default' => 'custom'
							],
							'font_family' => [
								'default' => ''
							],
							'font_weight' => [
								'default' => '400'
							],
							'font_size' => [
								'default' => [
									'unit' => 'px',
									'size' => '14'
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
					],
					'headerTypography' => [
						'label' => __('Table Header Typography', 'affiliatex'),
						'type' => Group_Control_Typography::get_type(),
						'selector' => $this->select_element(['table', ' .affx-pdt-table thead td']),
						'fields_options' => [
							'typography' => [
								'default' => 'custom'
							],
							'font_family' => [
								'default' => ''
							],
							'font_weight' => [
								'default' => '400'
							],
							'font_size' => [
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
					],
					'titleTypography' => [
						'label' => __('Title Typography', 'affiliatex'),
						'type' => Group_Control_Typography::get_type(),
						'selector' => $this->select_element('title'),
						'fields_options' => [
							'typography' => [
								'default' => 'custom'
							],
							'font_family' => [
								'default' => ''
							],
							'font_weight' => [
								'default' => '400'
							],
							'font_size' => [
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
					],
					'contentTypography' => [
						'label' => __('Content Typography', 'affiliatex'),
						'type' => Group_Control_Typography::get_type(),
						'selector' => $this->select_elements([
                            'wrapper',
                            ['table', ' p'],
                            ['table', ' li'],
                        ]),
						'fields_options' => [
							'typography' => [
								'default' => 'custom'
							],
							'font_family' => [
								'default' => ''
							],
							'font_weight' => [
								'default' => '400'
							],
							'font_size' => [
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
					],
				],
			],

			'spacing_settings_section' => [
				'label' => __('Spacing', 'affiliatex'),
				'tab' => Controls_Manager::TAB_STYLE,
				'fields' => [
					'imagePadding' => [
						'label' => __('Image Padding', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'em', 'rem', 'pt'],
						'default' => [
							'unit' => 'px',
							'top' => '0',
							'right' => '0',
							'bottom' => '0',
							'left' => '0',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_element('image-container') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					],
					'button1SpacingSettingsLabel' => [
						'label' => esc_html__('Primary Button', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
                        'condition' => [
                            'edButton1' => 'true',
                        ]
					],
					'button1Margin' => [
						'label' => __('Margin', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'em', 'rem', 'pt'],
						'default' => [
							'unit' => 'px',
							'top' => '5',
							'right' => '0',
							'bottom' => '5',
							'left' => '0',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_element('primary-button') => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ],
                        'condition' => [
                            'edButton1' => 'true',
                        ]
					],
					'button1Padding' => [
						'label' => __('Padding', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'em', 'rem', 'pt'],
						'default' => [
							'unit' => 'px',
							'top' => '10',
							'right' => '5',
							'bottom' => '10',
							'left' => '5',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_element('primary-button') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ],
                        'condition' => [
                            'edButton1' => 'true',
                        ]
					],
					'button2SpacingSettingsLabel' => [
						'label' => esc_html__('Secondary Button', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
                        'condition' => [
                            'edButton2' => 'true',
                        ]
					],
					'button2Margin' => [
						'label' => __('Margin', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'em', 'rem', 'pt'],
						'default' => [
							'unit' => 'px',
							'top' => '5',
							'right' => '0',
							'bottom' => '5',
							'left' => '0',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_element('secondary-button') => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ],
                        'condition' => [
                            'edButton2' => 'true',
                        ]
					],
					'button2Padding' => [
						'label' => __('Padding', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'em', 'rem', 'pt'],
						'default' => [
							'unit' => 'px',
							'top' => '10',
							'right' => '5',
							'bottom' => '10',
							'left' => '5',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_element('secondary-button') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ],
                        'condition' => [
                            'edButton2' => 'true',
                        ]
					],
					'margin' => [
						'label' => __('Margin', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'em', 'rem', 'pt'],
						'default' => [
							'unit' => 'px',
							'top' => '0',
							'right' => '0',
							'bottom' => '30',
							'left' => '0',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_elements([
                                'wrapper',
                                'table-single'
                            ]) => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					],
					'padding' => [
						'label' => __('Padding', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'em', 'rem', 'pt'],
						'default' => [
							'unit' => 'px',
							'top' => '24',
							'right' => '24',
							'bottom' => '24',
							'left' => '24',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_elements([
                                ['table', ' td:not(.affx-img-col)'],
                                ['table', ' th'],
                            ]) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
                    ],
                    // Amazon Attributes Configuration
                    'amazonAttributes' => [
                        'type' => Controls_Manager::HIDDEN,
                        'default' => [
                            [
                                'field' => 'title',
                                'blockField' => [
                                    'name' => 'name',
                                    'type' => 'text',
                                    'repeaterName' => 'productTable',
                                    'defaults' => [
                                        'name' => $defaults['productTable'][0]['name'],
                                    ],
                                ],
                                'type' => 'text',
                            ],
                            [
                                'field' => 'features',
                                'blockField' => [
                                    'name' => 'featuresListAmazon',
                                    'type' => 'list',
                                    'repeaterName' => 'productTable',
                                    'defaults' => [
                                        'featuresListAmazon' => '',
                                    ],
                                ],
                                'type' => 'list',
                            ],
                            [
                                'field' => 'display_price',
                                'blockField' => [
                                    'name' => 'offerPrice',
                                    'type' => 'text',
                                    'repeaterName' => 'productTable',
                                    'defaults' => [
                                        'offerPrice' => '$49.00',
                                    ],
                                ],
                                'type' => 'text',
                            ],
                            [
                                'field' => 'regular_display_price',
                                'blockField' => [
                                    'name' => 'regularPrice',
                                    'type' => 'text',
                                    'repeaterName' => 'productTable',
                                    'defaults' => [
                                        'regularPrice' => '$59.00',
                                    ],
                                ],
                                'type' => 'text',
                            ],
                            [
                                'field' => 'images',
                                'blockField' => [
                                    'name' => 'imageExternal',
                                    'type' => 'image',
                                    'repeaterName' => 'productTable',
                                    'defaults' => [
                                        'imageExternal' => ''
                                    ],
                                ],
                                'type' => 'image',
                            ],
                            [
                                'field' => 'url',
                                'blockField' => [
                                    'name' => 'button1URL',
                                    'type' => 'link',
                                    'repeaterName' => 'productTable',
                                    'defaults' => [
                                        'button1URL' => '',
                                    ],
                                ],
                                'type' => 'link',
                            ],
                            [
                                'field' => 'url',
                                'blockField' => [
                                    'name' => 'button2URL',
                                    'type' => 'link',
                                    'repeaterName' => 'productTable',
                                    'defaults' => [
                                        'button2URL' => '',
                                    ],
                                ],
                                'type' => 'link',
                            ],
                        ],
                    ],
				]
			]
		];
	}

    protected function register_controls()
    {
        WidgetHelper::generate_fields(
            $this,
            $this->get_elementor_controls(),
            'product-table'
        );
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
        $attributes['block_id']   = $this->get_id();

        $attributes = WidgetHelper::format_boolean_attributes($attributes);

        foreach ( $attributes['productTable'] as $key => $value ) {
            if ( $attributes['productTable'][$key]['imageType'] === 'default' ) {
                $attributes['productTable'][$key]['imageUrl'] = isset($value['imageUrl']['url']) ? esc_url($value['imageUrl']['url']) : '';
                $attributes['productTable'][$key]['imageAlt'] = isset($value['imageUrl']['alt']) ? esc_attr($value['imageUrl']['alt']) : '';
            } else {
                $attributes['productTable'][$key]['imageUrl'] = isset($value['imageExternal']) ? esc_url($value['imageExternal']) : '';
            }

            if ( $attributes['productTable'][$key]['featuresListType'] === 'list' ) {
                $attributes['productTable'][$key]['featuresList'] = WidgetHelper::format_list_items($value['featuresList']);
            } else {
                $attributes['productTable'][$key]['featuresList'] = $value['featuresListAmazon'];
            }
        }

        echo $this->render_template($attributes, '');
    }
}
