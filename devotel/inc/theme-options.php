<?php
/**
 * Theme options helpers and integration hooks.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default footer brand description (matches footer extract).
 */
function devotel_get_default_site_tagline() {
	return 'Innovating in the telecommunications sector since 2018, Devotel specialises in delivering comprehensive communication and connectivity solutions globally.';
}

/**
 * Default copyright string with year token.
 */
function devotel_get_default_footer_copyright() {
	return '© {year} Devotel LTD. All rights reserved.';
}

/**
 * Read a theme option from ACF with a string default.
 *
 * @param string $key     Field name.
 * @param string $default Default when empty.
 * @return string
 */
function devotel_get_theme_option( $key, $default = '' ) {
	$key = (string) $key;
	if ( '' === $key ) {
		return (string) $default;
	}

	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $key, 'option' );
		if ( is_string( $value ) && '' !== trim( $value ) ) {
			return trim( $value );
		}
		if ( is_numeric( $value ) && '' !== (string) $value ) {
			return (string) $value;
		}
	}

	return (string) $default;
}

/**
 * Replace {year} token in theme strings.
 *
 * @param string $text Input text.
 * @return string
 */
function devotel_replace_year_token( $text ) {
	$text = (string) $text;
	if ( '' === $text ) {
		return '';
	}

	return str_replace( '{year}', (string) gmdate( 'Y' ), $text );
}

/**
 * Resolve header logo URL for the current request.
 *
 * @param bool|null $is_home Force homepage variant. Null = detect from query.
 * @return string
 */
function devotel_get_header_logo_url( $is_home = null ) {
	$uploads_base = trailingslashit( (string) wp_upload_dir()['baseurl'] );
	$fallback     = $uploads_base . '2025/12/Group-20.png';

	$field = 'devotel_logo_default';

	if ( function_exists( 'get_field' ) ) {
		$image = get_field( $field, 'option' );
		if ( is_string( $image ) && '' !== trim( $image ) ) {
			return esc_url( $image );
		}
		if ( is_array( $image ) && ! empty( $image['url'] ) ) {
			return esc_url( (string) $image['url'] );
		}
		if ( is_numeric( $image ) ) {
			$url = wp_get_attachment_url( (int) $image );
			if ( is_string( $url ) && '' !== $url ) {
				return esc_url( $url );
			}
		}
	}

	return esc_url( $fallback );
}

/**
 * Resolve header CTA destination URL.
 *
 * @return string
 */
function devotel_get_header_cta_url() {
	$direct = devotel_get_theme_option( 'devotel_header_cta_url' );
	if ( '' !== $direct ) {
		return esc_url( $direct );
	}

	if ( function_exists( 'get_field' ) ) {
		$page_url = get_field( 'devotel_default_contact_page', 'option' );
		if ( is_string( $page_url ) && '' !== trim( $page_url ) ) {
			return esc_url( $page_url );
		}
		if ( is_numeric( $page_url ) ) {
			$permalink = get_permalink( (int) $page_url );
			if ( is_string( $permalink ) && '' !== $permalink ) {
				return esc_url( $permalink );
			}
		}
	}

	return esc_url( home_url( '/contact-us/' ) );
}

/**
 * Whether the header CTA should open in a new tab.
 *
 * @return bool
 */
function devotel_header_cta_opens_new_tab() {
	if ( ! function_exists( 'get_field' ) ) {
		return false;
	}

	return (bool) get_field( 'devotel_header_cta_open_new_tab', 'option' );
}

/**
 * Site-wide contact defaults for templates.
 *
 * @return array<string, string>
 */
function devotel_get_contact_defaults() {
	$defaults = array(
		'sales_email'    => devotel_get_theme_option( 'devotel_sales_email' ),
		'support_email'  => devotel_get_theme_option( 'devotel_support_email' ),
		'phone_display'  => devotel_get_theme_option( 'devotel_phone_display' ),
		'phone_tel'      => devotel_get_theme_option( 'devotel_phone_tel' ),
		'contact_url'    => devotel_get_header_cta_url(),
		'header_cta_text' => devotel_get_theme_option( 'devotel_header_cta_text', 'Talk to an expert' ),
	);

	/**
	 * Filter contact defaults exposed by the theme.
	 *
	 * @param array<string, string> $defaults Contact defaults.
	 */
	return apply_filters( 'devotel_contact_defaults', $defaults );
}

