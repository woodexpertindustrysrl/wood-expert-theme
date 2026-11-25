<?php
/**
 * Integrare WooCommerce. Șabloanele de categorie și produs vin în Faza 3.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'woocommerce' );
	}
);
