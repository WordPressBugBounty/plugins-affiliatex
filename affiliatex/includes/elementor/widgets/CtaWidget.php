<?php

namespace AffiliateX\Elementor\Widgets;

defined('ABSPATH') || exit;

use Elementor\Utils;
use Elementor\Controls_Manager;
use AffiliateX\Traits\CtaRenderTrait;
use Elementor\Group_Control_Background;
use AffiliateX\Traits\ButtonRenderTrait;
use AffiliateX\Helpers\Elementor\ChildHelper;
use AffiliateX\Elementor\ControlsManager;

class CtaWidget extends ElementorBase
{
    use CtaRenderTrait;
    use ButtonRenderTrait;

    protected function get_slug(): string
    {
        return 'cta';
    }

    protected function get_child_slugs(): array
    {
        return ['buttons'];
    }

    public function get_title()
    {
        return __('AffiliateX Call To Action', 'affiliatex');
    }

    public function get_icon()
    {
        return 'affx-icon-cta';
    }

    public function get_keywords()
    {
        return [
            "CTA",
            "affliatex"
        ];
    }

    protected function register_controls()
    {
        ///////////////////////////////////////////////////
        // CONTENT TAB
        ///////////////////////////////////////////////////
        /**************************************************************
         * Layout Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_cta_layout_settings',
            [
                'label' => __('Layout Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'ctaLayout',
            [
                'label'   => __('Select Layout', 'affiliatex'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'layoutOne' => __('Layout One', 'affiliatex'),
                    'layoutTwo' => __('Layout Two', 'affiliatex')
                ],
                'default' => 'layoutOne'
            ]
        );

        $this->add_control(
            'ctaAlignment',
            [
                'label'     => __('Alignment', 'affiliatex'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'center',
                'toggle'    => false,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'affiliatex'),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'affiliatex'),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'affiliatex'),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'condition' => [
                    'ctaLayout' => 'layoutOne'
                ]
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * CTA Image
         **************************************************************/
        $this->start_controls_section(
            'affx_cta_image_settings',
            [
                'label'     => __('CTA Image', 'affiliatex'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'ctaLayout' => 'layoutTwo'
                ]
            ]
        );

        $this->add_control(
            'imageType',
            [
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
                'condition' => [
                    'ctaLayout' => 'layoutTwo'
                ]
            ]
        );

        $this->add_control(
            'imgURL',
            [
                'label'     => __('Image', 'affiliatex'),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src()
                ],
                'condition' => [
                    'ctaLayout' => 'layoutTwo',
                    'imageType' => 'default',
                ],
                'selectors' => [
                    $this->select_element('image') => 'background-image: url({{URL}})'
                ]
            ]
        );

        $this->add_control(
            'imageExternal',
            [
                'label'       => __('External Image URL', 'affiliatex'),
                'type'        => ControlsManager::TEXT,
                'classes'     => 'affx-cta-image-external',
                'condition'   => [
                    'ctaLayout' => 'layoutTwo',
                    'imageType' => 'external',
                ],
                'selectors' => [
                    $this->select_element('image') => 'background-image: url({{VALUE}})'
                ]
            ]
        );

        $this->add_control(
            'imagePosition',
            [
                'label'     => __('Image Position', 'affiliatex'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'center center' => __('Center Center', 'affiliatex'),
                    'center left'   => __('Center Left', 'affiliatex'),
                    'center right'  => __('Center Right', 'affiliatex'),
                    'top center'    => __('Top Center', 'affiliatex'),
                    'top left'      => __('Top Left', 'affiliatex'),
                    'top right'     => __('Top Right', 'affiliatex'),
                    'bottom center' => __('Bottom Center', 'affiliatex'),
                    'bottom left'   => __('Bottom Left', 'affiliatex'),
                    'bottom right'  => __('Bottom Right', 'affiliatex')
                ],
                'default'   => 'center center',
                'selectors' => [
                    $this->select_element('image') => 'background-position: {{VALUE}}; align-items: flex-end; background-repeat: no-repeat; background-size: cover; display: flex; flex: 0 0 50%; justify-content: flex-end;'
                ],
                'condition' => [
                    'ctaLayout' => 'layoutTwo'
                ]
            ]
        );

