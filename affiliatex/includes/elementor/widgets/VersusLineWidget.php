<?php
namespace AffiliateX\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use AffiliateX\Traits\VersusLineRenderTrait;
use AffiliateX\Helpers\Elementor\WidgetHelper;
use AffiliateX\Elementor\ControlsManager;

defined('ABSPATH') or exit;

class VersusLineWidget extends ElementorBase
{
    use VersusLineRenderTrait;

    public function get_title(): string
    {
        return __('AffiliateX Versus Line', 'affiliatex');
    }

    public function get_icon(): string
    {
        return 'affx-icon-versus-line';
    }

    public function get_keywords()
    {
        return [
            "Versus Line",
            "versus",
            "AffiliateX"
        ];
    }

    public function get_elements(): array
    {
        return [
            'wrapper'   => 'affx-versus-table-wrap',
            'title'     => 'affx-versus-table-wrap .affx-versus-title',
            'vs-icon'   => 'affx-versus-table-wrap .affx-vs-icon',
            'table-odd-row' => 'affx-product-versus-table tbody tr:nth-child(odd) td',
        ];
    }

    protected function register_controls()
    {
        $defaults = $this->get_fields();

        ///////////////////////////////////////////////////
        // Content Tab
        ///////////////////////////////////////////////////
        /**************************************************************
         * Title Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_vl_title_settings',
            [
                'label' => __('Title Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'versusTitleTag',
            [
                'label'   => __('Title Tag', 'affiliatex'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h2' => 'h2',
                    'h3' => 'h3',
                    'h4' => 'h4',
                    'h5' => 'h5',
                    'h6' => 'h6',
                    'p'  => 'p'
                ],
                'default' => $defaults['versusTitleTag'],
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Content Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_vl_content_settings',
            [
                'label' => __('Content Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'vsLabel',
            [
                'label'       => __('VS Label', 'affiliatex'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => $defaults['vsLabel'],
            ]
        );

        $this->add_control(
            'versusTable',
            [
                'label'       => __('Table Items', 'affiliatex'),
                'type'        => Controls_Manager::REPEATER,
                'title_field' => '{{{ versusTitle }}}',
                'fields'      => [
                    [
                        'name'        => 'versusTitle',
                        'label'       => __('Title', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'repeater_name' => 'versusTable',
                        'default'     => __('Title', 'affiliatex')
                    ],
                    [
                        'name'        => 'versusSubTitle',
                        'label'       => __('Subtitle', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'repeater_name' => 'versusTable',
                        'default'     => __('Subtitle', 'affiliatex')
                    ],
                    [
                        'name'        => 'versusValue1',
                        'label'       => __('Value 1', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'label_block' => true,
                        'repeater_name' => 'versusTable',
                        'default'     => __('Value 1', 'affiliatex')
                    ],
                    [
                        'name'        => 'versusValue2',
                        'label'       => __('Value 2', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'repeater_name' => 'versusTable',
                        'default'     => __('Value 2', 'affiliatex')
                    ]
                ],
                'default'     => [
                    [
                        'versusTitle'    => __('Title', 'affiliatex'),
                        'versusSubTitle' => __('Subtitle', 'affiliatex'),
                        'versusValue1'   => __('Value 1', 'affiliatex'),
                        'versusValue2'   => __('Value 2', 'affiliatex')
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        ///////////////////////////////////////////////////
        // Style Tab
        ///////////////////////////////////////////////////
        /**************************************************************
         * Border settings
         **************************************************************/
        $this->start_controls_section(
            'affx_vl_border_settings',
            [
                'label' => __('Border Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'border',
                'label'          => __('Border', 'affiliatex'),
                'selector'       => $this->select_element('wrapper'),
                'fields_options' => [
                    'border' => [
                        'default' => ''
                    ],
                    'color'  => [
                        'default' => $defaults['border']['color']['color'],
                    ],
                    'width'  => [
                        'default' => [
                            'isLinked' => true,
                            'unit'     => 'px',
                            'top'      => $defaults['border']['width'],
                            'right'    => $defaults['border']['width'],
                            'bottom'   => $defaults['border']['width'],
                            'left'     => $defaults['border']['width']
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
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
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
                        'default' => ''
                    ],
                    'box_shadow'      => [
                        'default' => [
                            'vertical'   => $defaults['boxShadow']['v_offset'],
                            'horizontal' => $defaults['boxShadow']['h_offset'],
                            'blur'       => $defaults['boxShadow']['blur'],
                            'spread'     => $defaults['boxShadow']['spread'],
                            'color'      => $defaults['boxShadow']['color']['color'],
                            'inset'      => $defaults['boxShadow']['inset'],
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Color settings
         **************************************************************/
        $this->start_controls_section(
            'affx_vl_color_settings',
            [
                'label' => __('Color Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'vsTextColor',
            [
                'label'     => __('VS Text Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => $defaults['vsTextColor'],
                'selectors' => [
                    $this->select_element('vs-icon') => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'vsBgColor',
            [
                'label'     => __('VS Background Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => $defaults['vsBgColor'],
                'selectors' => [
                    $this->select_element('vs-icon') => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'contentColor',
            [
                'label'     => __('Content Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => $defaults['contentColor'],
                'selectors' => [
                    $this->select_elements(['wrapper', 'title']) => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'versusRowColor',
            [
                'label'     => __('Row Background Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => $defaults['versusRowColor'],
                'selectors' => [
                    $this->select_element('table-odd-row') => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'bgColorSolid',
                'label'          => __('Background', 'affiliatex'),
                'types'          => ['classic', 'gradient'],
                'exclude'        => ['image'],
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
                            'gradient' => [
                              'title' => __( 'Gradient', 'affiliatex' ),
                              'icon' => 'eicon-barcode',
                            ],
                        ],
                        'toggle' => false,
                        'render_type' => 'template',
                    ],
                    'color'      => [
                        'label' => __( 'Background Color', 'affiliatex' ),
                        'default' => $defaults['bgColorSolid'],
                        'condition' => [
                            'background' => 'classic'
                        ]
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
         * Typography settings
         **************************************************************/
        $this->start_controls_section(
            'affx_vl_typography_settings',
            [
                'label' => __('Typography Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'vsTypography',
                'label'          => __('VS Label Typography', 'affiliatex'),
                'selector'       => $this->select_element('vs-icon'),
                'fields_options' => [
                    'typography'  => [
                        'default' => 'yes'
                    ],
                    'font_family' => [
                        'default' => ''
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                    'font_size'   => [
                        'default' => ['unit' => 'px', 'size' => '18']
                    ],
                    'line_height' => [
                        'default' => [
                            'unit' => 'custom',
                            'size' => 1.65,
                        ],
                    ],
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'versusTitleTypography',
                'label'          => __('Title Typography', 'affiliatex'),
                'selector'       => $this->select_element('title'),
                'fields_options' => [
                    'typography'  => [
                        'default' => 'yes'
                    ],
                    'font_family' => [
                        'default' => ''
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                    'font_size'   => [
                        'default' => ['unit' => 'px', 'size' => '18']
                    ],
                    'line_height' => [
                        'default' => [
                            'unit' => 'custom',
                            'size' => 1.65,
                        ],
                    ],
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'versusContentTypography',
                'label'          => __('Content Typography', 'affiliatex'),
                'selector'       => $this->select_element('wrapper'),
                'fields_options' => [
                    'typography'  => [
                        'default' => 'yes'
                    ],
                    'font_family' => [
                        'default' => ''
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                    'font_size'   => [
                        'default' => ['unit' => 'px', 'size' => '18']
                    ],
                    'line_height' => [
                        'default' => [
                            'unit' => 'custom',
                            'size' => 1.65,
                        ],
                    ],
                ]
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Spacing
         **************************************************************/
        $this->start_controls_section(
            'affx_vl_spacing_settings',
            [
                'label' => __('Spacing Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label'      => __('Margin', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'pt'],
                'selectors'  => [
                    $this->select_element('wrapper') => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                    $this->select_element('wrapper') => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
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
                            'name' => 'versusTitle',
                            'type' => 'text',
                            'repeaterName' => 'versusTable',
                            'defaults' => [
                                'versusTitle' => __('Title', 'affiliatex'),
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'blockField' => [
                            'name' => 'versusSubTitle',
                            'type' => 'text',
                            'repeaterName' => 'versusTable',
                            'defaults' => [
                                'versusSubTitle' => __('Subtitle', 'affiliatex'),
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'blockField' => [
                            'name' => 'versusValue1',
                            'type' => 'text',
                            'repeaterName' => 'versusTable',
                            'defaults' => [
                                'versusValue1' => '$145',
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'blockField' => [
                            'name' => 'versusValue2',
                            'type' => 'text',
                            'repeaterName' => 'versusTable',
                            'defaults' => [
                                'versusValue2' => '$195',
                            ],
                        ],
                        'type' => 'text',
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }
}
