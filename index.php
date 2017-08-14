<?php
/*
Plugin Name: Google Books Importer
Plugin URI: https://firescripts.net
Description: Bulk import of books from Google Books
Version: 1.5
Author: Zarko
Author URI: https://firescripts.net
License: GPLv3
*/

define('GBI_PATH', dirname(__FILE__));
define('GBI_URL', plugin_dir_url(__FILE__));

add_action('admin_menu', 'gbi_register_submenu_page');
add_action('admin_init', 'gbi_register_resources');
add_action('admin_init', 'gbi_default_setup');

include('inc/functions.php');

function gbi_register_submenu_page() {
	add_menu_page('Google Books Importer', 'GB Import', 'manage_options', 'google-books-importer', 'gbi_admin_pages', 'dashicons-book-alt');
	add_submenu_page( 'google-books-importer', 'Google Books Importer Settings', 'GB Settings', 'manage_options', 'google-books-settings', 'gbi_admin_pages'); 
}

function gbi_admin_pages() { 
	require_once(GBI_PATH.'/admin.php');
}

// include resources
function gbi_register_resources() { 
	if(isset($_GET['page']) && ($_GET['page'] == 'google-books-importer' || $_GET['page'] == 'google-books-settings')) { 
		wp_enqueue_style('gbi-style', GBI_URL.'assets/style.css');
		wp_enqueue_script('gbi-script', GBI_URL.'assets/scripts.js', array('jquery'));
	}
}

function gbi_default_setup() { 
	
	if(get_option('gbi_fields'))
		return;

	// default setup
	$mapped_fields = array( 
		'post_title' => 'title',
		'post_content' => 'description',
		'post_excerpt' => 'subtitle',
		'post_status' => 'publish',
		'comment_status' => 'open',
		'post_types' => 'post',
		'category' => '0',
		'featured' => '0',
	);

	update_option('gbi_fields', $mapped_fields);
	update_option('gbi_apikey', '');

}