/**
 * Apply header extract overrides from theme options.
 *
 * @param string $markup Header HTML.
 * @return string
 */
function devotel_apply_header_theme_options( $markup ) {
	$markup = (string) $markup;
	if ( '' === $markup ) {
		return '';
	}

	$logo_url  = devotel_get_header_logo_url();
	$cta_text  = devotel_get_theme_option( 'devotel_header_cta_text', 'Talk to an expert' );
	$cta_url   = devotel_get_header_cta_url();
	$new_tab   = devotel_header_cta_opens_new_tab();

	$markup = preg_replace(
		'/(<img[^>]*class="header-logo-svg"[^>]*\bsrc=")[^"]*(")/i',
		'$1' . $logo_url . '$2',
		$markup,
		1
	);
	$markup = preg_replace(
		'/(<img[^>]*class="header-logo-svg"[^>]*\bdata-src=")[^"]*(")/i',
		'$1' . $logo_url . '$2',
		$markup,
		1
	);

	if ( '' !== $cta_text ) {
		$markup = str_replace( 'Talk to an expert', esc_html( $cta_text ), $markup );
	}

	if ( '' !== $cta_url ) {
		$markup = preg_replace(
			'/(<a\s+href=")[^"]*("(?:\s+[^>]*)?>\s*<div\s+class="header-talk-to-an-expert-wrapper")/i',
			'$1' . $cta_url . '$2',
			$markup,
			1
		);
		$markup = preg_replace(
			'/(<a\s+href=")[^"]*("(?:\s+[^>]*)?>\s*<button\s+class="mobile-menu-button-primary")/i',
			'$1' . $cta_url . '$2',
			$markup,
			1
		);
	}

	if ( $new_tab ) {
		$markup = preg_replace(
			'/(<a\s+href="' . preg_quote( $cta_url, '/' ) . '")(?![^>]*\btarget=)/i',
			'$1 target="_blank" rel="noopener noreferrer"',
			$markup
		);
	}

	return $markup;
}

/**
 * Build footer social link HTML from theme options.
 *
 * @return string
 */
function devotel_build_footer_social_markup() {
	if ( ! function_exists( 'have_rows' ) || ! have_rows( 'devotel_footer_social_links', 'option' ) ) {
		return '';
	}

	$items = '';
	while ( have_rows( 'devotel_footer_social_links', 'option' ) ) {
		the_row();
		$network   = (string) get_sub_field( 'network' );
		$url       = trim( (string) get_sub_field( 'url' ) );
		$aria      = trim( (string) get_sub_field( 'aria_label' ) );
		if ( '' === $url ) {
			continue;
		}

		if ( 'linkedin' === $network ) {
			$url = 'https://www.linkedin.com/company/devotel';
		}

		if ( '' === $aria ) {
			$aria = ucfirst( $network );
		}

		$inner = esc_html( $aria );
		if ( 'linkedin' === $network ) {
			$inner = '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M16.6676 0H1.32891C0.594141 0 0 0.580078 0 1.29727V16.6992C0 17.4164 0.594141 18 1.32891 18H16.6676C17.4023 18 18 17.4164 18 16.7027V1.29727C18 0.580078 17.4023 0 16.6676 0ZM5.34023 15.3387H2.66836V6.74648H5.34023V15.3387ZM4.0043 5.57578C3.14648 5.57578 2.45391 4.8832 2.45391 4.02891C2.45391 3.17461 3.14648 2.48203 4.0043 2.48203C4.85859 2.48203 5.55117 3.17461 5.55117 4.02891C5.55117 4.87969 4.85859 5.57578 4.0043 5.57578ZM15.3387 15.3387H12.6703V11.1621C12.6703 10.1672 12.6527 8.88398 11.2816 8.88398C9.89297 8.88398 9.68203 9.97031 9.68203 11.0918V15.3387H7.01719V6.74648H9.57656V7.9207H9.61172C9.9668 7.2457 10.8387 6.53203 12.1359 6.53203C14.8395 6.53203 15.3387 8.31094 15.3387 10.6242V15.3387Z" fill="#62748e"/></svg>';
		}

		$items .= '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer" class="devotel-footer-social-link" aria-label="' . esc_attr( $aria ) . '">' . $inner . '</a>';
	}

	return $items;
}

