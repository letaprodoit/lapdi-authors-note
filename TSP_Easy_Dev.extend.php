<?php				
/**
 * TSP_Easy_Dev_Options_Authors_Note - Extends the TSP_Easy_Dev_Options Class
 * @package TSP_Easy_Dev
 * @author sharrondenice, thesoftwarepeople
 * @author Sharron Denice, The Software People
 * @copyright 2013 The Software People
 * @license APACHE v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 * @version $Id: [FILE] [] [DATE] [TIME] [USER] $
 */

/**
 * @method void display_parent_page()
 * @method void display_plugin_options_page()
 */
class TSP_Easy_Dev_Options_Authors_Note extends TSP_Easy_Dev_Options
{
	/**
	 * Display all the plugins that The Software People has released
	 *
	 * @since 1.1.0
	 *
	 * @param none
	 *
	 * @return output to stdout
	 */
	public function display_parent_page()
	{
		$active_plugins			= get_option('active_plugins');
		$all_plugins 			= get_plugins();
	
		$free_active_plugins 	= array();
		$free_installed_plugins = array();
		$free_recommend_plugins = array();
		
		$pro_active_plugins 	= array();
		$pro_installed_plugins 	= array();
		$pro_recommend_plugins 	= array();
		
		$json 					= file_get_contents( $this->get_value('plugin_list') );
		$tsp_plugins 			= json_decode($json);
		
		foreach ( $tsp_plugins->{'plugins'} as $plugin_data )
		{
			if ( $plugin_data->{'type'} == 'FREE' )
			{
				if ( in_array($plugin_data->{'name'}, $active_plugins ) )
				{
					$free_active_plugins[] = (array)$plugin_data;
				}//endif
				elseif ( array_key_exists($plugin_data->{'name'}, $all_plugins ) )
				{
					$free_installed_plugins[] = (array)$plugin_data;
				}//end elseif
				else
				{
					$free_recommend_plugins[] = (array)$plugin_data;
				}//endelse
			}//endif
			elseif ( $plugin_data->{'type'} == 'PRO' )
			{
				if ( in_array($plugin_data->{'name'}, $active_plugins ) )
				{
					$pro_active_plugins[] = (array)$plugin_data;
				}//endif
				elseif ( array_key_exists($plugin_data->{'name'}, $all_plugins ) )
				{
					$pro_installed_plugins[] = (array)$plugin_data;
				}//endelseif
				else
				{
					$pro_recommend_plugins[] = (array)$plugin_data;
				}//endelse
			}//endelseif
		}//endforeach
		
		$free_active_count									= count($free_active_plugins);
		$free_installed_count 								= count($free_installed_plugins);
		$free_recommend_count 								= count($free_recommend_plugins);

		$free_total											= $free_active_count + $free_installed_count + $free_recommend_count;

		$pro_active_count									= count($pro_active_plugins);
		$pro_installed_count 								= count($pro_installed_plugins);
		$pro_recommend_count 								= count($pro_recommend_plugins);
		
		$pro_total											= $pro_active_count + $pro_installed_count + $pro_recommend_count;
				
		// Display settings to screen
		$smarty = new TSP_Easy_Dev_Smarty( $this->get_value('smarty_template_dirs'), 
			$this->get_value('smarty_cache_dir'), 
			$this->get_value('smarty_compiled_dir'), true );
			
		$smarty->assign( 'free_active_count',		$free_active_count);
		$smarty->assign( 'free_installed_count',	$free_installed_count);
		$smarty->assign( 'free_recommend_count',	$free_recommend_count);

		$smarty->assign( 'pro_active_count',		$pro_active_count);
		$smarty->assign( 'pro_installed_count',		$pro_installed_count);
		$smarty->assign( 'pro_recommend_count',		$pro_recommend_count);
		
		$smarty->assign( 'free_active_plugins',		$free_active_plugins);
		$smarty->assign( 'free_installed_plugins',	$free_installed_plugins);
		$smarty->assign( 'free_recommend_plugins',	$free_recommend_plugins);

		$smarty->assign( 'pro_active_plugins',		$pro_active_plugins);
		$smarty->assign( 'pro_installed_plugins',	$pro_installed_plugins);
		$smarty->assign( 'pro_recommend_plugins',	$pro_recommend_plugins);

		$smarty->assign( 'free_total',				$free_total);
		$smarty->assign( 'pro_total',				$pro_total);

		$smarty->assign( 'title',					"WordPress Plugins by The Software People");
		$smarty->assign( 'contact_url',				$this->get_value('contact_url'));

		$smarty->display( 'easy-dev-parent-page.tpl');
	}//end ad_menu
	
