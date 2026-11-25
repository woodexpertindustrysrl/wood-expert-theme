<?php
/**
 * Butonul plutitor WhatsApp. Apare doar dacă numărul e setat în „Setări temă”.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

$url = we_whatsapp_url();
if ( ! $url ) {
	return;
}
?>
<a
	class="fixed right-4 bottom-4 tab:right-6 tab:bottom-6 z-60 flex items-center justify-center tab:justify-start gap-2.5 size-13 tab:size-auto tab:h-13 tab:pl-1.5 tab:pr-4.5 rounded-full bg-white border border-sand-200 text-[15px] font-semibold text-tx shadow-xl hover:bg-sand-50 hover:text-tx"
	href="<?php echo esc_url( $url ); ?>"
	target="_blank"
	rel="noopener"
>
	<span class="flex items-center justify-center size-10 rounded-full bg-vd text-maro"><?php echo we_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
	<b class="hidden tab:inline font-semibold"><?php esc_html_e( 'Scrie-ne pe WhatsApp', 'wood-expert' ); ?></b>
	<span class="sr-only tab:hidden"><?php esc_html_e( 'Scrie-ne pe WhatsApp', 'wood-expert' ); ?></span>
</a>
