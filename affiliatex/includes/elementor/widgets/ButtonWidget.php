<?php
namespace AffiliateX\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AffiliateX\Traits\ButtonRenderTrait;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('\Elementor\Widget_Base')) {
    return;
}

class ButtonWidget extends Widget_Base {
    use ButtonRenderTrait;

    public function get_script_depends() {
        return ['fontawesome-all'];
    }

    public function get_style_depends() {
        wp_register_style(
            'affiliatex-button-style',
            AFFILIATEX_PLUGIN_URL . 'build/blocks/buttons/style-index.css',
            ['affiliatex-blocks-style'],
            AFFILIATEX_VERSION
        );

        return [
            'affiliatex-blocks-style',
            'affiliatex-button-style',
            'fontawesome'
        ];
    }

    public function get_name() {
        return 'affiliatex-button';
    }

    public function get_title() {
        return __('AffiliateX Button', 'affiliatex');
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return ['affiliatex'];
    }

    protected function register_controls() {

        /**************************************************************
         * 1) LAYOUT SETTINGS
         **************************************************************/
        $this->start_controls_section(
            'affx_layout_settings',
            [
                'label' => __('Layout Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Layout Style
        $this->add_control(
            'layoutStyle',
            [
                'label'   => __('Layout Style', 'affiliatex'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'layout-type-1', // "Default Button" in Gutenberg
                'options' => [
                    'layout-type-1' => __('Default Button', 'affiliatex'),
                    'layout-type-2' => __('Price Button', 'affiliatex'),
                ],
            ]
        );

        // Price Tag Position (shown only if layout-type-2)
        $this->add_control(
            'priceTagPosition',
            [
                'label'     => __('Price Tag Position', 'affiliatex'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'tagBtnright', // same default as Gutenberg
                'options'   => [
                    'tagBtnright' => __('Right', 'affiliatex'),
                    'tagBtnleft'  => __('Left', 'affiliatex'),
                ],
                'condition' => [
                    'layoutStyle' => 'layout-type-2', // only for Price Button
                ],
            ]
        );

        // Product Price
        $this->add_control(
            'productPrice',
            [
                'label'     => __('Product Price', 'affiliatex'),
                'type'      => Controls_Manager::TEXT,
                'default'   => '$145',
                'condition' => [
                    'layoutStyle' => 'layout-type-2', // only for Price Button
                ],
            ]
        );

        $this->end_controls_section(); // END Layout Settings

        /**************************************************************
         * 2) BUTTON SETTINGS
         **************************************************************/
        $this->start_controls_section(
            'affx_button_settings',
            [
                'label' => __('Button Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Button Label
        $this->add_control(
            'button_label',
            [
                'label'   => __('Button Label', 'affiliatex'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Button',
            ]
        );

        // Button URL
        $this->add_control(
            'button_url',
            [
                'label'       => __('Button URL', 'affiliatex'),
                'type'        => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'affiliatex'),
                'default'     => [
                    'url'             => '',
                    'is_external'     => false,
                    'nofollow'        => false,
                    'custom_attributes'=> '',
                ],
            ]
        );

        // Button Size
        $this->add_control(
            'buttonSize',
            [
                'label'   => __('Size', 'affiliatex'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => [
                    'small'  => __('Small', 'affiliatex'),
                    'medium' => __('Medium', 'affiliatex'),
                    'large'  => __('Large', 'affiliatex'),
                    'xlarge' => __('Extra Large', 'affiliatex'),
                ],
            ]
        );

        // Button Width
        $this->add_control(
            'buttonWidth',
            [
                'label'   => __('Width', 'affiliatex'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'flexible',
                'options' => [
                    'fixed'    => __('Fixed', 'affiliatex'),
                    'flexible' => __('Flexible', 'affiliatex'),
                    'full'     => __('Full Width', 'affiliatex'),
                ],
            ]
        );

        $this->add_responsive_control(
            'button_fixed_width',
            [
                'label'      => __('Fixed Width', 'affiliatex'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 50,
                        'max'  => 500,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'condition'  => [
                    'buttonWidth!' => ['flexible', 'full'],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .affiliatex-button' => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        // Button Alignment
        $this->add_control(
            'buttonAlignment',
            [
                'label'   => __('Alignment', 'affiliatex'),
                'type'    => Controls_Manager::CHOOSE,
                'toggle'  => true,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'affiliatex'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'affiliatex'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'affiliatex'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .affx-btn-inner' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section(); // END Button Settings

        /**************************************************************
         * 3) ICON SETTINGS
         **************************************************************/
        $this->start_controls_section(
            'affx_icon_settings',
            [
                'label' => __('Icon Settings', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Enable Icon
        $this->add_control(
            'edButtonIcon',
            [
                'label'   => __('Enable Icon', 'affiliatex'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on'=> __('Yes', 'affiliatex'),
                'label_off'=>__('No', 'affiliatex'),
            ]
        );

        // Icon Picker
        $this->add_control(
            'ButtonIcon',
            [
                'label' => __('Icon', 'affiliatex'),
                'type'  => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'far fa-thumbs-up',
                    'library' => 'regular',
                ],
                'condition' => [
                    'edButtonIcon' => 'yes',
                ],
            ]
        );

        // Icon Position
        $this->add_control(
            'iconPosition',
            [
                'label'   => __('Icon Position', 'affiliatex'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'axBtnleft',
                'options' => [
                    'axBtnleft'  => __('Left', 'affiliatex'),
                    'axBtnright' => __('Right', 'affiliatex'),
                ],
                'condition' => [
                    'edButtonIcon' => 'yes',
                ],
            ]
        );

        // Icon Size
        $this->add_control(
            'iconSize',
            [
                'label'   => __('Icon Size', 'affiliatex'),
                'type'    => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'   => [
                    'px' => [
                        'min'  => 8,
                        'max'  => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'condition' => [
                    'edButtonIcon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .affiliatex-button .button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); // END Icon Settings

        /**************************************************************
         * DESIGN (STYLE) TAB
         **************************************************************/
        $this->start_controls_section(
            'affx_button_design',
            [
                'label' => __('Design', 'affiliatex'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Text Color
        $this->add_control(
            'button_text_color',
            [
                'label'   => __('Text Color', 'affiliatex'),
                'type'    => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .affiliatex-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background Color
        $this->add_control(
            'button_background_color',
            [
                'label'   => __('Background Color', 'affiliatex'),
                'type'    => Controls_Manager::COLOR,
                'default' => '#2670FF',
                'selectors' => [
                    '{{WRAPPER}} .affiliatex-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Hover Text Color
        $this->add_control(
            'button_hover_text_color',
            [
                'label'   => __('Hover Text Color', 'affiliatex'),
                'type'    => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .affiliatex-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Hover Background Color
        $this->add_control(
            'button_hover_background_color',
            [
                'label'   => __('Hover Background Color', 'affiliatex'),
                'type'    => Controls_Manager::COLOR,
                'default' => '#084ACA',
                'selectors' => [
                    '{{WRAPPER}} .affiliatex-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'label'     => __('Typography', 'affiliatex'),
                'selector'  => '{{WRAPPER}} .affiliatex-button',
            ]
        );

        // Price Tag Colors Section
        $this->add_control(
            'price_tag_colors_section',
            [
                'label' => __('Price Tag Colors', 'affiliatex'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'layoutStyle' => 'layout-type-2',
                ],
            ]
        );

        // Price Tag Text Color
        $this->add_control(
            'priceTagTextColor',
            [
                'label'     => __('Text Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'condition' => [
                    'layoutStyle' => 'layout-type-2',
                ],
                'selectors' => [
                    '{{WRAPPER}} .affx-btn-inner a .price-tag' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        // Price Tag Background Color
        $this->add_control(
            'priceTagBgColor',
            [
                'label'     => __('Background Color', 'affiliatex'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#333333',
                'condition' => [
                    'layoutStyle' => 'layout-type-2',
                ],
                'selectors' => [
                    '{{WRAPPER}} .affx-btn-inner a .price-tag' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .affx-btn-inner a .price-tag:before' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        // Padding
        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => __('Padding', 'affiliatex'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .affiliatex-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); // END DESIGN (STYLE)
    }

    /**
     * Convert Elementor settings -> Gutenberg-like attributes
     * Then call existing ButtonBlock's render method
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        // Set default values for required attributes
        $defaults = [
            'buttonLabel'       => 'Button',
            'buttonSize'        => 'medium',
            'buttonWidth'       => 'flexible',
            'buttonAlignment'   => 'flex-start',
            'layoutStyle'       => 'layout-type-1',
            'priceTagPosition'  => 'tagBtnright',
            'productPrice'      => '$145',
            'edButtonIcon'      => false,
            'iconPosition'      => 'axBtnleft',
        ];

        // Merge defaults with actual settings
        $settings = wp_parse_args($settings, $defaults);

        // Build all link attributes using Elementor's helper
        $this->add_link_attributes('button', $settings['button_url']);

        // Add classes using the shared method
        $this->add_render_attribute('button', 'class', $this->get_button_classes($settings));

        // Convert Elementor icon to our format
        $icon_data = [
            'name' => 'thumb-up-simple',
            'value' => ''
        ];

        if (!empty($settings['ButtonIcon']) && !empty($settings['ButtonIcon']['value'])) {
            $icon_data = [
                'name' => str_replace(['fas ', 'far ', 'fab ', 'fa-'], '', $settings['ButtonIcon']['value']),
                'value' => $settings['ButtonIcon']['value']
            ];
        }

        $attributes = [
            'buttonLabel'       => $settings['button_label'],
            'buttonSize'        => $settings['buttonSize'],
            'buttonWidth'       => $settings['buttonWidth'],
            'buttonFixedWidth'  => isset($settings['button_fixed_width']) ? (int) $settings['button_fixed_width'] : 0,
            'buttonAlignment'   => $settings['buttonAlignment'],
            'layoutStyle'       => $settings['layoutStyle'],
            'priceTagPosition'  => $settings['priceTagPosition'],
            'productPrice'      => $settings['productPrice'],
            'edButtonIcon'      => ($settings['edButtonIcon'] === 'yes'),
            'ButtonIcon'        => $icon_data,
            'iconPosition'      => $settings['iconPosition'],
            'elementorLinkAttributes' => $this->get_render_attribute_string('button'),
            'block_id'          => 'elementor-' . $this->get_id(),
        ];

        echo $this->render_button($attributes);
    }
}
