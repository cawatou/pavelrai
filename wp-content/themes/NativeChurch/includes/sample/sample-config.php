<?php
/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */
if (!class_exists('Redux_Framework_sample_config')) {
load_theme_textdomain('imic-framework-admin', IMIC_FILEPATH . '/language');
    class Redux_Framework_sample_config {
        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;
        public function __construct() {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }
        public function initSettings() {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();
            // Create the sections and fields
            $this->setSections();
            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        /**
          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.
         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!</h1>';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }
              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }
        /**
          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.
          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons
         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'imic-framework-admin'),
                'desc' => __('<p>Did you know that IMIC Framework sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$imic_options</strong></p>', 'imic-framework-admin'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );
            return $sections;
        }
        /**
          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;
            return $args;
        }
        /**
          Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = __('Testing filter hook!','framework');
            return $defaults;
        }
        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);
                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }
        public function setSections() {
            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();
            if (is_dir($sample_patterns_path)) :
                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();
                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {
                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;
            ob_start();
            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';
            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'imic-framework-admin'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>
                <h4><?php echo $this->theme->display('Name'); ?></h4>
                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'imic-framework-admin'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'imic-framework-admin'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'imic-framework-admin') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'imic-framework-admin'), $this->theme->parent()->display('Name'));
            }
            ?>
                </div>
            </div>
            <?php
            $item_info = ob_get_contents();
            ob_end_clean();
            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }
			load_theme_textdomain('imic-framework-admin', IMIC_FILEPATH . '/language');
			$defaultLogo = get_template_directory_uri().'/images/logo.png';
			$defaultAdminLogo = get_template_directory_uri().'/images/logo@2x.png';
			$defaultBannerImages = get_template_directory_uri().'/images/page-header1.jpg';
			$defaultFavicon = '';
			$default_option_value = get_option('imic_options');
			$old_social_facebook = ($default_option_value['social-facebook']!='') ? $default_option_value['social-facebook'] : 'Facebook';
			$old_social_twitter = ($default_option_value['social-twitter']!='') ? $default_option_value['social-twitter'] : 'Twitter';
			$old_social_pinterest = ($default_option_value['social-pinterest']!='') ? $default_option_value['social-pinterest'] : 'Pinterest';
			$old_social_gplus = ($default_option_value['social-googleplus']!='') ? $default_option_value['social-googleplus'] : 'Google Plus';
			$old_social_ytube = ($default_option_value['social-youtube']!='') ? $default_option_value['social-youtube'] : 'Youtube';
			$old_social_instagram = ($default_option_value['social-instagram']!='') ? $default_option_value['social-instagram'] : 'Instagram';
			$old_social_vimeo = ($default_option_value['social-vimeo']!='') ? $default_option_value['social-vimeo'] : 'Vimeo';
			$old_social_rss = ($default_option_value['site-rss']!='') ? $default_option_value['site-rss'] : 'Rss';
			$default_logo = get_template_directory_uri() . '/images/logo.png';
			$default_favicon = get_template_directory_uri() . '/images/favicon.ico';
            // ACTUAL DECLARATION OF SECTIONS
			$this->sections[] = array(
    'icon' => 'el-icon-cogs',
    'icon_class' => 'icon-large',
    'title' => __('General Settings', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'enable_maintenance',
            'type' => 'switch',
            'title' => __('Enable Maintenance', 'imic-framework-admin'),
            'subtitle' => __('Enable the themes in maintenance mode.', 'imic-framework-admin'),
            "default" => 0,
            'on' => __('Enabled', 'imic-framework-admin'),
            'off' => __('Disabled', 'imic-framework-admin'),
        ),
        array(
            'id' => 'switch-responsive',
            'type' => 'switch',
            'title' => __('Enable Responsive', 'imic-framework-admin'),
            'subtitle' => __('Enable/Disable the responsive behaviour of the theme', 'imic-framework-admin'),
            "default" => 1,
        ),
         array(
            'id' => 'switch-thumbnail',
            'type' => 'switch',
            'title' => __('Enable Thumbnail', 'imic-framework-admin'),
            'subtitle' => __('Enable/Disable the Thumbnail behaviour of image', 'imic-framework-admin'),
            "default" => 0,
        ),
        array(
            'id' => 'enable_backtotop',
            'type' => 'switch',
            'title' => __('Enable Back To Top', 'imic-framework-admin'),
            'subtitle' => __('Enable the back to top button that appears in the bottom right corner of the screen.', 'imic-framework-admin'),
            "default" => 0,
        ),
        array(
            'id' => 'custom_favicon',
            'type' => 'media',
            'compiler' => 'true',
            'title' => __('Custom favicon', 'imic-framework-admin'),
            'desc' => __('Upload a .ico favicon image that will represent your website favicon', 'imic-framework-admin'),
            'default' => array('url' => $default_favicon),
        ),
       array(
            'id' => 'tracking-code',
            'type' => 'ace_editor',
            'title' => __('Tracking Code', 'imic-framework-admin'),
            'subtitle' => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'imic-framework-admin'),
        ),
        array(
            'id' => 'custom_admin_login_logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Custom admin login logo', 'imic-framework-admin'),
            'compiler' => 'true',
            //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'desc' => __('Upload a 254 x 95px image here to replace the admin login logo.', 'imic-framework-admin'),
            'subtitle' => __('', 'imic-framework-admin'),
            'default' => array('url' => $default_logo),
        )
    )
);
$this->sections[] = array(
    'icon' => 'el-icon-chevron-up',
    'title' => __('Header Options', 'imic-framework-admin'),
    'desc' => __('<p class="description">These are the options for the header.</p>', 'imic-framework-admin'),
    'fields' => array(
		array(
            'id' => 'header_image',
            'type' => 'media',
            'url' => true,
            'title' => __('Header Image', 'imic-framework-admin'),
            'desc' => __('Default header image for post types.', 'imic-framework-admin'),
            'subtitle' => __('Set this image as default header image for all Page/Post/Event/Sermons/Gallery.', 'imic-framework-admin'),
            'default' => array('url' => ''),
        ),
        array(
            'id' => 'logo_upload',
            'type' => 'media',
            'url' => true,
            'title' => __('Upload Logo', 'imic-framework-admin'),
            'desc' => __('Basic media uploader with disabled URL input field.', 'imic-framework-admin'),
            'subtitle' => __('Upload site logo to display in header.', 'imic-framework-admin'),
            'default' => array('url' => $default_logo),
        ),
        array(
            'id' => 'enable-header-stick',
            'type' => 'switch',
            'title' => __('Enable Header Stick', 'imic-framework-admin'),
            'subtitle' => __('Enable/Disable Header Stick behaviour of the theme', 'imic-framework-admin'),
            "default" => 1,
        ),
		array(
            'id' => 'header_area_height',
            'type' => 'text',
            'title' => __('Header Area Height', 'imic-framework-admin'),
            'subtitle' => __('Enter height for header Area', 'imic-framework-admin'),
            'default' => 80
        ),
    
        array(
    		'id' => 'header_layout',
    		'type' => 'image_select',
    		'compiler'=>true,
			'title' => __('Header Layout','imic-framework-admin'), 
			'subtitle' => __('Select the Header layout', 'imic-framework-admin'),
    			'options' => array(
					'1' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/headerLayout/header-1.jpg'),
    				'2' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/headerLayout/header-2.jpg'),
    				'3' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/headerLayout/header-3.jpg'),
    				),
    		'default' => '1'
    						),
        array(
						'id' => 'header_social_links',
						'type' => 'sortable',
						'label' => true,
						'compiler'=>true,
						'title' => __('Social Links', 'imic-framework-admin'),
						'desc' => __('Enter the social links and sort to active and display according to sequence in header.', 'imic-framework-admin'),
						'options' => array(
										'fa-facebook-square' => 'facebook',
										'fa-twitter-square' => 'twitter',
										'fa-pinterest' => 'pinterest',
										'fa-google-plus' => 'google',
										'fa-youtube' => 'youtube',
										'fa-instagram' => 'instagram',
										'fa-vimeo-square' => 'vimeo',
										'fa-rss' => 'rss',
										'fa-dribbble' => 'dribbble',
										'fa-dropbox' => 'dropbox',
										'fa-bitbucket' => 'bitbucket',
										'fa-flickr' => 'flickr',
										'fa-foursquare' => 'foursquare',
										'fa-github' => 'github',
										'fa-gittip' => 'gittip',
										'fa-linkedin' => 'linkedin',
										'fa-pagelines' => 'pagelines',
										'fa-skype' => 'skype',
										'fa-tumblr' => 'tumblr'
							),
					)
		),
);
$this->sections[] = array(
    'icon' => 'el-icon-font',
    'title' => __('Font Options', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'body_font_typography',
            'type' => 'typography',
            'title' => __('Body Font', 'imic-framework-admin'),
            'font-style' => false,
            'line-height' => false,
            'font-size' => false,
            'preview' => false,
            'text-align' => false,
            'google' => true,
            'subsets' => true,
            'font-weight' => false,
            'font-backup'=>true,
            'word-spacing'=>true,
            'letter-spacing'=>true,
            'color'=>false,
	    'subtitle' => __('Please Enter Body Font.', 'imic-framework-admin'),
            'default' => array(
             'font-family' => 'Roboto',
			 	'color' => '#333333',
				'font-backup' => '',
				'word-spacing' => '0px',
				'letter-spacing' => '0px',
              ),
        ),
        array(
            'id' => 'heading_font_typography',
            'type' => 'typography',
            'title' => __('Heading Font', 'imic-framework-admin'),
             'font-style' => false,
            'line-height' => false,
            'font-size' => false,
            'preview' => false,
            'text-align' => false,
            'google' => true,
            'subsets' => true,
            'font-weight' => false,
            'font-backup'=>true,
            'word-spacing'=>true,
            'letter-spacing'=>true,
            'color'=>false,
            'subtitle' => __('Please Enter Heading Font', 'imic-framework-admin'),
            'default' => array(
            'font-family' => 'Roboto Condensed',
			'color' => '#cccccc',
				'font-backup' => '',
				'word-spacing' => '0px',
				'letter-spacing' => '0px',
               ),
        ),
        array(
            'id' => 'metatext_date_font_typography',
            'type' => 'typography',
            'title' => __('Metatext date Font', 'imic-framework-admin'),
            'font-style' => false,
            'line-height' => false,
            'font-size' => false,
            'preview' => false,
            'text-align' => false,
            'google' => true,
            'subsets' => true,
            'font-weight' => false,
            'font-backup'=>true,
            'word-spacing'=>true,
            'letter-spacing'=>true,
            'color'=>false,
            'subtitle' => __('Please Enter Metatext date Font', 'imic-framework-admin'),
            'default' => array(
            'font-family' => 'Volkhov',
			'color' => '#ffffff',
				'font-backup' => '',
				'word-spacing' => '0px',
				'letter-spacing' => '0px',
            ),
        ),
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-chevron-down',
    'title' => __('Footer Options', 'imic-framework-admin'),
    'desc' => __('<p class="description">These are the options for the footer.</p>', 'imic-framework-admin'),
    'fields' => array(
		array(
            'id' => 'social-facebook',
            'type' => 'text',
			'Panel' => false,
			'required' => array('theme_color_types','equals','0'),
            'title' => __('Facebook', 'imic-framework-admin'),
            'subtitle' => __('Facebook URL to link your social bar\'s facebook icon.', 'imic-framework-admin'),
            'desc' => __('Enter your facebook URL for your theme footer.', 'imic-framework-admin'),
            'default' => 'https://www.facebook.com/',
        ),
        array(
            'id' => 'social-twitter',
            'type' => 'text',
			'required' => array('theme_color_types','equals','0'),
            'title' => __('Twitter', 'imic-framework-admin'),
            'subtitle' => __("Twitter URL to link your social bar's twitter icon.", 'imic-framework-admin'),
            'desc' => __('Enter your twitter URL for your theme footer.', 'imic-framework-admin'),
            'default' => 'https://twitter.com/',
        ),
        array(
            'id' => 'social-pinterest',
            'type' => 'text',
			'required' => array('theme_color_types','equals','0'),
            'title' => __('Pinterest', 'imic-framework-admin'),
            'subtitle' => __('Pinterest URL to link your social bar\'s Pinterest icon.', 'imic-framework-admin'),
            'desc' => __('Enter your Pinterest URL for your theme footer.', 'imic-framework-admin'),
            'default' => 'https://www.pinterest.com/',
        ),
        array(
            'id' => 'social-googleplus',
            'type' => 'text',
			'required' => array('theme_color_types','equals','0'),
            'title' => __('Google+', 'imic-framework-admin'),
            'subtitle' => __('Google+ URL to link your social bar\'s googleplus icon.', 'imic-framework-admin'),
            'desc' => __('Enter your googleplus URL for your theme footer.', 'imic-framework-admin'),
            'default' => 'https://www.google.co.in/',
        ),
        array(
            'id' => 'social-youtube',
            'type' => 'text',
			'required' => array('theme_color_types','equals','0'),
            'title' => __('Youtube', 'imic-framework-admin'),
            'subtitle' => __('Youtube URL to link your social bar\'s youtube icon.', 'imic-framework-admin'),
            'desc' => __('Enter your Youtube URL for your theme footer.', 'imic-framework-admin'),
            'default' => 'http://youtube.com/',
        ),
		
		array(
            'id' => 'social-instagram',
            'type' => 'text',
			'required' => array('theme_color_types','equals','0'),
            'title' => __('Instagram', 'imic-framework-admin'),
            'subtitle' => __('Instagram URL to link your social bar\'s Instagram icon.', 'imic-framework-admin'),
            'desc' => __('Enter your Instagram URL for your theme footer.', 'imic-framework-admin'),
            'default' => 'http://instagram.com/',
        ),
		
		array(
            'id' => 'social-vimeo',
            'type' => 'text',
			'required' => array('theme_color_types','equals','0'),
            'title' => __('Vimeo', 'imic-framework-admin'),
            'subtitle' => __('Vimeo URL to link your social bar\'s Vimeo icon.', 'imic-framework-admin'),
            'desc' => __('Enter your Vimeo URL for your theme footer.', 'imic-framework-admin'),
            'default' => 'http://vimeo.com/',
        ),
        array(
            'id' => 'site-rss',
            'type' => 'text',
			'required' => array('theme_color_types','equals','0'),
            'title' => __('Rss', 'imic-framework-admin'),
            'subtitle' => __('Rss URL to link your  Rss icon.', 'imic-framework-admin'),
            'desc' => __('Enter your Rss URL for you theme footer.', 'imic-framework-admin'),
            'default' => site_url().'/feed/',
        ),
        array(
            'id' => 'footer_copyright_text',
            'type' => 'text',
            'title' => __('Footer Copyright Text', 'imic-framework-admin'),
            'subtitle' => __(' Enter Copyright Text', 'imic-framework-admin'),
            'default' => __('All Rights Reserved', 'imic-framework-admin')
        ),
		array(
						'id' => 'footer_social_links',
						'type' => 'sortable',
						'label' => true,
						'compiler'=>true,
						'title' => __('Social Links', 'imic-framework-admin'),
						'desc' => __('Insert Social URL in their respective fields and sort as your desired order.', 'imic-framework-admin'),
						'options' => array(
										'fa-facebook' => $old_social_facebook,
										'fa-twitter' => $old_social_twitter,
										'fa-pinterest' => $old_social_pinterest,
										'fa-google-plus' => $old_social_gplus,
										'fa-youtube' => $old_social_ytube,
										'fa-instagram' => $old_social_instagram,
										'fa-vimeo-square' => $old_social_vimeo,
										'fa-rss' => $old_social_rss,
										'fa-dribbble' => 'dribbble',
										'fa-dropbox' => 'dropbox',
										'fa-bitbucket' => 'bitbucket',
										'fa-flickr' => 'flickr',
										'fa-foursquare' => 'foursquare',
										'fa-github' => 'github',
										'fa-gittip' => 'gittip',
										'fa-linkedin' => 'linkedin',
										'fa-pagelines' => 'pagelines',
										'fa-skype' => 'skype',
										'fa-tumblr' => 'tumblr'
							),
					),
		array(
    		'id' => 'footer_layout',
    		'type' => 'image_select',
    		'compiler'=>true,
			'title' => __('Footer Layout', 'imic-framework-admin'), 
			'subtitle' => __('Select the footer layout', 'imic-framework'),
    			'options' => array(
					'12' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-1.png'),
    				'6' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-2.png'),
    				'4' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-3.png'),
    				'3' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-4.png'),
					'2' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-5.png'),
    							),
    		'default' => '4'
    						),	
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-website',
    'title' => __('Theme Color Options', 'imic-framework-admin'),
    'fields' => array(
		 array(
			'id'=>'theme_color_type',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Page Layout', 'imic-framework-admin'), 
			'subtitle' => __('Select the page layout type', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Pre-Defined Color Schemes','imic-framework-admin'),
					'1' => __('Custom Color','imic-framework-admin')
				),
			'default' => '0',
			),
        array(
            'id' => 'theme_color_scheme',
            'type' => 'select',
			'required' => array('theme_color_type','equals','0'),
            'title' => __('Theme Color Scheme', 'imic-framework-admin'),
            'subtitle' => __('Select your themes alternative color scheme.', 'imic-framework-admin'),
            'options' => array('color1.css' => 'color1.css', 'color2.css' => 'color2.css', 'color3.css' => 'color3.css', 'color4.css' => 'color4.css', 'color5.css' => 'color5.css', 'color6.css' => 'color6.css', 'color7.css' => 'color7.css', 'color8.css' => 'color8.css', 'color9.css' => 'color9.css', 'color10.css' => 'color10.css'),
            'default' => 'color1.css',
        ),	
		array(
			'id'=>'custom_theme_color',
			'type' => 'color',
			'required' => array('theme_color_type','equals','1'),
			'title' => __('Custom Theme Color', 'imic-framework-admin'), 
			'subtitle' => __('Pick a color for the template.', 'imic-framework-admin'),
			'validate' => 'color',
			),
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-check-empty',
    'title' => __('Layout Options', 'imic-framework-admin'),
    'fields' => array(
        array(
			'id'=>'site_layout',
			'type' => 'image_select',
			'compiler'=>true,
			'title' => __('Page Layout', 'imic-framework-admin'), 
			'subtitle' => __('Select the page layout type', 'imic-framework-admin'),
			'options' => array(
					'wide' => array('alt' => 'Wide', 'img' => ReduxFramework::$_url.'assets/img/wide.png'),
					'boxed' => array('alt' => 'Boxed', 'img' => ReduxFramework::$_url.'assets/img/boxed.png')
				),
			'default' => 'wide',
			),
		array(
			'id'=>'repeatable-bg-image',
			'type' => 'image_select',
			'required' => array('site_layout','equals','boxed'),
			'title' => __('Repeatable Background Images', 'imic-framework-admin'), 
			'subtitle' => __('Select image to set in background.', 'imic-framework-admin'),
			'options' => array(
				'pt1.png' => array('alt' => 'pt1', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt1.png'),
				'pt2.png' => array('alt' => 'pt2', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt2.png'),
				'pt3.png' => array('alt' => 'pt3', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt3.png'),
				'pt4.png' => array('alt' => 'pt4', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt4.png'),
				'pt5.png' => array('alt' => 'pt5', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt5.png'),
				'pt6.png' => array('alt' => 'pt6', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt6.png'),
				'pt7.png' => array('alt' => 'pt7', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt7.png'),
				'pt8.png' => array('alt' => 'pt8', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt8.png'),
				'pt9.png' => array('alt' => 'pt9', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt9.png'),
				'pt10.png' => array('alt' => 'pt10', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt10.png'),
				'pt11.jpg' => array('alt' => 'pt11', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt11.jpg'),
				'pt12.jpg' => array('alt' => 'pt12', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt12.jpg'),
				'pt13.jpg' => array('alt' => 'pt13', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt13.jpg'),
				'pt14.jpg' => array('alt' => 'pt14', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt14.jpg'),
				'pt15.jpg' => array('alt' => 'pt15', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt15.jpg')
				)
			),	
		array(
			'id'=>'upload-repeatable-bg-image',
			'compiler'=>true,
			'required' => array('site_layout','equals','boxed'),
			'type' => 'media', 
			'url'=> true,
			'title' => __('Upload Repeatable Background Image', 'imic-framework-admin')
			),
		array(
			'id'=>'full-screen-bg-image',
			'compiler'=>true,
			'required' => array('site_layout','equals','boxed'),
			'type' => 'media', 
			'url'=> true,
			'title' => __('Upload Full Screen Background Image', 'imic-framework-admin')
			),	
		
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-calendar',
    'title' => __('Calendar Options', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'calendar_month_name',
            'type' => 'textarea',	
            'title' => __('Calendar Month Name', 'imic-framework-admin'),
            'desc' => __('Insert month name in local language by comma seperated to display on event calender like: January,February,March,April,May,June,July,August,September,October,November,December', 'imic-framework-admin'),
			'default' => '',
        ),
		array(
            'id' => 'calendar_month_name_short',
            'type' => 'textarea',	
            'title' => __('Calendar Month Name Short', 'imic-framework-admin'),
            'desc' => __('Insert month name short in local language by comma seperated to display on event calender like: Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec', 'imic-framework-admin'),
			'default' => '',
        ),
		array(
            'id' => 'calendar_day_name',
            'type' => 'textarea',	
            'title' => __('Calendar Day Name', 'imic-framework-admin'),
            'desc' => __('Insert day name in local language by comma seperated to display on event calender like: Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday', 'imic-framework-admin'),
			'default' => '',
        ),
		array(
            'id' => 'calendar_day_name_short',
            'type' => 'textarea',	
            'title' => __('Calendar Day Name Short', 'imic-framework-admin'),
            'desc' => __('Insert day name short in local language by comma seperated to display on event calender like: Sun,Mon,Tue,Wed,Thu,Fri,Sat', 'imic-framework-admin'),
			'default' => '',
        ),
		array(
    'id'       => 'event_feeds',
    'type'     => 'checkbox',
    'title'    => __('Show WP Events', 'imic-framework-admin'),
    'desc'     => __('Check if you wants to show WP Events in Calendar.', 'imic-framework-admin'),
    'default'  => '1'// 1 = on | 0 = off
),
		array(
            'id' => 'google_feed',
            'type' => 'text',	
            'title' => __('Google Calendar Feed URL', 'imic-framework-admin'),
            'desc' => __('Enter Google Feed URL for google events in Calendar.', 'imic-framework-admin'),
			'default' => '',
        ),
		array(
			'id'=>'event_default_color',
			'type' => 'color',
			'title' => __('Event Color', 'imic-framework-admin'), 
			'subtitle' => __('Pick a default color for Events.', 'imic-framework-admin'),
			'validate' => 'color',
			'default' => ''
			),
			array(
			'id'=>'recurring_event_color',
			'type' => 'color',
			'title' => __('Recurring Event Color', 'imic-framework-admin'), 
			'subtitle' => __('Pick a color for recurring Events.', 'imic-framework-admin'),
			'validate' => 'color',
			'default' => ''
			),
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-lines',
    'title' => __('Sidebar Options', 'imic-framework-admin'),
    'fields' => array(
		array(
			'id'       => 'post_sidebar',
			'type'     => 'select',
			'title'    => __('Post Sidebar Option', 'imic-framework-admin'), 
			'desc'     => __('Select sidebar to display by default on post pages.', 'imic-framework-admin'),
			'data'  => 'sidebars',
			'default'  => '',
		),
		array(
			'id'       => 'page_sidebar',
			'type'     => 'select',
			'title'    => __('Page Sidebar Option', 'imic-framework-admin'), 
			'desc'     => __('Select sidebar to display by default on pages.', 'imic-framework-admin'),
			'data'  => 'sidebars',
			'default'  => '',
		),
		array(
			'id'       => 'event_sidebar',
			'type'     => 'select',
			'title'    => __('Event Sidebar Option', 'imic-framework-admin'), 
			'desc'     => __('Select sidebar to display by default on events.', 'imic-framework-admin'),
			'data'  => 'sidebars',
			'default'  => '',
		),
		array(
			'id'       => 'cause_sidebar',
			'type'     => 'select',
			'title'    => __('Cause Sidebar Option', 'imic-framework-admin'), 
			'desc'     => __('Select sidebar to display by default on causes.', 'imic-framework-admin'),
			'data'  => 'sidebars',
			'default'  => '',
		),
		array(
			'id'       => 'sermon_sidebar',
			'type'     => 'select',
			'title'    => __('Sermon Sidebar Option', 'imic-framework-admin'), 
			'desc'     => __('Select sidebar to display by default on sermon pages.', 'imic-framework-admin'),
			'data'  => 'sidebars',
			'default'  => '',
		),
		array(
			'id'       => 'staff_sidebar',
			'type'     => 'select',
			'title'    => __('Staff Sidebar Option', 'imic-framework-admin'), 
			'desc'     => __('Select sidebar to display by default on staff pages.', 'imic-framework-admin'),
			'data'  => 'sidebars',
			'default'  => '',
		)
	),
);
$this->sections[] = array(
    'icon' => 'el-icon-edit',
    'title' => __('Custom CSS/JS', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'custom_css',
            'type' => 'ace_editor',
            //'required' => array('layout','equals','1'),	
            'title' => __('CSS Code', 'imic-framework-admin'),
            'subtitle' => __('Paste your CSS code here.', 'imic-framework-admin'),
            'mode' => 'css',
            'theme' => 'monokai',
            'desc' => '',
            'default' => "#header{\nmargin: 0 auto;\n}"
        ),
        array(
            'id' => 'custom_js',
            'type' => 'ace_editor',
            //'required' => array('layout','equals','1'),	
            'title' => __('JS Code', 'imic-framework-admin'),
            'subtitle' => __('Paste your JS code here.', 'imic-framework-admin'),
            'mode' => 'javascript',
            'theme' => 'chrome',
            'desc' => '',
            'default' => "jQuery(document).ready(function(){\n\n});"
        )
    ),
);
$this->sections[] = array(
                'title' => __('Import / Export', 'imic-framework-admin'),
                'desc' => __('Import and Export your Theme Framework settings from file, text or URL.', 'imic-framework-admin'),
                'icon' => 'el-icon-refresh',
                'fields' => array(
                    array(
                        'id' => 'opt-import-export',
                        'type' => 'import_export',
                       'title' => __('Import Export','imic-framework-admin'),
                        'subtitle' => __('Save and restore your Theme options','imic-framework-admin'),
                        'full_width' => false,
                    ),
                ),
            ); 
                       if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'imic-framework-admin'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }
        public function setHelpTabs() {
            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'imic-framework-admin'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'imic-framework-admin')
            );
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'imic-framework-admin'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'imic-framework-admin')
            );
            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'imic-framework-admin');
        }
        /**
          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {
            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'imic_options',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', 'imic-framework-admin'),
                'page_title'        => __('IMIC Options', 'imic-framework-admin'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyDzJyslYLbuwBAqc_UTRokHKAY1ZaXrotk', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                
                // OPTIONAL -> Give you extra features
                'page_priority'     => '58',                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => false,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE
                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );
            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/imithemes',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://twitter.com/imithemes',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that we sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'imic-framework-admin'), $v);
            } else {
                //$this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'imic-framework-admin');
            }
            // Add content after the form.
            //$this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'imic-framework-admin');
        }
    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}
/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;
/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';
        /*
          do your validation
          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */
        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
