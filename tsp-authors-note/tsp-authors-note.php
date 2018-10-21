<?php
    /*
    Plugin Name: 	LAPDI Authors Note
    Plugin URI: 	http://www.letaprodoit.com/software/plugins/wordpress/authors-note-for-wordpress.html
    Description: 	Author's Note allows you to <strong>add author's notes and afterthoughts</strong> to your blog posts and pages. Powered by <strong><a href="http://wordpress.org/plugins/tsp-easy-dev/">LAPDI Easy Dev</a></strong>.
    Author: 		Let A Pro Do IT!
    Author URI: 	http://www.letaprodoit.com/
    Version: 		1.0.3
    Text Domain: 	tspan
    Copyright: 		Copyright � 2013 Let A Pro Do IT!, LLC (www.letaprodoit.com). All rights reserved
    License: 		APACHE v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
    */

    require_once(ABSPATH . 'wp-admin/includes/plugin.php' );

    define('TSPAN_PLUGIN_FILE', 			__FILE__ );
    define('TSPAN_PLUGIN_PATH',				plugin_dir_path( __FILE__ ) );
    define('TSPAN_PLUGIN_URL', 				plugin_dir_url( __FILE__ ) );
    define('TSPAN_PLUGIN_BASE_NAME', 		plugin_basename( __FILE__ ) );
    define('TSPAN_PLUGIN_NAME', 			'tsp-authors-note');
    define('TSPAN_PLUGIN_TITLE', 			'Authors Note');
    define('TSPAN_PLUGIN_REQ_VERSION', 		"3.5.1");

    if (file_exists( WP_PLUGIN_DIR . "/tsp-easy-dev/tsp-easy-dev.php" ))
    {
        include_once WP_PLUGIN_DIR . "/tsp-easy-dev/tsp-easy-dev.php";
    }//end else
    else
        return;

    global $easy_dev_settings;

    require( TSPAN_PLUGIN_PATH . 'TSP_Easy_Dev.config.php');
    require( TSPAN_PLUGIN_PATH . 'TSP_Easy_Dev.extend.php');
    //--------------------------------------------------------
    // initialize the plugin
    //--------------------------------------------------------
    $authors_note 								= new TSP_Easy_Dev( TSPAN_PLUGIN_FILE, TSPAN_PLUGIN_REQ_VERSION );

    $authors_note->set_options_handler( new TSP_Easy_Dev_Options_Authors_Note( $easy_dev_settings ) );

    $authors_note->set_widget_handler( 'TSP_Easy_Dev_Widget_Authors_Note' );

    $authors_note->add_link ( 'FAQ',          preg_replace("/\%PLUGIN\%/", TSPAN_PLUGIN_NAME, TSP_WORDPRESS_FAQ_URL ));
    $authors_note->add_link ( 'Rate Me',      preg_replace("/\%PLUGIN\%/", TSPAN_PLUGIN_NAME, TSP_WORDPRESS_RATE_URL ) );
    $authors_note->add_link ( 'Support',      preg_replace("/\%PLUGIN\%/", 'wordpress-an', TSP_LAB_BUG_URL ));

    $authors_note->uses_shortcodes 				= true;

    // Queue User Styles
    $authors_note->add_css( TSPAN_PLUGIN_URL . TSPAN_PLUGIN_NAME . '.css' );

    $authors_note->set_plugin_icon( TSP_EASY_DEV_ASSETS_IMAGES_URL . 'icon_16.png' );

    $authors_note->add_shortcode ( TSPAN_PLUGIN_NAME );

    $authors_note->run( TSPAN_PLUGIN_FILE );

    // Initialize widget - Required by WordPress
    add_action('widgets_init', function () {
        global $authors_note;

        register_widget ( $authors_note->get_widget_handler() );
        apply_filters( $authors_note->get_widget_handler().'-init', $authors_note->get_options_handler() );
    });