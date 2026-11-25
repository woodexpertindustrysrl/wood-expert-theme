<?php
/**
 * Antetul paginii.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="sr-only-focusable" href="#continut"><?php esc_html_e( 'Sari la conținut', 'wood-expert' ); ?></a>
<?php
get_template_part( 'template-parts/header/topbar' );
get_template_part( 'template-parts/header/site-header' );
get_template_part( 'template-parts/header/drawer' );
?>
<main id="continut">
