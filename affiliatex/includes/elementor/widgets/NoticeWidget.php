<?php
namespace AffiliateX\Elementor\Widgets;

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use AffiliateX\Traits\NoticeRenderTrait;
use AffiliateX\Elementor\ControlsManager;
use AffiliateX\Blocks\AffiliateX_Customization_Helper;

/**
 * Notice Widget Class
 *
 * @package AffiliateX\Elementor\Widgets
 */
class NoticeWidget extends ElementorBase {

	use NoticeRenderTrait;

	public function get_slug(): string {
		return 'notice';
	}

	public function get_title() {
		return __( 'AffiliateX Notice', 'affiliatex' );
	}

	public function get_icon() {
		return 'affx-icon-notice';
	}

	public function get_keywords() {
		return array(
			'Notice',
			'Message',
			'AffiliateX',
		);
	}

	protected function register_controls() {
		//
		// CONTENT TAB
		//
		/**************************************************************
		 * Layout Settings
		 */
		$this->start_controls_section(
			'affx_notice_layout_setting_section',
			array(
				'label' => __( 'Layout Settings', 'affiliatex' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'layoutStyle',
			array(
				'label'   => __( 'Choose Layout', 'affiliatex' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'layout-type-1',
				'options' => array(
					'layout-type-1' => __( 'Layout One', 'affiliatex' ),
					'layout-type-2' => __( 'Layout Two', 'affiliatex' ),
				),
			)
		);
		$this->end_controls_section();

		/**************************************************************
		 * Title Settings
		 */
		$this->start_controls_section(
			'affx_notice_title_settings',
			array(
				'label' => __( 'Title Settings', 'affiliatex' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'noticeTitle',
			array(
				'label'   => __( 'Notice Title', 'affiliatex' ),
				'type'    => ControlsManager::TEXT,
				'default' => __( 'Notice', 'affiliatex' ),
			)
		);

		$this->add_control(
			'titleTag1',
			array(
				'label'   => __( 'Title Tag', 'affiliatex' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => array(
					'h2' => __( 'Heading 2 (h2)', 'affiliatex' ),
					'h3' => __( 'Heading 3 (h3)', 'affiliatex' ),
					'h4' => __( 'Heading 4 (h4)', 'affiliatex' ),
					'h5' => __( 'Heading 5 (h5)', 'affiliatex' ),
					'h6' => __( 'Heading 6 (h6)', 'affiliatex' ),
					'p'  => __( 'Paragraph (p)', 'affiliatex' ),
				),
			)
		);

		$this->add_control(
			'titleAlignment',
			array(
				'label'     => __( 'Title Alignment', 'affiliatex' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'affiliatex' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'affiliatex' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'affiliatex' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'toggle'    => false,
				'selectors' => array(
					$this->select_element( 'title' ) => 'text-align: {{VALUE}};',
				),
				'condition' => array(
					'layoutStyle' => array( 'layout-type-1', 'layout-type-2' ),
				),
			)
		);

		$this->add_control(
			'edTitleIcon',
			array(
				'label'        => __( 'Show Title Icon', 'affiliatex' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'affiliatex' ),
				'label_off'    => __( 'Off', 'affiliatex' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'noticeTitleIcon',
			array(
				'label'     => __( 'Title Icon', 'affiliatex' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fa fa-info-circle',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'edTitleIcon' => 'true',
				),
			)
		);

		$this->add_control(
			'noticeIconSize',
			array(
				'label'      => __( 'Title Icon Size', 'affiliatex' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 17,
				),
				'condition'  => array(
					'edTitleIcon' => 'true',
				),
				'selectors'  => array(
					$this->select_element( 'title' ) . ' > i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/**************************************************************
		 * Content Settings
		 */
		$this->start_controls_section(
			'affx_notice_content_settings',
			array(
				'label' => __( 'Content Settings', 'affiliatex' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'noticeContentType',
			array(
				'label'   => __( 'Content Type', 'affiliatex' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'paragraph' => array(
						'title' => esc_html__( 'Paragraph', 'affiliatex' ),
						'icon'  => 'eicon-editor-paragraph',
					),
					'list'      => array(
						'title' => esc_html__( 'List', 'affiliatex' ),
						'icon'  => 'eicon-bullet-list',
					),
					'amazon'    => array(
						'title' => esc_html__( 'Amazon', 'affiliatex' ),
						'icon'  => 'fa-brands fa-amazon',
					),
				),
				'default' => 'list',
				'toggle'  => false,
			)
		);

		$this->add_control(
			'noticeContent',
			array(
				'label'       => __( 'Content', 'affiliatex' ),
				'type'        => ControlsManager::TEXTAREA,
				'rows'        => 4,
				'default'     => __( 'This is the notice content', 'affiliatex' ),
				'placeholder' => __( 'Notice Content', 'affiliatex' ),
				'condition'   => array(
					'noticeContentType' => 'paragraph',
				),
			)
		);

		$this->add_control(
			'noticeListItems',
			array(
				'label'       => __( 'Content List', 'affiliatex' ),
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ content }}}',
				'fields'      => array(
					array(
						'name'    => 'content',
						'label'   => __( 'List Item', 'affiliatex' ),
						'type'    => ControlsManager::TEXT,
						'default' => 'Enter new item',
					),
				),
				'default'     => array(
					array(
						'content' => 'Enter new item',
					),
				),
				'condition'   => array(
					'noticeContentType' => 'list',
				),
			)
		);

		$this->add_control(
			'noticeListItemsAmazon',
			array(
				'label'     => __( 'Amazon Content List', 'affiliatex' ),
				'type'      => ControlsManager::TEXT,
				'default'   => '',
				'condition' => array(
					'noticeContentType' => 'amazon',
				),
			)
		);

		$this->add_responsive_control(
			'alignment',
			array(
				'label'     => __( 'Content Alignment', 'affiliatex' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'affiliatex' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'affiliatex' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'affiliatex' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'toggle'    => false,
				'selectors' => array(
					$this->select_element( 'content' ) => 'text-align: {{VALUE}}',
					$this->select_element( 'list' )    => 'justify-content: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'noticeListType',
			array(
				'label'     => __( 'List Type', 'affiliatex' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'unordered' => array(
						'title' => esc_html__( 'Unordered', 'affiliatex' ),
						'icon'  => 'eicon-editor-list-ul',
					),
					'ordered'   => array(
						'title' => esc_html__( 'Ordered', 'affiliatex' ),
						'icon'  => 'eicon-editor-list-ol',
					),
				),
				'default'   => 'unordered',
				'toggle'    => false,
				'condition' => array(
					'noticeContentType' => array( 'list', 'amazon' ),
				),
			)
		);

		$this->add_control(
			'noticeunorderedType',
			array(
				'label'     => __( 'List Item Icon Type', 'affiliatex' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'icon'   => array(
						'title' => __( 'Show Icon', 'affiliatex' ),
						'icon'  => 'eicon-star',
					),
					'bullet' => array(
						'title' => __( 'Show Bullet', 'affiliatex' ),
						'icon'  => 'eicon-ellipsis-v',
					),
				),
				'default'   => 'icon',
				'toggle'    => true,
				'condition' => array(
					'noticeContentType' => array( 'list', 'amazon' ),
					'noticeListType'    => 'unordered',
				),
			)
		);

		$this->add_control(
			'noticeListIcon',
			array(
				'label'       => __( 'List Item Icon', 'affiliatex' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => 'fas fa-check-circle',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'noticeContentType'   => array( 'list', 'amazon' ),
					'noticeListType'      => 'unordered',
					'noticeunorderedType' => 'icon',
				),
			)
		);

		$this->add_control(
			'noticeListIconSize',
			array(
				'label'      => __( 'List Icon Size', 'affiliatex' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 17,
				),
				'condition'  => array(
					'noticeContentType'   => array( 'list', 'amazon' ),
					'noticeListType'      => 'unordered',
					'noticeunorderedType' => 'icon',
				),
				'selectors'  => array(
					$this->select_element( 'list' ) . ' i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		//
		// STYLE CONTENT
		//
		/**************************************************************
		 * Border Settings
		 */
		$this->start_controls_section(
			'affx_notice_border_settings',
			array(
				'label' => __( 'Border', 'affiliatex' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'noticeBorder',
				'label'          => __( 'Border', 'affiliatex' ),
				'responsive'     => true,
				'selector'       => $this->select_element( 'wrapper' ),
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'color'  => array(
						'default' => '#E6ECF7',
					),
					'width'  => array(
						'default' => array(
							'isLinked' => false,
							'unit'     => 'px',
							'top'      => '0',
							'right'    => '0',
							'bottom'   => '0',
							'left'     => '0',
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'noticeBorderRadius',
			array(
				'label'      => __( 'Border Radius', 'affiliatex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'rem', 'em' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					$this->select_element( 'wrapper' ) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'           => 'boxShadow',
				'selector'       => $this->select_element( 'wrapper' ),
				'label'          => __( 'Box Shadow', 'affiliatex' ),
				'fields_options' => array(
					'box_shadow_type' => array(
						'default' => 'yes',
					),
					'box_shadow'      => array(
						'default' => array(
							'vertical'   => '5',
							'horizontal' => '0',
							'blur'       => '20',
							'spread'     => '0',
							'color'      => 'rgba(210,213,218,0.2)',
							'inset'      => false,
						),
					),
				),
			)
		);

		$this->end_controls_section();

		/**************************************************************
		 * Colors
		 */
		$this->start_controls_section(
			'affx_notice_color_section',
			array(
				'label' => __( 'Colors', 'affiliatex' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'noticeTextColor',
			array(
				'label'     => __( 'Title Color', 'affiliatex' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					$this->select_element( 'layout-1-wrapper' ) . ' .affiliatex-notice-title' => 'color: {{VALUE}} !important;',
				),
				'condition' => array(
					'layoutStyle' => array( 'layout-type-1' ),
				),
			)
		);

		$this->add_control(
			'noticeTextColorAlt',
			array(
				'label'     => __( 'Title Color', 'affiliatex' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#084ACA',
				'selectors' => array(
					$this->select_element( 'layout-2-wrapper' ) . ' .affiliatex-notice-title' => 'color: {{VALUE}} !important;',
				),
				'condition' => array(
					'layoutStyle' => array( 'layout-type-2' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'noticeBgColor',
				'types'          => array( 'classic', 'gradient' ),
				'exclude'        => array( 'image' ),
				'selector'       => $this->select_element( 'title' ),
				'fields_options' => array(
					'background'     => array(
						'default' => 'classic',
						'options' => array(
							'classic'  => array(
								'title' => esc_html__( 'Color', 'affiliatex' ),
								'icon'  => 'eicon-paint-brush',
							),
							'gradient' => array(
								'title' => esc_html__( 'Gradient', 'affiliatex' ),
								'icon'  => 'eicon-barcode',
							),
						),
						'label'   => __( 'Title Background Type', 'affiliatex' ),
					),
					'color'          => array(
						'default' => '#24B644',
						'label'   => __( 'Title Background Color', 'affiliatex' ),
					),
					'color_b'        => array(
						'default' => '#7ADCB4',
					),
					'color_b_stop'   => array(
						'default' => array(
							'unit' => '%',
							'size' => 60,
						),
					),
					'gradient_angle' => array(
						'default' => array(
							'unit' => 'deg',
							'size' => '135',
						),
					),
				),
				'condition'      => array(
					'layoutStyle' => 'layout-type-1',
				),
			)
		);

		$this->add_control(
			'noticeListColor',
			array(
				'label'     => __( 'Content Color', 'affiliatex' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => AffiliateX_Customization_Helper::get_value( 'fontColor', '#292929' ),
				'selectors' => array(
					$this->select_element( 'content' ) => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'listBgColor',
				'types'          => array( 'classic', 'gradient' ),
				'exclude'        => array( 'image' ),
				'selector'       => $this->select_element( 'content' ),
				'fields_options' => array(
					'background'     => array(
						'default' => 'classic',
						'options' => array(
							'classic'  => array(
								'title' => esc_html__( 'Color', 'affiliatex' ),
								'icon'  => 'eicon-paint-brush',
							),
							'gradient' => array(
								'title' => esc_html__( 'Gradient', 'affiliatex' ),
								'icon'  => 'eicon-barcode',
							),
						),
						'label'   => __( 'Content Background Type', 'affiliatex' ),
					),
					'color'          => array(
						'default' => '#ffffff',
						'label'   => __( 'Content Background Color', 'affiliatex' ),
					),
					'color_b'        => array(
						'default' => '#A9B8C3',
					),
					'color_b_stop'   => array(
						'default' => array(
							'unit' => '%',
							'size' => 60,
						),
					),
					'gradient_angle' => array(
						'default' => array(
							'unit' => 'deg',
							'size' => '135',
						),
					),
				),
				'condition'      => array(
					'layoutStyle' => 'layout-type-1',
				),
			)
		);

		$this->add_control(
			'noticeIconColor',
			array(
				'label'     => __( 'List Icon Color', 'affiliatex' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#24B644',
				'condition' => array(
					'noticeContentType' => array( 'list', 'amazon' ),
				),
				'selectors' => array(
					$this->select_element( 'list' ) . ' i' => 'color: {{VALUE}}',
					$this->select_element( 'list' ) . '::marker' => 'color: {{VALUE}}',
					$this->select_element( 'list' ) . '::before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'noticeIconTwoColor',
			array(
				'label'     => __( 'Title Icon Color', 'affiliatex' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#084ACA',
				'selectors' => array(
					$this->select_element( 'layout-2-wrapper' ) . ' .affiliatex-notice-title > i' => 'color: {{VALUE}} !important;',
				),
				'condition' => array(
					'layoutStyle' => array( 'layout-type-2' ),
					'edTitleIcon' => 'true',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'noticeBgTwoColor',
				'types'          => array( 'classic', 'gradient' ),
				'exclude'        => array( 'image' ),
				'selector'       => $this->select_element( 'wrapper' ) . ':not(.layout-type-1)',
				'fields_options' => array(
					'background'     => array(
						'default' => 'classic',
						'options' => array(
							'classic'  => array(
								'title' => esc_html__( 'Color', 'affiliatex' ),
								'icon'  => 'eicon-paint-brush',
							),
							'gradient' => array(
								'title' => esc_html__( 'Gradient', 'affiliatex' ),
								'icon'  => 'eicon-barcode',
							),
						),
						'label'   => __( 'Background Color Type', 'affiliatex' ),
					),
					'color'          => array(
						'default' => '#F6F9FF',
						'label'   => __( 'Background Color', 'affiliatex' ),
					),
					'gradient'       => array(
						'default' => 'linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%)',
					),
					'color_b'        => array(
						'default' => '#00D082',
					),
					'color_b_stop'   => array(
						'default' => array(
							'unit' => '%',
							'size' => 30,
						),
					),
					'gradient_angle' => array(
						'default' => array(
							'unit' => 'deg',
							'size' => '135',
						),
					),
				),
				'condition'      => array(
					'layoutStyle' => array( 'layout-type-2' ),
				),
			)
		);

		$this->end_controls_section();

		/**************************************************************
		 * Typography Section
		 */
		$this->start_controls_section(
			'affx_notice_section_typography',
			array(
				'label' => __( 'Typography', 'affiliatex' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'titleTypography',
				'label'          => __( 'Title Typography', 'affiliatex' ),
				'selector'       => $this->select_element( 'title' ),
				'fields_options' => array(
					'typography'      => array(
						'default' => 'custom',
					),
					'font_family'     => array(
						'default' => AffiliateX_Customization_Helper::get_value( 'typography.family', '' ),
					),
					'font_weight'     => array(
						'default' => '400',
					),
					'font_size'       => array(
						'default' => array(
							'unit' => 'px',
							'size' => '18',
						),
					),
					'line_height'     => array(
						'default' => array(
							'unit' => 'custom',
							'size' => 1.5,
						),
					),
					'letter_spacing'  => array(
						'default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
					'text_transform'  => array(
						'default' => 'none',
					),
					'text_decoration' => array(
						'default' => 'none',
					),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'listTypography',
				'label'          => __( 'Content Typography', 'affiliatex' ),
				'selector'       => $this->select_element( 'paragraph-list' ),
				'fields_options' => array(
					'typography'      => array(
						'default' => 'custom',
					),
					'font_family'     => array(
						'default' => AffiliateX_Customization_Helper::get_value( 'typography.family', '' ),
					),
					'font_weight'     => array(
						'default' => '400',
					),
					'font_size'       => array(
						'default' => array(
							'unit' => 'px',
							'size' => '18',
						),
					),
					'line_height'     => array(
						'default' => array(
							'unit' => 'custom',
							'size' => 1.65,
						),
					),
					'letter_spacing'  => array(
						'default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
					'text_transform'  => array(
						'default' => 'none',
					),
					'text_decoration' => array(
						'default' => 'none',
					),
				),
			)
		);

		$this->end_controls_section();

		/**************************************************************
		 * Spacing Section
		 */
		$this->start_controls_section(
			'affx_notice_spacing_section',
			array(
				'label'     => __( 'Spacing', 'affiliatex' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'layoutStyle' => 'layout-type-1',
				),
			)
		);

		$this->add_responsive_control(
			'noticeMargin',
			array(
				'label'      => __( 'Margin', 'affiliatex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'pt' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '30',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					$this->select_element( 'wrapper' ) => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'layoutStyle' => 'layout-type-1',
				),
			)
		);

		$this->add_responsive_control(
			'titlePadding',
			array(
				'label'      => __( 'Title Padding', 'affiliatex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'pt' ),
				'default'    => array(
					'top'      => '10',
					'right'    => '15',
					'bottom'   => '10',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					$this->select_element( 'title' ) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'layoutStyle' => 'layout-type-1',
				),
			)
		);

		$this->add_control(
			'titleAndWrapperPaddingAlt',
			array(
				'type'      => Controls_Manager::HIDDEN,
				'default'   => 'DEFAULT_VALUE',
				'selectors' => array(
					$this->select_element( 'layout-2-wrapper' ) => 'padding: 20px',
					$this->select_element( 'layout-2-wrapper' ) . ' .affiliatex-notice-title' => 'padding-bottom: 10px',
				),
				'condition' => array(
					'layoutStyle' => array( 'layout-type-2' ),
				),
			)
		);

		$this->add_responsive_control(
			'contentPadding',
			array(
				'label'      => __( 'Content Padding', 'affiliatex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'pt' ),
				'default'    => array(
					'top'      => '10',
					'right'    => '15',
					'bottom'   => '10',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					$this->select_element( 'content' ) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'layoutStyle' => 'layout-type-1',
				),
			)
		);

		$this->add_control(
			'amazonAttributes',
			array(
				'type'    => Controls_Manager::HIDDEN,
				'default' => array(
					array(
						'field'      => 'title',
						'blockField' => array(
							'name'     => 'noticeTitle',
							'type'     => 'text',
							'defaults' => array(
								'noticeTitle' => __( 'Notice', 'affiliatex' ),
							),
						),
						'type'       => 'text',
					),
					array(
						'field'      => 'features',
						'blockField' => array(
							'name'        => 'noticeListItemsAmazon',
							'type'        => 'list',
							'disabled'    => true,
							'placeholder' => __( 'Click on the button to connect product', 'affiliatex' ),
							'defaults'    => array(
								'noticeContentType'     => 'list',
								'noticeListItemsAmazon' => '',
							),
							'conditions'  => array(
								'noticeContentType' => 'amazon',
							),
						),
						'type'       => 'list',
					),
				),
			)
		);

		$this->end_controls_section();
	}
}
