<?php

namespace AffiliateX\Blocks;

defined('ABSPATH') || exit;

use AffiliateX\Helpers\AffiliateX_Helpers;

/**
 * AffiliateX Product Table Block
 *
 * @package AffiliateX
 */
class ProductTableBlock extends BaseBlock
{
	protected function get_slug(): string
	{
		return 'product-table';	
	}

	private function render_pt_stars($rating, $starColor, $starInactiveColor)
	{
		$output = '';
		for ($i = 0; $i < 5; $i++) {
			$color = $i < $rating ? $starColor : $starInactiveColor;
			$output .= sprintf(
				'<span style="color:%s;width:25px;height:25px;display:inline-flex;"><svg fill="currentColor" width="25" height="25" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg></span>',
				esc_attr($color)
			);
		}
		return $output;
	}

	protected function get_fields(): array
	{
		return [
			'block_id' => '',
			'productTable' => [],
			'layoutStyle' => 'layoutOne',
			'imageColTitle' => 'Image',
			'productColTitle' => 'Product',
			'featuresColTitle' => 'Features',
			'ratingColTitle' => 'Rating',
			'priceColTitle' => 'Price',
			'edImage' => true,
			'edCounter' => true,
			'edProductName' => true,
			'edRating' => true,
			'edRibbon' => true,
			'edPrice' => false,
			'edButton1' => true,
			'edButton1Icon' => true,
			'button1Icon' => [
				'name' => 'angle-right',
				'value' => 'fas fa-angle-right'
			],
			'button1IconAlign' => 'right',
			'edButton2' => true,
			'edButton2Icon' => true,
			'button2Icon' => [
				'name' => 'angle-right',
				'value' => 'fas fa-angle-right'
			],
			'button2IconAlign' => 'right',
			'starColor' => '#FFB800',
			'starInactiveColor' => '#A3ACBF',
			'productContentType' => 'paragraph',
			'contentListType' => 'unordered',
			'productIconList' => [
				'name' => 'check-circle-outline',
				'value' => 'far fa-check-circle'
			],
			'productNameTag' => 'h5',
		];
	}

	public function render(array $attributes, string $content) : string
	{
		$attributes = $this->parse_attributes($attributes);
		extract($attributes);

		$wrapper_attributes = get_block_wrapper_attributes(array(
			'id' => "affiliatex-pdt-table-style-$block_id"
		));

		$productNameTag = AffiliateX_Helpers::validate_tag($productNameTag, 'h5');

		ob_start();
		include $this->get_template_path();
		return ob_get_clean();
	}
}
