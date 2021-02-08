<?php				
    /**
     * TSP_Easy_Dev_Options_Authors_Note - Extends the TSP_Easy_Dev_Options Class
     * @package TSP_Easy_Dev
     * @author sharrondenice, letaprodoit
     * @author Sharron Denice, Let A Pro Do IT!
     * @copyright 2021 Let A Pro Do IT!
     * @license APACHE v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
     * @version $Id: [FILE] [] [DATE] [TIME] [USER] $
     */

    class TSP_Easy_Dev_Options_Authors_Note extends TSP_Easy_Dev_Options
    {
        /**
         * Implements the settings_page to display settings specific to this plugin
         *
         * @since 1.1.0
         *
         * @return void - output to screen
         *
         * @throws SmartyException
         */
        function display_plugin_options_page()
        {
            $message = "";

            $error = "";

            // get settings from database
            $shortcode_fields = get_option( $this->get_value('shortcode-fields-option-name') );

            $defaults = new TSP_Easy_Dev_Data ( $shortcode_fields, 'shortcode' );

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

            global $authors_note;

            $smarty->assign( 'plugin_title',			TSPAN_PLUGIN_TITLE);
            $smarty->assign( 'plugin_links',			    implode(' | ', $authors_note->get_meta_links()));
            $smarty->assign( 'EASY_DEV_SETTINGS_UI',	$this->get_value('name') . '_child-page-instructions.tpl');

            $smarty->assign( 'form_fields',				$form_fields);
            $smarty->assign( 'message',					$message);
            $smarty->assign( 'error',					$error);
            $smarty->assign( 'form',					    $form);
            $smarty->assign( 'plugin_name',				$this->get_value('name'));
            $smarty->assign( 'nonce_name',				wp_nonce_field( $this->get_value('name'), $this->get_value('name').'_nonce_name' ));

            $smarty->display( 'easy-dev-child-page-default.tpl');

        }//end settings_page

    }//end TSP_Easy_Dev_Options_View


    /**
     * TSP_Easy_Dev_Widget_Authors_Note - Extends the TSP_Easy_Dev_Widget Class
     * @package TSPEasyPlugin
     * @author sharrondenice, letaprodoit
     * @author Sharron Denice, Let A Pro Do IT!
     * @copyright 2021 Let A Pro Do IT!
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
         * @return void
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
         * @param array $fields Required - array of current values
         *
         * @return void - display to widget box
         *
         * @throws SmartyException
         */
        public function display_form( $fields )
        {
            $smarty = new TSP_Easy_Dev_Smarty( $this->options->get_value('smarty_template_dirs'),
                $this->options->get_value('smarty_cache_dir'),
                $this->options->get_value('smarty_compiled_dir'), true );

            $smarty->assign( 'shortcode_fields', $fields );
            $smarty->assign( 'class', 'widefat' );

            $smarty->display( 'easy-dev-shortcode-form.tpl' );
        }//end form

        /**
         * Implementation (required) to print widget & shortcode information to screen
         *
         * @since 1.1.0
         *
         * @param array $fields - the settings to display
         * @param boolean $echo Optional - if false returns output instead of displaying to screen
         * @param string $tag Optional - the name of the shortcode being processed
         *
         * @return string $output if echo is true displays to screen else returns string
         *
         * @throws SmartyException
         */
        public function display_widget( $fields, $echo = true, $tag = null )
        {
            extract ( $fields );

            $return_HTML = "";
            $title = null;

            global $wpdb, $post;

            if (empty($fields['shortcode_content']) && empty($fields['note']))
            {
                $fields['shortcode_content'] = null;

                $content = $post->post_content;
                $tag = $this->options->get_value('name');

                if ( preg_match( "/\[$tag .*?\](.*?)\[\/$tag\]/", $content, $matches ) )
                {
                    if ( array_key_exists( 1, $matches ) )
                    {
                        $fields['shortcode_content'] = $matches[1];
                    }//end if
                }//endif
            }//end if


            if (!empty($fields['title']))
            {
                $title = $fields['before_title'] . $fields['title'] . $fields['after_title'];
            }//end else

            $author_ID 		= !empty($post) ? $post->post_author : '';
            $author 		= get_userdata( $author_ID ); //user data
            $gravatar		= null;
            $name 			= null;
            $bio 			= null;
            $website		= null;
            $links			= array();

            if ($fields['show_name'] == 'Y' && !empty($author))
            {
                $name 		= $author->display_name;
            }//end if
            if ($fields['show_pic'] == 'Y' && !empty($author))
            {
                $gravatar_type = get_option('wpu_gravatar_type');
                $gravatar = get_avatar($author->user_email, $fields['thumb_size'], $gravatar_type, $name); //get avatar
            }//end if
            if ($fields['show_bio'] == 'Y' && !empty($author_ID))
            {
                $bio 		= get_the_author_meta( 'description', $author_ID );
            }//end if
            if ($fields['show_website'] == 'Y' && !empty($author_ID))
            {
                $website	= get_the_author_meta( 'user_url', $author_ID );
            }//end if
            if ($fields['show_links'] == 'Y' && !empty($author_ID))
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
            $smarty->assign("note", 	html_entity_decode($fields['note'] . $fields['shortcode_content']), true);

            $return_HTML .= $smarty->fetch( $this->options->get_value('name') . '_layout'.$fields['layout'].'.tpl' );

            if ($echo)
                echo $return_HTML;

            return $return_HTML;
        }//end display
    }//end TSP_Easy_Dev_Widget_Authors_Note