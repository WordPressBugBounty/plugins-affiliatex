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
		$fontWeight = (int) $fontType * 100;
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

        // Parse Amazon shortcode if listItems is a string.
        if ( is_string( $listItems ) ) {
            $listItems = affx_maybe_parse_amazon_shortcode( $listItems );
        }

		ob_start();
		include AFFILIATEX_PLUGIN_DIR . '/templates/components/list.php';
		return ob_get_clean();
	}

	/**
	 * Convert an associative array of html element attributes into string format.
	 * 
	 * @param mixed $args	An associative array of attribute keys and values.
	 * 
	 * @return string
	 */
	public static function array_to_attributes( array $args = [] ): string {
		$string = '';

		if ( is_array( $args ) && ! empty ( $args ) ) {
			$string = implode( ' ', array_map( function( $key, $value ) {
				if ( is_array( $value ) ) {
					$value = implode( ' ', $value );
				}

				return esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
			},
			array_keys( $args ),
			$args
			));
		}

		return $string;
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

    /**
     * Check if the current page has AffiliateX Elementor widgets.
     *
     * @param int|null $post_id Optional. Post ID to check. Defaults to current post.
     * @return bool
     */
    public static function has_elementor_widgets( $post_id = null ) {
        if ( ! class_exists( '\Elementor\Plugin' ) ) {
            return false;
        }

        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }

        if ( ! $post_id || ! \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id ) ) {
            return false;
        }

        $elementor_data = get_post_meta( $post_id, '_elementor_data', true );
        
        return $elementor_data && ( 
            strpos( $elementor_data, 'affiliatex-' ) !== false || 
            strpos( $elementor_data, '"widgetType":"affx-' ) !== false 
        );
    }

    /**
     * Is_affiliatex_block - Returns true when viewing a page with AffiliateX blocks.
     * 
     * Checks for both Gutenberg blocks.
     *
     * @return bool
     */
    public static function is_affiliatex_block() {
        $affx_block =
            has_block( 'affiliatex/buttons' ) ||
            has_block( 'affiliatex/pros-and-cons' ) ||
            has_block( 'affiliatex/cta' ) ||
            has_block( 'affiliatex/notice' ) ||
            has_block( 'affiliatex/verdict' ) ||
            has_block( 'affiliatex/single-product' ) ||
            has_block( 'affiliatex/specifications' ) ||
            has_block( 'affiliatex/versus-line' ) ||
            has_block( 'affiliatex/single-product-pros-and-cons' ) ||
            has_block( 'affiliatex/product-image-button' ) ||
            has_block( 'affiliatex/single-coupon' ) ||
            has_block( 'affiliatex/coupon-grid' ) ||
            has_block( 'affiliatex/product-tabs' ) ||
            has_block( 'affiliatex/coupon-listing' ) ||
            has_block( 'affiliatex/top-products' ) ||
            has_block( 'affiliatex/versus' ) ||
            has_block( 'affiliatex/product-table' ) ||
            has_block( 'affiliatex/product-comparison' ) ||
            has_block( 'affiliatex/rating-box' );

        return apply_filters( 'is_affiliatex_block', $affx_block );
    }

    /**
     * Returns true when viewing a page with AffiliateX blocks or widgets.
     * 
     * Checks for both Gutenberg blocks and Elementor widgets.
     *
     * @return bool
     */
    public static function post_has_affiliatex_items() {
        return apply_filters( 'post_has_affiliatex_items', self::is_affiliatex_block() || self::has_elementor_widgets() );
    }

    /**
     * Add full block link attributes to the block wrapper.
     *
     * @param string $wrapper_attributes
     * @param bool $edFullBlockLink
     * @param string $blockUrl
     * @param bool $blockOpenInNewTab
     * @return string
     */
    public static function add_clickable_attributes( $wrapper_attributes, $edFullBlockLink, $blockUrl, $blockOpenInNewTab ) {
        if ( $edFullBlockLink ) {
            $wrapper_attributes .= sprintf(
                ' data-clickable="%s" data-click-url="%s" data-click-new-tab="%s"',
                $edFullBlockLink ? 'true' : 'false',
                esc_url( do_shortcode( $blockUrl ) ),
                $blockOpenInNewTab ? 'true' : 'false'
            );
        }

        return $wrapper_attributes;
    }
}

