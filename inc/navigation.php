<?php
/**
 * Datele de navigare: meniul principal (mega-meniu + drawer) și coloanele din subsol.
 *
 * Meniurile se administrează din Aspect → Meniuri. Cât timp o locație nu are meniu,
 * se afișează structura din design (design/Light.dc.html), cu linkuri „#”.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

/**
 * Structura meniului principal, normalizată:
 * [
 *   [ 'label', 'url', 'current', 'children' => [ [ 'label', 'url', 'badge', 'current' ] ],
 *     'feature' => [ 'image_id', 'image_url', 'chip', 'title' ] ],
 * ]
 */
function we_primary_nav(): array {
	static $nav = null;
	if ( null !== $nav ) {
		return $nav;
	}

	$nav = we_nav_from_location( 'primary' );
	if ( null === $nav ) {
		$nav = we_primary_nav_fallback();
	}

	return $nav = apply_filters( 'we_primary_nav', $nav );
}

/**
 * Construiește arborele (2 niveluri) din meniul atribuit unei locații.
 *
 * @param string $location Locația meniului.
 * @return array|null Null dacă locația nu are meniu atribuit.
 */
function we_nav_from_location( string $location ): ?array {
	$locations = get_nav_menu_locations();
	if ( empty( $locations[ $location ] ) ) {
		return null;
	}

	$items = wp_get_nav_menu_items( $locations[ $location ], array( 'update_post_term_cache' => false ) );
	if ( ! $items ) {
		return null;
	}

	_wp_menu_item_classes_by_context( $items ); // Marchează elementele curente.

	$has_acf = function_exists( 'get_field' );
	$tree    = array();
	$by_id   = array();

	foreach ( $items as $item ) {
		if ( (int) $item->menu_item_parent === 0 ) {
			$feature = array(
				'image_id'  => 0,
				'image_url' => '',
				'chip'      => '',
				'title'     => '',
			);
			if ( $has_acf ) {
				$feature['image_id'] = (int) get_field( 'we_mega_image', $item->ID );
				$feature['chip']     = (string) get_field( 'we_mega_chip', $item->ID );
				$feature['title']    = (string) get_field( 'we_mega_title', $item->ID );
			}

			$by_id[ $item->ID ] = count( $tree );
			$tree[]             = array(
				'label'    => $item->title,
				'url'      => $item->url,
				'current'  => (bool) ( $item->current || $item->current_item_ancestor ),
				'children' => array(),
				'feature'  => $feature,
			);
		}
	}

	foreach ( $items as $item ) {
		$parent = (int) $item->menu_item_parent;
		if ( $parent && isset( $by_id[ $parent ] ) ) {
			$badge = $has_acf ? (string) get_field( 'we_menu_badge', $item->ID ) : '';
			if ( '' === $badge && 'taxonomy' === $item->type ) {
				$term = get_term( (int) $item->object_id, $item->object );
				if ( $term && ! is_wp_error( $term ) && $term->count > 0 ) {
					$badge = (string) $term->count;
				}
			}

			$tree[ $by_id[ $parent ] ]['children'][] = array(
				'label'   => $item->title,
				'url'     => $item->url,
				'badge'   => $badge,
				'current' => (bool) $item->current,
			);
		}
	}

	return $tree;
}

/**
 * Structura din design, folosită până se configurează meniul în WordPress.
 */
