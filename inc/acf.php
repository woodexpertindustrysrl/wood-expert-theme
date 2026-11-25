<?php
/**
 * ACF Pro: pagina „Setări temă” și câmpurile pentru mega-meniu.
 * Câmpurile sunt înregistrate din cod, ca să fie versionate în Git.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'acf/init',
	function () {
		if ( ! function_exists( 'acf_add_options_page' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_options_page(
			array(
				'page_title' => __( 'Setări temă Wood Expert', 'wood-expert' ),
				'menu_title' => __( 'Setări temă', 'wood-expert' ),
				'menu_slug'  => 'we-settings',
				'capability' => 'manage_options',
				'icon_url'   => 'dashicons-admin-customizer',
				'position'   => 59,
				'redirect'   => false,
			)
		);

		$d = we_defaults();

		$text = static function ( string $key, string $label, string $instructions = '', string $type = 'text' ) use ( $d ) {
			return array(
				'key'          => 'field_we_' . $key,
				'name'         => 'we_' . $key,
				'label'        => $label,
				'type'         => $type,
				'instructions' => $instructions,
				'placeholder'  => is_string( $d[ $key ] ?? null ) ? $d[ $key ] : '',
			);
		};

		$tab = static function ( string $key, string $label ) {
			return array(
				'key'   => 'field_we_tab_' . $key,
				'label' => $label,
				'type'  => 'tab',
			);
		};

		acf_add_local_field_group(
			array(
				'key'      => 'group_we_settings',
				'title'    => __( 'Setări temă', 'wood-expert' ),
				'fields'   => array(
					$tab( 'contact', 'Contact' ),
					$text( 'phone_label', 'Telefon (afișat)', 'Ex.: 0732.672.147' ),
					$text( 'phone', 'Telefon (pentru apel)', 'Format internațional, ex.: +40732672147' ),
					$text( 'email', 'E-mail', '', 'email' ),
					$text( 'address', 'Adresă' ),
					$text( 'whatsapp', 'Număr WhatsApp', 'Format internațional, ex.: +40732672147. Gol = butonul plutitor WhatsApp nu se afișează.' ),

					$tab( 'topbar', 'Bara de sus' ),
					$text( 'topbar_text', 'Anunț', 'Textul din bara maro de sus. Gol = se folosește textul implicit.' ),
					$text( 'topbar_link_label', 'Text link anunț' ),
					$text( 'topbar_link_url', 'URL link anunț', 'Gol = linkul nu se afișează.', 'url' ),
					$text( 'client_zone_url', 'URL „Zonă clienți”', 'Gol = linkul nu se afișează.', 'url' ),

					$tab( 'header', 'Header' ),
					$text( 'cta_label', 'Text buton CTA' ),
					$text( 'cta_url', 'URL buton CTA', 'Pagina formularului de ofertă.', 'url' ),

					$tab( 'footer', 'Subsol' ),
					$text( 'footer_text', 'Descriere sub logo', '', 'textarea' ),
					$text( 'newsletter_label', 'Titlu newsletter' ),

					$tab( 'social', 'Rețele sociale' ),
					$text( 'facebook', 'Facebook', '', 'url' ),
					$text( 'instagram', 'Instagram', '', 'url' ),
					$text( 'linkedin', 'LinkedIn', '', 'url' ),
					$text( 'youtube', 'YouTube', '', 'url' ),
					$text( 'tiktok', 'TikTok', '', 'url' ),
					$text( 'pinterest', 'Pinterest', '', 'url' ),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'we-settings',
						),
					),
				),
			)
		);

		// Câmpuri pe elementele meniului principal: panoul din dreapta al mega-meniului.
		acf_add_local_field_group(
			array(
				'key'      => 'group_we_mega',
				'title'    => __( 'Mega-meniu', 'wood-expert' ),
				'fields'   => array(
					array(
						'key'          => 'field_we_mega_image',
						'name'         => 'we_mega_image',
						'label'        => 'Imagine card',
						'type'         => 'image',
						'return_format' => 'id',
						'preview_size' => 'thumbnail',
						'instructions' => 'Doar pentru elementele de nivel 1 care au subelemente.',
					),
					array(
						'key'   => 'field_we_mega_chip',
						'name'  => 'we_mega_chip',
						'label' => 'Etichetă card',
						'type'  => 'text',
						'placeholder' => 'Ex.: Bușteni și cherestea',
					),
					array(
						'key'   => 'field_we_mega_title',
						'name'  => 'we_mega_title',
						'label' => 'Titlu card',
						'type'  => 'text',
						'placeholder' => 'Ex.: Fabrici de cherestea echipate complet',
					),
					array(
						'key'          => 'field_we_menu_badge',
						'name'         => 'we_menu_badge',
						'label'        => 'Badge (subelemente)',
						'type'         => 'text',
						'instructions' => 'Opțional. Gol = pentru categoriile de produse se afișează automat numărul de produse.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'nav_menu_item',
							'operator' => '==',
							'value'    => 'location/primary',
						),
					),
				),
			)
		);
	}
);
