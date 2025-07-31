<?php
namespace AffiliateX\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use AffiliateX\Helpers\Elementor\WidgetHelper;
use AffiliateX\Traits\SpecificationsRenderTrait;
use AffiliateX\Elementor\ControlsManager;

defined('ABSPATH') or exit;

class SpecificationsWidget extends ElementorBase
{
    use SpecificationsRenderTrait;

    public function get_title(): string
    {
        return __('Affiliatex Specifications', 'affiliatex');
    }

    public function get_icon(): string
    {
        return 'affx-icon-product-spec';
    }

    public function get_keywords()
    {
        return [
            "specifications",
            "AffiliateX"
        ];
    }

    protected function register_controls()
    {
        ///////////////////////////////////////////////////
        // Content
        ///////////////////////////////////////////////////
        /**************************************************************
         * Layout settings
         **************************************************************/
        $this->start_controls_section(
            'affx_specifications_layout_settings',
            [
                'label' => __('Layout Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'layoutStyle',
            [
                'label'   => __('Layout Style', 'affiliatex'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'layout-1',
                'options' => [
                    'layout-1' => __('Layout 1', 'affiliatex'),
                    'layout-2' => __('Layout 2', 'affiliatex'),
                    'layout-3' => __('Layout 3', 'affiliatex')
                ]
            ]
        );

        $this->add_control(
            'specificationColumnWidth',
            [
                'label' => esc_html__('Table Column', 'affiliatex'),
                'type' => Controls_Manager::VISUAL_CHOICE,
                'label_block' => true,
                'options' => [
                    'style-one' => [
                        'title' => esc_attr__('33 | 66', 'affiliatex'),
                        'image' => AFFILIATEX_PLUGIN_URL . '/assets/icons/layout/33-66.svg',
                    ],
                    'style-two' => [
                        'title' => esc_attr__('50 | 50', 'affiliatex'),
                        'image' => AFFILIATEX_PLUGIN_URL . '/assets/icons/layout/50-50.svg',
                    ],
                    'style-three' => [
                        'title' => esc_attr__('66 | 33', 'affiliatex'),
                        'image' => AFFILIATEX_PLUGIN_URL . '/assets/icons/layout/66-33.svg',
                    ],
                ],
                'default' => 'style-one',
                'columns' => 3,
                'prefix_class' => 'col-width-',
                'render_type' => 'template',
            ]
        );

        $this->end_controls_section();


        /**************************************************************
         * Title Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_title_settings',
            [
                'label' => __('Title Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'edSpecificationTitle',
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
            'specificationTitle',
            [
                'label' => __('Title', 'affiliatex'),
                'type' => ControlsManager::TEXT,
                'default' => __('Specifications', 'affiliatex')
            ]
        );

        $this->add_control(
            'productTitleAlign',
            [
                'label'     => __('Title Alignment', 'affiliatex'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'left',
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
                    'edSpecificationTitle' => 'true'
                ],
                'toggle'    => false,
                'selectors' => [
                    $this->select_element('title') => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'specificationTitleTag',
            [
                'label'     => __('Title Tag', 'affiliatex'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'h2',
                'options'   => [
                    'h2' => __('Heading 2 (h2)', 'affiliatex'),
                    'h3' => __('Heading 3 (h3)', 'affiliatex'),
                    'h4' => __('Heading 4 (h4)', 'affiliatex'),
                    'h5' => __('Heading 5 (h5)', 'affiliatex'),
                    'h6' => __('Heading 6 (h6)', 'affiliatex'),
                    'p'  => __('Paragraph (p)', 'affiliatex')
                ],
                'condition' => [
                    'edSpecificationTitle' => 'true'
                ]
            ]
        );


        $this->end_controls_section();

        /**************************************************************
         * Specifications
         **************************************************************/
        $this->start_controls_section(
            'affx_specifications_settings',
            [
                'label' => __('Specifications Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'specificationTable',
            [
                'label'   => __('Specifications', 'affiliatex'),
                'type'    => Controls_Manager::REPEATER,
                'title_field' => '{{{ specificationLabel }}}',
                'fields'  => [
                    [
                        'name'        => 'specificationLabel',
                        'label'       => __('Label', 'affiliatex'),
                        'type'        => ControlsManager::TEXT,
                        'repeater_name' => 'specificationTable',
                        'default'     => __('Specification Label', 'affiliatex')
                    ],
                    [
                        'name'        => 'specificationValue',
                        'label'       => __('Value', 'affiliatex'),
                        'type'        => ControlsManager::TEXTAREA,
                        'repeater_name' => 'specificationTable',
                        'default'     => __('Specification Value', 'affiliatex')
                    ]
                ],
                'default' => [
                    [
                        'specificationLabel' => __('Specification Label', 'affiliatex'),
                        'specificationValue' => __('Specification Value', 'affiliatex')
                    ]
                ]
            ]
        );

        $this->add_control(
            'specificationLabelAlign',
            [
                'label'     => __('Label Alignment', 'affiliatex'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'left',
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
                'toggle'    => false,
                'selectors' => [
                    $this->select_element('label') => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'specificationValueAlign',
            [
                'label'     => __('Value Alignment', 'affiliatex'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'left',
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
                'toggle'    => false,
                'selectors' => [
                    $this->select_element('value') => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        ///////////////////////////////////////////////////
        // Style tab
        ///////////////////////////////////////////////////
        /**************************************************************
         * Border Settings
         **************************************************************/
        $this->start_controls_section(
            'affx_specifications_border_settings',
            [
                'label' => __('Border Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'specificationBorder',
                'label'          => __('Border', 'affiliatex'),
                'selector'       => $this->select_element('container'),
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
            'specificationBorderRadius',
            [
                'label'      => __('Border Radius', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    $this->select_element('container') => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false

                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'specificationBoxShadow',
                'selector'       => $this->select_element('wrapper'),
                'label'          => __('Box Shadow', 'affiliatex'),
            ]
        );

        $this->end_controls_section();

        /**************************************************************
         * Colors
         **************************************************************/
        $this->start_controls_section(
            'affx_specifications_colors',
            [
                'label' => __('Colors', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'specificationTitleColor',
            [
                'label'     => __('Title Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#292929',
                'selectors' => [
                    $this->select_element('title') => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'specificationTitleBgColor',
            [
                'label'     => __('Title Background Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    $this->select_element('table-heading') => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'specificationLabelColor',
            [
                'label'     => __('Label Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    $this->select_element('label') => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'specificationValueColor',
            [
                'label'     => __('Value Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#292929',
                'selectors' => [
                    $this->select_element('value') => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'specificationRowColor',
            [
                'label'     => __('Table Row Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#F5F7FA',
                'selectors' => [
                    $this->select_element('table') . '.layout-2 .affx-spec-label' => 'background: {{VALUE}};'
                ],
                'condition' => [
                    'layoutStyle' => 'layout-2'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'specificationBgColorSolid',
                'label'          => __('Background', 'affiliatex'),
                'types'          => ['classic', 'gradient'],
                'exclude'        => ['image'],
                'selector'       => $this->select_element('table'),
                'fields_options' => [
                    'background' => [
                        'label'   => __('Background Type', 'affiliatex'),
                        'default' => 'classic',
                        'options' => [
                            'classic' => [
                                'title' => __('Color', 'affiliatex'),
                                'icon'  => 'eicon-global-colors',
                            ],
                            'gradient' => [
                                'title' => __('Gradient', 'affiliatex'),
                                'icon' => 'eicon-barcode',
                            ],
                        ],
                        'toggle' => false,
                    ],
                    'color'      => [
                        'label' => __('Background Color', 'affiliatex'),
                        'default' => '#fff',
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
         * Typography
         **************************************************************/
        $this->start_controls_section(
            'affx_specifications_typography',
            [
                'label' => __('Typography', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'specificationTitleTypography',
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
                'name'           => 'specificationLabelTypography',
                'label'          => __('Label Typography', 'affiliatex'),
                'selector'       => $this->select_element('label'),
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'specificationValueTypography',
                'label'          => __('Value Typography', 'affiliatex'),
                'selector'       => $this->select_element('value'),
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
         * Spacing
         **************************************************************/
        $this->start_controls_section(
            'affx_specifications_spacing',
            [
                'label' => __('Spacing', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'specificationMargin',
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
            'specificationPadding',
            [
                'label'      => __('Padding', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'pt'],
                'selectors'  => [
                    WidgetHelper::select_multiple_elements([
                        $this->select_element('table-cell'),
                        $this->select_element('table-heading')
                    ]) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'      => '16',
                    'right'    => '24',
                    'bottom'   => '16',
                    'left'     => '24',
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
                            'name' => 'specificationTitle',
                            'type' => 'text',
                            'defaults' => [
                                'specificationTitle' => __('Specifications', 'affiliatex'),
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'blockField' => [
                            'name' => 'specificationLabel',
                            'type' => 'text',
                            'repeaterName' => 'specificationTable',
                            'defaults' => [
                                'specificationLabel' => __('Specification Label', 'affiliatex'),
                            ],
                        ],
                        'type' => 'text',
                    ],
                    [
                        'blockField' => [
                            'name' => 'specificationValue',
                            'type' => 'text',
                            'repeaterName' => 'specificationTable',
                            'defaults' => [
                                'specificationValue' => __('Specification Value', 'affiliatex'),
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
