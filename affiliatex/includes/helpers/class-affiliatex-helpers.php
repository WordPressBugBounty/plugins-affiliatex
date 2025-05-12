<?php
namespace AffiliateX\Helpers;

/**
 * Affiliatex Helpers class
 *
 */

class AffiliateX_Helpers {

	/**
	 * Parse CSS into correct CSS syntax.
	 *
	 * @param array  $selectors The block selectors.
	 * @param string $id The selector ID.
	 * @since 0.0.1
	 */
	public static function generate_css($selectors, $id) {
		$styling_css = '';

		if ( empty( $selectors ) ) {
			return '';
		}

		foreach ( $selectors as $key => $value ) {

			$css = '';

			foreach ( $value as $j => $val ) {

				if ( 'font-family' === $j && 'Default' === $val ) {
					continue;
				}

				if ( ! empty( $val ) ) {
					if ( 'font-family' === $j ) {
						$css .= $j . ': "' . $val . '";';
					} else {
						$css .= $j . ': ' . $val . ';';
					}

				}
			}

			if ( ! empty( $css ) ) {
				$styling_css     .= $id;
				$styling_css     .= $key . '{';
				$styling_css .= $css . '}';
			}
		}

		return $styling_css;
	}

	/**
	 * Get CSS value
	 *
	 * Syntax:
	 *
	 *  get_css_value( VALUE, UNIT );
	 *
	 * E.g.
	 *
	 *  get_css_value( VALUE, 'em' );
	 *
	 * @param string $value  CSS value.
	 * @param string $unit  CSS unit.
	 * @since x.x.x
	 */
	public static function get_css_value( $value = '', $unit = '' ) {

		if ( '' == $value) {
			return $value;
		}

		$css_val = '';

		if ( !empty( $value ) ) {

			$css_val = esc_attr( $value ) . $unit;
		}

		return $css_val;
	}

	public static function get_css_boxshadow( $v ) {
		if ( isset( $v['enable'] ) &&  $v['enable'] === true ) {
			$h_offset = isset( $v['h_offset'] ) ? $v['h_offset'] : 0;
			$v_offset = isset( $v['v_offset'] ) ? $v['v_offset'] : 5;
			$blur     = isset( $v['blur'] ) ? $v['blur'] : 20;
			$spread   = isset( $v['spread'] ) ? $v['spread'] : 0;
			$color    = isset( $v['color']['color'] ) ? $v['color']['color'] : 'rgba(210,213,218,0.2)';
			$inset    = isset( $v['inset'] ) && $v['inset'] === true ? 'inset' : '';

			return  $h_offset . 'px ' . $v_offset . 'px ' . $blur . 'px ' . $spread . 'px ' . $color . $inset;
		} else {
			return "none";
		}
	}

	public static function get_fontweight_variation( $variation ) {
		$fontType   = $variation[1];
		$fontWeight = $fontType * 100;
		return $fontWeight;
	}

	public static function get_font_style( $variation ) {
		$variationType = $variation[0];
		$font          = $variationType === 'n' ? 'normal' : ( $variationType === 'i' ? 'italic' : 'Default' );
		return $font;
	}

	public static function validate_tag($tag, $default = 'h2') {
		$allowed_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p');
		return in_array($tag, $allowed_tags, true) ? $tag : $default;
	}
	
	/**
	 * Render a list
	 *
	 * @param array $args {
	 *     @type string $listType           'unordered' or 'ordered'
	 *     @type string $unorderedType      'icon' or 'bullet'
	 *     @type array  $listItems          Array of list items
	 *     @type string $iconName           Optional icon class name
	 * }
	 * @return void
	 */
	
	public static function render_list($args) {
		$defaults = array(
				'listType' => 'unordered',
				'unorderedType' => 'icon',
				'listItems' => array(),
				'iconName' => '',
		);

		$args = wp_parse_args($args, $defaults);
		extract($args);
		$listTag = $listType === 'unordered' ? 'ul' : 'ol';
		$wrapperClasses = array('affiliatex-list');
		$wrapperClasses[] .= 'affiliatex-list-type-' . $listType;
		$wrapperClasses[] .= $unorderedType === 'icon' ? 'afx-icon-list' : 'bullet';

		ob_start();
		include AFFILIATEX_PLUGIN_DIR . '/templates/components/list.php';
		return ob_get_clean();
	}

	/**
	 * This function handles both media library images and images with url
	 *
	 * @param int       $image_id    The WordPress media library image ID
	 * @param string    $image_url   The image URL
	 * @param string    $image_alt   The image alt text
	 * @param bool      $is_sitestripe Whether to show sitestripe
	 * @param string    $sitestripe  The sitestripe HTML content
	 * @return string   The image HTML or empty string if no image available
	 */

	public static function affiliatex_get_media_image_html($image_id = 0, $image_url = '', $image_alt = '', $is_sitestripe = false, $sitestripe = '', $size = 'full') {
		
		if ($is_sitestripe && !empty($sitestripe)) {
			return $sitestripe;
		}

		if (!empty($image_id) && wp_attachment_is_image($image_id)) {
			// Setting height to auto to prevent image distortion
			$image = wp_get_attachment_image($image_id, $size, false, array('style' => 'height: auto;'));
			return $image;
		}

		if (!empty($image_url)) {
			$fallback_url_bc = str_replace('app/src/images/fallback.jpg', 'src/images/fallback.jpg', $image_url);
			$processed_url = do_shortcode($fallback_url_bc);
			$escaped_url = esc_url($processed_url);

			return sprintf(
				'<img src="%s" alt="%s"/>',
				$escaped_url,
				esc_attr($image_alt)
			);
		}

		return '';
	}
}

