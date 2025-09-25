<?php
namespace AffiliateX\Elementor\Widgets;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use AffiliateX\Traits\NoticeRenderTrait;
use AffiliateX\Elementor\ControlsManager;

class NoticeWidget extends ElementorBase
{
    use NoticeRenderTrait;

    public function get_slug(): string
    {
        return 'notice';
    }

    public function get_title()
    {
        return __('AffiliateX Notice', 'affiliatex');
    }

    public function get_icon()
    {
        return 'affx-icon-notice';
    }

    public function get_keywords()
    {
        return [
            "Notice",
            "Message",
            "AffiliateX"
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
            'affx_notice_layout_setting_section',
            [
                'label' => __('Layout Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'layoutStyle',
            [
                'label'   => __('Choose Layout', 'affiliatex'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'layout-type-1',
                'options' => [
                    'layout-type-1' => __('Layout One', 'affiliatex'),
                    'layout-type-2' => __('Layout Two', 'affiliatex')
                ]
            ]
        );
        $this->end_controls_section();

        /**************************************************************
         * Title Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_notice_title_settings',
            [
                'label' => __('Title Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'noticeTitle',
            [
                'label'   => __('Notice Title', 'affiliatex'),
                'type'    => ControlsManager::TEXT,
                'default' => __('Notice', 'affiliatex')
            ]
        );

        $this->add_control(
            'titleTag1',
            [
                'label'   => __('Title Tag', 'affiliatex'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h2' => __('Heading 2 (h2)', 'affiliatex'),
                    'h3' => __('Heading 3 (h3)', 'affiliatex'),
                    'h4' => __('Heading 4 (h4)', 'affiliatex'),
                    'h5' => __('Heading 5 (h5)', 'affiliatex'),
                    'h6' => __('Heading 6 (h6)', 'affiliatex')
                ]
            ]
        );

        $this->add_control(
            'titleAlignment',
            [
                'label'     => __('Title Alignment', 'affiliatex'),
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
                'default'   => 'left',
                'toggle'    => false,
                'selectors' => [
                    $this->select_element('title') => 'text-align: {{VALUE}};'
                ],
                'condition' => [
                    'layoutStyle' => ['layout-type-1', 'layout-type-2'],
                ]
            ]
        );

        $this->add_control(
            'edTitleIcon',
            [
                'label'        => __('Show Title Icon', 'affiliatex'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('On', 'affiliatex'),
                'label_off'    => __('Off', 'affiliatex'),
                'return_value' => 'true',
                'default'      => 'true'
            ]
        );

        $this->add_control(
            'noticeTitleIcon',
            [
                'label'     => __('Title Icon', 'affiliatex'),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fa fa-info-circle',
                    'library' => 'fa-solid'
                ],
                'condition' => [
                    'edTitleIcon' => 'true'
                ]
            ]
        );

        $this->add_control(
            'noticeIconSize',
            [
                'label' => __( 'Title Icon Size', 'affiliatex' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 17,
                ],
                'condition' => [
                    'edTitleIcon' => 'true'
                ],
                'selectors' => [
                    $this->select_element('title') . ' > i' => 'font-size: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Content Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_notice_content_settings',
            [
                'label' => __('Content Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'noticeContentType',
            [
                'label'   => __('Content Type', 'affiliatex'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'paragraph' => [
                        'title' => esc_html__('Paragraph', 'affiliatex'),
                        'icon'  => 'eicon-editor-paragraph'
                    ],
                    'list'      => [
                        'title' => esc_html__('List', 'affiliatex'),
                        'icon'  => 'eicon-bullet-list'
                    ],
                    'amazon' => [
                        'title' => esc_html__('Amazon', 'affiliatex'),
                        'icon'  => 'fa-brands fa-amazon'
                    ]
                ],
                'default' => 'list',
                'toggle'  => false
            ]
        );

        $this->add_control(
            'noticeContent',
            [
                'label'       => __('Content', 'affiliatex'),
                'type'        => ControlsManager::TEXTAREA,
                'rows'        => 4,
                'default'     => __( 'This is the notice content', 'affiliatex' ),
                'placeholder' => __( 'Notice Content', 'affiliatex' ),
                'condition'   => [
                    'noticeContentType' => 'paragraph'
                ]
            ]
        );

        $this->add_control(
            'noticeListItems',
            [
                'label'     => __('Content List', 'affiliatex'),
                'type'      => Controls_Manager::REPEATER,
                'title_field' => '{{{ content }}}',
                'fields'    => [
                    [
                        'name'    => 'content',
                        'label'   => __('List Item', 'affiliatex'),
                        'type'    => ControlsManager::TEXT,
                        'default' => 'Enter new item'
                    ]
                ],
                'default'   => [
                    [
                        'content' => 'Enter new item'
                    ]
                ],
                'condition' => [
                    'noticeContentType' => 'list'
                ]
            ]
        );

        $this->add_control(
            'noticeListItemsAmazon',
            [
                'label'     => __('Amazon Content List', 'affiliatex'),
                'type'      => ControlsManager::TEXT,
                'default'   => '',
                'condition' => [
                    'noticeContentType' => 'amazon'
                ]
            ]
        );

        $this->add_responsive_control(
            'alignment',
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
                'default'   => 'left',
                'toggle'    => false,
                'selectors' => [
                    $this->select_element('content') => 'text-align: {{VALUE}}',
                    $this->select_element('list') => 'justify-content: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'noticeListType',
            [
                'label'     => __('List Type', 'affiliatex'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'unordered' => [
                        'title' => esc_html__('Unordered', 'affiliatex'),
                        'icon'  => 'eicon-editor-list-ul'
                    ],
                    'ordered'   => [
                        'title' => esc_html__('Ordered', 'affiliatex'),
                        'icon'  => 'eicon-editor-list-ol'
                    ]
                ],
                'default'   => 'unordered',
                'toggle'    => false,
                'condition' => [
                    'noticeContentType' => ['list', 'amazon']
                ]
            ]
        );

        $this->add_control(
            'noticeunorderedType',
            [
                'label' => __( 'List Item Icon Type', 'affiliatex' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'icon' => [
                        'title' => __( 'Show Icon', 'affiliatex' ),
                        'icon' => 'eicon-star'
                    ],
                    'bullet' => [
                        'title' => __( 'Show Bullet', 'affiliatex' ),
                        'icon' => 'eicon-ellipsis-v'
                    ],
                ],
                'default' => 'icon',
                'toggle' => true,
                'condition' => [
                    'noticeContentType' => ['list', 'amazon'],
                    'noticeListType' => 'unordered',
                ],
            ]
        );

        $this->add_control(
            'noticeListIcon',
            [
                'label'       => __('List Item Icon', 'affiliatex'),
                'type'        => Controls_Manager::ICONS,
                'label_block' => true,
                'default'     => [
                    'value'   => 'fas fa-check-circle',
                    'library' => 'fa-solid'
                ],
                'condition'   => [
                    'noticeContentType' => ['list', 'amazon'],
                    'noticeListType'    => 'unordered',
                    'noticeunorderedType' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'noticeListIconSize',
            [
                'label' => __( 'List Icon Size', 'affiliatex' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 17,
                ],
                'condition' => [
                    'noticeContentType' => ['list', 'amazon'],
                    'noticeListType' => 'unordered',
                    'noticeunorderedType' => 'icon'
                ],
                'selectors' => [
                    $this->select_element('list') . ' i' => 'font-size: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->end_controls_section();

        
        ///////////////////////////////////////////////////
        // STYLE CONTENT
        ///////////////////////////////////////////////////
        /**************************************************************
         * Border Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_notice_border_settings',
            [
                'label' => __('Border', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'noticeBorder',
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
                            'isLinked' => false,
                            'unit'     => 'px',
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '0',
                            'left'     => '0'
                        ]
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'noticeBorderRadius',
            [
                'label'      => __('Border Radius', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    $this->select_element('wrapper') => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'boxShadow',
                'selector'       => $this->select_element('wrapper'),
                'label'          => __('Box Shadow', 'affiliatex'),
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => 'yes'
                    ],
                    'box_shadow'      => [
                        'default' => [
                            'vertical'   => '5',
                            'horizontal' => '0',
                            'blur'       => '20',
                            'spread'     => '0',
                            'color'      => 'rgba(210,213,218,0.2)',
                            'inset'      => false
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
            'affx_notice_color_section',
            [
                'label' => __('Colors', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'noticeTextColor',
            [
                'label'     => __('Title Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    $this->select_element('layout-1-wrapper') . ' .affiliatex-notice-title' => 'color: {{VALUE}} !important;'
                ],
                'condition' => [
                    'layoutStyle' => ['layout-type-1']
                ]
            ]
        );

        $this->add_control(
            'noticeTextColorAlt',
            [
                'label'     => __('Title Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#084ACA',
                'selectors' => [
                    $this->select_element('layout-2-wrapper') . ' .affiliatex-notice-title' => 'color: {{VALUE}} !important;'
                ],
                'condition' => [
                    'layoutStyle' => ['layout-type-2']
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'noticeBgColor',
                'types'          => ['classic', 'gradient'],
                'exclude'        => ['image'],
                'selector'       => $this->select_element('title'),
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                        'options' => [
                            'classic' => [
                                'title' => esc_html__( 'Color', 'affiliatex' ),
                                'icon' => 'eicon-paint-brush',
                            ],
                            'gradient' => [
                                'title' => esc_html__( 'Gradient', 'affiliatex' ),
                                'icon' => 'eicon-barcode',
                            ],
                        ],
                        'label' => __('Title Background Type', 'affiliatex'),
                    ],
                    'color'      => [
                        'default' => '#24B644',
                        'label'   => __( 'Title Background Color', 'affiliatex' ),
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
                    ]
                ],
                'condition'      => [
                    'layoutStyle' => 'layout-type-1'
                ]
            ]
        );

        $this->add_control(
            'noticeListColor',
            [
                'label'     => __('Content Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#292929',
                'selectors' => [
                    $this->select_element('content') => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'listBgColor',
                'types'          => ['classic', 'gradient'],
                'exclude'        => ['image'],
                'selector'       => $this->select_element('content'),
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                        'options' => [
                            'classic' => [
                                'title' => esc_html__( 'Color', 'affiliatex' ),
                                'icon' => 'eicon-paint-brush',
                            ],
                            'gradient' => [
                                'title' => esc_html__( 'Gradient', 'affiliatex' ),
                                'icon' => 'eicon-barcode',
                            ],
                        ],
                        'label' => __('Content Background Type', 'affiliatex'),
                    ],
                    'color'      => [
                        'default' => '#ffffff',
                        'label'   => __( 'Content Background Color', 'affiliatex' ),
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
                    ]
                ],
                'condition'      => [
                    'layoutStyle' => 'layout-type-1'
                ]
            ]
        );

        $this->add_control(
            'noticeIconColor',
            [
                'label'     => __('List Icon Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#24B644',
                'condition' => [
                    'noticeContentType' => ['list', 'amazon']
                ],
                'selectors' => [
                    $this->select_element('list') . ' i' => 'color: {{VALUE}}',
                    $this->select_element('list') . '::marker' => 'color: {{VALUE}}',
                    $this->select_element('list') . '::before' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'noticeIconTwoColor',
            [
                'label'     => __('Title Icon Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#084ACA',
                'selectors' => [
                    $this->select_element('layout-2-wrapper') . ' .affiliatex-notice-title > i' => 'color: {{VALUE}} !important;'
                ],
                'condition' => [
                    'layoutStyle' => [ 'layout-type-2' ],
                    'edTitleIcon' => 'true',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'noticeBgTwoColor',
                'types'          => ['classic', 'gradient'],
                'exclude'        => ['image'],
                'selector'       => $this->select_element('inner-wrapper') . ':not(.layout-type-1)',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                        'options' => [
                            'classic' => [
                                'title' => esc_html__( 'Color', 'affiliatex' ),
                                'icon' => 'eicon-paint-brush',
                            ],
                            'gradient' => [
                                'title' => esc_html__( 'Gradient', 'affiliatex' ),
                                'icon' => 'eicon-barcode',
                            ],
                        ],
                        'label' => __('Background Color Type', 'affiliatex'),
                    ],
                    'color'      => [
                        'default' => '#F6F9FF',
                        'label'   => __( 'Background Color', 'affiliatex' ),
                    ],
                    'gradient'   => [
                        'default' => 'linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%)'
                    ],
                    'color_b' => [
                        'default' => '#00D082',
                    ],
                    'color_b_stop' => [
                        'default' => [
                            'unit' => '%',
                            'size' => 30,
                        ]
                    ],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => '135'
                        ]
                    ]
                ],
                'condition' => [
                    'layoutStyle' => ['layout-type-2'],
                ]
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Typography Section
         **************************************************************/
        $this->start_controls_section(
            'affx_notice_section_typography',
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
                'selector'       => $this->select_element('title'),
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'listTypography',
                'label'          => __('Content Typography', 'affiliatex'),
                'selector'       => $this->select_element('paragraph-list'),
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
                ]
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Spacing Section
         **************************************************************/
        $this->start_controls_section(
            'affx_notice_spacing_section',
            [
                'label' => __('Spacing', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layoutStyle' => 'layout-type-1'
                ]
            ]
        );

        $this->add_responsive_control(
            'noticeMargin',
            [
                'label'      => __('Margin', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'pt'],
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
                ],
                'condition' => [
                    'layoutStyle' => 'layout-type-1'
                ]
            ]
        );

        $this->add_responsive_control(
            'titlePadding',
            [
                'label'      => __('Title Padding', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'pt'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '15',
                    'bottom'   => '10',
                    'left'     => '15',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    $this->select_element('title') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'layoutStyle' => 'layout-type-1'
                ]
            ]
        );

        $this->add_control(
			'titleAndWrapperPaddingAlt',
			[
				'type' => Controls_Manager::HIDDEN,
                'default' => 'DEFAULT_VALUE',
                'selectors' => [
                    $this->select_element('layout-2-wrapper' ) => 'padding: 20px',
                    $this->select_element('layout-2-wrapper' ) . ' .affiliatex-notice-title' => 'padding-bottom: 10px',
                ],
                'condition' => [
                    'layoutStyle' => ['layout-type-2'],
                ]
			]
		);

        $this->add_responsive_control(
            'contentPadding',
            [
                'label'      => __('Content Padding', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'pt'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '15',
                    'bottom'   => '10',
                    'left'     => '15',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    $this->select_element('content') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'layoutStyle' => 'layout-type-1'
                ]
            ]
        );

        $this->add_control(
            'amazonAttributes',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => [
                    [
                        'field' => 'title',
                        'blockField' => [
                            'name' => 'noticeTitle',
                            'type' => 'text',
                            'defaults' => [
                                'noticeTitle' => __('Notice', 'affiliatex'),
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'field' => 'features',
                        'blockField' => [
                            'name' => 'noticeListItemsAmazon',
                            'type' => 'list',
                            'disabled' => true,
                            'placeholder' => __('Click on the button to connect product', 'affiliatex'),
                            'defaults' => [
                                'noticeContentType' => 'list',
                                'noticeListItemsAmazon' => '',
                            ],
                            'conditions' => [
                                'noticeContentType' => 'amazon',
                            ],
                        ],
                        'type' => 'list',
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }
}
