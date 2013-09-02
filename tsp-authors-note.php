<?php
/*
Plugin Name: 	TSP Authors Note
Plugin URI: 	http://www.thesoftwarepeople.com/software/plugins/wordpress/authors-note-for-wordpress.html
Description: 	Author's Note allows you to <strong>add your author's notes and afterthoughts</strong>to your blog posts. Powered by <strong><a href="http://wordpress.org/plugins/tsp-easy-dev/">TSP Easy Dev</a></strong>.
Author: 		The Software People
Author URI: 	http://www.thesoftwarepeople.com/
Version: 		1.0
Text Domain: 	tspan
Copyright: 		Copyright © 2013 The Software People, LLC (www.thesoftwarepeople.com). All rights reserved
License: 		APACHE v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
*/

require_once(ABSPATH . 'wp-admin/includes/plugin.php' );

define('TSPAN_PLUGIN_FILE', 			__FILE__ );
define('TSPAN_PLUGIN_PATH',				plugin_dir_path( __FILE__ ) );
define('TSPAN_PLUGIN_URL', 				plugin_dir_url( __FILE__ ) );
define('TSPAN_PLUGIN_BASE_NAME', 		plugin_basename( __FILE__ ) );
define('TSPAN_PLUGIN_NAME', 			'tsp-authors-note');
define('TSPAN_PLUGIN_TITLE', 			'TSP Authors Note');
define('TSPAN_PLUGIN_REQ_VERSION', 		"3.5.1");

// The recommended option would be to require the installation of the standard version and
// bundle the Pro classes into your plugin if needed
if ( !file_exists ( WP_PLUGIN_DIR . "/tsp-easy-dev/TSP_Easy_Dev.register.php" ) )
{
	function display_tspan_notice()
	{
		$message = TSPAN_PLUGIN_TITLE . ' <strong>was not installed</strong>, plugin requires the installation of <strong><a href="plugin-install.php?tab=search&type=term&s=TSP+Easy+Dev">TSP Easy Dev</a></strong>.';
	    ?>
	    <div class="error">
	        <p><?php echo $message; ?></p>
	    </div>
	    <?php
	}//end display_tspan_notice

	add_action( 'admin_notices', 'display_tspan_notice' );
	deactivate_plugins( TSPAN_PLUGIN_BASE_NAME );
	return;
}//endif
else
{
    if (file_exists( WP_PLUGIN_DIR . "/tsp-easy-dev/TSP_Easy_Dev.register.php" ))
    {
    	include_once WP_PLUGIN_DIR . "/tsp-easy-dev/TSP_Easy_Dev.register.php";
    }//end else
}//end else

global $easy_dev_settings;

require( TSPAN_PLUGIN_PATH . 'TSP_Easy_Dev.config.php');
require( TSPAN_PLUGIN_PATH . 'TSP_Easy_Dev.extend.php');
//--------------------------------------------------------
// initialize the plugin
//--------------------------------------------------------
$authors_note 								= new TSP_Easy_Dev( TSPAN_PLUGIN_FILE, TSPAN_PLUGIN_REQ_VERSION );

$authors_note->set_options_handler( new TSP_Easy_Dev_Options_Authors_Note( $easy_dev_settings ) );

$authors_note->set_widget_handler( 'TSP_Easy_Dev_Widget_Authors_Note' );

$authors_note->add_link ( 'FAQ', 			'http://wordpress.org/extend/plugins/tsp-authors-note/faq/' );
$authors_note->add_link ( 'Rate Me', 		'http://wordpress.org/support/view/plugin-reviews/tsp-authors-note' );
$authors_note->add_link ( 'Support', 		'http://lab.thesoftwarepeople.com/tracker/wordpress-an/issues/new' );

$authors_note->uses_smarty 					= true;

$authors_note->uses_shortcodes 				= true;

// Queue User Styles
$authors_note->add_css( TSPAN_PLUGIN_URL . TSPAN_PLUGIN_NAME . '.css' );

// Queue Admin Styles
$authors_note->add_css( TSPAN_PLUGIN_URL . 'css' . DS. 'admin-style.css', true );

$authors_note->set_plugin_icon( TSPAN_PLUGIN_URL . 'images' . DS . 'tsp_icon_16.png' );

$authors_note->add_shortcode ( TSPAN_PLUGIN_NAME );

$authors_note->run( TSPAN_PLUGIN_FILE );

// Initialize widget - Required by WordPress
add_action('widgets_init', function () {
	global $authors_note;
	
	register_widget ( $authors_note->get_widget_handler() ); 
	apply_filters( $authors_note->get_widget_handler().'-init', $authors_note->get_options_handler() );
});
?>