<?php

namespace AffiliateX\Blocks;

defined( 'ABSPATH' ) || exit;

use AffiliateX\Helpers\AffiliateX_Helpers;

/**
 * AffiliateX Versus Line Block
 *
 * @package AffiliateX
 */
class VersusLineBlock extends BaseBlock
{
	protected function get_slug(): string
	{
		return 'versus-line';
	}

	protected function get_fields(): array
	{
		return [
			'block_id' => '',
			'versusTable' => [],
			'vsLabel' => '',
			'versusTitleTag' => 'p'
		];
	}

	public function render(array $attributes, string $content) : string
	{
		$attributes = $this->parse_attributes($attributes);
		extract($attributes);

		$wrapper_attributes = get_block_wrapper_attributes(array(
			'id' => "affiliatex-versus-line-style-$block_id",
			'class' => "affx-versus-line-block-container",
		));

		$versusTitleTag = AffiliateX_Helpers::validate_tag($attributes['versusTitleTag'], 'p');

		ob_start();
		include $this->get_template_path();
		return ob_get_clean();
	}
}