function we_primary_nav_fallback(): array {
	$mega = static function ( string $label, string $chip, string $title, array $cats ): array {
		return array(
			'label'    => $label,
			'url'      => '#',
			'current'  => false,
			'children' => array_map(
				static fn( $c ) => array(
					'label'   => $c[0],
					'url'     => '#',
					'badge'   => (string) $c[1],
					'current' => false,
				),
				$cats
			),
			'feature'  => array(
				'image_id'  => 0,
				'image_url' => '',
				'chip'      => $chip,
				'title'     => $title,
			),
		);
	};

	$link = static fn( string $label ) => array(
		'label'    => $label,
		'url'      => '#',
		'current'  => false,
		'children' => array(),
		'feature'  => array(),
	);

	return array(
		$mega(
			'Prelucrare primară',
			'Bușteni și cherestea',
			'Fabrici de cherestea echipate complet',
			array(
				array( 'Linii debitare bușteni', 15 ),
				array( 'Fierăstraie circulare multilamă', 15 ),
				array( 'Optimizatoare și linii de sortare', 7 ),
				array( 'Uscătoare cherestea', 5 ),
				array( 'Cazane industriale', 5 ),
				array( 'Tocătoare resturi lemnoase', 4 ),
				array( 'Decojitoare bușteni', 3 ),
				array( 'Instalații de exhaustare', 3 ),
				array( 'Linii producție paleți', 3 ),
				array( 'Camere de aburire', 2 ),
			)
		),
		$mega(
			'Prelucrare secundară',
			'Tâmplărie și biomasă',
			'Tâmplărie, prese, peleți, glulam și CLT',
			array(
				array( 'Mașini clasice de tâmplărie', 41 ),
				array( 'Prese lemn și tâmplărie', 22 ),
				array( 'Mașini de calibrat și șlefuit', 14 ),
				array( 'Linii producție peleți', 11 ),
				array( 'Fierăstraie panglică de tâmplărie', 10 ),
				array( 'Linii producție glulam', 9 ),
				array( 'Linii de îmbinat în dinți', 5 ),
				array( 'Linii producție CLT', 3 ),
				array( 'Prese brichete rumeguș', 2 ),
			)
		),
		$mega(
			'PAL / MDF',
			'Nanxing · exclusivitate',
			'Fabrici de mobilă PAL și MDF, linii complete Nanxing',
			array(
				array( 'Roboți de vopsire prin pulverizare', 19 ),
				array( 'Mașini de aplicat cant', 16 ),
				array( 'CNC de găurit pe 6 laturi', 11 ),
				array( 'Circulare de formatizat în pachet', 8 ),
				array( 'Mașini de uscare cu aer cald', 8 ),
				array( 'CNC nesting', 4 ),
				array( 'Circulare cu masă mobilă și incizor', 2 ),
			)
		),
		$link( 'Utilaje în stoc' ),
		$link( 'Producători' ),
		$link( 'Noutăți' ),
		$link( 'Contact' ),
	);
}

/**
 * Coloană din subsol: titlul (numele meniului) și linkurile.
 *
 * @param string $location         Locația meniului.
 * @param string $fallback_heading Titlu implicit.
 * @param array  $fallback_links   Etichete implicite (din design).
 * @return array{heading:string, links:array<int,array{label:string,url:string}>}
 */
function we_footer_column( string $location, string $fallback_heading, array $fallback_links ): array {
	$locations = get_nav_menu_locations();

	if ( ! empty( $locations[ $location ] ) ) {
		$menu  = wp_get_nav_menu_object( $locations[ $location ] );
		$items = wp_get_nav_menu_items( $locations[ $location ], array( 'update_post_term_cache' => false ) );
		if ( $menu && $items ) {
			$links = array();
			foreach ( $items as $item ) {
				if ( (int) $item->menu_item_parent === 0 ) {
					$links[] = array(
						'label' => $item->title,
						'url'   => $item->url,
					);
				}
			}
			return array(
				'heading' => $menu->name,
				'links'   => $links,
			);
		}
	}

	return array(
		'heading' => $fallback_heading,
		'links'   => array_map(
			static fn( $label ) => array(
				'label' => $label,
				'url'   => '#',
			),
			$fallback_links
		),
	);
}

/**
 * Imaginea cardului din mega-meniu.
 *
 * @param array $feature Datele cardului.
 */
function we_mega_image( array $feature ): string {
	if ( ! empty( $feature['image_id'] ) ) {
		return wp_get_attachment_image(
			$feature['image_id'],
			'medium_large',
			false,
			array(
				'class'    => 'absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-105',
				'alt'      => '',
				'loading'  => 'lazy',
				'decoding' => 'async',
				'sizes'    => '340px',
			)
		);
	}
	if ( ! empty( $feature['image_url'] ) ) {
		return sprintf(
			'<img class="absolute inset-0 size-full object-cover" src="%s" alt="" loading="lazy" decoding="async">',
			esc_url( $feature['image_url'] )
		);
	}
	return '';
}
