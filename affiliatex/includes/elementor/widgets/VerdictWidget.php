<?php

namespace AffiliateX\Elementor\Widgets;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use AffiliateX\Helpers\Elementor\ChildHelper;
use AffiliateX\Traits\VerdictRenderTrait;
use AffiliateX\Elementor\ControlsManager;
use AffiliateX\Helpers\Elementor\WidgetHelper;

/**
 * AffiliateX Single Product Elementor Widget
 *
 * @package AffiliateX
 */
class VerdictWidget extends ElementorBase
{
    use VerdictRenderTrait;

    protected function get_child_slugs(): array
    {
        return ['buttons', 'pros-and-cons'];
    }

    public function get_title()
    {
        return __('AffiliateX Verdict', 'affiliatex');
    }

    public function get_icon()
    {
        return 'affx-icon-verdict';
    }

    public function get_keywords()
    {
        return [
            "verdict",
            "AffiliateX"
        ];
    }

    protected function get_elements(): array
    {
        return [
            'wrapper' => 'affblk-verdict-wrapper',
            'layout-1' => 'verdict-layout-1',
            'layout-2' => 'verdict-layout-2',
            'title' => 'verdict-title',
            'content' => 'verdict-content',
        ];
    }

    protected function register_controls()
    {
        $defaults = $this->get_fields();


        ///////////////////////////////////////////////////
        // Content Tab
        ///////////////////////////////////////////////////
        /**************************************************************
         * Layout Settings
         **************************************************************/
        $this->start_controls_section(
            'layout_settings_section',
            [
                'label' => __('Layout Settings', 'affiliatex'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'verdictLayout',
            [
                'label' => __('Verdict Layout', 'affiliatex'),
                'type' => Controls_Manager::SELECT,
                'default' => $defaults['verdictLayout'],
                'options' => [
                    'layoutOne' => __('Layout One', 'affiliatex'),
                    'layoutTwo' => __('Layout Two', 'affiliatex'),
                ]
            ]
        );

        $this->end_controls_section();


        /**************************************************************
         * General Settings
         **************************************************************/
        $this->start_controls_section(
            'general_settings_section',
            [
                'label' => __('General Settings', 'affiliatex'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'verdictTitleTag',
            [
                'label' => __('Verdict Heading Tag', 'affiliatex'),
                'type' => Controls_Manager::SELECT,
                'default' => $defaults['verdictTitleTag'],
                'options' => [
                    'h2' => __('Heading 2 (h2)', 'affiliatex'),
                    'h3' => __('Heading 3 (h3)', 'affiliatex'),
                    'h4' => __('Heading 4 (h4)', 'affiliatex'),
                    'h5' => __('Heading 5 (h5)', 'affiliatex'),
                    'h6' => __('Heading 6 (h6)', 'affiliatex'),
                    'p' => __('Paragraph (p)', 'affiliatex')
                ],
            ]
        );

        $this->add_control(
            'verdictTitle',
            [
                'label' => __('Title', 'affiliatex'),
                'type' => ControlsManager::TEXT,
                'default' => $defaults['verdictTitle'],
            ]
        );

        $this->add_control(
            'verdictContent',
            [
                'label' => __('Content', 'affiliatex'),
                'type' => ControlsManager::TEXTAREA,
                'default' => $defaults['verdictContent']
            ]
        );

        $this->add_control(
            'contentAlignment',
            [
                'label' => __('Content Alignment', 'affiliatex'),
                'type' => Controls_Manager::CHOOSE,
                'default' => $defaults['contentAlignment'],
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'affiliatex'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'affiliatex'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'affiliatex'),
                        'icon' => 'eicon-text-align-right'
                    ]
                ],
                'selectors' => [
                    $this->select_element('layout-2') => "text-align: {{VALUE}}",
                ],
                'condition' => [
                    'verdictLayout' => 'layoutTwo'
                ]
            ]
        );

        $this->add_control(
            'edProsCons',
            [
                'label' => __('Show Pros and Cons', 'affiliatex'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => $defaults['edProsCons'] ? 'true' : 'false',
                'condition' => [
                    'verdictLayout' => 'layoutOne'
                ]
            ]
        );
        
        $this->add_control(
            'edRatingsArrow',
            [
                'label' => __('Display Arrow', 'affiliatex'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => $defaults['edRatingsArrow'] ? 'true' : 'false',
                'condition' => [
                    'verdictLayout' => 'layoutTwo'
                ]
            ]
        );

        $this->end_controls_section();


        /**************************************************************
         * Rating Settings
         **************************************************************/
        $this->start_controls_section(
            'rating_settings_section',
            [
                'label' => __('Rating Settings', 'affiliatex'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'verdictLayout' => 'layoutOne'
                ]
            ]
        );

        $this->add_control(
            'edverdictTotalScore',
            [
                'label' => esc_html__('Enable Score Rating', 'affiliatex'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => $defaults['edverdictTotalScore'] ? 'true' : 'false',
            ]
        );

        $this->add_control(
            'verdictTotalScore',
            [
                'label' => esc_html__('Total Score', 'affiliatex'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => $defaults['verdictTotalScore'],
                ],
                'condition' => [
                    'edverdictTotalScore' => 'true'
                ]
            ]
        );

        $this->add_control(
            'ratingContent',
            [
                'label' => __('Rating Score Content', 'affiliatex'),
                'type' => ControlsManager::TEXT,
                'default' => $defaults['ratingContent'],
                'condition' => [
                    'edverdictTotalScore' => 'true'
                ]
            ]
        );

        $this->add_control(
            'ratingAlignment',
            [
                'label' => __('Rating Alignment', 'affiliatex'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'row-reverse',
                'options' => [
                    'row-reverse' => [
                        'title' => esc_html__('Left', 'affiliatex'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'row' => [
                        'title' => esc_html__('Right', 'affiliatex'),
                        'icon' => 'eicon-text-align-right'
                    ]
                ],
                'toggle' => false,
                'selectors' => [
                    $this->select_element(['layout-1', ' .main-text-holder']) => "flex-direction: {{VALUE}} !important;",
                ],
                'condition' => [
                    'edverdictTotalScore' => 'true'
                ]
            ]
        );

        $this->end_controls_section();


        ///////////////////////////////////////////////////
        //  Style Tab
        ///////////////////////////////////////////////////
        /**************************************************************
         * Border Settings.
         **************************************************************/
        $this->start_controls_section(
            'border_settings_section',
            [
                'label' => __('Border Settings', 'affiliatex'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'verdictBorder',
                'selector' => $this->select_element('wrapper'),
                'fields_options' => [
                    'border' => [
                        'default' => $defaults['verdictBorder']['style']
                    ],
                    'color' => [
                        'default' => $defaults['verdictBorder']['color']['color']
                    ],
                    'width' => [
                        'default' => [
                            'isLinked' => 'true',
                            'unit' => 'px',
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1'
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'verdictBorderRadius',
            [
                'label' => esc_html__('Border Radius', 'affiliatex'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    $this->select_element('wrapper') => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'verdictBoxShadow',
                'selector' => $this->select_element('wrapper'),
                'label' => __('Box Shadow', 'affiliatex'),
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => ''
                    ],
                    'box_shadow' => [
                        'default' => [
                            'vertical' => $defaults['verdictBoxShadow']['v_offset'],
                            'horizontal' => $defaults['verdictBoxShadow']['h_offset'],
                            'blur' => $defaults['verdictBoxShadow']['blur'],
                            'spread' => $defaults['verdictBoxShadow']['spread'],
                            'color' => $defaults['verdictBoxShadow']['color']['color'],
                            'inset' => $defaults['verdictBoxShadow']['inset'],
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_section();


        /**************************************************************
         * Colors
         **************************************************************/
        $this->start_controls_section(
            'affx_sp_style_general',
            [
                'label' => __('Colors', 'affiliatex'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'verdictTitleColor',
            [
                'label' => __('Title Color', 'affiliatex'),
                'type' => Controls_Manager::COLOR,
                'default' => $defaults['verdictTitleColor'],
                'selectors' => [
                    $this->select_element('title') => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'verdictContentColor',
            [
                'label' => __('Content Color', 'affiliatex'),
                'type' => Controls_Manager::COLOR,
                'default' => $defaults['verdictContentColor'],
                'selectors' => [
                    $this->select_element('content') => 'color: {{VALUE}}',
                    $this->select_element(['wrapper', ' .verdict-user-rating-wrapper']) => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'scoreTextColor',
            [
                'label' => __('Score Text Color', 'affiliatex'),
                'type' => Controls_Manager::COLOR,
                'default' => $defaults['scoreTextColor'],
                'selectors' => [
                    $this->select_element(['layout-1', ' .num']) => 'color: {{VALUE}}',
                    $this->select_element(['layout-1', ' .affx-verdict-rating-number']) => 'color: {{VALUE}}',
                    $this->select_element(['layout-1', ' .rich-content']) => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'verdictLayout' => 'layoutOne',
                    'edverdictTotalScore' => 'true'
                ]
            ]
        );

        $this->add_control(
            'scoreBgTopColor',
            [
                'label' => __('Score Top Background Color', 'affiliatex'),
                'type' => Controls_Manager::COLOR,
                'default' => $defaults['scoreBgTopColor'],
                'selectors' => [
                    $this->select_element('layout-1') . ' .num' => 'background: {{VALUE}}'
                ],
                'condition' => [
                    'verdictLayout' => 'layoutOne',
                    'edverdictTotalScore' => 'true'
                ]
            ]
        );

        $this->add_control(
            'scoreBgBotColor',
            [
                'label' => __('Score Bottom Background Color', 'affiliatex'),
                'type' => Controls_Manager::COLOR,
                'default' => $defaults['scoreBgBotColor'],
                'selectors' => [
                    $this->select_element(['layout-1', ' .rich-content']) => 'background: {{VALUE}}',
                    $this->select_element(['layout-1', ' .rich-content::after']) => 'border-top: 5px solid {{VALUE}}',
                ],
                'condition' => [
                    'verdictLayout' => 'layoutOne',
                    'edverdictTotalScore' => 'true'
                ]
            ]
        );

        $this->add_control(
            'verdictArrowColor',
            [
                'label' => __('Arrow Color', 'affiliatex'),
                'type' => Controls_Manager::COLOR,
                'default' => $defaults['verdictArrowColor'],
                'selectors' => [
                    $this->select_element(
                        ['layout-2', '.display-arrow .affx-btn-inner .affiliatex-button::after']
                    ) => 'background: {{VALUE}}'
                ],
                'condition' => [
                    'verdictLayout' => 'layoutTwo',
                    'edRatingsArrow' => 'true'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'verdictBackground',
                'types' => ['classic', 'gradient'],
                'selector' => $this->select_element('wrapper'),
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                        'options' => [
                            'classic' => [
                                'title' => esc_html__('Solid Color', 'elementor'),
                                'icon' => 'eicon-paint-brush',
                            ],
                            'gradient' => [
                                'title' => esc_html__('Gradient', 'elementor'),
                                'icon' => 'eicon-barcode',
                            ],
                        ],
                        'label' => __('Verdict Background Type', 'affiliatex'),
                    ],
                    'color' => [
                        'default' => $defaults['verdictBgColorSolid'],
                        'label' => __('Verdict Background Color', 'affiliatex'),
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
        );

        $this->end_controls_section();


        /**************************************************************
         * Typography
         **************************************************************/
        $this->start_controls_section(
            'typography_settings_section',
            [
                'label' => __('Typography', 'affiliatex'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'verdictTitleTypography',
                'label' => __('Title Typography', 'affiliatex'),
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
                            'size' => '24'
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'verdictContentTypography',
                'label' => __('Content Typography', 'affiliatex'),
                'selector' => $this->select_element('content'),
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
                ]
            ]
        );

        $this->end_controls_section();


        /**************************************************************
         * Spacing
         **************************************************************/
        $this->start_controls_section(
            'spacing_section_settings',
            [
                'label' => __('Spacing', 'affiliatex'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'verdictBoxPadding',
            [
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
                    $this->select_element('wrapper') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'verdictMargin',
            [
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
                            'name' => 'verdictTitle',
                            'type' => 'text',
                            'defaults' => [
                                'verdictTitle' => $defaults['verdictTitle'],
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'blockField' => [
                            'name' => 'verdictContent',
                            'type' => 'text',
                            'defaults' => [
                                'verdictContent' => $defaults['verdictContent'],
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'blockField' => [
                            'name' => 'pros_and_cons_child_prosListItemsAmazon',
                            'type' => 'list',
                            'defaults' => [
                                'pros_and_cons_child_prosContentType' => 'list',
                                'pros_and_cons_child_prosListItemsAmazon' => '',
                            ],
                            'conditions' => [
                                'pros_and_cons_child_prosContentType' => 'amazon',
                            ],
                        ],
                        'type' => 'list',
                    ],
                    [
                        'blockField' => [
                            'name' => 'pros_and_cons_child_consListItemsAmazon',
                            'type' => 'list',
                            'defaults' => [
                                'pros_and_cons_cons_child_contentType' => 'list',
                                'pros_and_cons_cons_child_listItemsAmazon' => '',
                            ],
                            'conditions' => [
                                'pros_and_cons_child_consContentType' => 'amazon',
                            ],
                        ],
                        'type' => 'list',
                    ],
                    [
                        'field' => 'display_price',
                        'blockField' => [
                            'name' => 'button_child_productPrice',
                            'type' => 'text',
                            'defaults' => [
                                'button_child_productPrice' => '$145',
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'field' => 'url',
                        'blockField' => [
                            'name' => 'button_child_buttonURL',
                            'type' => 'link',
                            'defaults' => [
                                'button_child_buttonURL' => '',
                            ],
                        ],
                        'type' => 'link',
                    ],
                ],
            ]
        );

        $this->end_controls_section();


        /**************************************************************
         * Child Button settings
         **************************************************************/
        $child = new ChildHelper(
            $this,
            $this->get_button_elementor_fields(),
            self::$inner_button_config
        );

        $child->generate_fields();

        /**************************************************************
         * Child Pros and Cons settings
         **************************************************************/
        $pros_and_cons_widget = new ProsAndConsWidget();

        $controls = $pros_and_cons_widget->get_elementor_controls();

        $child = new ChildHelper(
            $this,
            $controls,
            self::$inner_pros_and_cons_config
        );

        $child->generate_fields();
    }

    /**
     * Render for Elementor
     *
     * @return void
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $attributes = $this->parse_attributes($settings);
        $attributes = WidgetHelper::process_attributes($attributes);

        extract($attributes);

        $attributes['block_id'] = $this->get_id();
        $attributes['verdictTotalScore'] = isset($attributes['verdictTotalScore']['size']) ? esc_html($attributes['verdictTotalScore']['size']) : '';

        if ('layoutOne' == $verdictLayout) {
            $child_attributes = ChildHelper::extract_attributes($attributes, self::$inner_pros_and_cons_config);

            $pros_and_cons_widget = new ProsAndConsWidget();

            ob_start();
            $pros_and_cons_widget->render($child_attributes);
            $inner_widget_content = ob_get_clean();
        } elseif ('layoutTwo' == $verdictLayout) {
            $button_child = '';

            $child_attributes = ChildHelper::extract_attributes($attributes, self::$inner_button_config);

            ob_start();
            $this->render_button($child_attributes);
            $button_child = ob_get_clean();

            $inner_widget_content = $button_child;
        }

        echo $this->render_template($attributes, $inner_widget_content);
    }
}
