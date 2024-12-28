<?php

namespace AffiliateX\Blocks;

defined( 'ABSPATH' ) || exit;

use AffiliateX\Helpers\AffiliateX_Helpers;

/**
 * AffiliateX Verdict Block
 *
 * @package AffiliateX
 */
class VerdictBlock extends BaseBlock
{
	protected function get_slug(): string
	{
		return 'verdict';
	}

	protected function get_fields(): array
	{
		return [
			'block_id' => '',
			'verdictLayout' => 'layoutOne',
			'verdictTitle' => 'Verdict Title.',
			'verdictContent' => 'Start creating Verdict in seconds, and convert more of your visitors into leads.',
			'edverdictTotalScore' => true,
			'verdictTotalScore' => 8.5,
			'ratingContent' => 'Our Score',
			'edRatingsArrow' => true,
			'edProsCons' => true,
			'verdictTitleTag' => 'h2',
			'ratingAlignment' => 'left'
		];
	}

	public function render(array $attributes, string $content) : string
	{
		$attributes = $this->parse_attributes($attributes);
		extract($attributes);

		$wrapper_attributes = get_block_wrapper_attributes(array(
			'id' => "affiliatex-verdict-style-$block_id",
		));

		$verdictTitleTag = AffiliateX_Helpers::validate_tag($verdictTitleTag, 'h2');

		$layoutClass = '';
		if ($verdictLayout === 'layoutOne') {
			$layoutClass = ' verdict-layout-1';
		} elseif ($verdictLayout === 'layoutTwo') {
			$layoutClass = ' verdict-layout-2';
		}

		if (str_contains($content, $layoutClass)) {
			return $content;
		}

		$ratingClass = $edverdictTotalScore ? ' number-rating' : '';
		$arrowClass = $edRatingsArrow ? ' display-arrow' : '';
		$innerBlocksContentHtml = $edProsCons ? $content : '';

		ob_start();
		include $this->get_template_path();
		return ob_get_clean();
	}
}
