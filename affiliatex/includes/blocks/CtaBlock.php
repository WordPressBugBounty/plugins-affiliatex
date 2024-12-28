<?php

namespace AffiliateX\Blocks;

defined( 'ABSPATH' ) || exit;

use AffiliateX\Helpers\AffiliateX_Helpers;

/**
 * AffiliateX CTA Block
 *
 * @package AffiliateX
 */
class CtaBlock extends BaseBlock
{
	protected function get_slug(): string
	{
		return 'cta';
	}

	protected function get_fields(): array
	{
		return [
			'block_id' => '',
			'ctaTitle' => 'Call to Action Title.',
			'ctaTitleTag' => 'h2',
			'ctaContent' => 'Start creating CTAs in seconds, and convert more of your visitors into leads.',
			'ctaBGType' => 'color',
			'ctaLayout' => 'layoutOne',
			'ctaAlignment' => 'center',
			'columnReverse' => false,
			'ctaButtonAlignment' => 'center',
			'edButtons' => true
		];
	}

	public function render(array $attributes, string $content) : string
	{
		$attributes = $this->parse_attributes($attributes);
		extract($attributes);
		
		// Use get_block_wrapper_attributes to get the class names and other attributes.
		$wrapper_attributes = get_block_wrapper_attributes([
			'class' => "affblk-cta-wrapper",
			'id' => "affiliatex-style-$block_id"
		]);

		$layoutClass = ($ctaLayout === 'layoutOne') ? ' layout-type-1' : (($ctaLayout === 'layoutTwo') ? ' layout-type-2' : '');
		$columnReverseClass = ($columnReverse && $ctaLayout !== 'layoutOne') ? ' col-reverse' : '';
		$bgClass = ($ctaBGType == 'image') ? ' img-opacity' : ' bg-color';
		$ctaTitleTag = AffiliateX_Helpers::validate_tag($ctaTitleTag, 'h2');

		if (str_contains($content, $layoutClass)) {
			return $content;
		}

		ob_start();
		include $this->get_template_path();
		return ob_get_clean();
	}
}
