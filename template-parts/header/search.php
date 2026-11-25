<?php
/**
 * Panoul de căutare, deschis din iconița de lupă din header.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

$is_shop = class_exists( 'WooCommerce' );
?>
<div
	id="cautare"
	class="absolute inset-x-0 top-full bg-white border-b border-line shadow-xl animate-drop"
	x-show="$store.ui.search"
	x-cloak
	@keydown.escape.stop="$store.ui.search = false"
	x-effect="$store.ui.search && $nextTick(() => $refs.q.focus())"
>
	<form class="wrap flex gap-2 py-5" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="sr-only" for="cautare-q"><?php esc_html_e( 'Caută', 'wood-expert' ); ?></label>
		<input
			id="cautare-q"
			class="field flex-1 min-w-0 h-12"
			type="search"
			name="s"
			x-ref="q"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php esc_attr_e( 'Caută utilaje, de ex. mașină de aplicat cant', 'wood-expert' ); ?>"
		>
		<?php if ( $is_shop ) : ?>
			<input type="hidden" name="post_type" value="product">
		<?php endif; ?>
		<button class="btn btn-primary min-h-12" type="submit">
			<?php echo we_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span class="hidden tab:inline"><?php esc_html_e( 'Caută', 'wood-expert' ); ?></span>
			<span class="sr-only tab:hidden"><?php esc_html_e( 'Caută', 'wood-expert' ); ?></span>
		</button>
	</form>
</div>
