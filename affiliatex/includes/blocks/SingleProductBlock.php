<?php

namespace AffiliateX\Blocks;

defined( 'ABSPATH' ) || exit;

use AffiliateX\Helpers\AffiliateX_Helpers;

/**
 * AffiliateX Single Product Block
 *
 * @package AffiliateX
 */
class SingleProductBlock extends BaseBlock
{
	protected function get_slug(): string
	{
		return 'single-product';
	}

    private function render_pb_stars($ratings, $productRatingColor, $ratingInactiveColor, $ratingStarSize) {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $color = ($i <= $ratings) ? $productRatingColor : $ratingInactiveColor;
            $stars .= sprintf(
                '<span style="color:%s;width:%dpx;height:%dpx;display:inline-flex;">
                    <svg fill="currentColor" width="%d" height="%d" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                    </svg>
                </span>',
                esc_attr($color),
                esc_attr($ratingStarSize),
                esc_attr($ratingStarSize),
                esc_attr($ratingStarSize),
                esc_attr($ratingStarSize)
            );
        }
        return $stars;
    }

	protected function get_fields(): array
	{
		return [
			'block_id' => '',
			'productLayout' => 'layoutOne',
			'productTitle' => 'Title',
			'productTitleTag' => 'h2',
			'productContent' => 'You can have short product description here. It can be added as and enable/disable toggle option from which user can have control on it.',
			'productSubTitle' => 'Subtitle',
			'productSubTitleTag' => 'h3',
			'productContentType' => 'paragraph',
			'ContentListType' => 'unordered',
			'productContentList' => [],
			'productImageAlign' => 'left',
			'productSalePrice' => '$49',
			'productPrice' => '$59',
			'productIconList' => [
				'name' => 'check-circle-outline',
				'value' => 'far fa-check-circle'
			],
			'ratings' => 5,
			'edRatings' => false,
			'edTitle' => true,
			'edSubTitle' => false,
			'edContent' => true,
			'edPricing' => false,
			'PricingType' => 'picture',
			'productRatingColor' => '#FFB800',
			'ratingInactiveColor' => '#808080',
			'ratingContent' => 'Our Score',
			'ratingStarSize' => 25,
			'edButton' => false,
			'edProductImage' => false,
			'edRibbon' => false,
			'productRibbonLayout' => 'one',
			'ribbonText' => 'Sale',
			'ribbonAlign' => 'left',
			'ImgUrl' => '',
			'numberRatings' => '8.5',
			'productRatingAlign' => 'right',
			'productStarRatingAlign' => 'left',
			'productImageType' => 'default',
			'productImageExternal' => '',
			'productImageSiteStripe' => '',
			'productPricingAlign' => 'left',
		];
	}

	public function render(array $attributes, string $content) : string
	{
		$attributes = $this->parse_attributes($attributes);
		extract($attributes);

		if(is_array($productContentList) && count($productContentList) > 0 && isset($productContentList[0]['list']) && is_string($productContentList[0]['list']) && has_shortcode($productContentList[0]['list'], 'affiliatex-product')){
			$productContentList = do_shortcode($productContentList[0]['list']);
			$productContentList = json_decode($productContentList, true);
		}

		$wrapper_attributes = get_block_wrapper_attributes(array(
			'id' => "affiliatex-single-product-style-$block_id",
		));

		$productTitleTag = AffiliateX_Helpers::validate_tag($productTitleTag, 'h2');
		$productSubTitleTag = AffiliateX_Helpers::validate_tag($productSubTitleTag, 'h3');

		$layoutClass = '';
		if ($productLayout === 'layoutOne') {
			$layoutClass = ' product-layout-1';
		} elseif ($productLayout === 'layoutTwo') {
			$layoutClass = ' product-layout-2';
		} elseif ($productLayout === 'layoutThree') {
			$layoutClass = ' product-layout-3';
		}
		if (str_contains($content, $layoutClass)) {
			return str_replace('app/src/images/fallback', 'src/images/fallback', $content);
		}

		$ratingClass = '';
		if ($PricingType === 'picture') {
			$ratingClass = 'star-rating';
		} elseif ($PricingType === 'number') {
			$ratingClass = 'number-rating';
		}

		$imageAlign = $edProductImage ? 'image-' . $productImageAlign : '';
		$ribbonLayout = '';
		if ($productRibbonLayout === 'one') {
			$ribbonLayout = ' ribbon-layout-1';
		} elseif ($productRibbonLayout === 'two') {
			$ribbonLayout = ' ribbon-layout-2';
		}

		$imageClass = !$edProductImage ? 'no-image' : '';
		$productRatingNumberClass = $PricingType === 'number' ? 'rating-align-' . $productRatingAlign : '';
		$ImageURL = $productImageType === 'default' ? $ImgUrl : $productImageExternal;
		$isSiteStripe = 'sitestripe' === $productImageType && '' !== $productImageSiteStripe ? true : false;

		ob_start();
		include $this->get_template_path();
		return ob_get_clean();
	}
}
