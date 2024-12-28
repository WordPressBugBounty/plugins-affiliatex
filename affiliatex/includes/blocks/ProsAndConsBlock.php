<?php

namespace AffiliateX\Blocks;

defined( 'ABSPATH' ) || exit;

use AffiliateX\Helpers\AffiliateX_Helpers;

/**
 * AffiliateX Pros and Cons Block
 *
 * @package AffiliateX
 */
class ProsAndConsBlock extends BaseBlock
{
	protected function get_slug(): string
	{
		return 'pros-and-cons';
	}

	protected function get_fields(): array
	{
		return [
			'block_id' => '',
			'prosTitle' => 'Pros',
			'consTitle' => 'Cons',
			'prosIcon' => [
				'name' => 'check-circle',
				'value' => 'far fa-circle'
			],
			'consIcon' => [
				'name' => 'times-circle',
				'value' => 'far fa-circle'
			],
			'titleTag1' => 'p',
			'layoutStyle' => 'layout-type-1',
			'prosListItems' => [],
			'consListItems' => [],
			'prosContent' => '',
			'consContent' => '',
			'prosContentType' => 'list',
			'consContentType' => 'list',
			'prosListType' => 'unordered',
			'consListType' => 'unordered',
			'prosListIcon' => [
				'name' => 'thumb-up-simple',
				'value' => 'far fa-thumbs-up'
			],
			'consListIcon' => [
				'name' => 'thumb-down-simple',
				'value' => 'far fa-thumbs-down'
			],
			'prosunorderedType' => 'icon',
			'consunorderedType' => 'icon',
			'prosIconStatus' => true,
			'consIconStatus' => true
		];
	}

	public function render($attributes, $content) : string
	{
		$attributes = $this->parse_attributes($attributes);
		extract($attributes);
		
		$wrapper_attributes = get_block_wrapper_attributes(array(
			'id' => "affiliatex-pros-cons-style-$block_id",
			'class' => 'affx-pros-cons-wrapper',
		));

		if ( is_array( $prosListItems ) && count( $prosListItems ) > 0 && isset( $prosListItems[0]['list'] ) && is_string( $prosListItems[0]['list'] ) && has_shortcode( $prosListItems[0]['list'], 'affiliatex-product' ) ) {
			$prosListItems = json_decode( do_shortcode( $prosListItems[0]['list'] ), true );
		}

		if ( is_array( $consListItems ) && count( $consListItems ) > 0 && isset( $consListItems[0]['list'] ) && is_string( $consListItems[0]['list'] ) && has_shortcode( $consListItems[0]['list'], 'affiliatex-product' ) ) {
			$consListItems = json_decode( do_shortcode( $consListItems[0]['list'] ), true );
		}

		$titleTag1 = AffiliateX_Helpers::validate_tag($titleTag1, 'p');
		
		ob_start();
		include $this->get_template_path();
		return ob_get_clean();
	}
}
