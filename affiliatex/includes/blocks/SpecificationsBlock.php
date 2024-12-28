<?php

namespace AffiliateX\Blocks;

defined( 'ABSPATH' ) || exit;

use AffiliateX\Helpers\AffiliateX_Helpers;

/**
 * AffiliateX Specifications Block
 *
 * @package AffiliateX
 */
class SpecificationsBlock extends BaseBlock
{
    protected function get_slug(): string
    {
        return 'specifications';
    }

    protected function get_fields(): array
    {
        return [
            'block_id' => '',
            'layoutStyle' => 'layout-1',
            'specificationTitle' => 'Specifications',
            'specificationTable' => [],
            'edSpecificationTitle' => true,
            'specificationTitleTag' => 'h2',
        ];
    }

	public function render(array $attributes, string $content) : string
    {
        $attributes = $this->parse_attributes($attributes);
        extract($attributes);

        $wrapper_attributes = get_block_wrapper_attributes(array(
            'id' => "affiliatex-specification-style-$block_id",
        ));

        $specificationTitleTag = AffiliateX_Helpers::validate_tag($specificationTitleTag, 'h2');

        ob_start();
        include $this->get_template_path();
        return ob_get_clean();
    }
}
