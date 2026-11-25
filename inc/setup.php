<?php
/**
 * Suport temă, meniuri, curățenie de bază.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'wood-expert', WE_DIR . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
		);

		register_nav_menus(
			array(
				'primary'            => __( 'Meniu principal (header, mega-meniu și drawer mobil)', 'wood-expert' ),
				'footer-primara'     => __( 'Subsol: coloana 1 (Prelucrare primară)', 'wood-expert' ),
				'footer-secundara'   => __( 'Subsol: coloana 2 (Secundară și PAL/MDF)', 'wood-expert' ),
				'footer-producatori' => __( 'Subsol: coloana 3 (Exclusivitate)', 'wood-expert' ),
				'footer-companie'    => __( 'Subsol: Companie', 'wood-expert' ),
				'legal'              => __( 'Subsol: linkuri legale', 'wood-expert' ),
			)
		);
	}
);

// Lățimea conținutului pentru embed-uri.
add_action(
	'after_setup_theme',
	function () {
		$GLOBALS['content_width'] = 1216;
	},
	0
);