/**
 * Build footer legal links HTML from theme options.
 *
 * @return string
 */
function devotel_build_footer_legal_links_markup() {
	if ( ! function_exists( 'have_rows' ) || ! have_rows( 'devotel_footer_legal_links', 'option' ) ) {
		return '';
	}

	$known = array(
		'privacy policy' => 'https://devotel.com/privacy-policy/',
		'brand kit'      => 'https://devotel.com/brand-kit/',
	);

	$links = '';
	while ( have_rows( 'devotel_footer_legal_links', 'option' ) ) {
		the_row();
		$label = trim( (string) get_sub_field( 'label' ) );
		$url   = trim( (string) get_sub_field( 'url' ) );
		if ( '' === $label || '' === $url ) {
			continue;
		}
		$key = strtolower( $label );
		if ( isset( $known[ $key ] ) ) {
			$url = $known[ $key ];
		}
		$links .= '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
	}

	return $links;
}

/**
 * Apply footer extract overrides from theme options.
 *
 * @param string $markup Footer HTML.
 * @return string
 */
function devotel_apply_footer_theme_options( $markup ) {
	$markup = (string) $markup;
	if ( '' === $markup ) {
		return '';
	}

	$tagline = devotel_get_theme_option( 'devotel_site_tagline', devotel_get_default_site_tagline() );
	if ( '' !== $tagline ) {
		$markup = str_replace( devotel_get_default_site_tagline(), esc_html( $tagline ), $markup );
	}

	$newsletter_title = devotel_get_theme_option( 'devotel_footer_newsletter_title', 'Devotel Newsletter' );
	if ( '' !== $newsletter_title ) {
		$markup = str_replace( 'Devotel Newsletter', esc_html( $newsletter_title ), $markup );
	}

	$newsletter_text = devotel_get_theme_option( 'devotel_footer_newsletter_text', 'The latest experience tips and trends. No spam!' );
	if ( '' !== $newsletter_text ) {
		$markup = str_replace( 'The latest experience tips and trends. No spam!', esc_html( $newsletter_text ), $markup );
	}

	$newsletter_form = devotel_get_theme_option( 'devotel_newsletter_shortcode' );
	if ( '' !== $newsletter_form && function_exists( 'do_shortcode' ) ) {
		$newsletter_html = trim( (string) do_shortcode( $newsletter_form ) );
		if ( '' !== $newsletter_html ) {
			$markup = preg_replace(
				'/<div\s+class="wpcf7 no-js"[\s\S]*?<\/form><\/div>/i',
				$newsletter_html,
				$markup,
				1
			);
		}
	}

	$copyright = devotel_replace_year_token(
		devotel_get_theme_option( 'devotel_footer_copyright', devotel_get_default_footer_copyright() )
	);
	if ( '' !== $copyright ) {
		$markup = preg_replace(
			'/<div class="devotel-footer-copyright">[\s\S]*?<\/div>/i',
			'<div class="devotel-footer-copyright">' . esc_html( $copyright ) . '</div>',
			$markup,
			1
		);
	}

	if ( function_exists( 'get_field' ) ) {
		$external = get_field( 'devotel_footer_external_links', 'option' );
		if ( is_array( $external ) ) {
			$esimora = trim( (string) ( $external['esimora_url'] ?? '' ) );
			$devhub  = trim( (string) ( $external['devhub_url'] ?? '' ) );
			if ( '' !== $esimora ) {
				$markup = preg_replace(
					'/(<a\s+href=")[^"]*esimora\.com[^"]*(">Esimora<\/a>)/i',
					'$1' . esc_url( $esimora ) . '$2',
					$markup,
					1
				);
			}
			if ( '' !== $devhub ) {
				$markup = preg_replace(
					'/(<a\s+href=")[^"]*hub\.devotel\.com[^"]*(">Devhub<\/a>)/i',
					'$1' . esc_url( $devhub ) . '$2',
					$markup,
					1
				);
			}
		}
	}

	$social_markup = devotel_build_footer_social_markup();
	if ( '' !== $social_markup ) {
		$markup = preg_replace(
			'/<div class="devotel-footer-social">\s*[\s\S]*?\s*<\/div>/i',
			'<div class="devotel-footer-social">' . $social_markup . '</div>',
			$markup,
			1
		);
	}

	$legal_links = devotel_build_footer_legal_links_markup();
	if ( '' !== $legal_links ) {
		$markup = preg_replace(
			'/(<div class="devotel-footer-copyright">[\s\S]*?<\/div>)\s*<a href="[^"]*">Privacy Policy<\/a>\s*<a href="[^"]*">Brand Kit<\/a>/i',
			'$1' . $legal_links,
			$markup,
			1
		);
	}

	return $markup;
}

