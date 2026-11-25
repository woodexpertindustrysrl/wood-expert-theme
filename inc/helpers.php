<?php
/**
 * Funcții ajutătoare: opțiuni temă, iconițe, logo.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

/**
 * Valorile implicite ale setărilor temei. Se pot suprascrie din „Setări temă” (ACF).
 * Datele de contact sunt cele din CLAUDE.md.
 */
function we_defaults(): array {
	return array(
		'phone_label'       => '0732.672.147',
		'phone'             => '+40732672147',
		'email'             => 'office@woodexpert.ro',
		'address'           => 'Str. Albinelor nr. 7, sector 4, 040431 București',
		'topbar_text'       => 'BIFE-SIM 2026: peste 10 utilaje Nanxing testate live',
		'topbar_link_label' => 'Citește articolul →',
		'topbar_link_url'   => '',
		'client_zone_url'   => '',
		'cta_label'         => 'Cere ofertă',
		'cta_url'           => home_url( '/cere-oferta/' ),
		'footer_text'       => 'Principalul furnizor de utilaje pentru prelucrarea lemnului din România, din 2005.',
		'newsletter_label'  => 'Newsletter: montaje, noutăți și utilaje în stoc',
		'whatsapp'          => '',
		'facebook'          => '',
		'instagram'         => '',
		'linkedin'          => '',
		'youtube'           => '',
		'tiktok'            => '',
		'pinterest'         => '',
	);
}

/**
 * Citește o setare din pagina de opțiuni ACF, cu valoare implicită.
 *
 * @param string $key Cheia câmpului.
 * @return mixed
 */
function we_opt( string $key ) {
	static $cache = array();
	if ( array_key_exists( $key, $cache ) ) {
		return $cache[ $key ];
	}

	$defaults = we_defaults();
	$value    = null;

	if ( function_exists( 'get_field' ) ) {
		$value = get_field( 'we_' . $key, 'option' );
	}
	if ( null === $value || '' === $value || false === $value ) {
		$value = $defaults[ $key ] ?? '';
	}

	$cache[ $key ] = $value;
	return $value;
}

/**
 * Transformă un număr de telefon în format pentru link tel: (doar cifre și +).
 *
 * @param string $phone Număr în orice format.
 */
function we_tel( string $phone ): string {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );
}

/**
 * Link WhatsApp din numărul setat (format internațional, fără +).
 */
function we_whatsapp_url(): string {
	$num = preg_replace( '/[^0-9]/', '', (string) we_opt( 'whatsapp' ) );
	return $num ? 'https://wa.me/' . $num : '';
}

/**
 * Iconițe SVG inline (preluate din design/Light.dc.html).
 *
 * @param string $name  Numele iconiței.
 * @param string $class Clase CSS.
 */
function we_icon( string $name, string $class = 'icon' ): string {
	$paths = array(
		'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
		'arrow-right'  => '<path d="M5 12h14M13 6l6 6-6 6"/>',
		'search'       => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
		'menu'         => '<path d="M4 7h16M4 12h16M4 17h10"/>',
		'close'        => '<path d="M6 6l12 12M18 6 6 18"/>',
		'pin'          => '<path d="M12 21s-7-6.2-7-11.5A7 7 0 0 1 19 9.5C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
		'phone'        => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/>',
		'mail'         => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'whatsapp'     => '<path d="M21 11.5a8.4 8.4 0 0 1-12.4 7.4L3 21l2.1-5.4A8.4 8.4 0 1 1 21 11.5z"/>',
	);

	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}

	return sprintf(
		'<svg class="%s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%s</svg>',
		esc_attr( $class ),
		$paths[ $name ]
	);
}

/**
 * Găsește fișierul de logo în assets/logo/. Logo-ul se folosește doar din acest folder,
 * nu se recolorează și nu se reconstruiește cu font (vezi CLAUDE.md).
 *
 * @param string $variant „principal” (fundal deschis) sau „negativ” (fundal închis).
 * @return string Calea relativă în temă sau șir gol dacă lipsește.
 */
function we_logo_file( string $variant = 'principal' ): string {
	$candidates = 'negativ' === $variant
		? array( 'logo-negativ.svg', 'logo-negativ.png', 'logo-alb.svg', 'logo-alb.png' )
		: array( 'logo.svg', 'logo.png', 'logo.webp', 'logo-principal.svg', 'logo-principal.png' );

	$candidates = apply_filters( 'we_logo_candidates', $candidates, $variant );

	foreach ( $candidates as $file ) {
		if ( file_exists( WE_DIR . '/assets/logo/' . $file ) ) {
			return 'assets/logo/' . $file;
		}
	}
	return '';
}

/**
 * Afișează logo-ul. Dacă fișierul lipsește, afișează un spațiu rezervat vizibil
 * (nu reconstruim logo-ul din text).
 *
 * @param string $class   Clase pentru <img>.
 * @param string $variant Varianta de logo.
 */
function we_logo( string $class = 'h-[30px] tab:h-9 w-auto block', string $variant = 'principal' ): void {
	$file = we_logo_file( $variant );
	$alt  = 'Wood Expert – Limitless technology';

	if ( $file ) {
		$size = '';
		$abs  = WE_DIR . '/' . $file;
		if ( ! str_ends_with( $file, '.svg' ) ) {
			$dim = wp_getimagesize( $abs );
			if ( $dim ) {
				$size = sprintf( ' width="%d" height="%d"', $dim[0], $dim[1] );
			}
		}
		printf(
			'<img class="%s" src="%s" alt="%s"%s decoding="async">',
			esc_attr( $class ),
			esc_url( WE_URI . '/' . $file . '?v=' . we_asset_version( $file ) ),
			esc_attr( $alt ),
			$size // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- numere formatate mai sus.
		);
		return;
	}

	printf(
		'<span class="inline-flex items-center h-9 px-3 rounded-lg border border-dashed border-sand-200 text-xs font-semibold text-mut" title="%s"><span class="sr-only">%s</span><span aria-hidden="true">%s</span></span>',
		esc_attr__( 'Adaugă fișierul de logo în assets/logo/', 'wood-expert' ),
		esc_html( $alt ),
		esc_html__( 'Logo lipsă: assets/logo/', 'wood-expert' )
	);
}
