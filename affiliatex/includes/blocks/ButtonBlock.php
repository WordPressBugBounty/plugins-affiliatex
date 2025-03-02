<?php

namespace AffiliateX\Blocks;

use AffiliateX\Traits\ButtonRenderTrait;

defined( 'ABSPATH' ) || exit;

/**
 * AffiliateX Button Block
 *
 * @package AffiliateX
 */
class ButtonBlock extends BaseBlock
{
	use ButtonRenderTrait;

	protected function get_slug(): string
	{
		return 'buttons';
	}

	protected function get_fields(): array
	{
		return [
			'buttonLabel' => 'Button',
			'buttonSize' => 'medium',
			'buttonWidth' => 'flexible',
			'buttonURL' => '',
			'iconPosition' => 'left',
			'block_id' => '',
			'ButtonIcon' => [
				'name' => 'thumb-up-simple',
				'value' => 'far fa-thumbs-up'
			],
			'edButtonIcon' => false,
			'btnRelSponsored' => false,
			'openInNewTab' => false,
			'btnRelNoFollow' => false,
			'buttonAlignment' => 'flex-start',
			'btnDownload' => false,
			'layoutStyle' => 'layout-type-1',
			'priceTagPosition' => 'tagBtnright',
			'productPrice' => '$145'
		];
	}

	public function render(array $attributes, string $content) : string
	{
		$attributes = $this->parse_attributes($attributes);
		return $this->render_button($attributes);
	}
}
