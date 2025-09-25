<?php

namespace AffiliateX\Traits;

use AffiliateX\Elementor\ControlsManager;
use AffiliateX\Helpers\Elementor\WidgetHelper;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * This trait is a channel for share rendering methods between Gutenberg and Elementor
 *
 * @package AffiliateX
 */
trait ButtonRenderTrait
{
    /**
     * Get the button Elementor fields
     *
     * @return array
     */
    protected function get_button_elementor_fields(): array
    {
        $defaults = $this->get_button_fields();

        $fields = [
            'layout_settings' => [
                'label'  => __('Layout Settings', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_CONTENT,
                'fields' => [
                    'layoutStyle'      => [
                        'label'   => __('Layout Style', 'affiliatex'),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'layout-type-1', // "Default Button" in Gutenberg
                        'options' => [
                            'layout-type-1' => __('Default Button', 'affiliatex'),
                            'layout-type-2' => __('Price Button', 'affiliatex')
                        ]
                    ],
                    'priceTagPosition' => [
                        'label'     => __('Price Tag Position', 'affiliatex'),
                        'type'      => Controls_Manager::SELECT,
                        'default'   => 'tagBtnright', // same default as Gutenberg
                        'options'   => [
                            'tagBtnright' => __('Right', 'affiliatex'),
                            'tagBtnleft'  => __('Left', 'affiliatex')
                        ],
                        'condition' => [
                            'layoutStyle' => 'layout-type-2' // only for Price Button
                        ]
                    ],
                    'productPrice'     => [
                        'label'     => __('Product Price', 'affiliatex'),
                        'type'      => ControlsManager::TEXT,
                        'amazon_button' => true,
                        'default'   => '$145',
                        'condition' => [
                            'layoutStyle' => 'layout-type-2' // only for Price Button
                        ]
                    ]
                ]
            ],
            'button_settings' => [
                'label'  => __('General Settings', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_CONTENT,
                'fields' => [
                    'button_label'       => [
                        'label'   => __('Button Label', 'affiliatex'),
                        'type'    => Controls_Manager::TEXT,
                        'default' => 'Button'
                    ],
                    'buttonURL'         => [
                        'label'       => __('Button URL', 'affiliatex'),
                        'label_block' => true,
                        'type'        => ControlsManager::TEXT,
                        'placeholder' => __('Paste URL or type to search', 'affiliatex'),
                        'input_type' => 'url',
                        'amazon_button' => true,
                    ],
                    'btnRelNoFollow'=> [
                        'label' => esc_html__('Add Rel="Nofollow"?', 'affiliatex'),
                        'type' => Controls_Manager::SWITCHER,
                        'return_value' => 'true',
                        'default' => 'false',
                    ],
                    'btnRelSponsored'=> [
                        'label' => esc_html__('Add Rel="Sponsored"?', 'affiliatex'),
                        'type' => Controls_Manager::SWITCHER,
                        'return_value' => 'true',
                        'default' => 'false',
                    ],
                    'btnDownload'=> [
                        'label' => esc_html__('Add Download Attribute', 'affiliatex'),
                        'type' => Controls_Manager::SWITCHER,
                        'return_value' => 'true',
                        'default' => 'false',
                    ],
                    'openInNewTab'=> [
                        'label' => esc_html__('Open Link In New Window', 'affiliatex'),
                        'type' => Controls_Manager::SWITCHER,
                        'return_value' => 'true',
                        'default' => 'false',
                    ],
                    'buttonSize'         => [
                        'label'   => __('Size', 'affiliatex'),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'medium',
                        'options' => [
                            'small'  => __('Small', 'affiliatex'),
                            'medium' => __('Medium', 'affiliatex'),
                            'large'  => __('Large', 'affiliatex'),
                            'xlarge' => __('Extra Large', 'affiliatex')
                        ]
                    ],
                    'buttonWidth'        => [
                        'label'   => __('Width', 'affiliatex'),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'flexible',
                        'options' => [
                            'fixed'    => __('Fixed', 'affiliatex'),
                            'flexible' => __('Flexible', 'affiliatex'),
                            'full'     => __('Full Width', 'affiliatex')
                        ]
                    ],
                    'button_fixed_width' => [
                        'label'      => __('Fixed Width', 'affiliatex'),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px'],
                        'range'      => [
                            'px' => [
                                'min'  => 50,
                                'max'  => 500,
                                'step' => 1
                            ]
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 200
                        ],
                        'condition'  => [
                            'buttonWidth!' => ['flexible', 'full']
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .affiliatex-button' => 'width: {{SIZE}}{{UNIT}} !important;'
                        ]
                    ],
                    'buttonAlignment'    => [
                        'label'     => __('Alignment', 'affiliatex'),
                        'type'      => Controls_Manager::CHOOSE,
                        'toggle'    => true,
                        'options'   => [
                            'flex-start' => [
                                'title' => __('Left', 'affiliatex'),
                                'icon'  => 'eicon-text-align-left'
                            ],
                            'center'     => [
                                'title' => __('Center', 'affiliatex'),
                                'icon'  => 'eicon-text-align-center'
                            ],
                            'flex-end'   => [
                                'title' => __('Right', 'affiliatex'),
                                'icon'  => 'eicon-text-align-right'
                            ]
                        ],
                        'default'   => 'flex-start',
                        'selectors' => [
                            '{{WRAPPER}} .affx-btn-inner' => 'justify-content: {{VALUE}};'
                        ]
                    ],
                ]
            ],
            'icon_settings'   => [
                'label'  => __('Icon Settings', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_CONTENT,
                'fields' => [
                    'edButtonIcon' => [
                        'label'     => __('Enable Icon', 'affiliatex'),
                        'type'      => Controls_Manager::SWITCHER,
                        'default'   => '',
                        'label_on'  => __('Yes', 'affiliatex'),
                        'label_off' => __('No', 'affiliatex')
                    ],
                    'ButtonIcon'   => [
                        'label'     => __('Icon', 'affiliatex'),
                        'type'      => Controls_Manager::ICONS,
                        'default'   => [
                            'value'   => 'far fa-thumbs-up',
                            'library' => 'regular'
                        ],
                        'condition' => [
                            'edButtonIcon' => 'yes'
                        ]
                    ],
                    'iconPosition' => [
                        'label'     => __('Icon Position', 'affiliatex'),
                        'type'      => Controls_Manager::SELECT,
                        'default'   => 'axBtnleft',
                        'options'   => [
                            'axBtnleft'  => __('Left', 'affiliatex'),
                            'axBtnright' => __('Right', 'affiliatex')
                        ],
                        'condition' => [
                            'edButtonIcon' => 'yes'
                        ]
                    ],
                    'iconSize'     => [
                        'label'      => __('Icon Size', 'affiliatex'),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px'],
                        'range'      => [
                            'px' => [
                                'min'  => 8,
                                'max'  => 50,
                                'step' => 1
                            ]
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 20
                        ],
                        'condition'  => [
                            'edButtonIcon' => 'yes'
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .affiliatex-button .button-icon' => 'font-size: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                ]
            ],

            'border_settings_section' => [
                'label'  => __('Border', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_STYLE,
                'fields' => [
                    'buttonBorder' => [
                        'label' => __('Button Border', 'affiliatex'),
                        'type' => Group_Control_Border::get_type(),
                        'responsive' => true,
                        'selector' => '{{WRAPPER}} .affx-btn-inner a'
                    ],
                    'buttonShadow' => [
                        'label' => __('Box Shadow', 'affiliatex'),
                        'type' => Group_Control_Box_Shadow::get_type(),
                        'selector' => '{{WRAPPER}} .affx-btn-inner a'
                    ],
                ],
            ],

            'color_settings_section' => [
                'label'  => __('Colors', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_STYLE,
                'fields' => [
                    'button_text_color'             => [
                        'label'     => __('Text Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .affiliatex-button' => 'color: {{VALUE}};'
                        ]
                    ],
                    'button_hover_text_color'       => [
                        'label'     => __('Text Hover Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .affiliatex-button:hover' => 'color: {{VALUE}};'
                        ]
                    ],
                    'button_background' => [
                        'label'          => __('Background', 'affiliatex'),
                        'type'           => Group_Control_Background::get_type(),
                        'types'          => ['classic', 'gradient'],
                        'exclude'        => ['image'],
                        'selector'       => '{{WRAPPER}} .affiliatex-button',
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
                                'default' => '#2670FF',
                            ],
                            'color_b' => [
                                'default' => '#A9B8C3',
                            ],
                            'color_b_stop' => [
                                'default' => [
                                    'unit' => '%',
                                    'size' => 100,
                                ]
                            ],
                            'gradient_angle' => [
                                'default' => [
                                    'unit' => 'deg',
                                    'size' => '135'
                                ]
                            ],
                        ],
                    ],
                    'button_hover_background' => [
                        'label'          => __('Background', 'affiliatex'),
                        'type'           => Group_Control_Background::get_type(),
                        'types'          => ['classic', 'gradient'],
                        'exclude'        => ['image'],
                        'selector'       => '{{WRAPPER}} .affiliatex-button:hover',
                        'fields_options' => [
                            'background' => [
                                'label'   => __('Background Hover Type', 'affiliatex'),
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
                                'label' => __('Background Hover Color', 'affiliatex'),
                                'default' => '#084ACA',
                            ],
                            'color_b' => [
                                'default' => '#A9B8C3',
                            ],
                            'color_b_stop' => [
                                'default' => [
                                    'unit' => '%',
                                    'size' => 100,
                                ]
                            ],
                            'gradient_angle' => [
                                'default' => [
                                    'unit' => 'deg',
                                    'size' => '135'
                                ]
                            ],
                        ],
                    ],
                    'price_tag_colors_section'      => [
                        'label'     => __('Price Tag Colors', 'affiliatex'),
                        'type'      => Controls_Manager::HEADING,
                        'separator' => 'before',
                        'condition' => [
                            'layoutStyle' => 'layout-type-2'
                        ]
                    ],
                    'priceTagTextColor'             => [
                        'label'     => __('Text Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#2670FF',
                        'condition' => [
                            'layoutStyle' => 'layout-type-2'
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .affx-btn-inner a .price-tag' => 'color: {{VALUE}} !important;'
                        ]
                    ],
                    'priceTagBgColor'               => [
                        'label'     => __('Background Color', 'affiliatex'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#FFFFFF',
                        'condition' => [
                            'layoutStyle' => 'layout-type-2'
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .affx-btn-inner a .price-tag'        => 'background-color: {{VALUE}} !important;',
                            '{{WRAPPER}} .affx-btn-inner a .price-tag:before' => 'background-color: {{VALUE}} !important;'
                        ]
                    ],
                ],
            ],

            'typography_settings_section'   => [
                'label'  => __('Typography', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_STYLE,
                'fields' => [
                    'button_typography'             => [
                        'label'    => __('Typography', 'affiliatex'),
                        'selector' => '{{WRAPPER}} .affiliatex-button',
                        'type'     => Group_Control_Typography::get_type(),
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
                                    'size' => 1.65,
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
                        ]
                    ],
                ],
            ],

            'spacing_settings_section'   => [
                'label'  => __('Spacing', 'affiliatex'),
                'tab'    => Controls_Manager::TAB_STYLE,
                'fields' => [
                    'buttonPadding'                => [
                        'label'      => __('Padding', 'affiliatex'),
                        'type'       => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', 'em', '%'],
                        'selectors'  => [
                            '{{WRAPPER}} .affiliatex-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ],
                    ],
                    'buttonMargin'                  => [
                        'label'      => __('Margin', 'affiliatex'),
                        'type'       => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', 'em', '%'],
                        'selectors'  => [
                            '{{WRAPPER}} .affiliatex-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ],
                        'default'    => [
                            'unit'     => 'px',
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '30',
                            'left'     => '0',
                            'isLinked' => false
                        ],
                    ],
                    'amazonAttributes' => [
                        'type' => Controls_Manager::HIDDEN,
                        'default' => [
                            [
                                'field' => 'display_price',
                                'blockField' => [
                                    'name' => 'productPrice',
                                    'type' => 'text',
                                    'format' => 'price',
                                    'typeSelector' => 'layoutStyle',
                                    'defaults' => [
                                        'productPrice' => $defaults['productPrice'],
                                    ],
                                    'conditions' => [
                                        'layoutStyle' => 'layout-type-2',
                                    ],
                                ],
                                'type' => 'text',
                            ],
                            [
                                'field' => 'url',
                                'blockField' => [
                                    'name' => 'buttonURL',
                                    'type' => 'link',
                                    'defaults' => [
                                        'buttonURL' => $defaults['buttonURL'],
                                    ],
                                ],
                                'type' => 'link',
                            ],
                        ],
                    ],
                ]
            ]
        ];

        return $fields;
    }

    /**
     * Generate button class names based on attributes
     */
    protected function get_button_classes($attributes)
    {
        $classNames = [
            'affiliatex-button',
            'btn-align-' . ($attributes['buttonAlignment'] ?? 'flex-start'),
            'btn-is-' . ($attributes['buttonSize'] ?? 'medium'),
            $attributes['buttonWidth'] === 'fixed' ? 'btn-is-fixed' : '',
            $attributes['buttonWidth'] === 'full' ? 'btn-is-fullw' : '',
            $attributes['buttonWidth'] === 'flexible' ? 'btn-is-flex-' . $attributes['buttonSize'] : '',
            $attributes['layoutStyle'] === 'layout-type-2' && $attributes['priceTagPosition'] === 'tagBtnleft' ? 'left-price-tag' : '',
            $attributes['layoutStyle'] === 'layout-type-2' && $attributes['priceTagPosition'] === 'tagBtnright' ? 'right-price-tag' : '',
            $attributes['edButtonIcon'] && $attributes['iconPosition'] === 'axBtnright' ? 'icon-right' : 'icon-left'
        ];

        return array_filter($classNames);
    }

    /**
     * Prepare attributes for template
     */
    protected function prepare_template_attributes($attributes)
    {
        // Create wrapper attributes differently based on context
        if (isset($attributes['elementorLinkAttributes'])) {
            // Elementor context
            $wrapper_attributes = sprintf(
                'class="affx-btn-wrapper" id="affiliatex-blocks-style-%s"',
                esc_attr($attributes['block_id'])
            );
        } else {
            // Gutenberg context
            $wrapper_attributes = get_block_wrapper_attributes([
                'class' => 'affx-btn-wrapper',
                'id'    => "affiliatex-blocks-style-{$attributes['block_id']}"
            ]);

            $attributes['classNames'] = implode(' ', $this->get_button_classes($attributes));
            
            // Prepare Gutenberg-specific attributes.
            $rel = ['noopener'];
    
            if (! empty($attributes['btnRelNoFollow'])) {
                $rel[] = 'nofollow';
            }
    
            if (! empty($attributes['btnRelSponsored'])) {
                $rel[] = 'sponsored';
            }
    
            $attributes['rel'] = implode(' ', $rel);
    
            $attributes['target']     =  ! empty($attributes['openInNewTab']) ? ' target="_blank"' : '';
            $attributes['download']   =  ! empty($attributes['btnDownload']);
    
        }
        
        // Prepare icon HTML
        $attributes['iconLeft'] =  ! empty($attributes['edButtonIcon']) && $attributes['iconPosition'] === 'axBtnleft'
            ? '<i class="button-icon ' . esc_attr($attributes['ButtonIcon']['value']) . '"></i>'
            : '';

        $attributes['iconRight'] =  ! empty($attributes['edButtonIcon']) && $attributes['iconPosition'] === 'axBtnright'
            ? '<i class="button-icon ' . esc_attr($attributes['ButtonIcon']['value']) . '"></i>'
            : '';

        return array_merge(['wrapper_attributes' => $wrapper_attributes], $attributes);
    }

    protected function get_button_fields(): array
    {
        return [
            'buttonLabel'      => 'Button',
            'buttonSize'       => 'medium',
            'buttonWidth'      => 'flexible',
            'buttonURL'        => '',
            'iconPosition'     => 'left',
            'block_id'         => '',
            'ButtonIcon'       => [
                'name'  => 'thumb-up-simple',
                'value' => 'far fa-thumbs-up'
            ],
            'edButtonIcon'     => false,
            'btnRelSponsored'  => false,
            'openInNewTab'     => false,
            'btnRelNoFollow'   => false,
            'buttonAlignment'  => 'flex-start',
            'btnDownload'      => false,
            'layoutStyle'      => 'layout-type-1',
            'priceTagPosition' => 'tagBtnright',
            'productPrice'     => '$145'
        ];
    }

    /**
     * Render function for Elementor
     *
     * @param array $settings
     * @return void
     */
    public function render_button(array $settings): void
    {
        // Merge defaults with actual settings
        $settings = wp_parse_args($settings, $this->get_button_fields());
        $settings = WidgetHelper::process_attributes($settings);

        // Create unique button ID to prevent conflicts when multiple buttons are rendered
        $button_id = 'button-' . ($settings['name'] ?? '') . '-' . $this->get_id() . '-' . uniqid();
        
        // Build all link attributes using Elementor's helper
        if (isset($settings['button_url'])) {
            $this->add_link_attributes($button_id, $settings['button_url']);
        } else if (isset($settings['buttonURL']) && ! empty($settings['buttonURL'])) {
            $this->add_render_attribute($button_id, 'href', esc_url($settings['buttonURL']));
        }

        // Add classes using the shared method
        $this->add_render_attribute($button_id, 'class', $this->get_button_classes($settings));


        // Add rel attributes if enabled.
        $rel = [];

        if (isset($settings['btnRelNoFollow']) && $settings['btnRelNoFollow']) {
            $rel[] = 'nofollow';
        };

        if (isset($settings['btnRelSponsored']) && $settings['btnRelSponsored']) {
            $rel[] = 'sponsored';
        };

        $this->add_render_attribute($button_id, 'rel', implode(' ', $rel));

        // Add _target attribute if open in new tab enabled.
        if (isset($settings['openInNewTab']) && $settings['openInNewTab']) {
            $this->add_render_attribute($button_id, 'target', '_blank');
        };

        // Add download attribute if enabled.
        if (isset($settings['btnDownload']) && $settings['btnDownload']) {
            $this->add_render_attribute($button_id, 'download', '');
        };

        // Convert Elementor icon to our format
        $icon_data = [
            'name'  => 'thumb-up-simple',
            'value' => ''
        ];

        if (! empty($settings['ButtonIcon']) && ! empty($settings['ButtonIcon']['value'])) {
            $icon_data = [
                'name'  => str_replace(['fas ', 'far ', 'fab ', 'fa-'], '', $settings['ButtonIcon']['value']),
                'value' => $settings['ButtonIcon']['value']
            ];
        }

        $attributes = [
            'buttonLabel'             => $settings['button_label'] ?? $settings['buttonLabel'],
            'buttonSize'              => $settings['buttonSize'],
            'buttonWidth'             => $settings['buttonWidth'],
            'buttonFixedWidth'        => isset($settings['button_fixed_width']) ? (int) $settings['button_fixed_width'] : 0,
            'buttonAlignment'         => $settings['buttonAlignment'],
            'layoutStyle'             => $settings['layoutStyle'],
            'priceTagPosition'        => $settings['priceTagPosition'],
            'productPrice'            => $settings['productPrice'],
            'edButtonIcon'            => ($settings['edButtonIcon'] === 'yes'),
            'ButtonIcon'              => $icon_data,
            'iconPosition'            => $settings['iconPosition'],
            'elementorLinkAttributes' => $this->get_render_attribute_string($button_id),
            'block_id'                => 'elementor-' . $this->get_id(),
        ];

        echo $this->render_button_template($attributes);
    }

    /**
     * Main template rendering function, can be used by Gutenberg directly
     *
     * @param array $attributes
     * @param string $content
     * @return string
     */
    public function render_button_template(array $attributes, string $content = ''): string
    {
        $template_attributes = $this->prepare_template_attributes($attributes);
        extract($template_attributes);

        ob_start();
        include AFFILIATEX_PLUGIN_DIR . '/templates/blocks/buttons.php';

        return ob_get_clean();
    }
}
