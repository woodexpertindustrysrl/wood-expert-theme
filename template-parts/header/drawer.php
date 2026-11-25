<?php
/**
 * Drawer-ul mobil (sub 1180px). Aceleași date ca mega-meniul.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

$nav     = we_primary_nav();
$dr_link = 'flex justify-between items-center w-full py-3.5 px-1 border-b border-line text-tx text-[17px] font-semibold text-left';
?>
<div
	id="drawer"
	class="fixed inset-0 z-80 bg-maro-3/35 backdrop-blur-xs desk:hidden"
	x-data
	x-show="$store.ui.drawer"
	x-cloak
	x-transition.opacity.duration.200ms
	@click.self="$store.ui.closeDrawer()"
	@keydown.escape.window="$store.ui.closeDrawer()"
>
	<div
		class="absolute right-0 inset-y-0 flex flex-col gap-1.5 w-[min(420px,100%)] px-5 pt-5 pb-8 overflow-y-auto bg-white border-l border-line shadow-xl animate-slide"
		role="dialog"
		aria-modal="true"
		aria-label="<?php esc_attr_e( 'Meniu', 'wood-expert' ); ?>"
		x-data="weDrawer"
		x-trap.inert.noscroll="$store.ui.drawer"
	>
		<div class="flex justify-between items-center mb-3">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Wood Expert Industry – acasă', 'wood-expert' ); ?>">
				<?php we_logo( 'h-7 w-auto block' ); ?>
			</a>
			<button type="button" class="ico-btn" @click="$store.ui.closeDrawer()">
				<span class="sr-only"><?php esc_html_e( 'Închide meniul', 'wood-expert' ); ?></span>
				<?php echo we_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
		</div>

		<nav aria-label="<?php esc_attr_e( 'Meniu mobil', 'wood-expert' ); ?>" class="flex flex-col">
			<?php foreach ( $nav as $i => $item ) : ?>
				<?php if ( $item['children'] ) : ?>
					<div>
						<button
							type="button"
							class="<?php echo esc_attr( $dr_link ); ?> cursor-pointer"
							aria-controls="dr-sub-<?php echo (int) $i; ?>"
							:aria-expanded="section === <?php echo (int) $i; ?> ? 'true' : 'false'"
							aria-expanded="false"
							@click="toggle(<?php echo (int) $i; ?>)"
						>
							<?php echo esc_html( $item['label'] ); ?>
							<span class="text-maro text-xl leading-none" aria-hidden="true" x-text="section === <?php echo (int) $i; ?> ? '−' : '+'">+</span>
						</button>
						<div id="dr-sub-<?php echo (int) $i; ?>" class="flex flex-col pt-1 pb-3 pl-2" x-show="section === <?php echo (int) $i; ?>" x-collapse.duration.200ms x-cloak>
							<?php if ( ! empty( $item['url'] ) && '#' !== $item['url'] ) : ?>
								<a class="py-2.5 text-[15px] font-semibold text-tx" href="<?php echo esc_url( $item['url'] ); ?>">
									<?php
									/* translators: %s: numele categoriei principale */
									printf( esc_html__( 'Toată gama: %s', 'wood-expert' ), esc_html( $item['label'] ) );
									?>
								</a>
							<?php endif; ?>
							<?php foreach ( $item['children'] as $child ) : ?>
								<a class="py-2.5 text-[15px] text-tx-2" href="<?php echo esc_url( $child['url'] ); ?>">
									<?php echo esc_html( $child['label'] ); ?>
									<?php if ( '' !== $child['badge'] ) : ?>
										<span class="text-mut">· <?php echo esc_html( $child['badge'] ); ?></span>
									<?php endif; ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php else : ?>
					<a class="<?php echo esc_attr( $dr_link ); ?>" href="<?php echo esc_url( $item['url'] ); ?>" <?php echo $item['current'] ? 'aria-current="page"' : ''; ?>><?php echo esc_html( $item['label'] ); ?></a>
				<?php endif; ?>
			<?php endforeach; ?>
		</nav>

		<a class="btn btn-primary mt-5" href="<?php echo esc_url( we_opt( 'cta_url' ) ); ?>"><?php echo esc_html( we_opt( 'cta_label' ) ); ?></a>
		<a class="btn btn-ghost" href="<?php echo esc_attr( we_tel( (string) we_opt( 'phone' ) ) ); ?>">
			<?php
			/* translators: %s: numărul de telefon */
			printf( esc_html__( 'Sună: %s', 'wood-expert' ), esc_html( we_opt( 'phone_label' ) ) );
			?>
		</a>
	</div>
</div>
