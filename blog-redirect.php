<?php
/*
Plugin Name: Blog Redirect
Description: 
Author: Kailey Lampert
Author URI: http://kaileylampert.com/
*/

$blogredirect = new blogredirect();

class blogredirect {
	function blogredirect( ) {
		add_filter( 'admin_init', array( &$this, 'admin_init' ) );
		add_action( 'template_redirect', array( &$this, 'template_redirect' ) );
	}
	function admin_init( ) {
		register_setting( 'general', 'blogredirect_url', 'esc_url' );
		add_settings_field('some_random_text', __('Blog Redirect (301)', 'blogredirect' ), array( &$this, 'add_settings_field'), 'general' ); 
	}
	function add_settings_field( ) {
		$url = get_option( 'blogredirect_url' );
		echo "<input type='url' name='blogredirect_url' value='{$url}' size='35' />";
	}
	function template_redirect( ) {
		if ( $url = get_option( 'blogredirect_url' ) ) {
		
			$curr = (is_ssl() ? 'https://' : 'http://') . $_SERVER[ 'SERVER_NAME' ] . $_SERVER[ 'REQUEST_URI' ];
			$root = substr($curr, 0, strpos($curr, '/', 10)) .'/' ;

			$url = trailingslashit( $url );
			// header('Location:'.str_replace( $root, $url, $curr ), true, 301);
			wp_redirect( str_replace( $root, $url, $curr ), 301 );
			exit;
		}
	}
}