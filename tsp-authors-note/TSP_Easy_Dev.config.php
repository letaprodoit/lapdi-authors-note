<?php									
    /* @group Easy Dev Package settings, all plugins use the same settings, DO NOT EDIT */
    if ( !defined( 'TSP_PARENT_NAME' )) define('TSP_PARENT_NAME', 			'tsp_plugins');
    if ( !defined( 'TSP_PARENT_TITLE' )) define('TSP_PARENT_TITLE', 		'LAPDI Plugins');
    if ( !defined( 'TSP_PARENT_MENU_POS' )) define('TSP_PARENT_MENU_POS', 	2617638.180);
    /* @end */

    /**
    * Every plugin that uses Easy Dev must define the DS variable that sets the path deliminter
    *
    * @var string
    */
    if (!defined('DS')) {
        if (strpos(php_uname('s') , 'Win') !== false) define('DS', '\\');
        else define('DS', '/');
    }//endif

    $easy_dev_settings = get_plugin_data( TSPAN_PLUGIN_FILE, false, false );
    $easy_dev_settings['parent_name']			= TSP_PARENT_NAME;
    $easy_dev_settings['parent_title']			= TSP_PARENT_TITLE;
    $easy_dev_settings['menu_pos'] 				= TSP_PARENT_MENU_POS;

    $easy_dev_settings['name'] 					= TSPAN_PLUGIN_NAME;
    $easy_dev_settings['key'] 					= $easy_dev_settings['TextDomain'];
    $easy_dev_settings['title']					= $easy_dev_settings['Name'];
    $easy_dev_settings['title_short']			= $easy_dev_settings['Name'];

    $easy_dev_settings['option_prefix']			= TSPAN_PLUGIN_NAME . "-option";

    $easy_dev_settings['file']	 				= TSPAN_PLUGIN_FILE;
    $easy_dev_settings['base_name']	 			= TSPAN_PLUGIN_BASE_NAME;

    $easy_dev_settings['widget_width']	 		= 300;
    $easy_dev_settings['widget_height'] 		= 350;

    $easy_dev_settings['smarty_template_dirs']	= array( TSPAN_PLUGIN_PATH . 'assets/templates', TSP_EASY_DEV_ASSETS_TEMPLATES_PATH );
    $easy_dev_settings['smarty_compiled_dir']  	= TSP_EASY_DEV_TMP_PATH . TSPAN_PLUGIN_NAME . DS . 'compiled';
    $easy_dev_settings['smarty_cache_dir'] 		= TSP_EASY_DEV_TMP_PATH . TSPAN_PLUGIN_NAME . DS . 'cache';

    //* Custom globals *//
    $easy_dev_settings['title_short']			= preg_replace("/" .strtoupper(LAPDI_ACRONYM). "|" . strtoupper(TSP_ACRONYM). "/","",$easy_dev_settings['Name']);
    //* Custom globals *//

    $easy_dev_settings['plugin_options']		= array(
        'widget_fields'						=> array(
            'title' 		=> array(
                'type' 			=> 'INPUT',
                'label' 		=> 'Title',
                'value' 		=> 'LAPDI Authors Note',
            ),
            'show_bio' 	=> array(
                'type' 			=> 'SELECT',
                'label' 		=> 'Show Bio',
                'value' 		=> 'N',
                'options'		=> array ('Yes' => 'Y', 'No' => 'N'),
            ),
            'show_name' 	=> array(
                'type' 			=> 'SELECT',
                'label' 		=> 'Show Author Name',
                'value' 		=> 'N',
                'options'		=> array ('Yes' => 'Y', 'No' => 'N'),
            ),
            'show_pic' 	=> array(
                'type' 			=> 'SELECT',
                'label' 		=> 'Show Author Photo',
                'value' 		=> 'N',
                'options'		=> array ('Yes' => 'Y', 'No' => 'N'),
            ),
            'show_website' 	=> array(
                'type' 			=> 'SELECT',
                'label' 		=> 'Show Website URL',
                'value' 		=> 'N',
                'options'		=> array ('Yes' => 'Y', 'No' => 'N'),
            ),
            'show_links' 	=> array(
                'type' 			=> 'SELECT',
                'label' 		=> 'Show Social Links',
                'value' 		=> 'N',
                'options'		=> array ('Yes' => 'Y', 'No' => 'N'),
            ),
            'style' 		=> array(
                'type' 			=> 'SELECT',
                'label' 		=> 'Note Style:',
                'value' 		=> 0,
                'options'		=> array(
                                        'No Style/Custom'	=> 0,
                                        'Light'				=> 1,
                                        'Dark'				=> 2),
            ),
            'layout' 		=> array(
                'type' 			=> 'SELECT',
                'label' 		=> 'Choose the layout:',
                'value' 		=> 0,
                'options'		=> array(
                                        'Title (Top) Image (left), Text (right)'	=> 0),
            ),
            'thumb_size' 	=> array(
                'type' 			=> 'INPUT',
                'label' 		=> 'Avatar Size',
                'value' 		=> 80,
            ),
            'before_title' 	=> array(
                'type' 			=> 'INPUT',
                'label' 		=> 'HTML Before Title',
                'value' 		=> '<h3 class="widget-title">',
                'html'			=> true,
            ),
            'after_title' 	=> array(
                'type' 			=> 'INPUT',
                'label' 		=> 'HTML After Title',
                'value' 		=> '</h3>',
                'html'			=> true,
            )
        ),
    );
    $easy_dev_settings['plugin_options']['shortcode_fields'] = $easy_dev_settings['plugin_options']['widget_fields'];
    $easy_dev_settings['required_plugins']	     = array(
        'tsp-easy-dev' => array(
            'title'     => 'LAPDI Easy Dev',
            'version'   => '2.0.0',
            'operator'  => '>='
        )
    );
    $easy_dev_settings['incompatible_plugins']	 = array();
    $easy_dev_settings['automations']	         = array();
    $easy_dev_settings['endpoints']	             = array();