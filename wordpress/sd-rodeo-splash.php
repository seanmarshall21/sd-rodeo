<?php
/**
 * Plugin Name: SD Rodeo Splash
 * Description: [sd_rodeo_splash] drops the San Diego Rodeo 2027 splash (hosted on Netlify) into a page as a full-height frame.
 * Version:     1.0
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
		'height' => 'calc(100svh - var(--wp-admin--admin-bar--height, 0px))',
	), $atts, 'sd_rodeo_splash' );

	$src    = esc_url( $a['src'] );
	$height = esc_attr( $a['height'] );

	return '<div class="sd-rodeo-splash" style="width:100%;height:' . $height . ';margin:0;padding:0;line-height:0;background:#33281D;">'
		. '<iframe src="' . $src . '" title="San Diego Rodeo 2027" loading="eager" referrerpolicy="strict-origin-when-cross-origin"'
		. ' style="display:block;width:100%;height:100%;border:0;" allow="clipboard-write"></iframe>'
		. '</div>';
}
add_shortcode( 'sd_rodeo_splash', 'sd_rodeo_splash_shortcode' );
