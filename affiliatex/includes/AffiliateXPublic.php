<?php
/**
 * Public Class
 *
 * @package AffiliateX
 */

namespace AffiliateX;

use AffiliateX\Helpers\AffiliateX_Helpers;

/**
 * AffilateX Public instance
 *
 * @since 1.0.0
 */
class AffiliateXPublic {

	/**
	 * Class Constructor for public instance.
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Init Hooks
	 *
	 * @return void
	 */
	public function init_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp', array( $this, 'generate_assets' ), 99 );
		add_action( 'wp_head', array( $this, 'generate_stylesheet' ), 80 );
	}

	/**
	 * Generate Fonts Assets
	 *
	 * @return void
	 */
	public function generate_assets() {
		$m = new \AB_FONTS_MANAGER();
		$m->generate_assets();
	}

	/**
	 * Load Frontend assets.
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		if ( AffiliateX_Helpers::post_has_affiliatex_items() ) {
			wp_enqueue_style(
				'affiliatex-public', // Handle.
				plugin_dir_url( AFFILIATEX_PLUGIN_FILE ) . 'build/publicCSS.css',
				array(),
				AFFILIATEX_VERSION
			);
			$m = new \AB_FONTS_MANAGER();
			$m->load_dynamic_google_fonts();

			wp_enqueue_style(
				'fontawesome',
				plugin_dir_url( AFFILIATEX_PLUGIN_FILE ) . 'build/fontawesome.css',
				array(),
				AFFILIATEX_VERSION
			);

			wp_enqueue_script(
				'affiliatex-frontend',
				plugin_dir_url( AFFILIATEX_PLUGIN_FILE ) . 'build/frontendJs.js',
				array( 'jquery' ),
				AFFILIATEX_VERSION,
				false
			);
		}
	}


	/**
	 * Generates stylesheet and appends in head tag.
	 *
	 * @since 0.0.1
	 */
	public function generate_stylesheet() {

		$m          = new \AB_FONTS_MANAGER();
		$stylesheet = $m::$stylesheet;

		if ( is_null( $stylesheet ) || '' === $stylesheet ) {
			return;
		}
		ob_start();
		?>
		<style id="affiliatex-styles-frontend"><?php echo $stylesheet; //phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped, WordPress.Security.EscapeOutput.OutputNotEscaped ?></style>
		<?php
		ob_end_flush();
	}
}
