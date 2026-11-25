<?php
/**
 * Subsolul site-ului.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

// Coloanele de linkuri: din meniurile WordPress, cu structura din design ca rezervă.
// Lista de producători trebuie verificată cu docs/producatori.md (vezi docs/progres.md).
$columns = array(
	we_footer_column(
		'footer-primara',
		'Prelucrare primară',
		array( 'Linii debitare bușteni', 'Fierăstraie multilamă', 'Optimizare și sortare cherestea', 'Uscătoare cherestea', 'Cazane industriale', 'Linii de paleți' )
	),
	we_footer_column(
		'footer-secundara',
		'Secundară și PAL/MDF',
		array( 'Mașini de aplicat cant', 'CNC de găurit pe 6 laturi', 'CNC nesting', 'Mașini clasice de tâmplărie', 'Linii de peleți', 'Linii glulam și CLT' )
	),
	we_footer_column(
		'footer-producatori',
		'Exclusivitate',
		array( 'Nanxing', 'Primultini', 'Paul Maschinenfabrik', 'Baschild', 'Giardina Group', 'O.M.A.R.', 'Nova Pellet', 'Wravor' )
	),
);
$company = we_footer_column( 'footer-companie', 'Companie', array( 'Despre noi', 'Expoziții și târguri', 'Wood Cademy', 'Cataloage' ) );
$legal   = we_footer_column( 'legal', 'Legal', array( 'Termeni și condiții', 'Politica cookie', 'Sitemap', 'Contact' ) );

$address = (string) we_opt( 'address' );
$email   = antispambot( (string) we_opt( 'email' ) );
$maps    = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $address );
$waze    = 'https://waze.com/ul?q=' . rawurlencode( $address ) . '&navigate=yes';

$socials = array_filter(
	array(
		'Facebook'  => array( 'Fb', we_opt( 'facebook' ) ),
		'Instagram' => array( 'Ig', we_opt( 'instagram' ) ),
		'LinkedIn'  => array( 'In', we_opt( 'linkedin' ) ),
		'YouTube'   => array( 'Yt', we_opt( 'youtube' ) ),
		'TikTok'    => array( 'Tk', we_opt( 'tiktok' ) ),
		'Pinterest' => array( 'Pi', we_opt( 'pinterest' ) ),
	),
	static fn( $s ) => ! empty( $s[1] )
);

$link_cls = 'text-tx-2 text-[15px] font-medium hover:text-tx';
$h_cls    = 'mt-1 mb-4 text-sm font-semibold text-mut';
?>
<footer class="mt-24 border-t border-line bg-sand-50">
	<div class="wrap">
		<div class="grid grid-cols-1 tab:grid-cols-2 desk:grid-cols-[minmax(0,1.3fr)_repeat(4,minmax(0,1fr))] gap-10 pt-12 pb-8 tab:pt-16 tab:pb-12">

			<div class="tab:col-span-full desk:col-span-1">
				<a class="inline-block" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Wood Expert Industry – acasă', 'wood-expert' ); ?>">
					<?php we_logo( 'h-[42px] w-auto block' ); ?>
				</a>
				<p class="mt-4.5 mb-5.5 max-w-80 text-[15px] text-mut"><?php echo esc_html( we_opt( 'footer_text' ) ); ?></p>

				<form class="max-w-95" x-data="weNewsletter" @submit.prevent="submit()" novalidate>
					<label class="block mb-2 text-sm font-semibold text-tx" for="nl-mail"><?php echo esc_html( we_opt( 'newsletter_label' ) ); ?></label>
					<div class="flex gap-2">
						<input id="nl-mail" class="field flex-1 min-w-0 text-sm" type="email" name="email" autocomplete="email" placeholder="<?php esc_attr_e( 'Adresa ta de e-mail', 'wood-expert' ); ?>">
						<button class="btn btn-primary px-4 text-sm" type="submit"><?php esc_html_e( 'Abonează-te', 'wood-expert' ); ?></button>
					</div>
					<p class="mt-2 text-[13px] text-mut" x-show="notice" x-cloak role="status"><?php esc_html_e( 'Abonarea la newsletter va fi disponibilă în curând.', 'wood-expert' ); ?></p>
				</form>
			</div>

			<?php foreach ( $columns as $col ) : ?>
				<div>
					<h2 class="<?php echo esc_attr( $h_cls ); ?>"><?php echo esc_html( $col['heading'] ); ?></h2>
					<ul class="flex flex-col gap-3">
						<?php foreach ( $col['links'] as $l ) : ?>
							<li><a class="<?php echo esc_attr( $link_cls ); ?>" href="<?php echo esc_url( $l['url'] ); ?>"><?php echo esc_html( $l['label'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>

			<div>
				<h2 class="<?php echo esc_attr( $h_cls ); ?>"><?php esc_html_e( 'Contact', 'wood-expert' ); ?></h2>
				<ul class="flex flex-col gap-3 text-sm text-tx-2">
					<li class="flex gap-2.5">
						<?php echo we_icon( 'pin', 'icon mt-0.5 text-mut' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><?php echo esc_html( $address ); ?></span>
					</li>
					<li class="flex gap-2.5">
						<?php echo we_icon( 'phone', 'icon mt-0.5 text-mut' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<a class="text-tx-2 hover:text-tx" href="<?php echo esc_attr( we_tel( (string) we_opt( 'phone' ) ) ); ?>"><?php echo esc_html( we_opt( 'phone_label' ) ); ?></a>
					</li>
					<li class="flex gap-2.5">
						<?php echo we_icon( 'mail', 'icon mt-0.5 text-mut' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<a class="text-tx-2 hover:text-tx" href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
					</li>
					<li class="flex gap-3.5 pl-7">
						<a class="text-tx-2 hover:text-tx underline underline-offset-2" href="<?php echo esc_url( $maps ); ?>" target="_blank" rel="noopener">Google Maps</a>
						<a class="text-tx-2 hover:text-tx underline underline-offset-2" href="<?php echo esc_url( $waze ); ?>" target="_blank" rel="noopener">Waze</a>
					</li>
				</ul>

				<h2 class="<?php echo esc_attr( $h_cls ); ?> mt-7"><?php echo esc_html( $company['heading'] ); ?></h2>
				<ul class="flex flex-col gap-3">
					<?php foreach ( $company['links'] as $l ) : ?>
						<li><a class="<?php echo esc_attr( $link_cls ); ?>" href="<?php echo esc_url( $l['url'] ); ?>"><?php echo esc_html( $l['label'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<div class="flex flex-wrap justify-between items-center gap-6 py-6 border-t border-sand-200">
			<?php if ( $socials ) : ?>
				<ul class="flex gap-2">
					<?php foreach ( $socials as $name => $s ) : ?>
						<li>
							<a class="flex items-center justify-center size-11 rounded-[10px] border border-sand-200 bg-white text-xs font-bold text-mut shadow-xs hover:bg-maro hover:border-maro hover:text-white" href="<?php echo esc_url( $s[1] ); ?>" target="_blank" rel="noopener">
								<span aria-hidden="true"><?php echo esc_html( $s[0] ); ?></span>
								<span class="sr-only"><?php echo esc_html( $name ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<div class="flex flex-wrap gap-2">
				<a class="px-3 py-2.5 rounded-lg border border-sand-200 bg-white text-xs text-tx-2" href="https://anpc.ro/ce-este-sal/" target="_blank" rel="noopener nofollow"><?php esc_html_e( 'ANPC – Soluționarea alternativă a litigiilor', 'wood-expert' ); ?></a>
				<a class="px-3 py-2.5 rounded-lg border border-sand-200 bg-white text-xs text-tx-2" href="https://ec.europa.eu/consumers/odr" target="_blank" rel="noopener nofollow"><?php esc_html_e( 'Soluționarea online a litigiilor (UE)', 'wood-expert' ); ?></a>
			</div>
		</div>

		<div class="flex flex-wrap justify-between gap-4 pt-6 pb-9 border-t border-sand-200 text-sm text-mut">
			<span>
				<?php
				/* translators: %s: anul curent */
				printf( esc_html__( '© %s Wood Expert Industry SRL. Toate drepturile rezervate.', 'wood-expert' ), esc_html( wp_date( 'Y' ) ) );
				?>
			</span>
			<nav class="flex flex-wrap gap-5" aria-label="<?php esc_attr_e( 'Legal', 'wood-expert' ); ?>">
				<?php foreach ( $legal['links'] as $l ) : ?>
					<a class="text-mut hover:text-tx" href="<?php echo esc_url( $l['url'] ); ?>"><?php echo esc_html( $l['label'] ); ?></a>
				<?php endforeach; ?>
			</nav>
		</div>
	</div>
	<div class="outline-word overflow-hidden whitespace-nowrap select-none pt-4 text-center text-[clamp(60px,15vw,210px)] font-extrabold leading-[.8] tracking-[-.06em]" aria-hidden="true">WOOD EXPERT</div>
</footer>
