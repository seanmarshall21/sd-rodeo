<?php
/**
 * Plugin Name: SD Rodeo Splash
 * Description: [sd_rodeo_splash] drops the San Diego Rodeo 2027 splash (hosted on Netlify) into a page as a full-height frame.
 * Version:     1.3
 * Author:      Vivo Creative
 *
 * Install: upload this folder to wp-content/plugins/ and activate, or paste the function + add_shortcode
 * lines into a Code Snippets snippet. Then put [sd_rodeo_splash] on the page (a full-width / no-sidebar template).
 *
 * Attributes:
 *   src     – where the splash lives (default: the Netlify site)
 *   height  – CSS height of the frame (default: the visible viewport, minus the WP admin bar when logged in)
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function sd_rodeo_splash_shortcode( $atts ) {
	$a = shortcode_atts( array(
		'src'    => 'https://sd-rodeo-2027.netlify.app/',
		'height' => '100svh',
	), $atts, 'sd_rodeo_splash' );

	$src    = esc_url( $a['src'] );
	$height = esc_attr( $a['height'] );

	// Logged-in users get the WP admin bar above the page; take its height off so nothing scrolls.
	static $css_done = false;
	$css = '';
	if ( ! $css_done ) {
		$css_done = true;
		$css = '<style>html,body{overflow:hidden!important;overscroll-behavior:none;height:100%}'   /* the splash is one screen: no scroll, no bounce */
			. 'body.admin-bar .sd-rodeo-splash{height:calc(' . $height . ' - 32px)!important}'
			. '@media(max-width:782px){body.admin-bar .sd-rodeo-splash{height:calc(' . $height . ' - 46px)!important}}</style>';
	}

	// Event structured data, so Google can show the dates and venue with the result.
	static $ld_done = false;
	$ld = '';
	if ( ! $ld_done ) {
		$ld_done = true;
		$ld = '<script type="application/ld+json">' . wp_json_encode( array(
			'@context'            => 'https://schema.org',
			'@type'               => 'Event',
			'name'                => 'San Diego Rodeo 2027',
			'startDate'           => '2027-01-15',
			'endDate'             => '2027-01-17',
			'eventStatus'         => 'https://schema.org/EventScheduled',
			'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
			'description'         => 'San Diego Rodeo returns to Petco Park for its 4th consecutive year. All ages.',
			'image'               => array( 'https://www.rodeosd.com/wp-content/uploads/sd-rodeo-2027-og.jpg' ),
			'url'                 => get_permalink(),
			'location'            => array(
				'@type'   => 'Place',
				'name'    => 'Petco Park',
				'address' => array(
					'@type'           => 'PostalAddress',
					'streetAddress'   => '100 Park Blvd',
					'addressLocality' => 'San Diego',
					'addressRegion'   => 'CA',
					'postalCode'      => '92101',
					'addressCountry'  => 'US',
				),
			),
			'organizer'           => array( '@type' => 'Organization', 'name' => 'Outriders', 'url' => 'https://www.rodeosd.com/' ),
			'offers'              => array(
				'@type'        => 'Offer',
				'url'          => 'https://laylo.com/sandiegorodeo/SDR2027',
				'availability' => 'https://schema.org/PreOrder',
			),
		), JSON_UNESCAPED_SLASHES ) . '</script>';
	}

	return $css . $ld . '<div class="sd-rodeo-splash" style="width:100%;height:' . $height . ';margin:0;padding:0;line-height:0;background:#33281D;">'
		. '<iframe src="' . $src . '" title="San Diego Rodeo 2027" loading="eager" referrerpolicy="strict-origin-when-cross-origin"'
		. ' style="display:block;width:100%;height:100%;border:0;" allow="clipboard-write"></iframe>'
		. '</div>';
}
add_shortcode( 'sd_rodeo_splash', 'sd_rodeo_splash_shortcode' );
