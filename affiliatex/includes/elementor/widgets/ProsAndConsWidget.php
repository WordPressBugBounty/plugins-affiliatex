<?php

namespace AffiliateX\Elementor\Widgets;

defined('ABSPATH') || exit;

use AffiliateX\Helpers\Elementor\WidgetHelper;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use AffiliateX\Traits\ProsAndConsRenderTrait;
use AffiliateX\Elementor\ControlsManager;

/**
 * AffiliateX Single Product Elementor Widget
 *
 * @package AffiliateX
 */
class ProsAndConsWidget extends ElementorBase
{
	use ProsAndConsRenderTrait;

	public function get_title()
	{
		return __('AffiliateX Pros and Cons', 'affiliatex');
	}

	public function get_icon()
	{
		return 'affx-icon-pros-cons';
	}

	public function get_keywords()
	{
		return [
			"Pros and Cons",
			"Pros",
			"Cons",
			"AffiliateX"
		];
	}

	protected function get_elements(): array
	{
		return [
			'wrapper'                  => 'affx-pros-cons-inner-wrapper',
			'layout-1-wrapper'         => 'affx-pros-cons-inner-wrapper.layout-type-1',
			'layout-2-wrapper'         => 'affx-pros-cons-inner-wrapper.layout-type-2',
			'layout-3-wrapper'         => 'affx-pros-cons-inner-wrapper.layout-type-3',
			'layout-4-wrapper'         => 'affx-pros-cons-inner-wrapper.layout-type-4',
			'pros-block'               => 'affiliatex-block-pros',
			'cons-block'               => 'affiliatex-block-cons',
			'layout-3-pros-title-icon' => 'affx-pros-cons-inner-wrapper.layout-type-3 .affiliatex-block-pros i',
			'layout-3-cons-title-icon' => 'affx-pros-cons-inner-wrapper.layout-type-3 .affiliatex-block-cons i',
			'pros'                     => 'affx-pros-inner',
			'cons'                     => 'affx-cons-inner',
			'pros-content-wrapper'     => 'affiliatex-pros',
			'cons-content-wrapper'     => 'affiliatex-cons',
			'title'                    => 'affiliatex-title',
			'content'                  => 'affiliatex-content',
			'list'                     => 'affiliatex-list',
			'list-item'                => 'affiliatex-list li',
		];
	}

