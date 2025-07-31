<?php

namespace AffiliateX\Blocks;

use AffiliateX\Traits\VerdictRenderTrait;

defined('ABSPATH') || exit;

/**
 * AffiliateX Verdict Block
 *
 * @package AffiliateX
 */
class VerdictBlock extends BaseBlock
{
    use VerdictRenderTrait;

    /**
     * Gutenberg block render.
     * @param mixed $attributes
     * @param mixed $content
     * @return string
     */
    public function render($attributes, $content): string
    {
        return $this->render_template($attributes, $content);
    }
}