/**
 * Live frontend values used to pre-populate Theme Settings.
 *
 * @return array<string, mixed>
 */
function devotel_get_theme_options_seed_data() {
	$uploads_base = trailingslashit( (string) wp_upload_dir()['baseurl'] );
	$contact_page = get_page_by_path( 'contact-us' );
	$contact_url  = ( $contact_page instanceof WP_Post ) ? get_permalink( $contact_page ) : home_url( '/contact-us/' );

	$logo_default_url = $uploads_base . '2025/12/Group-20.png';
	$logo_home_url    = $uploads_base . '2025/12/Group-20-2.png';
	$logo_default_id  = attachment_url_to_postid( $logo_default_url );
	$logo_home_id     = attachment_url_to_postid( $logo_home_url );

	return array(
		'devotel_site_tagline'            => devotel_get_default_site_tagline(),
		'devotel_logo_default'            => $logo_default_id ? $logo_default_id : $logo_default_url,
		'devotel_logo_home'               => $logo_home_id ? $logo_home_id : $logo_home_url,
		'devotel_header_cta_text'         => 'Talk to an expert',
		'devotel_header_cta_url'          => '',
		'devotel_header_cta_open_new_tab' => 0,
		'devotel_default_contact_page'    => is_string( $contact_url ) ? $contact_url : home_url( '/contact-us/' ),
		'devotel_sales_email'             => 'sales@devotel.com',
		'devotel_phone_display'           => '+1 (919) 263 24 06',
		'devotel_phone_tel'               => '+19192632406',
		'devotel_footer_newsletter_title' => 'Devotel Newsletter',
		'devotel_footer_newsletter_text'  => 'The latest experience tips and trends. No spam!',
		'devotel_newsletter_shortcode'    => '[contact-form-7 id="9119" title="Newsletter"]',
		'devotel_footer_copyright'        => devotel_get_default_footer_copyright(),
		'devotel_footer_social_links'     => array(
			array(
				'network'    => 'linkedin',
				'url'        => 'https://www.linkedin.com/company/devotel',
				'aria_label' => 'LinkedIn',
			),
		),
		'devotel_footer_external_links'   => array(
			'esimora_url' => 'https://esimora.com/',
			'devhub_url'  => 'https://hub.devotel.com/#home',
		),
		'devotel_footer_legal_links'      => array(
			array(
				'label' => 'Privacy Policy',
				'url'   => 'https://devotel.com/privacy-policy/',
			),
			array(
				'label' => 'Brand Kit',
				'url'   => 'https://devotel.com/brand-kit/',
			),
		),
	);
}

/**
 * Whether a theme option value should be treated as empty for seeding.
 *
 * @param mixed $value Option value.
 * @return bool
 */
function devotel_is_empty_theme_option( $value ) {
	if ( null === $value ) {
		return true;
	}
	if ( is_string( $value ) ) {
		return '' === trim( $value );
	}
	if ( is_array( $value ) ) {
		return empty( $value );
	}
	if ( is_numeric( $value ) ) {
		return false;
	}

	return empty( $value );
}

/**
 * Pre-populate empty Theme Settings from live frontend defaults.
 */
function devotel_seed_theme_options() {
	if ( ! function_exists( 'get_field' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$seed_version = 2;
	$stored       = (int) get_option( 'devotel_theme_options_seed_version', 0 );
	if ( $stored >= $seed_version ) {
		return;
	}

	foreach ( devotel_get_theme_options_seed_data() as $field_key => $seed_value ) {
		$existing = get_field( $field_key, 'option' );
		if ( devotel_is_empty_theme_option( $existing ) ) {
			update_field( $field_key, $seed_value, 'option' );
		}
	}

	update_option( 'devotel_theme_options_seed_version', $seed_version, false );
}
add_action( 'acf/init', 'devotel_seed_theme_options', 20 );
