<?php

namespace AffiliateX\Blocks;

use AffiliateX\Helpers\AffiliateX_Helpers;
use AffiliateX_Block_Helper;

defined('ABSPATH') || exit;

/**
 * AffiliateX Button Block
 *
 * @package AffiliateX
 */
class ProductComparisonBlock extends BaseBlock
{
	protected function get_slug(): string
	{
		return 'product-comparison';
	}

	private function render_pc_stars($rating, $starColor, $starInactiveColor)
	{
		$full_star = '<span style="color:' . esc_attr($starColor) . ';width:25px;height:25px;display:inline-flex"><svg fill="currentColor" width="25" height="25" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg></span>';
		$empty_star = '<span style="color:' . esc_attr($starInactiveColor) . ';width:25px;height:25px;display:inline-flex"><svg fill="currentColor" width="25" height="25" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg></span>';

		$stars = '';
		for ($i = 0; $i < 5; $i++) {
			if ($i < $rating) {
				$stars .= $full_star;
			} else {
				$stars .= $empty_star;
			}
		}
		return '<span class="rating-stars">' . $stars . '</span>';
	}

	protected function get_fields(): array
	{
		return [
			'block_id' => '',
			'productComparisonTable' => [],
			'comparisonSpecs' => [],
			'pcRibbon' => true,
			'pcTitle' => true,
			'starColor' => '#FFB800',
			'starInactiveColor' => '#A3ACBF',
			'pcImage' => true,
			'pcRating' => true,
			'pcPrice' => true,
			'pcButton' => true,
			'pcButtonIcon' => true,
			'buttonIconAlign' => 'right',
			'buttonIcon' => [
				'name' => 'angle-right',
				'value' => 'fas fa-angle-right'
			],
			'pcTitleTag' => 'h2',
			'pcTitleAlign' => 'center',
		];
	}

	public function render(array $attributes, string $content) : string
	{
		$attributes = $this->parse_attributes($attributes);
		extract($attributes);

		// Get block wrapper attributes
		$wrapper_attributes = get_block_wrapper_attributes([
			'id' => "affiliatex-product-comparison-blocks-style-$block_id"
		]);

		$pcTitleTag = AffiliateX_Helpers::validate_tag($pcTitleTag, 'h2');

		ob_start();
		include $this->get_template_path();
		return ob_get_clean();
	}
}
