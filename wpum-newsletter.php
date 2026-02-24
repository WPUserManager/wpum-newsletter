<?php
/*
Plugin Name: WPUM Newsletter
Plugin URI:  https://wpusermanager.com
Description: WP User Manager addon for the Newsletter plugin.
Version:     1.1.1
Author:      WP User Manager
Author URI:  https://wpusermanager.com/
License:     GPLv3+
*/

/**
 * Add the Newsletter optin checkbox to the registration form
 *
 * @param array $fields
 *
 * @return array
 */
function wpum_newsletter_add_optin( $fields ) {
	$newsletter_options = get_option( 'newsletter_wpusers', array() );
	if ( ! empty( $newsletter_options['subscribe'] ) && $newsletter_options['subscribe'] != 1 ) {
		$fields['newsletter'] = array(
			'label'       => '',
			'type'        => 'checkbox',
			'description' => $newsletter_options['subscribe_label'],
			'priority'    => 9999,
			'required'    => false,
			'value'       => $newsletter_options['subscribe'] == 3,
		);
	}

	return $fields;
}

add_action( 'newsletter_init', 'wpum_newsletter_init' );
function wpum_newsletter_init() {
	add_filter( 'wpum_get_registration_fields', 'wpum_newsletter_add_optin' );
}

function wpum_newsletter_register_new_account_tabs( $tabs ) {
	$tabs['posts'] = [
		'name'     => esc_html( apply_filters( 'wpum_newsletters_account_title', __( 'Newsletters', 'wpum-newsletters' ) ) ),
		'priority' => 0,
	];

	return $tabs;
}

add_filter( 'wpum_get_account_page_tabs', 'wpum_newsletter_register_new_account_tabs' );

function wpum_newsletter_account_tab_content() {
	echo '<h2>' . apply_filters( 'wpum_newsletters_account_title', __( 'Newsletters', 'wpum-newsletters' ) ) . '</h2>';
	echo do_shortcode( '[newsletter_profile]' );
}

add_action( 'wpum_account_page_content_posts', 'wpum_newsletter_account_tab_content' );

