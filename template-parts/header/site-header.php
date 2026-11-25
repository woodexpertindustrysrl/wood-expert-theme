<?php
/**
 * Header lipicios: logo, navigare cu mega-meniu, căutare, CTA, buton drawer.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

$nav       = we_primary_nav();
$nav_btn   = 'inline-flex items-center gap-1 h-10 px-3 rounded-lg text-tx-2 font-semibold text-[15px] cursor-pointer transition-colors hover:bg-sand-50 hover:text-tx';
$is_active = 'bg-sand-50 text-tx';
?>
<header
	class="sticky top-0 z-50 bg-white/86 backdrop-blur-[14px] backdrop-saturate-160 border-b border-line"
	x-data="weMega"
	@pointerleave="$event.pointerType === 'mouse' && leave()"
	@pointerenter="clearTimeout(closeTimer)"
	@keydown.escape="close()"
	@focusout="focusOut($event)"
>
	<div class="wrap flex items-center gap-6 min-h-16 tab:min-h-18">
		<a class="flex items-center flex-none" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Wood Expert Industry – acasă', 'wood-expert' ); ?>">
			<?php we_logo(); ?>
		</a>

		<nav class="hidden desk:flex items-center justify-center gap-0.5 flex-1" aria-label="<?php esc_attr_e( 'Meniu principal', 'wood-expert' ); ?>">
			<?php foreach ( $nav as $i => $item ) : ?>
				<?php if ( $item['children'] ) : ?>
					<button
						type="button"
						class="<?php echo esc_attr( $nav_btn . ' aria-expanded:bg-sand-50 aria-expanded:text-tx aria-expanded:[&>svg]:rotate-180' . ( $item['current'] ? ' text-tx' : '' ) ); ?>"
						aria-controls="mega-<?php echo (int) $i; ?>"
						:aria-expanded="menu === <?php echo (int) $i; ?> ? 'true' : 'false'"
						aria-expanded="false"
						@pointerenter="hover($event, <?php echo (int) $i; ?>)"
						@click="click(<?php echo (int) $i; ?>)"
					>
						<?php echo esc_html( $item['label'] ); ?>
						<?php echo we_icon( 'chevron-down', 'size-4 text-mut transition-transform duration-200' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>
				<?php else : ?>
					<a
						class="<?php echo esc_attr( $nav_btn . ( $item['current'] ? ' ' . $is_active : '' ) ); ?>"
						href="<?php echo esc_url( $item['url'] ); ?>"
						<?php echo $item['current'] ? 'aria-current="page"' : ''; ?>
						@pointerenter="$event.pointerType === 'mouse' && close()"
					><?php echo esc_html( $item['label'] ); ?></a>
				<?php endif; ?>
			<?php endforeach; ?>
		</nav>

		<div class="flex items-center gap-2 flex-none ml-auto desk:ml-0">
			<button
				type="button"
				class="ico-btn"
				aria-controls="cautare"
				:aria-expanded="$store.ui.search ? 'true' : 'false'"
				aria-expanded="false"
				@click="close(); $store.ui.toggleSearch()"
			>
				<span class="sr-only"><?php esc_html_e( 'Caută utilaje', 'wood-expert' ); ?></span>
				<?php echo we_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
			<a class="btn btn-primary hidden desk:inline-flex" href="<?php echo esc_url( we_opt( 'cta_url' ) ); ?>">
				<?php echo esc_html( we_opt( 'cta_label' ) ); ?>
				<?php echo we_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
			<button
				type="button"
				class="ico-btn desk:hidden"
				aria-controls="drawer"
				:aria-expanded="$store.ui.drawer ? 'true' : 'false'"
				aria-expanded="false"
				@click="$store.ui.openDrawer()"
			>
				<span class="sr-only"><?php esc_html_e( 'Deschide meniul', 'wood-expert' ); ?></span>
				<?php echo we_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
		</div>
	</div>

	<?php
	foreach ( $nav as $i => $item ) {
		if ( $item['children'] ) {
			get_template_part(
				'template-parts/header/mega-menu',
				null,
				array(
					'index' => (int) $i,
					'item'  => $item,
				)
			);
		}
	}

	get_template_part( 'template-parts/header/search' );
	?>
</header>
