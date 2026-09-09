<?php
/**
 * Plugin Name: SD Rodeo Splash
 * Description: [sd_rodeo_splash] drops the San Diego Rodeo 2027 splash (hosted on Netlify) into a page as a full-height frame.
 * Version:     1.2
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

	return $css . '<div class="sd-rodeo-splash" style="width:100%;height:' . $height . ';margin:0;padding:0;line-height:0;background:#33281D;">'
		. '<iframe src="' . $src . '" title="San Diego Rodeo 2027" loading="eager" referrerpolicy="strict-origin-when-cross-origin"'
		. ' style="display:block;width:100%;height:100%;border:0;" allow="clipboard-write"></iframe>'
		. '</div>';
}
add_shortcode( 'sd_rodeo_splash', 'sd_rodeo_splash_shortcode' );
