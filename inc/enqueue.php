<?php
/**
 * Încărcarea stilurilor, scripturilor și a fontului.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

/**
 * Versiune după data modificării fișierului, ca să invalidăm cache-ul la fiecare build.
 *
 * @param string $rel Cale relativă în temă.
 */
function we_asset_version( string $rel ): string {
	$path = WE_DIR . '/' . ltrim( $rel, '/' );
	return file_exists( $path ) ? (string) filemtime( $path ) : WE_VERSION;
}

add_action(
	'wp_enqueue_scripts',
	function () {
		// Inter Tight din Google Fonts. De mutat self-hosted în Faza 7 (performanță).
		wp_enqueue_style(
			'we-font',
			'https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;500;600;700;800&display=swap',
			array(),
			null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		);

		wp_enqueue_style( 'we-theme', WE_URI . '/assets/css/theme.css', array( 'we-font' ), we_asset_version( 'assets/css/theme.css' ) );

		wp_enqueue_script(
			'we-theme',
			WE_URI . '/assets/js/theme.js',
			array(),
			we_asset_version( 'assets/js/theme.js' ),
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}
);

// Preconnect pentru Google Fonts.
add_filter(
	'wp_resource_hints',
	function ( array $urls, string $relation ) {
		if ( 'preconnect' === $relation ) {
			$urls[] = 'https://fonts.googleapis.com';
			$urls[] = array(
				'href'        => 'https://fonts.gstatic.com',
				'crossorigin' => 'anonymous',
			);
		}
		return $urls;
	},
	10,
	2
);
