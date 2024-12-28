<?php

namespace AffiliateX\Blocks;

use AffiliateX\Blocks\BaseBlock;

defined( 'ABSPATH' ) || exit;

/**
 * AffiliateX Button Block
 *
 * @package AffiliateX
 */
class ButtonBlock extends BaseBlock
{
	protected function get_slug(): string
	{
		return 'buttons';
	}

	protected function get_fields() : array
	{
		return [
			'buttonLabel' => 'Button',
			'buttonSize' => 'medium',
			'buttonWidth' => 'flexible',
			'buttonURL' =>	'',
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
		extract($attributes);

		$wrapper_attributes = get_block_wrapper_attributes(array(
			'class' => 'affx-btn-wrapper',
			'id' => "affiliatex-blocks-style-$block_id"
		));

		// Construct class names
		$classNames = [
			'affiliatex-button',
			'btn-align-' . $buttonAlignment,
			'btn-is-' . $buttonSize,
			$buttonWidth === 'fixed' ? 'btn-is-fixed' : '',
			$buttonWidth === 'full' ? 'btn-is-fullw' : '',
			$buttonWidth === 'flexible' ? 'btn-is-flex-' . $buttonSize : '',
			$layoutStyle === 'layout-type-2' && $priceTagPosition === 'tagBtnleft' ? 'left-price-tag' : '',
			$layoutStyle === 'layout-type-2' && $priceTagPosition === 'tagBtnright' ? 'right-price-tag' : '',
			$edButtonIcon && $iconPosition === 'axBtnright' ? 'icon-right' : 'icon-left'
		];
		$classNames = implode(' ', array_filter($classNames));

		// Construct rel attribute
		$rel = ['noopener'];
		if ($btnRelNoFollow) $rel[] = 'nofollow';
		if ($btnRelSponsored) $rel[] = 'sponsored';
		$rel = implode(' ', $rel);

		// Construct target attribute
		$target = $openInNewTab ? ' target="_blank"' : '';

		// Construct download attribute
		$download = $btnDownload ? ' download="affiliatex"' : '';

		// Construct icon HTML
		$iconLeft = $edButtonIcon && $iconPosition === 'axBtnleft' ? '<i class="button-icon ' . esc_attr($ButtonIcon) . '"></i>' : '';
		$iconRight = $edButtonIcon && $iconPosition === 'axBtnright' ? '<i class="button-icon ' . esc_attr($ButtonIcon) . '"></i>' : '';

		ob_start();
		include $this->get_template_path();
		return ob_get_clean();
	}
}