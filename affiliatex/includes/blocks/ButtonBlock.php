<?php

namespace AffiliateX\Blocks;

use AffiliateX\Traits\ButtonRenderTrait;

defined('ABSPATH') || exit;

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
		return $this->get_button_fields();
	}

	public function render(array $attributes, string $content): string
	{
		$attributes = $this->parse_attributes($attributes);
		return $this->render_button_template($attributes, $content);
	}
}