	public function get_elementor_controls() {
		return [
			'layout_settings_section' => [
				'label' => __('Layout Settings', 'affiliatex'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'fields' => [
					'layoutStyle' => [
						'label' => __('Choose Layout', 'affiliatex'),
						'type' => Controls_Manager::SELECT,
						'default' => 'layout-type-1',
						'options' => [
							'layout-type-1' => __('Layout One', 'affiliatex'),
							'layout-type-2' => __('Layout Two', 'affiliatex'),
							'layout-type-3' => __('Layout Three', 'affiliatex'),
							'layout-type-4' => __('Layout Four', 'affiliatex'),
						],
					],
				]
			],

			'general_settings_section' => [
				'label' => __('General Settings', 'affiliatex'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'fields' => [
					'titleTag1' => [
						'label' => __('Heading Tag', 'affiliatex'),
						'type' => Controls_Manager::SELECT,
						'default' => 'p',
						'options' => [
							'h2' => 'H2',
							'h3' => 'H3',
							'h4' => 'H4',
							'h5' => 'H5',
							'h6' => 'H6',
							'p' => 'Paragraph (p)',
						],
					],
					'alignment' => [
						'label' => __('Title Alignment', 'affiliatex'),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'left' => [
								'title' => __('Left', 'affiliatex'),
								'icon' => 'eicon-text-align-left',
							],
							'center' => [
								'title' => __('Center', 'affiliatex'),
								'icon' => 'eicon-text-align-center',
							],
							'right' => [
								'title' => __('Right', 'affiliatex'),
								'icon' => 'eicon-text-align-right',
							],
						],
						'default' => 'left',
						'selectors' => [
							$this->select_elements( ['pros-block', 'cons-block']) => "text-align: {{VALUE}};",
						],
						'toggle' => false,
						'condition' => [
							'layoutStyle!' => 'layout-type-3',
						]
					],
					'alignmentThree' => [
						'label' => __('Title Alignment', 'affiliatex'),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'flex-start' => [
								'title' => __('Left', 'affiliatex'),
								'icon' => 'eicon-text-align-left',
							],
							'center' => [
								'title' => __('Center', 'affiliatex'),
								'icon' => 'eicon-text-align-center',
							],
							'flex-end' => [
								'title' => __('Right', 'affiliatex'),
								'icon' => 'eicon-text-align-right',
							],
						],
						'default' => 'center',
						'selectors' => [
							$this->select_elements(
								[
									['layout-3-wrapper', ' .affiliatex-block-pros .pros-title-icon'],
									['layout-3-wrapper', ' .affiliatex-block-cons .cons-title-icon'],
								]
							) => "justify-content: {{VALUE}};",
							$this->select_elements(
								[
									['layout-3-wrapper', ' .affiliatex-block-pros'],
									['layout-3-wrapper', ' .affiliatex-block-cons'],
								]
							) => "align-items: {{VALUE}}",
						],
						'toggle' => false,
						'condition' => [
							'layoutStyle' => 'layout-type-3',
						]
					],
					'contentAlignment' => [
						'label' => __('Content Alignment', 'affiliatex'),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'left' => [
								'title' => __('Left', 'affiliatex'),
								'icon' => 'eicon-text-align-left',
							],
							'center' => [
								'title' => __('Center', 'affiliatex'),
								'icon' => 'eicon-text-align-center',
							],
							'right' => [
								'title' => __('Right', 'affiliatex'),
								'icon' => 'eicon-text-align-right',
							],
						],
						'default' => 'left',
						'selectors' => [
							$this->select_elements(['pros-content-wrapper', 'cons-content-wrapper']) => "text-align: {{VALUE}};",
						],
						'toggle' => false,
					],
				]
			],

			'pros_settings_section' => [
				'label' => __('Pros Settings', 'affiliatex'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'fields' => [
                    'prosTitle' => [
						'label' => __('Pros Heading Title', 'affiliatex'),
						'type' => ControlsManager::TEXT,
						'default' => __('Pros', 'affiliatex'),
					],
					'prosIconStatus' => [
						'label' => __('Enable Pros Title Icon', 'affiliatex'),
						'type' => Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => 'true',
					],
					'prosListIcon' => [
						'label' => __('Pros Title Icon', 'affiliatex'),
						'type' => Controls_Manager::ICONS,
						'default' => [
							'value' => 'far fa-thumbs-up',
							'library' => 'fa-regular',
						],
						'condition' => [
							'prosIconStatus' => 'true',
						],
					],
					'prosIconSize' => [
                        'label' => __('Pros Title Icon Size', 'affiliatex'),
						'type' => Controls_Manager::SLIDER,
						'size_units' => ['px'],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 40,
								'step' => 1,
							],
						],
						'default' => [
							'unit' => 'px',
							'size' => 18,
						],
						'selectors' => [
							$this->select_element('pros-block') . ' i' => 'font-size: {{SIZE}}{{UNIT}};',
						],
						'condition' => [
							'prosIconStatus' => 'true',
						],
					],
					'prosContentType' => [
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
                            'amazon' => [
                                'title' => __('Amazon', 'affiliatex'),
                                'icon' => 'fa-brands fa-amazon',
                            ],
						],
						'default' => 'list',
						'toggle' => false,
					],
                    'prosContent' => [
						'label' => esc_html__('Pros Content', 'affiliatex'),
						'type' => ControlsManager::TEXTAREA,
						'rows' => 4,
						'default' => esc_html__('Content', 'affiliatex'),
						'placeholder' => esc_html__('Content', 'affiliatex'),
						'condition' => [
							'prosContentType' => 'paragraph'
						]
					],
                    'prosListItems' => [
						'label' => __('Pros List Items', 'affiliatex'),
						'type' => Controls_Manager::REPEATER,
                        'title_field' => '{{{ content }}}',
						'fields' => [
							[
								'name' => 'content',
								'label' => __('Pros Content', 'affiliatex'),
								'type' => ControlsManager::TEXT,
								'default' => 'Enter new item'
							]
						],
						'default' => [
							[
								'content' => 'Enter new item'
							]
						],
						'condition' => [
							'prosContentType' => 'list'
						]
					],
                    'prosListItemsAmazon' => [
                        'label' => __('Amazon Pros List Items', 'affiliatex'),
                        'type' => ControlsManager::TEXT,
                        'disabled' => true,
                        'placeholder' => __('Click on the button to connect product', 'affiliatex'),
                        'condition' => [
                            'prosContentType' => 'amazon',
                        ],
                    ],
					'prosListType' => [
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
						'default' => 'unordered',
						'condition' => [
							'prosContentType' => ['list', 'amazon'],
						],
					],
					'prosUnorderedType' => [
						'label' => __('Unordered Type', 'affiliatex'),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'icon' => [
								'title' => __('Show Icon', 'affiliatex'),
								'icon' => 'eicon-star',
							],
							'bullet' => [
								'title' => __('Show Bullet', 'affiliatex'),
								'icon' => 'eicon-dot-circle-o',
							],
						],
						'toggle' => false,
						'default' => 'icon',
						'condition' => [
							'prosContentType' => ['list', 'amazon'],
							'prosListType' => 'unordered',
						],
					],
					'prosIcon' => [
						'label' => __('Pros List Icon', 'affiliatex'),
						'type' => Controls_Manager::ICONS,
						'default' => [
							'value' => 'far fa-check-circle',
							'library' => 'fa-regular',
						],
                        'condition' => [
                            'prosContentType' => ['list', 'amazon'],
							'prosListType' => 'unordered',
                            'prosUnorderedType' => 'icon',
                        ],
					]
				],
			],


			'cons_settings_section' => [
				'label' => __('Cons Settings', 'affiliatex'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'fields' => [
                    'consTitle' => [
						'label' => __('Cons Heading Title', 'affiliatex'),
						'type' => ControlsManager::TEXT,
						'default' => __('Cons', 'affiliatex'),
					],
					'consIconStatus' => [
						'label' => __('Enable Cons Title Icon', 'affiliatex'),
						'type' => Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => 'true',
					],
					'consListIcon' => [
						'label' => __('Cons Title Icon', 'affiliatex'),
						'type' => Controls_Manager::ICONS,
						'default' => [
							'value' => 'far fa-thumbs-down',
							'library' => 'fa-regular',
						],
						'condition' => [
							'consIconStatus' => 'true',
						],
					],
					'consIconSize' => [
                        'label' => __('Cons Title Icon Size', 'affiliatex'),
						'type' => Controls_Manager::SLIDER,
						'size_units' => ['px'],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 40,
								'step' => 1,
							],
						],
						'default' => [
							'unit' => 'px',
							'size' => 18,
						],
						'selectors' => [
							$this->select_element('cons-block') . ' i' => 'font-size: {{SIZE}}{{UNIT}};',
						],
						'condition' => [
							'consIconStatus' => 'true',
						],
					],
					'consContentType' => [
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
                            'amazon' => [
                                'title' => __('Amazon', 'affiliatex'),
                                'icon' => 'fa-brands fa-amazon',
                            ],
						],
						'default' => 'list',
						'toggle' => false,
					],
                    'consContent' => [
						'label' => esc_html__('Cons Content', 'affiliatex'),
						'type' => ControlsManager::TEXTAREA,
						'rows' => 4,
						'default' => esc_html__('Content', 'affiliatex'),
						'placeholder' => esc_html__('Content', 'affiliatex'),
						'condition' => [
							'consContentType' => 'paragraph'
						]
                    ],
                    'consListItems' => [
						'label' => __('Cons List Items', 'affiliatex'),
						'type' => Controls_Manager::REPEATER,
                        'title_field' => '{{{ content }}}',
						'fields' => [
							[
								'name' => 'content',
								'label' => __('Cons Content', 'affiliatex'),
								'type' => ControlsManager::TEXT,
								'default' => 'Enter new item'
							]
						],
						'default' => [
							[
								'content' => 'Enter new item'
							]
						],
						'condition' => [
							'consContentType' => 'list'
						]
					],
                    'consListItemsAmazon' => [
                        'label' => __('Amazon Cons List Items', 'affiliatex'),
                        'type' => ControlsManager::TEXT,
                        'disabled' => true,
                        'placeholder' => __('Click on the button to connect product', 'affiliatex'),
                        'condition' => [
                            'consContentType' => 'amazon',
                        ],
                    ],
					'consListType' => [
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
						'default' => 'unordered',
						'condition' => [
							'consContentType' => ['list', 'amazon'],
						],
					],
					'consUnorderedType' => [
						'label' => __('Unordered Type', 'affiliatex'),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'icon' => [
								'title' => __('Show Icon', 'affiliatex'),
								'icon' => 'eicon-star',
							],
							'bullet' => [
								'title' => __('Show Bullet', 'affiliatex'),
								'icon' => 'eicon-dot-circle-o',
							],
						],
						'default' => 'icon',
						'condition' => [
							'consContentType' => ['list', 'amazon'],
							'consListType' => 'unordered',
						],
						'toggle' => false,
					],
					'consIcon' => [
						'label' => __('Cons List Icon', 'affiliatex'),
						'type' => Controls_Manager::ICONS,
						'default' => [
							'value' => 'far fa-times-circle',
							'library' => 'fa-regular',
						],
                        'condition' => [
                            'consContentType' => ['list', 'amazon'],
							'consListType' => 'unordered',
                            'consUnorderedType' => 'icon',
                        ],
					]
				]
			],

			'border_settings_section' => [
				'label' => __('Border', 'affiliatex'),
				'tab' => Controls_Manager::TAB_STYLE,
				'fields' => [
					'prosBorder' => [
						'label' => __('Pros Title Border', 'affiliatex'),
						'type' => Group_Control_Border::get_type(),
                        'responsive' => true,
						'selector' => $this->select_elements(['pros-block']),
						'fields_options' => [
							'border' => [
								'default' => 'none',
								'label' => __('Pros Title Border Type', 'affiliatex'),
							],
							'color' => [
								'default' => '#dddddd',
								'label' => __('Pros Title Border Color', 'affiliatex'),
							],
							'width' => [
								'default' => [
									'isLinked' => false,
									'unit' => 'px',
									'top' => '1',
									'right' => '1',
									'bottom' => '1',
									'left' => '1'
								],
								'label' => __('Pros Title Border Width', 'affiliatex'),
							]
						],
						'separator' => 'before',
						'condition' => [
							'layoutStyle!' => 'layout-type-3'
						]
					],
					'prosBorderThree' => [
						'label' => __('Pros Title Border', 'affiliatex'),
						'type' => Group_Control_Border::get_type(),
                        'responsive' => true,
						'selector' => $this->select_element('layout-3-pros-title-icon'),
						'fields_options' => [
							'border' => [
								'default' => 'solid',
								'label' => __('Pros Title Border Type', 'affiliatex'),
							],
							'color' => [
								'default' => '#ffffff',
								'label' => __('Pros Title Border Color', 'affiliatex'),
							],
							'width' => [
								'default' => [
									'isLinked' => false,
									'unit' => 'px',
									'top' => '4',
									'right' => '4',
									'bottom' => '4',
									'left' => '4'
								],
								'label' => __('Pros Title Border Width', 'affiliatex'),
							]
						],
						'separator' => 'before',
						'condition' => [
							'layoutStyle' => 'layout-type-3'
						]
					],
					'prosContentBorder' => [
						'label' => __('Pros Content Border', 'affiliatex'),
						'type' => Group_Control_Border::get_type(),
                        'responsive' => true,
						'selector' => $this->select_elements(
							[
								'pros-content-wrapper'
							]
						),
						'fields_options' => [
							'border' => [
								'default' => 'none',
								'label' => __('Pros Content Border Type', 'affiliatex'),
							],
							'color' => [
								'default' => '#dddddd',
								'label' => __('Pros Content Border Color', 'affiliatex'),
							],
							'width' => [
								'default' => [
									'isLinked' => false,
									'unit' => 'px',
									'top' => '0',
									'right' => '0',
									'bottom' => '0',
									'left' => '0'
								],
								'label' => __('Pros Content Border Width', 'affiliatex'),
							]
						],
						'separator' => 'before',
						'condition' => [
							'layoutStyle!' => 'layout-type-3'
						]
					],
					'prosContentBorderThree' => [
						'label' => __('Pros Content Border', 'affiliatex'),
						'type' => Group_Control_Border::get_type(),
                        'responsive' => true,
						'selector' => $this->select_elements(
							[
								['layout-3-wrapper', ' .pros-icon-title-wrap'],
								['layout-3-wrapper', ' .affiliatex-pros'],
							]
						),
						'fields_options' => [
							'border' => [
								'default' => 'solid',
								'label' => __('Pros Content Border Type', 'affiliatex'),
							],
							'color' => [
								'default' => '#24B644',
								'label' => __('Pros Content Border Color', 'affiliatex'),
							],
							'width' => [
								'default' => [
									'isLinked' => false,
									'unit' => 'px',
									'top' => '4',
									'right' => '4',
									'bottom' => '4',
									'left' => '4'
								],
								'label' => __('Pros Content Border Width', 'affiliatex'),
							]
						],
						'separator' => 'before',
						'condition' => [
							'layoutStyle' => 'layout-type-3'
						]
					],
					'consBorder' => [
						'label' => __('Cons Title Border', 'affiliatex'),
						'type' => Group_Control_Border::get_type(),
                        'responsive' => true,
						'selector' => $this->select_elements(['cons-block']),
						'fields_options' => [
							'border' => [
								'default' => 'none',
								'label' => __('Cons Title Border Type', 'affiliatex'),
							],
							'color' => [
								'default' => '#dddddd',
								'label' => __('Cons Title Border Color', 'affiliatex'),
							],
							'width' => [
								'default' => [
									'isLinked' => false,
									'unit' => 'px',
									'top' => '1',
									'right' => '1',
									'bottom' => '1',
									'left' => '1'
								],
								'label' => __('Cons Title Border Width', 'affiliatex'),
							]
						],
						'separator' => 'before',
						'condition' => [
							'layoutStyle!' => 'layout-type-3'
						],
					],
					'consBorderThree' => [
						'label' => __('Cons Title Border', 'affiliatex'),
						'type' => Group_Control_Border::get_type(),
                        'responsive' => true,
						'selector' => $this->select_element('layout-3-cons-title-icon'),
						'fields_options' => [
							'border' => [
								'default' => 'solid',
								'label' => __('Cons Title Border Type', 'affiliatex'),
							],
							'color' => [
								'default' => '#ffffff',
								'label' => __('Cons Title Border Color', 'affiliatex'),
							],
							'width' => [
								'default' => [
									'isLinked' => false,
									'unit' => 'px',
									'top' => '4',
									'right' => '4',
									'bottom' => '4',
									'left' => '4'
								],
								'label' => __('Cons Title Border Width', 'affiliatex'),

							]
						],
						'separator' => 'before',
						'condition' => [
							'layoutStyle' => 'layout-type-3'
						],
					],
					'consContentBorder' => [
						'label' => __('Cons Content Border', 'affiliatex'),
						'type' => Group_Control_Border::get_type(),
                        'responsive' => true,
						'selector' => $this->select_elements(
							[
								'cons-content-wrapper'
							]
						),
						'fields_options' => [
							'border' => [
								'default' => 'none',
								'label' => __('Cons Content Border Type', 'affiliatex'),
							],
							'color' => [
								'default' => '#dddddd',
								'label' => __('Cons Content Border Color', 'affiliatex'),
							],
							'width' => [
								'default' => [
									'isLinked' => false,
									'unit' => 'px',
									'top' => '1',
									'right' => '1',
									'bottom' => '1',
									'left' => '1'
								],
								'label' => __('Cons Content Border Width', 'affiliatex'),
							]
						],
						'separator' => 'before',
						'condition' => [
							'layoutStyle!' => 'layout-type-3'
						]
					],
					'consContentBorderThree' => [
						'label' => __('Cons Content Border', 'affiliatex'),
						'type' => Group_Control_Border::get_type(),
                        'responsive' => true,
						'selector' => $this->select_elements(
							[
								['layout-3-wrapper', ' .cons-icon-title-wrap'],
								['layout-3-wrapper', ' .affiliatex-cons'],
							]
						),
						'fields_options' => [
							'border' => [
								'default' => 'solid',
								'label' => __('Cons Content Border Type', 'affiliatex'),
							],
							'color' => [
								'default' => '#F13A3A',
								'label' => __('Cons Content Border Color', 'affiliatex'),
							],
							'width' => [
								'default' => [
									'isLinked' => false,
									'unit' => 'px',
									'top' => '4',
									'right' => '4',
									'bottom' => '4',
									'left' => '4'
								],
								'label' => __('Cons Content Border Width', 'affiliatex'),
							]
						],
						'separator' => 'before',
						'condition' => [
							'layoutStyle' => 'layout-type-3'
						]
					],
					'titleBorderRadius' => [
						'label' => __('Title Border Radius', 'affiliatex'),
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
							$this->select_elements(['pros-block', 'cons-block']) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						],
						'separator' => 'before',
						'condition' => [
							'layoutStyle!' => 'layout-type-3'
						]
					],
					'titleBorderRadiusThree' => [
						'label' => __('Title Border Radius', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'rem', 'em'],
						'default' => [
							'top' => '50',
							'right' => '50',
							'bottom' => '50',
							'left' => '50',
							'unit' => 'px',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_element('title') => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						],
						'condition' => [
							'layoutStyle' => 'layout-type-3'
						]
					],
					'contentBorderRadius' => [
						'label' => __('Content Border Radius', 'affiliatex'),
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
							$this->select_elements(['pros-content-wrapper', 'cons-content-wrapper']) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						],
						'condition' => [
							'layoutStyle!' => 'layout-type-3',
						]
					],
					'contentBorderRadiusThree' => [
						'label' => __('Content Border Radius', 'affiliatex'),
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
							$this->select_elements(['pros-content-wrapper', 'cons-content-wrapper']) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							$this->select_elements(
								[
									['layout-3-wrapper', ' .pros-icon-title-wrap' ],
									['layout-3-wrapper', ' .cons-icon-title-wrap' ]
									]
								) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition' => [
							'layoutStyle' => 'layout-type-3',
						]
					],
					'boxShadow' => [
						'type' => Group_Control_Box_Shadow::get_type(),
						'selector' => $this->select_elements(
							[
								'layout-1-wrapper',
								['layout-2-wrapper', ' .affx-pros-inner'],
								['layout-2-wrapper', ' .affx-cons-inner'],
								['layout-3-wrapper', ' .affx-pros-inner'],
								['layout-3-wrapper', ' .affx-cons-inner'],
							]
						),
						'label' => __('Box Shadow', 'affiliatex'),
						'fields_options' => [
							'box_shadow_type' => [
								'default' => ''
							],
							'box_shadow' => [
								'default' => [
									'vertical' => '5',
									'horizontal' => '0',
									'blur' => '20',
									'spread' => '0',
									'color' => 'rgba(210,213,218,0.2)',
									'inset' => false
								]
							]
						]
					]
				]
			],

			'colors_setting_section' => [
				'label' => __('Colors', 'affiliatex'),
				'tab' => Controls_Manager::TAB_STYLE,
				'fields' => [
					'prosColorSettingsLabel' => [
						'label' => esc_html__('Pros Color Settings', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
					],
					'prosTextColor' => [
						'label' => __('Title Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => '#ffffff',
						'selectors' => [
							$this->select_element('pros-block') . ' .affiliatex-title' => 'color: {{VALUE}}',
							$this->select_element('pros-block') . ' i' => 'color: {{VALUE}}',
						],
						'condition' => [
							'layoutStyle!' => 'layout-type-3',
						],
					],
					'prosTextColorThree' => [
						'label' => __('Title Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => '#24B644',
						'selectors' => [
							$this->select_element('pros-block') . ' .affiliatex-title' => 'color: {{VALUE}}',
						],
						'condition' => [
							'layoutStyle' => 'layout-type-3',
						],
					],
					'prosTitleIconColorThree' => [
						'label' => __('Title Icon Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => '#ffffff',
						'selectors' => [
							$this->select_element('layout-3-wrapper') . ' .affiliatex-block-pros i' => 'color: {{VALUE}}',
						],
						'condition' => [
							'layoutStyle' => 'layout-type-3',
						],
					],
					'prosListColor' => [
						'label' => __('Content Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => '#292929',
						'selectors' => [
							$this->select_element('pros') . ' .affiliatex-list li' => 'color: {{VALUE}}',
							$this->select_element('pros') . ' .affiliatex-content' => 'color: {{VALUE}}',
						],
					],
					'prosIconColor' => [
						'label' => __('List Icon Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => '#24B644',
						'selectors' => [
							$this->select_element('pros') . ' li::before' => 'color: {{VALUE}}; border-color: {{VALUE}}; background: {{VALUE}}',
							$this->select_element('pros') . ' li::marker' => 'color: {{VALUE}}',
							$this->select_element('pros') . ' ul.before li::marker' => 'background: {{VALUE}}',
							$this->select_element('pros') . ' li i' => 'color: {{VALUE}}',
						],
					],
					'prosBgColor' => [
						'type' => Group_Control_Background::get_type(),
						'types' => ['classic', 'gradient'],
						'selector' => $this->select_elements(
							[
								'pros-block',
								'layout-3-pros-title-icon'
							]
						),
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
								'label' => __('Title Background Type', 'affiliatex'),
								'toggle' => false,
							],
							'color' => [
								'label' => __('Title Background Color', 'affiliatex'),
								'default' => '#24B644',
							],
							'color_b' => [
								'default' => '#7ADCB4',
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
					'prosListBg' => [
						'type' => Group_Control_Background::get_type(),
						'types' => ['classic', 'gradient'],
						'selector' => $this->select_elements([
							'pros-content-wrapper',
							['layout-3-wrapper', ' .affiliatex-block-pros'],
							['layout-4-wrapper', ' .affiliatex-pros p'],
							['layout-4-wrapper', ' .affiliatex-pros li'],
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
								'label' => __('Content Background Type', 'affiliatex'),
								'toggle' => false,
							],
							'color' => [
								'label' => __('Content Background Color', 'affiliatex'),
								'default' => '#F5FFF8',

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
					'consColorSettingsLabel' => [
						'label' => esc_html__('Cons Color Settings', 'affiliatex'),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
					],
					'consTextColor' => [
						'label' => __('Title Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => '#ffffff',
						'selectors' => [
							$this->select_element('cons-block') . ' .affiliatex-title' => 'color: {{VALUE}}',
							$this->select_element('cons-block') . ' i' => 'color: {{VALUE}}',
						],
						'condition' => [
							'layoutStyle!' => 'layout-type-3'
						],
					],
					'consTextColorThree' => [
						'label' => __('Title Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => '#F13A3A',
						'selectors' => [
							$this->select_element('cons-block') . ' .affiliatex-title' => 'color: {{VALUE}}',
						],
						'condition' => [
							'layoutStyle' => 'layout-type-3'
						],
					],
					'consTitleIconColorThree' => [
						'label' => __('Title Icon Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => '#ffffff',
						'selectors' => [
							$this->select_element('layout-3-wrapper') . ' .affiliatex-block-cons i' => 'color: {{VALUE}}',
						],
						'condition' => [
							'layoutStyle' => 'layout-type-3',
						],
					],
					'consListColor' => [
						'label' => __('Content Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => '#292929',
						'selectors' => [
							$this->select_element('cons') . ' .affiliatex-list li' => 'color: {{VALUE}}',
							$this->select_element('cons') . ' .affiliatex-content' => 'color: {{VALUE}}',
						],
					],
					'consIconColor' => [
						'label' => __('List Icon Color', 'affiliatex'),
						'type' => Controls_Manager::COLOR,
						'default' => '#F13A3A',
						'selectors' => [
							$this->select_element('cons') . ' li::before' => 'color: {{VALUE}}; border-color: {{VALUE}}; background: {{VALUE}}',
							$this->select_element('cons') . ' li::marker' => 'color: {{VALUE}}',
							$this->select_element('cons') . ' ul.before li::marker' => 'background: {{VALUE}}',
							$this->select_element('cons') . ' li i' => 'color: {{VALUE}}',
						],
					],
					'consBgColor' => [
						'type' => Group_Control_Background::get_type(),
						'types' => ['classic', 'gradient'],
						'selector' => $this->select_elements(
							[
								'cons-block',
								'layout-3-cons-title-icon'
							]
						),
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
								'label' => __('Title Background Type', 'affiliatex'),
								'toggle' => false,
							],
							'color' => [
								'label' => __('Title Background Color', 'affiliatex'),
								'default' => '#F13A3A',
							],
							'color_b' => [
								'default' => '#FF6900',
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
					'consListBg' => [
						'type' => Group_Control_Background::get_type(),
						'types' => ['classic', 'gradient'],
						'selector' => $this->select_elements([
							'cons-content-wrapper',
							['layout-3-wrapper', ' .affiliatex-block-cons'],
							['layout-4-wrapper', ' .affiliatex-cons p'],
							['layout-4-wrapper', ' .affiliatex-cons li'],
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
								'label' => __('Content Background Type', 'affiliatex'),
								'toggle' => 'false',
							],
							'color' => [
								'label' => __('Content Background Color', 'affiliatex'),
								'default' => '#FFF5F5',
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
					]
				]
			],

			'typography_settings_section' => [
				'label' => __('Typography', 'affiliatex'),
				'tab' => Controls_Manager::TAB_STYLE,
				'fields' => [
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
								'default' => '500'
							],
							'font_size' => [
								'default' => [
									'unit' => 'px',
									'size' => '20'
								]
							],
							'line_height' => [
								'default' => [
									'unit' => '',
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
					],
					'listTypography' => [
						'label' => __('List/Content Typography', 'affiliatex'),
						'type' => Group_Control_Typography::get_type(),
						'selector' => $this->select_elements(['content', 'list']),
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
									'unit' => '',
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

				]
			],

			'spacing_settings_section' => [
				'label' => __('Spacing', 'affiliatex'),
				'tab' => Controls_Manager::TAB_STYLE,
				'fields' => [
					'titleMargin' => [
						'label' => __('Title Margin', 'affiliatex'),
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
							$this->select_element('pros-block') => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							$this->select_element('cons-block') => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition' => [
							'layoutStyle!' => 'layout-type-3'
						],
					],
					'titlePadding' => [
						'label' => __('Title Padding', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'em', 'rem', 'pt'],
						'default' => [
							'unit' => 'px',
							'top' => '10',
							'right' => '20',
							'bottom' => '10',
							'left' => '20',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_element('pros-block') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							$this->select_element('cons-block') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition' => [
							'layoutStyle!' => 'layout-type-3'
						],
					],
					'contentMargin' => [
						'label' => __('Content Margin', 'affiliatex'),
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
							$this->select_elements(['content', 'list']) => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					],
					'contentPadding' => [
						'label' => __('Content Padding', 'affiliatex'),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'em', 'rem', 'pt'],
						'default' => [
							'unit' => 'px',
							'top' => '10',
							'right' => '20',
							'bottom' => '10',
							'left' => '20',
							'isLinked' => false
						],
						'selectors' => [
							$this->select_elements(
								[
									'content', 
									'list',
									['layout-4-wrapper', ' .affiliatex-content li'],
									['layout-4-wrapper', ' .affiliatex-list li'],
								]
							) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
							$this->select_element('wrapper') => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					],
					'padding' => [
						'label' => __('Padding', 'affiliatex'),
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
							$this->select_element('wrapper') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
                    ],
                    // Amazon Attributes Configuration
                    'amazonAttributes' => [
                        'type' => Controls_Manager::HIDDEN,
                        'default' => [
                            [
                                'field' => 'features',
                                'blockField' => [
                                    'name' => 'prosListItemsAmazon',
                                    'type' => 'list',
                                    'defaults' => [
                                        'prosContentType' => 'list',
                                        'prosListItemsAmazon' => '',
                                    ],
                                    'conditions' => [
                                        'prosContentType' => 'amazon',
                                    ],
                                ],
                                'type' => 'list',
                            ],
                            [
                                'field' => 'features',
                                'blockField' => [
                                    'name' => 'consListItemsAmazon',
                                    'type' => 'list',
                                    'defaults' => [
                                        'consContentType' => 'list',
                                        'consListItemsAmazon' => '',
                                    ],
                                    'conditions' => [
                                        'consContentType' => 'amazon',
                                    ],
                                ],
                                'type' => 'list',
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
            'pros-and-cons'
        );
	}

	/**
	 * Render for Elementor
	 *
	 * @return void
	 */
	public function render( $attributes = [])
	{
		if ( ! $attributes ) {
			$settings = $this->get_settings_for_display();
			$attributes = $this->parse_attributes($settings);
            $attributes = WidgetHelper::process_attributes($attributes);
		}

		$attributes['block_id'] = $this->get_id();
		if ( 'list' == $attributes['prosContentType'] ) {
			$attributes['prosListItems'] = WidgetHelper::format_list_items($attributes['prosListItems']);
		} elseif ( 'amazon' == $attributes['prosContentType'] ) {
			$attributes['prosListItems'] = $attributes['prosListItemsAmazon'];
		}

		if ( 'list' == $attributes['consContentType']) {
			$attributes['consListItems'] = WidgetHelper::format_list_items($attributes['consListItems']);
		} elseif ( 'amazon' == $attributes['consContentType'] ) {
			$attributes['consListItems'] = $attributes['consListItemsAmazon'];
		}

		echo $this->render_template($attributes);
	}
}