	/**
	 * Implements the settings_page to display settings specific to this plugin
	 *
	 * @since 1.1.0
	 *
	 * @param none
	 *
	 * @return output to screen
	 */
	function display_plugin_options_page() 
	{
		$message = "";
		
		$error = "";
		
		// get settings from database
		$shortcode_fields = get_option( $this->get_value('shortcode-fields-option-name') );
		
		$defaults = new TSP_Easy_Dev_Data ( $shortcode_fields );

		$form = null;
		if ( array_key_exists( $this->get_value('name') . '_form_submit', $_REQUEST ))
		{
			$form = $_REQUEST[ $this->get_value('name') . '_form_submit'];
		}//endif
				
		// Save data for settings page
		if( isset( $form ) && check_admin_referer( $this->get_value('name'), $this->get_value('name') . '_nonce_name' ) ) 
		{
			$defaults->set_values( $_POST );
			$shortcode_fields = $defaults->get();
			
			update_option( $this->get_value('shortcode-fields-option-name'), $shortcode_fields );
			
			$message = __( "Options saved.", $this->get_value('name') );
		}
		
		$form_fields = $defaults->get_values( true );

		// Display settings to screen
		$smarty = new TSP_Easy_Dev_Smarty( $this->get_value('smarty_template_dirs'), 
			$this->get_value('smarty_cache_dir'), 
			$this->get_value('smarty_compiled_dir'), true );

		$smarty->assign( 'form_fields',				$form_fields);
		$smarty->assign( 'message',					$message);
		$smarty->assign( 'error',					$error);
		$smarty->assign( 'form',					$form);
		$smarty->assign( 'plugin_name',				$this->get_value('name'));
		$smarty->assign( 'nonce_name',				wp_nonce_field( $this->get_value('name'), $this->get_value('name').'_nonce_name' ));
		
		$smarty->display( $this->get_value('name') . '_shortcode_settings.tpl');
				
	}//end settings_page
	
}//end TSP_Easy_Dev_Options_View


/**
 * TSP_Easy_Dev_Widget_Authors_Note - Extends the TSP_Easy_Dev_Widget Class
 * @package TSPEasyPlugin
 * @author sharrondenice, thesoftwarepeople
 * @author Sharron Denice, The Software People
 * @copyright 2013 The Software People
 * @license APACHE v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 * @version $Id: [FILE] [] [DATE] [TIME] [USER] $
 */

/**
 * Extends the TSP_Easy_Dev_Widget_Authors_Note Class
 *
 * original author: Sharron Denice
 */
class TSP_Easy_Dev_Widget_Authors_Note extends TSP_Easy_Dev_Widget
{
	/**
	 * Constructor
	 */	
	public function __construct() 
	{
		add_filter( get_class()  .'-init', array($this, 'init'), 10, 1 );
	}//end __construct

	/**
	 * Function added to filter to allow initialization of widget
	 *
	 * @since 1.1.0
	 *
	 * @param object $options Required - pass in reference to options class
	 *
	 * @return none
	 */
	public function init( $options )
	{
        // Create the widget
		parent::__construct( $options );
	}//end init

