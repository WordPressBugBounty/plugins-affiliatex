<?php

namespace AffiliateX\Blocks;

use AffiliateX\Traits\VerdictRenderTrait;

defined( 'ABSPATH' ) || exit;

/**
 * AffiliateX Verdict Block
 *
 * @package AffiliateX
 */
class VerdictBlock extends BaseBlock {

	use VerdictRenderTrait;

	/**
	 * Gutenberg block render.
	 *
	 * @param array $attributes
	 * @param string $content
	 * @return string
	 */
	public function render( array $attributes, string $content, $block = null ): string {
		return $this->render_template( $attributes, $content );
	}
}
