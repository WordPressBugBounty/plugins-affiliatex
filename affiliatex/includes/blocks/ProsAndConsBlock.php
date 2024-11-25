<?php
/**
 * AffiliateX Button Block
 *
 * @package AffiliateX
 */

namespace AffiliateX\Blocks;

defined( 'ABSPATH' ) || exit;

use AffiliateX\Helpers\AffiliateX_Helpers;
/**
 * Admin class
 *
 * @package AffiliateX
 */
class ProsAndConsBlock {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->init();
	}

	public function init()
	{
		add_action('enqueue_block_editor_assets', [$this, 'enqueue_block']);
		add_action('init', [$this, 'register_block']);
	}

	public function enqueue_block()
	{
		wp_enqueue_script('affiliatex-blocks-pros-and-cons', plugin_dir_url( AFFILIATEX_PLUGIN_FILE ) . 'build/blocks/pros-and-cons/index.js', array('affiliatex'), AFFILIATEX_VERSION, true);
	}

	public function register_block()
	{
		register_block_type_from_metadata(AFFILIATEX_PLUGIN_DIR . '/build/blocks/pros-and-cons', [
			'render_callback' => [$this, 'render'],
		]);
	}

	public function render($attributes)
	{
		$attributes = AffiliateX_Customization_Helper::apply_customizations($attributes);
		$block_id = isset($attributes['block_id']) ? esc_attr($attributes['block_id']) : '';
		$prosTitle = isset($attributes['prosTitle']) ? wp_kses_post($attributes['prosTitle']) : '';
		$consTitle = isset($attributes['consTitle']) ? wp_kses_post($attributes['consTitle']) : '';
		$prosIcon = isset($attributes['prosIcon']) ? esc_attr($attributes['prosIcon']['name']) : '';
		$consIcon = isset($attributes['consIcon']) ? esc_attr($attributes['consIcon']['name']) : '';
		$titleTag1 = isset($attributes['titleTag1']) ? AffiliateX_Helpers::validate_tag($attributes['titleTag1'], 'p') : 'p';
		$layoutStyle = isset($attributes['layoutStyle']) ? esc_attr($attributes['layoutStyle']) : '';
		$prosListItems = isset($attributes['prosListItems']) ? $attributes['prosListItems'] : array();
		$consListItems = isset($attributes['consListItems']) ? $attributes['consListItems'] : array();
		$prosContent = isset($attributes['prosContent']) ? wp_kses_post($attributes['prosContent']) : '';
		$prosContentType = isset($attributes['prosContentType']) ? esc_attr($attributes['prosContentType']) : 'list';
		$consContentType = isset($attributes['consContentType']) ? esc_attr($attributes['consContentType']) : 'list';
		$prosListType = isset($attributes['prosListType']) ? esc_attr($attributes['prosListType']) : 'unordered';
		$consListType = isset($attributes['consListType']) ? esc_attr($attributes['consListType']) : 'unordered';
		$prosUnorderedType = isset($attributes['prosUnorderedType']) ? esc_attr($attributes['prosUnorderedType']) : 'icon';
		$consUnorderedType = isset($attributes['consUnorderedType']) ? esc_attr($attributes['consUnorderedType']) : 'icon';
		$consContent = isset($attributes['consContent']) ? wp_kses_post($attributes['consContent']) : '';
		$prosListIcon = isset($attributes['prosListIcon']) ? esc_attr($attributes['prosListIcon']['name']) : '';
		$consListIcon = isset($attributes['consListIcon']) ? esc_attr($attributes['consListIcon']['name']) : '';
		$prosIconStatus = isset($attributes['prosIconStatus']) ? esc_attr($attributes['prosIconStatus']) : false;
		$consIconStatus = isset($attributes['consIconStatus']) ? esc_attr($attributes['consIconStatus']) : false;

		if ( is_array( $prosListItems ) && count( $prosListItems ) > 0 && isset( $prosListItems[0]['list'] ) && is_string( $prosListItems[0]['list'] ) && has_shortcode( $prosListItems[0]['list'], 'affiliatex-product' ) ) {
			$prosListItems = json_decode( do_shortcode( $prosListItems[0]['list'] ), true );
		}

		if ( is_array( $consListItems ) && count( $consListItems ) > 0 && isset( $consListItems[0]['list'] ) && is_string( $consListItems[0]['list'] ) && has_shortcode( $consListItems[0]['list'], 'affiliatex-product' ) ) {
			$consListItems = json_decode( do_shortcode( $consListItems[0]['list'] ), true );
		}

		$wrapper_attributes = get_block_wrapper_attributes(array(
			'id' => "affiliatex-pros-cons-style-$block_id",
			'class' => 'affx-pros-cons-wrapper',
		));

		// Convert pros list items to HTML
		$prosListHtml = '';
		foreach ($prosListItems as $item) {
			$prosListHtml .= '<li>' . wp_kses_post(affx_extract_child_items($item)) . '</li>';
		}

		// Convert cons list items to HTML
		$consListHtml = '';
		foreach ($consListItems as $item) {
			$consListHtml .= '<li>' . wp_kses_post(affx_extract_child_items($item)) . '</li>';
		}

		$prosList = $prosContentType === 'list' ?
			sprintf('<%1$s class="affiliatex-list %2$s">%3$s</%1$s>',
				$prosListType == 'unordered' ? 'ul' : 'ol',
				$prosUnorderedType === 'icon' ? 'icon affiliatex-icon affiliatex-icon-' . $prosIcon : 'bullet',
				$prosListHtml
			) : sprintf('<p class="affiliatex-content">%s</p>', $prosContent);

		$consList = $consContentType === 'list' ?
			sprintf('<%1$s class="affiliatex-list %2$s">%3$s</%1$s>',
				$consListType == 'unordered' ? 'ul' : 'ol',
				$consUnorderedType === 'icon' ? 'icon affiliatex-icon affiliatex-icon-' . $consIcon : 'bullet',
				$consListHtml
			) : sprintf('<p class="affiliatex-content">%s</p>', $consContent);

		return sprintf(
			'<div %1$s>
				<div class="affx-pros-cons-inner-wrapper %2$s">
					<div class="affx-pros-inner">
						<div class="pros-icon-title-wrap">
							<div class="affiliatex-block-pros">
								<%3$s class="affiliatex-title affiliatex-icon %4$s">%5$s</%3$s>
							</div>
						</div>
						<div class="affiliatex-pros">
							%6$s
						</div>
					</div>
					<div class="affx-cons-inner">
						<div class="cons-icon-title-wrap">
							<div class="affiliatex-block-cons">
								<%3$s class="affiliatex-title affiliatex-icon %7$s">%8$s</%3$s>
							</div>
						</div>
						<div class="affiliatex-cons">
							%9$s
						</div>
					</div>
				</div>
			</div>',
			$wrapper_attributes,
			esc_attr($layoutStyle),
			wp_kses_post($titleTag1),
			$prosIconStatus ? 'affiliatex-icon-' . $prosListIcon : '',
			wp_kses_post($prosTitle),
			$prosList,
			$consIconStatus ? 'affiliatex-icon-' . $consListIcon : '',
			wp_kses_post($consTitle),
			$consList
		);
	}
}