	/**
	 * Override required of form function to display widget information
	 *
	 * @since 1.1.0
	 *
	 * @param array $instance Required - array of current values
	 *
	 * @return display to widget box
	 */
	public function display_form( $fields )
	{
		$smarty = new TSP_Easy_Dev_Smarty( $this->options->get_value('smarty_template_dirs'), 
			$this->options->get_value('smarty_cache_dir'), 
			$this->options->get_value('smarty_compiled_dir'), true );
    	
    	$smarty->assign( 'form_fields', $fields );
    	$smarty->assign( 'class', 'widefat' );
		$smarty->display( 'default_form.tpl' );
	}//end form
	
	/**
	 * Implementation (required) to print widget & shortcode information to screen
	 *
	 * @since 1.1.0
	 *
	 * @param array $fields  - the settings to display
	 * @param boolean $echo Optional - if false returns output instead of displaying to screen
	 *
	 * @return string $output if echo is true displays to screen else returns string
	 */
	public function display_widget( $fields, $echo = true )
	{
	    extract ( $fields );
	    
		$return_HTML = "";
		
	    global $wpdb, $post;
	    
	    if (empty($shortcode_content))
	    {
	    	$shortcode_content = null;
	    	
	    	$content = $post->post_content;
	    	$tag = $this->options->get_value('name');
	    	
	    	if ( preg_match( "/\[$tag .*?\](.*?)\[\/$tag\]/", $content, $matches ) )
	    	{
	    		if ( array_key_exists( 1, $matches ) )
	    		{
	    			$shortcode_content = $matches[1];
	    		}//end if
	    	}//endif
	    }//end if
	    if (empty($title))
	    {
	    	$title = null;
	    }//end if
	    else
	    {
	    	$title = $before_title . $title . $after_title;
	    }//end else
	    	  	    
	    $author_ID 		= $post->post_author;
		$author 		= get_userdata( $author_ID ); //user data
		$gravatar		= null;
		$name 			= null;			
		$bio 			= null;
		$website		= null;
		$links			= array();
		
		if ($show_name == 'Y')
		{
			$name 		= $author->display_name;	
		}//end if
		if ($show_pic == 'Y')
		{
			$gravatar_type = get_option('wpu_gravatar_type');
			$gravatar = get_avatar($author->user_email, $thumb_size, $gravatar_type, $name); //get avatar
		}//end if
		if ($show_bio == 'Y')
		{
			$bio 		= get_the_author_meta( 'description', $author_ID );	
		}//end if
		if ($show_website == 'Y')
		{
			$website	= get_the_author_meta( 'user_url', $author_ID );
		}//end if
		if ($show_links == 'Y')
		{
			$links['yim'] 		= get_the_author_meta( 'yim', $author_ID );
			$links['aim'] 		= get_the_author_meta( 'aim', $author_ID );
			$links['jabber'] 	= get_the_author_meta( 'jabber', $author_ID );
		}//end if
		
		$smarty = new TSP_Easy_Dev_Smarty( $this->options->get_value('smarty_template_dirs'), 
			$this->options->get_value('smarty_cache_dir'), 
			$this->options->get_value('smarty_compiled_dir'), true );
	    
	    // Store values into Smarty
	    foreach ( $fields as $key => $val )
	    {
	    	$smarty->assign( $key, $val, true);
	    }//end foreach
		
		$smarty->assign("title",	$title, true);
	    $smarty->assign("name",		$name, true);
		$smarty->assign("gravatar", $gravatar, true);
		$smarty->assign("bio",  	$bio, true);
		$smarty->assign("website",	$website, true);
		$smarty->assign("links",	$links, true);
		$smarty->assign("note", 	html_entity_decode($shortcode_content), true);
			
		$return_HTML .= $smarty->fetch( $this->options->get_value('name') . '_layout'.$layout.'.tpl' );
		
		if ($echo)
			echo $return_HTML;
		
		return $return_HTML;
	}//end display
}//end TSP_Easy_Dev_Widget_Authors_Note
?>