<?php
/**
 * Bara maro de sus: anunț și date de contact.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

$text       = (string) we_opt( 'topbar_text' );
$link_url   = (string) we_opt( 'topbar_link_url' );
$link_label = (string) we_opt( 'topbar_link_label' );
$zone_url   = (string) we_opt( 'client_zone_url' );
?>
<div class="bg-maro text-cr text-sm">
	<div class="wrap flex justify-between items-center gap-4 min-h-11 py-2">
		<div class="flex gap-4 items-center min-w-0">
			<?php if ( $text ) : ?>
				<span class="min-w-0"><i class="inline-block size-[7px] rounded-full bg-vd mr-2 align-middle" aria-hidden="true"></i><?php echo esc_html( $text ); ?></span>
			<?php endif; ?>
			<?php if ( $text && $link_url ) : ?>
				<a class="hidden tab:inline shrink-0 text-cr font-medium underline underline-offset-2 hover:text-white" href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $link_label ); ?></a>
			<?php endif; ?>
		</div>
		<div class="flex gap-5 items-center shrink-0">
			<a class="text-cr font-medium hover:text-white" href="<?php echo esc_attr( we_tel( (string) we_opt( 'phone' ) ) ); ?>"><?php echo esc_html( we_opt( 'phone_label' ) ); ?></a>
			<a class="hidden tab:inline text-cr font-medium hover:text-white" href="mailto:<?php echo esc_attr( antispambot( (string) we_opt( 'email' ) ) ); ?>"><?php echo esc_html( antispambot( (string) we_opt( 'email' ) ) ); ?></a>
			<?php if ( $zone_url ) : ?>
				<a class="hidden tab:inline text-cr font-medium hover:text-white" href="<?php echo esc_url( $zone_url ); ?>"><?php esc_html_e( 'Zonă clienți', 'wood-expert' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>
