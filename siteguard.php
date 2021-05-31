<?php

/*
Plugin Name: SiteGuard
Plugin URI:  https://dropl.ai
Description: Protect your wordpress website from non-logged users.
Version:     1.0
Author:      Dropl
Author URI:  https://dropl.ai
License:     GPL2 etc

*/

function send_http_auth_headers(){
	header('WWW-Authenticate: Basic realm="Website Restricted"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Please speak to an administrator for access to this website.';
        exit;
}

add_action('template_redirect', 'maybe_add_http_auth_basic', 0);

function maybe_add_http_auth_basic(){
	global $wp;
	if ( ! is_user_logged_in() ) {
			$user = HTTP_USER_NAME; # Define this in wp-config.php
			$pass = HTTP_USER_PASS; # Define this in wp-config.php
			# Check if user/pass has been entered
			if (!isset($_SERVER['PHP_AUTH_USER'])) {
				send_http_auth_headers();
			} else{
				# Check if the user/pass is correct
				if ($_SERVER['PHP_AUTH_USER'] !== $user && $_SERVER['PHP_AUTH_PW'] !== $pass) {
					send_http_auth_headers();
				}
			}
	}
}