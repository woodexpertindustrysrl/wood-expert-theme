<?php
/**
 * Panoul mega-meniului pentru un element de nivel 1.
 *
 * @package WoodExpert
 *
 * @var array $args { index: int, item: array }
 */

defined( 'ABSPATH' ) || exit;

$i       = (int) ( $args['index'] ?? 0 );
$item    = $args['item'] ?? array();
$feature = $item['feature'] ?? array();
$title   = $feature['title'] ?: $item['label'];
$has_url = ! empty( $item['url'] );
$img     = we_mega_image( $feature );
?>
<div
	id="mega-<?php echo (int) $i; ?>"
	class="hidden desk:block absolute inset-x-0 top-full bg-white border-b border-line shadow-xl animate-drop"
	x-show="menu === <?php echo (int) $i; ?>"
	x-cloak
>
	<div class="wrap grid grid-cols-[minmax(0,1fr)_340px] gap-10 pt-8 pb-9">
		<div class="grid grid-cols-3 gap-x-4 gap-y-0.5 content-start">
			<p class="col-span-full mb-2.5 text-sm font-bold text-or-ink"><?php echo esc_html( $item['label'] ); ?></p>
			<?php foreach ( $item['children'] as $child ) : ?>
				<a
					class="flex justify-between items-center gap-3 p-3 rounded-lg text-[15px] font-semibold text-tx transition-colors hover:bg-sand-50 hover:text-tx<?php echo $child['current'] ? ' bg-sand-50' : ''; ?>"
					href="<?php echo esc_url( $child['url'] ); ?>"
					<?php echo $child['current'] ? 'aria-current="page"' : ''; ?>
				>
					<?php echo esc_html( $child['label'] ); ?>
					<?php if ( '' !== $child['badge'] ) : ?>
						<span class="shrink-0 text-xs font-semibold text-tx-2 bg-sand-50 border border-sand-200 px-2 py-0.5 rounded-full">
							<span class="sr-only"><?php esc_html_e( 'Număr utilaje:', 'wood-expert' ); ?></span>
							<?php echo esc_html( $child['badge'] ); ?>
						</span>
					<?php endif; ?>
				</a>
			<?php endforeach; ?>
		</div>

		<a
			class="group relative isolate flex flex-col justify-end min-h-[250px] p-5 rounded-2xl overflow-hidden bg-sand-50 border border-line"
			href="<?php echo esc_url( $has_url ? $item['url'] : '#' ); ?>"
		>
			<?php echo $img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- generat de wp_get_attachment_image / esc_url. ?>
			<span class="absolute inset-0 bg-linear-to-b from-maro/0 from-30% to-maro-3/85" aria-hidden="true"></span>
			<?php if ( ! empty( $feature['chip'] ) ) : ?>
				<span class="chip relative"><?php echo esc_html( $feature['chip'] ); ?></span>
			<?php endif; ?>
			<b class="relative mt-3.5 text-xl leading-tight tracking-[-.02em] text-white"><?php echo esc_html( $title ); ?></b>
			<small class="relative mt-1.5 text-[13px] text-cr"><?php esc_html_e( 'Vezi soluția completă →', 'wood-expert' ); ?></small>
		</a>
	</div>
</div>
