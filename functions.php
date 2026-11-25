<?php
/**
 * Wood Expert – punctul de intrare al temei.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

define( 'WE_VERSION', '0.1.0' );
define( 'WE_DIR', get_template_directory() );
define( 'WE_URI', get_template_directory_uri() );

require_once WE_DIR . '/inc/helpers.php';
require_once WE_DIR . '/inc/setup.php';
require_once WE_DIR . '/inc/enqueue.php';
require_once WE_DIR . '/inc/acf.php';
require_once WE_DIR . '/inc/navigation.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once WE_DIR . '/inc/woocommerce.php';
}