        $this->add_control(
            'columnReverse',
            [
                'label'        => __('Enable Column Reverse', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'affiliatex'),
                'label_off'    => __('No', 'affiliatex'),
                'return_value' => 'true',
                'default'      => '',
                'condition'    => [
                    'ctaLayout' => 'layoutTwo'
                ]
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Title Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_cta_title',
            [
                'label' => __('Title Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'ctaTitle',
            [
                'label'       => esc_html__('Title', 'affiliatex'),
                'type'        => ControlsManager::TEXT,
                'default'     => esc_html__('Call to Action Title.', 'affiliatex'),
                'placeholder' => esc_html__('Type your title here', 'affiliatex'),
            ]
        );

        $this->add_control(
            'ctaTitleTag',
            [
                'label'   => __('Title Heading Tag', 'affiliatex'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h2' => __('Heading 2 (h2)', 'affiliatex'),
                    'h3' => __('Heading 3 (h3)', 'affiliatex'),
                    'h4' => __('Heading 4 (h4)', 'affiliatex'),
                    'h5' => __('Heading 5 (h5)', 'affiliatex'),
                    'h6' => __('Heading 6 (h6)', 'affiliatex'),
                    'p'  => __('Paragraph (p)', 'affiliatex')

                ],
                'default' => 'h2'
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Content Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_cta_content',
            [
                'label' => __('Content Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'ctaContent',
            [
                'label'       => esc_html__('Description', 'affiliatex'),
				'type' => ControlsManager::TEXTAREA,
                'default'     => esc_html__('Start creating CTAs in seconds, and convert more of your visitors into leads.', 'affiliatex'),
                'placeholder' => esc_html__('Type your description here', 'affiliatex'),
				'rows' => 4,
            ]
        );

        $this->add_control(
            'contentAlignment',
            [
                'label'     => __('Content Alignment', 'affiliatex'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'affiliatex'),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => __('Center', 'affiliatex'),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'  => [
                        'title' => __('Right', 'affiliatex'),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'default'   => 'center',
                'toggle'    => false,
                'selectors' => [
                    $this->select_element('title')   => 'text-align: {{VALUE}}',
                    $this->select_element('content') => 'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Button Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_cta_button_settings',
            [
                'label' => __('Button Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'edButtons',
            [
                'label'        => __('Enable Buttons', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'affiliatex'),
                'label_off'    => __('No', 'affiliatex'),
                'return_value' => 'true',
                'default'      => 'true'
            ]
        );

        $this->add_control(
            'edButtonTwo',
            [
                'label'        => __('Enable Button Two', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'affiliatex'),
                'label_off'    => __('No', 'affiliatex'),
                'return_value' => 'true',
                'default'      => 'true',
                'condition'    => [
                    'edButtons' => 'true'
                ]
            ]
        );

        $this->add_control(
            'ctaButtonAlignment',
            [
                'label'     => __('Button Alignment', 'affiliatex'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'affiliatex'),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => __('Center', 'affiliatex'),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'  => [
                        'title' => __('Right', 'affiliatex'),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'default'   => 'center',
                'toggle'    => false,
                'selectors' => [
                    $this->select_element('buttons') => 'display: flex; flex-wrap: wrap; width: 100%; justify-content: {{VALUE}};'
                ],
                'condition' => [
                    'edButtons' => 'true',
                ]
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
            'affx_cta_border_settings',
            [
                'label' => __('Border', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'           => 'ctaBorder',
                'label'          => __('Border', 'affiliatex'),
                'responsive'     => true,
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
            ]
        );

        $this->add_responsive_control(
            'ctaBorderRadius',
            [
                'label'      => __('Border Radius', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem', 'em'],
                'default'    => [
                    'top'    => 8,
                    'right'  => 8,
                    'bottom' => 8,
                    'left'   => 8,
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    $this->select_element('wrapper') => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'ctaBoxShadow',
                'label'         => __('Box Shadow', 'affiliatex'),
                'selector'      => $this->select_element('wrapper'),
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Color Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_cta_colors_section',
            [
                'label' => __('Colors', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'ctaTitleColor',
            [
                'label'     => __('Title Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#262b33',
                'selectors' => [
                    $this->select_element('title') => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'ctaTextColor',
            [
                'label'     => __('Text Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#292929',
                'selectors' => [
                    $this->select_element('content') => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
			'ctaLayout2BGType',
			[
				'label' => esc_html__( 'Background Color', 'affiliatex' ),
				'type' => Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
				'selectors' => [
					$this->select_element('wrapper') => 'background-color: {{VALUE}}',
				],
                'condition' => [
                    'ctaLayout' => 'layoutTwo'
                ]
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'ctaBGType',
                'label'          => __('Background', 'affiliatex'),
                'types'          => ['classic', 'image'],
                'exclude'        => ['gradient'],
                'selector'       => $this->select_element('wrapper'),
                'fields_options' => [
                    'background' => [
                        'label'   => __( 'Background Type', 'affiliatex' ),
                        'default' => 'classic',
                        'options' => [
                            'classic' => [
                                'title' => __( 'Color', 'affiliatex' ),
                                'icon'  => 'eicon-global-colors',
                            ],
                            'image' => [
                                'title' => __( 'Image', 'affiliatex' ),
                                'icon'  => 'eicon-e-image',
                            ]
                        ],
                        'toggle' => false,
                        'render_type' => 'template',
                    ],
                    'color'      => [
                        'label' => __( 'Background Color', 'affiliatex' ),
                        'default' => '#fff',
                        'condition' => [
                            'background' => 'classic'
                        ]
                    ],
                    'image' => [
                        'label' => __( 'Background Image', 'affiliatex' ),
                        'condition' => [
                            'background' => 'image',
                        ]
                    ],
                    'position' => [
                        'default' => 'center center',
                        'condition' => [
                            'background' => 'image',
                            'image[url]!' => '',
                        ]
                    ],
                    'xpos' => [
                        'condition' => [
                            'background' => [ 'image' ],
                            'position' => [ 'initial' ],
                            'image[url]!' => '',
                            ]
                        ],
                    'ypos' => [
                        'condition' => [
                            'background' => [ 'image' ],
                            'position' => [ 'initial' ],
                            'image[url]!' => '',
                        ]
                    ],
                    'attachment' => [
                        'condition' => [
                            'background' => 'image',
                            'image[url]!' => '',
                        ]
                    ],
                    'attachment_alert' => [
                        'condition' => [
                            'background' => 'image',
                            'image[url]!' => '',
                            'attachment' => 'fixed',
                        ]
                    ],
                    'repeat' => [
                        'default' => 'no-repeat',
                        'condition' => [
                            'background' => 'image',
                            'image[url]!' => '',
                        ]
                    ],
                    'size' => [
                        'default' => 'cover',
                        'condition' => [
                            'background' => 'image',
                            'image[url]!' => '',
                        ]
                    ],
                    'bg_width' => [
                        'condition' => [
                            'background' => 'image',
                            'size'       =>  'initial',
                            'image[url]!' => '',
                        ]
                    ],
                ],
                'condition' => [
                    'ctaLayout' => 'layoutOne'
                ]
            ]
        );

        $this->add_control(
            'ctaExternalBgImage',
            [
                'label'     => __('External Image URL', 'affiliatex'),
                'type'      => ControlsManager::TEXT,
                'condition' => [
                    'ctaLayout' => 'layoutOne',
                    'ctaBGType_background' => 'image'
                ],
            ]
        );

        $this->add_control(
			'overlayOpacity',
			[
				'label' => esc_html__( 'Overlay Opacity', 'affiliatex' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0.1,
				],
				'selectors' => [
					$this->select_element('wrapper') . '::before' => 'opacity: {{SIZE}};',
				],
                'condition' => [
                    'ctaLayout' => 'layoutOne',
                    "ctaBGType_background" => 'image'
                ]
			]
		);

        $this->end_controls_section();

        /**************************************************************
         * Typography Section
         **************************************************************/
        $this->start_controls_section(
            'affx_cta_section_typography',
            [
                'label' => __('Typography', 'affiliatex'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'ctaTitleTypography',
                'label'          => __('Title Typography', 'affiliatex'),
                'selector'       => $this->select_element('title'),
                'fields_options' => [
                    'typography' => [
                        'default' => 'custom',
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 40,
                        ],
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
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'ctaContentTypography',
                'label'          => __('Content Typography', 'affiliatex'),
                'selector'       => $this->select_element('content'),
                'fields_options' => [
                    'typography' => [
                        'default' => 'custom',
                    ],
                    'font_weight' => [
                        'default' => '400',
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 18,
                        ]
                    ],
                    'line_height' => [
                        'default' => [
                            'unit' => '',
                            'size' => 1.5,
                        ]
                    ],
                    'letter_spacing' => [
                        'default' => [
                            'unit' => 'em',
                            'size' => 0,
                        ]
                    ],
                    'text_transform' => [
                        'default' => 'none',
                    ],
                    'text_decoration' => [
                        'default' => 'none',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Spacing Section
         **************************************************************/
        $this->start_controls_section(
            'affx_cta_section_spacing',
            [
                'label' => __('Spacing', 'affiliatex'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'ctaBoxPadding',
            [
                'label'      => __('Padding', 'affiliatex'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '60',
                    'right'    => '30',
                    'bottom'   => '60',
                    'left'     => '30',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    $this->select_element('wrapper') . '.layout-type-1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    $this->select_element('wrapper') . '.layout-type-2 .content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'ctaMargin',
            [
                'label'      => __('Margin', 'affiliatex'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '30',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    $this->select_element('wrapper') => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
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
                            'name' => 'ctaTitle',
                            'type' => 'text',
                            'defaults' => [
                                'ctaTitle' => esc_html__('Call to Action Title.', 'affiliatex'),
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'blockField' => [
                            'name' => 'ctaContent',
                            'type' => 'text',
                            'defaults' => [
                                'ctaContent' => esc_html__('Start creating CTAs in seconds, and convert more of your visitors into leads.', 'affiliatex'),
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'field' => 'display_price',
                        'blockField' => [
                            'name' => 'button_child1_1_productPrice',
                            'type' => 'text',
                            'defaults' => [
                                'button_child1_1_productPrice' => '$145',
                            ],
                            'conditions' => [
                                'button_child1_1_layoutStyle' => 'layout-type-2'
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'field' => 'images',
                        'blockField' => [
                            'name' => 'imageExternal',
                            'type' => 'image',
                            'defaults' => [
                                'imageExternal' => '',
                                'imageType' => 'default',
                            ],
                            'conditions' => [
                                'imageType' => 'external'
                            ],
                        ],
                        'type' => 'image',
                    ],
                    [
                        'field' => 'images',
                        'blockField' => [
                            'name' => 'ctaExternalBgImage',
                            'type' => 'image',
                            'defaults' => [
                                'ctaExternalBgImage' => '',
                            ],
                        ],
                        'type' => 'image',
                    ],
                    [
                        'field' => 'url',
                        'blockField' => [
                            'name' => 'button_child1_1_buttonURL',
                            'type' => 'link',
                            'defaults' => [
                                'button_child1_1_buttonURL' => '',
                            ],
                        ],
                        'type' => 'link',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Button 1 & 2 fields
         **************************************************************/
        $child1 = new ChildHelper($this, $this->get_button_elementor_fields(), self::$button1_config);
        $child2 = new ChildHelper($this, $this->get_button_elementor_fields(), self::$button2_config);

        $child1->generate_fields();
        $child2->generate_fields();
    }
}
