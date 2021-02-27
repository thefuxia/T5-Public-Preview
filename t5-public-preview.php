<?php # -*- coding: utf-8 -*-
/**
 * Plugin Name: T5 Public Preview
 * Description: Make drafts and pending posts publicly visible.
 * Plugin URI:  http://wordpress.stackexchange.com/q/107062/73
 * Version:     2013.10.03
 * Author:      Fuxia Scholz
 * Author URI:  https://fuxia.me
 * Licence:     MIT
 * License URI: http://opensource.org/licenses/MIT
 * Textdomain:  plugin_t5_public_preview
 * Domain Path: /languages
 */

add_action( 'wp_loaded', 't5_public_preview_init' );

/**
 * Starter
 *
 * @wp-hook wp_loaded
 * @return  void
 */
function t5_public_preview_init() {

	$dir = dirname( __FILE__ );

	require "$dir/php/T5_Public_Preview.php";

	$preview = new T5_Public_Preview( $dir );
	$preview->setup();
}
