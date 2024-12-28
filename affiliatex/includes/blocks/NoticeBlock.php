<?php

namespace AffiliateX\Blocks;

use AffiliateX\Helpers\AffiliateX_Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * AffiliateX Notice Block
 *
 * @package AffiliateX
 */
class NoticeBlock extends BaseBlock
{
	protected function get_slug(): string
	{
		return 'notice';
	}

	protected function get_fields(): array
	{
		return [
			'block_id' => '',
			'titleTag1' => 'h2',
			'layoutStyle' => 'layout-type-1',
			'noticeTitle' => 'Notice',
			'noticeTitleIcon' => [
				'name' => 'info-circle',
				'value' => 'fa fa-info-circle'
			],
			'noticeListItems' => ['List items'],
			'noticeListType' => 'unordered',
			'noticeContent' => 'This is the notice content',
			'noticeContentType' => 'list',
			'noticeListIcon' => [
				'name' => 'check-circle',
				'value' => 'far fa-check-circle'
			],
			'noticeunorderedType' => 'icon',
			'edTitleIcon' => true,
			'titleAlignment' => 'left'
		];
	}

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

		$titleIconClass = $edTitleIcon ? "affiliatex-icon-{$noticeTitleIcon['name']}" : '';
		$titleTag1 = AffiliateX_Helpers::validate_tag($titleTag1, 'h2');

		if ($noticeContentType === 'list') {
			$listTag = $noticeListType === 'unordered' ? 'ul' : 'ol';
			$listClass = $noticeunorderedType === 'icon' ? "affiliatex-list icon affiliatex-icon affiliatex-icon-{$noticeListIcon['name']}" : 'affiliatex-list bullet';
		}

		ob_start();
		include $this->get_template_path();
		return ob_get_clean();
	}
}
