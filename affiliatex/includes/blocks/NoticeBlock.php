<?php

namespace AffiliateX\Blocks;

use AffiliateX\Traits\NoticeRenderTrait;
use AffiliateX\Helpers\AffiliateX_Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * AffiliateX Notice Block
 *
 * @package AffiliateX
 */
class NoticeBlock extends BaseBlock
{
	use NoticeRenderTrait;

	public function render(array $attributes, string $content) : string
	{
		$attributes = $this->parse_attributes($attributes);
		extract($attributes);

		if(is_array($noticeListItems) && count($noticeListItems) === 1 && isset($noticeListItems[0]['list']) && has_shortcode($noticeListItems[0]['list'], 'affiliatex-product')) {
			$noticeListItems = json_decode(do_shortcode($noticeListItems[0]['list']), true);
		}

		$wrapper_attributes = get_block_wrapper_attributes(array(
			'class' => 'affx-notice-wrapper',
			'id' => "affiliatex-notice-style-$block_id"
		));

		$titleTag1 = AffiliateX_Helpers::validate_tag($titleTag1, 'h2');
		$list = AffiliateX_Helpers::render_list(
			array(
				'listType' => $noticeListType,
				'unorderedType' => $noticeunorderedType,
				'listItems' => $noticeListItems,
				'iconName' => $noticeListIcon['value'],
			)
		);

		ob_start();
		include $this->get_template_path();
		return ob_get_clean();
	}
}
