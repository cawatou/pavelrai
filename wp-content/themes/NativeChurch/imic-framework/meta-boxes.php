<?php
$home_page = get_option('page_on_front');
$featured_block = get_post_meta($home_page,'imic_home_featured_blocks1',true);
$featured_block2 = get_post_meta($home_page,'imic_home_featured_blocks2',true);
$featured_block3 = get_post_meta($home_page,'imic_home_featured_blocks3',true);
$all_blocks = array($featured_block,$featured_block2,$featured_block3);
if($featured_block!='') {
update_post_meta($home_page,'imic_home_row_featured_blocks',$all_blocks);
update_post_meta($home_page,'imic_home_featured_blocks1','');
update_post_meta($home_page,'imic_home_featured_blocks2','');
update_post_meta($home_page,'imic_home_featured_blocks3','');
}
/* * ** Meta Box Functions **** */
$prefix = 'imic_';
global $meta_boxes;
load_theme_textdomain('framework', IMIC_FILEPATH . '/language');
$meta_boxes = array();
  /* Staff Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'staff_meta_box',
    'title' => __('Staff Member Meta', 'framework'),
    'pages' => array('staff'),
    'fields' => array(
        // Staff MEMBER FACEBOOK
        array(
            'name' => __('Facebook', 'framework'),
            'id' => $prefix . 'staff_member_facebook',
            'desc' => __("Enter the staff member's Facebook URL.", 'framework'),
            'clone' => false,
            'type' => 'hidden',
            'std' => '',
        ),
        // Staff MEMBER TWITTER
        array(
            'name' => __('Twitter', 'framework'),
            'id' => $prefix . 'staff_member_twitter',
            'desc' => __("Enter the staff member's Twitter username.", 'framework'),
            'clone' => false,
            'type' => 'hidden',
            'std' => '',
        ),
        // Staff MEMBER Google+
        array(
            'name' => __('Google+', 'framework'),
            'id' => $prefix . 'staff_member_google_plus',
            'desc' => __("Enter the staff member's Google+ URL.", 'framework'),
            'type' => 'hidden',
            'std' => '',
        ),
        // Staff MEMBER Pinterest+
        array(
            'name' => __('Pinterest', 'framework'),
            'id' => $prefix . 'staff_member_pinterest',
            'desc' => __("Enter the staff member's Pinterest URL.", 'framework'),
            'type' => 'hidden',
            'std' => '',
        ),
      // Staff MEMBER Email
        array(
            'name' => __('Email', 'framework'),
            'id' => $prefix . 'staff_member_email',
            'desc' => __("Enter the staff member's Email.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Job Title', 'framework'),
            'id' => $prefix . 'staff_job_title',
            'desc' => __("Enter the staff job title.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
 	  array(
                    'name'  => __('Social Icon', 'framework'),
                    'id'    => $prefix."social_icon_list",
                    'desc'  =>  __('Enter Social Icon and Url.', 'framework'),
                    'type'  => 'text_list',
                    'clone' => true,
                    'options' => array(
                            '0' => __('Social', 'framework'),
                            '1' => __('Url', 'framework'))
                      ),
    )
);
/* Causes Meta Box
  ================================================== */
/*** Causes Details Meta box ***/   
$meta_boxes[] = array(
    'id' => 'cause_meta_box',
    'title' => __('Cause Details', 'framework'),
    'pages' => array('causes'),
    'fields' => array( 
        //Cause End Date
        array(
            'name' => __(' Cause End Date', 'framework'),
            'id' => $prefix . 'cause_end_dt',
            'desc' => __("Insert date of Cause end.", 'framework'),
            'type' => 'date',
			'js_options' => array(
				'dateFormat'      =>'yy-mm-dd',
				'changeMonth'     => true,
				'changeYear'      => true,
				'showButtonPanel' => false,
			),
        ),
		//Frequency Count
		array(
            'name' => __('Cause Amount', 'framework'),
            'id' => $prefix . 'cause_amount',
            'desc' => __("Insert total number of amount required for cause.", 'framework'),
            'type' => 'text',
        ), 
		array(
            'name' => __('Cause Amount Received', 'framework'),
            'id' => $prefix . 'cause_amount_received',
            'desc' => __("This is the total amount reveived for this cause.", 'framework'),
            'type' => 'text',
        ),      
    )
);
/* Event Meta Box
  ================================================== */
/*** Event Details Meta box ***/   
$meta_boxes[] = array(
    'id' => 'event_meta_box',
    'title' => __('Event Details Meta Box', 'framework'),
    'pages' => array('event'),
    'fields' => array( 
        // Event Start Date  
        array(
            'name' => __('Event Start Date', 'framework'),
            'id' => $prefix . 'event_start_dt',
            'desc' => __("Insert date of Event start.", 'framework'),
            'type' => 'date',
			'js_options' => array(
	                'dateFormat'      => 'yy-mm-dd',
					'changeMonth'     => true,
					'changeYear'      => true,
					'showButtonPanel' => true,
				),
        ),
        //Event End Date
        array(
            'name' => __(' Event End Date', 'framework'),
            'id' => $prefix . 'event_end_dt',
            'desc' => __("Insert date of Event end.", 'framework'),
            'type' => 'date',
			'js_options' => array(
				'dateFormat'      =>'yy-mm-dd',
				'changeMonth'     => true,
				'changeYear'      => true,
				'showButtonPanel' => false,
			),
        ),
        //Event Start Time
		array(
			'name' => __( 'Event Start Time', 'framework' ),
			'id' => $prefix.'event_start_tm',
			'type' => 'time',
			
			// jQuery datetime picker options. See here http://trentrichardson.com/examples/timepicker/
			'js_options' => array(
			'stepMinute' => 5,
			'showSecond' => false,
			'stepSecond' => 10,
			),
			),
        //Event End Time
		array(
			'name' => __( 'Event End Time', 'framework' ),
			'id' => $prefix.'event_end_tm',
			'type' => 'time',
			
			// jQuery datetime picker options. See here http://trentrichardson.com/examples/timepicker/
			'js_options' => array(
			'stepMinute' => 5,
			'showSecond' => false,
			'stepSecond' => 10,
			),
			),
         //Address
		array(
			'name'  => __('Address', 'framework'),
			'id'    => $prefix."event_address",
			'desc'  =>  __('Enter event\'s address.', 'framework'),
			'type' => 'textarea',
			'cols' => 20,
			'rows' => 3,
		),
            //Contact Number
		array(
			'name'  => __('Contact Number', 'framework'),
			'id'    => $prefix."event_contact",
			'desc'  =>  __('Enter event\'s contact number.', 'framework'),
			'type'  => 'text',
		),  
		array(
            'name' => __('Event Registration', 'framework'),
            'id' => $prefix . 'event_registration_status',
            'desc' => __("Select Enabled to active Event Registration.", 'framework'),
            'type' => 'select',
            'options' => array(
		'0' => __('Disable', 'framework'),
				'1' => __('Enable','framework'),
            ),
			'std' => 0,
        ),
		array(
			'name'  => __('Event Registration Fee', 'framework'),
			'id'    => $prefix."event_registration_fee",
			'desc'  =>  __('Enter event\'s registration fee(This field will work only when native-church-plugin activated.)', 'framework'),
			'type'  => 'text',
		),      
    )
);
/*** Event Recurrence Meta box ***/   
$meta_boxes[] = array(
    'id' => 'event_recurring_box',
    'title' => __('Event Recurrence Box', 'framework'),
    'pages' => array('event'),
    'fields' => array( 		 
        //Frequency of Event
        array(
            'name' => __('Event Frequency', 'framework'),
            'id' => $prefix . 'event_frequency',
            'desc' => __("Select Frequency.", 'framework'),
            'type' => 'select',
            'options' => array(
				'0' => __('Not Required','framework'),
                '1' => __('Every Day', 'framework'),
				'2' => __('Every Second Day', 'framework'),
				'3' => __('Every Third Day', 'framework'),
				'4' => __('Every Fourth Day', 'framework'),
				'5' => __('Every Fifth Day', 'framework'),
				'6' => __('Every Sixth Day', 'framework'),
                '7' => __('Every Week', 'framework'),
				'30' => __('Every Month', 'framework'),
            ),
        ),
		//Frequency Count
		array(
            'name' => __('Number of times to repeat event', 'framework'),
            'id' => $prefix . 'event_frequency_count',
            'desc' => __("Enter the number of how many time this event should repeat.", 'framework'),
            'type' => 'text',
        ),    
		array(
            'name' => __('Do not change', 'framework'),
            'id' => $prefix . 'event_frequency_end',
            'desc' => __("If any changes done in this file, may your theme will not work like running now.", 'framework'),
            'type' => 'hidden',
        ),    
    )
);
/*** Total Persons Details Meta box ***/   
$meta_boxes[] = array(
    'id' => 'event_person_meta_box',
    'title' => __('Total Persons Details Meta Box', 'framework'),
    'pages' => array('event'),
    'fields' => array( 
        //Attendees
       	array(
			'name'  => __('Attendees', 'framework'),
			'id'    => $prefix."event_attendees",
			'desc'  =>  __('Enter number of attendees.', 'framework'),
			'type'  => 'text',
		),
        //Staff Members
		array(
			'name'  => __('Staff Members', 'framework'),
			'id'    => $prefix."event_staff_members",
			'desc'  =>  __('Enter number of staff members.', 'framework'),
			'type'  => 'text',
		),
		array(
			'name'  => __('Email Address', 'framework'),
			'id'    => $prefix."event_email",
			'desc'  =>  __('Enter Email for Event.', 'framework'),
			'type'  => 'text',
		),
    )
);
/*** Featured Event Meta box ***/   
$meta_boxes[] = array(
    'id' => 'featured_event_meta_box',
    'title' => __('Featured Event Meta Box', 'framework'),
    'pages' => array('event'),
    'fields' => array( 
        //Attendees
       	array(
			'name'  => __('Featured Event', 'framework'),
			'id'    => $prefix."event_featured",
			'desc'  =>  __('Select for featured event .', 'framework'),
			'type'  => 'select',
                       'options' => array(
                       '0' => __('No', 'framework'),
                      '1' => __('Yes', 'framework'),
                     ),
		),
        )
);
/* Gallery Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'gallery_meta_box',
    'title' => __('Post Meta Box', 'framework'),
    'pages' => array('gallery', 'post'),
    'fields' => array(
        // Gallery Video Url
        array(
            'name' => __('Video Url', 'framework'),
            'id' => $prefix . 'gallery_video_url',
            'desc' => __("Enter the Video URL.", 'framework'),
            'type' => 'url',
        ),
        // Gallery Link Url
        array(
            'name' => __('Link Url', 'framework'),
            'id' => $prefix . 'gallery_link_url',
            'desc' => __("Enter the Link URL.", 'framework'),
            'type' => 'url',
        ),
        // Gallery Images
        array(
            'name' => __('Gallery Image', 'framework'),
            'id' => $prefix . 'gallery_images',
            'desc' => __("Enter Gallery Image.", 'framework'),
            'type' => 'image_advanced',
        ),
		array(
            'name' => __('Slider Image', 'framework'),
            'id' => $prefix . 'gallery_slider_image',
            'desc' => __("Enter Slider Image.", 'framework'),
            'type' => 'image_advanced',
        ),
		array(
            'name' => __('Slider Speed', 'framework'),
            'id' => $prefix . 'gallery_slider_speed',
            'desc' => __("Default Slider Speed is 5000.", 'framework'),
            'type' => 'text',
        ),
       array(
            'name' => __('Slider Pagination', 'framework'),
            'id' => $prefix . 'gallery_slider_pagination',
            'desc' => __("Enable to show pagination for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Enable', 'framework'),
                'no' => __('Disable', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Auto Slide', 'framework'),
            'id' => $prefix . 'gallery_slider_auto_slide',
            'desc' => __("Select Yes to slide automatically.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Direction Arrows', 'framework'),
            'id' => $prefix . 'gallery_slider_direction_arrows',
            'desc' => __("Select Yes to show slider direction arrows.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Effects', 'framework'),
            'id' => $prefix . 'gallery_slider_effects',
            'desc' => __("Select effects for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'fade' => __('Fade', 'framework'),
                'slide' => __('Slide', 'framework'),
            ),
        ),
        //Audio Display
        array(
            'name' => __('Audio Display', 'framework'),
            'id' => $prefix . 'gallery_audio_display',
            'desc' => __("Select Audio Display.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('By Ifame', 'framework'),
                '2' => __('By Upload', 'framework'),
            ),
        ),
        array(
            'name' => __('SoundCloud Track', 'framework'),
            'id' => $prefix . 'gallery_audio',
            'desc' => __("Enter SoundCloud iframe code to show on post.", 'framework'),
            'type' => 'textarea',
            'std' => '',
        ),
        // Upload Audio
        array(
            'name' => __('Audio', 'framework'),
            'id' => $prefix . 'gallery_uploaded_audio',
            'desc' => __("Upload Audio.", 'framework'),
            'type' => 'file_advanced',
            'max_file_uploads' => 1
        ),
    )
);
/* Post Page Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'post_page_meta_box',
    'title' => __('Page/Post Header Options', 'framework'),
   'pages' => array('post','page','sermons','event','product'),
    'fields' => array(
        // Custom title
        array(
            'name' => __('Custom Title', 'framework'),
            'id' => $prefix . 'post_page_custom_title',
            'desc' => __("Enter Custom Title.", 'framework'),
            'type' => 'text',
        ),
		array(
            'name' => __('Choose Header Type', 'framework'),
            'id' => $prefix . 'pages_Choose_slider_display',
            'desc' => __("Select Slider Display.", 'framework'),
            'type' => 'select',
            'options' => array(
				  '0' => __('Banner Image', 'framework'),
                '1' => __('Flex Slider', 'framework'),
                '2' => __('Revolution Slider', 'framework'),
            ),
        ),
		array(
            'name' => __('Banner Image', 'framework'),
            'id' => $prefix . 'header_image',
            'desc' => __("Upload banner image for header for this Page/Post.", 'framework'),
            'type' => 'image_advanced',
            'max_file_uploads' => 1
        ),
        array(
                   'name' => __('Select Revolution Slider from list','framework'),
                    'id' => $prefix . 'pages_select_revolution_from_list',
                    'desc' => __("Select Revolution Slider from list", 'framework'),
                    'type' => 'select',
                    'options' => RevSliderShortCode(),
                ),
        //Slider Image
		array(
            'name' => __('Slider Height', 'framework'),
            'id' => $prefix . 'pages_slider_height',
            'desc' => __("Default Slider Height is 200.", 'framework'),
            'type' => 'text',
        ),
        array(
            'name' => __('Slider Image', 'framework'),
            'id' => $prefix . 'pages_slider_image',
            'desc' => __("Enter Slider Image.", 'framework'),
            'type' => 'image_advanced',
        ),
		array(
            'name' => __('Slider Speed', 'framework'),
            'id' => $prefix . 'pages_slider_speed',
            'desc' => __("Default Slider Speed is 5000.", 'framework'),
            'type' => 'text',
        ),
		array(
            'name' => __('Slider Pagination', 'framework'),
            'id' => $prefix . 'pages_slider_pagination',
            'desc' => __("Enable to show pagination for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Enable', 'framework'),
                'no' => __('Disable', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Auto Slide', 'framework'),
            'id' => $prefix . 'pages_slider_auto_slide',
            'desc' => __("Select Yes to slide automatically.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Direction Arrows', 'framework'),
            'id' => $prefix . 'pages_slider_direction_arrows',
            'desc' => __("Select Yes to show slider direction arrows.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Effects', 'framework'),
            'id' => $prefix . 'pages_slider_effects',
            'desc' => __("Select effects for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'fade' => __('Fade', 'framework'),
                'slide' => __('Slide', 'framework'),
            ),
        ),
        )
);
/* Post Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'post_meta_box',
    'title' => __('Custom Description  Meta Box', 'framework'),
    'pages' => array('post'),
    'fields' => array(
        // Custom Description
        array(
            'name' => __('Custom Description', 'framework'),
            'id' => $prefix . 'post_custom_description',
            'desc' => __("Enter Custom Description.", 'framework'),
            'type' => 'textarea',
        ),
     )
);
/* Sermon Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'sermons_meta_box',
    'title' => __('Sermons  Meta Box', 'framework'),
    'pages' => array('sermons'),
    'fields' => array(
         //Pdf
        array(
            'name' => __('Upload Pdf', 'framework'),
            'id' => $prefix . 'sermons_pdf_upload_option',
            'desc' => __("Select Pdf Upload Option.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('By Upload', 'framework'),
                '2' => __('By Url', 'framework'),
            ),
        ),
        // Upload Pdf
        array(
            'name' => __('Upload Pdf', 'framework'),
            'id' => $prefix . 'sermons_Pdf',
            'desc' => __("Upload Pdf for Sermons.", 'framework'),
            'type' => 'file_advanced',
            'max_file_uploads' => 1
        ),
        // Upload Pdf by url
        array(
            'name' => __('Upload Pdf', 'framework'),
            'id' => $prefix . 'sermons_pdf_by_url',
            'desc' => __("Enter Pdf Url for Sermons.", 'framework'),
            'type' => 'url',
            
        ),
        // Sermons Url
        array(
            'name' => __('Sermons Url', 'framework'),
            'id' => $prefix . 'sermons_url',
            'desc' => __("Enter vimeo/youtube url for Sermons.", 'framework'),
            'type' => 'url',
        ),
         //Audio Display
        array(
            'name' => __('Upload Audio', 'framework'),
            'id' => $prefix . 'sermons_audio_upload',
            'desc' => __("Select Audio Upload Option.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('By Upload', 'framework'),
                '2' => __('By Url', 'framework'),
            ),
        ),
        // Upload Audio
        array(
            'name' => __('Audio', 'framework'),
            'id' => $prefix . 'sermons_audio',
            'desc' => __("Upload Audio.", 'framework'),
            'type' => 'file_advanced',
            'max_file_uploads' => 1
        ),
        array(
            'name' => __('Audio', 'framework'),
            'id' => $prefix . 'sermons_url_audio',
            'desc' => __("Enter Audio Url for Sermons", 'framework'),
            'type' => 'url',
           
        ),
      )
);
/* * **Contact Page Meta Box 1 *** */
$meta_boxes[] = array(
    'id' => 'template-contact1',
    'title' => __('Email & Subject', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
            //Email
        array(
            'name' => __('Email', 'framework'),
            'id' => $prefix . 'contact_email',
            'desc' => __("Enter Email to Use in contact Form in default admin email used.", 'framework'),
            'type' => 'text',
            'std' => get_option('admin_email')
        ),
        //Subject
        array(
            'name' => __('Subject', 'framework'),
            'id' => $prefix . 'contact_subject',
            'desc' => __("Enter Subject to Use in contact Page.", 'framework'),
            'type' => 'textarea',
        ),
    )
);
/* * **Contact Page Meta Box 2 *** */
$meta_boxes[] = array(
    'id' => 'template-contact2',
    'title' => __('Map Box', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
        //Our Location Text
        array(
            'name' => __('Our Location Text', 'framework'),
            'id' => $prefix . 'our_location_text',
            'desc' => __("Enter the Our Location Text to display on cotact page.", 'framework'),
            'type' => 'text',
        ),
        //Map Display
        array(
            'name' => __('Map Display', 'framework'),
            'id' => $prefix . 'contact_map_display',
            'desc' => __("Select Map Display.", 'framework'),
            'type' => 'select',
            'options' => array(
                'no' => __('No', 'framework'),
                'yes' => __('Yes', 'framework'),
            ),
        ),
        //Map Box Code
        array(
            'name' => __('Map Box Code', 'framework'),
            'id' => $prefix . 'contact_map_box_code',
            'desc' => __("Enter the code to display on cotact page.", 'framework'),
            'type' => 'textarea',
        ),
    )
);
/* * **Home Page Meta Box1 *** */
$meta_boxes[] = array(
    'id' => 'template-home1',
    'title' => __('Slider Metabox', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
         array(
            'name' => __('Choose Slider', 'framework'),
            'id' => $prefix . 'Choose_slider_display',
            'desc' => __("Select Slider Display.", 'framework'),
            'type' => 'select',
            'options' => array(
                '0' => __('Flex Slider', 'framework'),
                '1' => __('Revolution Slider', 'framework'),
            ),
        ),
        array(
                   'name' => __("Select Revolution Slider from list","framework"),
                    'id' => $prefix . 'select_revolution_from_list',
                    'desc' => __("Select Revolution Slider from list", 'framework'),
                    'type' => 'select',
                    'options' => RevSliderShortCode(),
                ),
        //Slider Image
        array(
            'name' => __('Slider Image', 'framework'),
            'id' => $prefix . 'slider_image',
            'desc' => __("Enter Slider Image.", 'framework'),
            'type' => 'image_advanced',
        ),
		array(
            'name' => __('Slider Speed', 'framework'),
            'id' => $prefix . 'slider_speed',
            'desc' => __("Default Slider Speed is 5000.", 'framework'),
            'type' => 'text',
        ),
		array(
            'name' => __('Slider Pagination', 'framework'),
            'id' => $prefix . 'slider_pagination',
            'desc' => __("Enable to show pagination for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Enable', 'framework'),
                'no' => __('Disable', 'framework'),
            ),
				'std' => 'yes',
        ),
		array(
            'name' => __('Slider Auto Slide', 'framework'),
            'id' => $prefix . 'slider_auto_slide',
            'desc' => __("Select Yes to slide automatically.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Direction Arrows', 'framework'),
            'id' => $prefix . 'slider_direction_arrows',
            'desc' => __("Select Yes to show slider direction arrows.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Effects', 'framework'),
            'id' => $prefix . 'slider_effects',
            'desc' => __("Select effects for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'fade' => __('Fade', 'framework'),
                'slide' => __('Slide', 'framework'),
            ),
        ),
        ));
/* * **Home Second Meta Box1 *** */
$meta_boxes[] = array(
    'id' => 'template-h-second-1',
    'title' => __('Categories Area', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		array(
            'name' => __('Switch for categories area', 'framework'),
            'id' => $prefix . 'switch_categories_post',
            'desc' => __("Select enable or disable to show/hide categories posts area.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Enable', 'framework'),
                '2' => __('Disable', 'framework'),
            ),
				'std' => '1',
        ),
        array(
            'name' => __('Category show on home page', 'framework'),
            'id' => $prefix . 'category_to_show_on_home',
            'desc' => __("Choose Category to show  on Home page", 'framework'),
            'clone' => true,
            'clone-group' => 'imic-clone-group',
            'type' => 'select',
            'options' => imic_get_cat_list()
        ),
        array(
            'name' => __('Number of Post', 'framework'),
            'id' => $prefix . 'number_of_post_cat',
            'desc' => __("Enter Number of Post", 'framework'),
            'type' => 'text',
            'std' => '',
            'clone' => true,
            'clone-group' => 'imic-clone-group',
        ),
    ),
);
/* * **Home Page Meta Box6 *** */
$meta_boxes[] = array(
    'id' => 'template-home6',
    'title' => __('Select option for Area Under Slider', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		array(
            'name' => __('Switch for section under slider', 'framework'),
            'id' => $prefix . 'upcoming_area',
            'desc' => __("Select enable or disable to show/hide Event/Sermon under slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Enable', 'framework'),
                '2' => __('Disable', 'framework'),
            ),
			'std' => '1',
        ),
        array(
            'name' => __('Recent Event/Sermon', 'framework'),
            'id' => $prefix . 'latest_sermon_events_to_show_on',
            'desc' => __("Choose Latest item to show under slider", 'framework'),
            'type' => 'select',
            'options' => array(
                'letest_event' => __('Latest event', 'framework'),
                'letest_sermon' => __('Latest Sermon', 'framework'),
				'text' => __('Custom Message', 'framework'),
            ),
        ),
		array(
            'name' => __('Custom Text Message', 'framework'),
            'id' => $prefix . 'custom_text_message',
            'desc' => __("Enter Custom Message, this field could also be use for shortcodes.", 'framework'),
            'type' => 'textarea',
        ),
        array(
        'name'    => __( 'Event Category', 'framework' ),
        'id'      => $prefix . 'advanced_event_taxonomy',
        'desc' => __("Choose Event Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'event-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
            ),
        array(
            'name' => __('Switch for Going on events', 'framework'),
            'id' => $prefix . 'going_on_events',
            'desc' => __("Select enable or disable to show/hide Going On Events under slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Disable', 'framework'),
                '2' => __('Enable', 'framework'),
            ),
			'std' => '1',
        ),
        	array(
            'name' => __('Custom Going On Events Title', 'framework'),
            'id' => $prefix . 'custom_going_on_events_title',
            'desc' => __("Enter Going On Events Title.", 'framework'),
            'type' => 'text',
        ),
            array(
        'name'    => __( 'Sermons Category', 'framework' ),
        'id'      => $prefix . 'advanced_sermons_category',
        'desc' => __("Choose Sermons Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'sermons-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
            ),
        array(
            'name' => __('All Event/Sermon Button Url', 'framework'),
            'id' => $prefix . 'all_event_sermon_url',
            'desc' => __("Enter Event/Sermon Button Url", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
        ));
/* * **Home Page Meta Box4 *** */
$meta_boxes[] = array(
    'id' => 'template-home4',
    'title' => __('Featured Blocks Area', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		array(
            'name' => __('Switch for featured blocks', 'framework'),
            'id' => $prefix . 'imic_featured_blocks',
            'desc' => __("Select enable or disable to show/hide feature blocks.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Enable', 'framework'),
                '2' => __('Disable', 'framework'),
            ),
			'std' => '1',
        ),
        array(
            'name' => __('Featured Blocks to show on home page', 'framework'),
            'id' => $prefix . 'home_featured_blocks',
            'desc' => __("Enter the Posts/Pages comma separated Id to show on Home page featured block. example - 1,2,3", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => __('Title for featured blocks', 'framework'),
            'id' => $prefix . 'home_row_featured_blocks',
            'desc' => __("Enter the title for featured blocks", 'framework'),
            'type' => 'text',
			'clone' => true,
            'std' => ''
        ),
        array(
            'name' => __('Title for first featured block', 'framework'),
            'id' => $prefix . 'home_featured_blocks1',
            'desc' => __("Enter the title for first featured block area", 'framework'),
            'type' => 'hidden',
            'std' => ''
        ),
         array(
            'name' => __('Title for second featured block', 'framework'),
            'id' => $prefix . 'home_featured_blocks2',
            'desc' => __("Enter the title for second featured block area", 'framework'),
            'type' => 'hidden',
            'std' => ''
        ),
         array(
            'name' => __('Title for third featured block', 'framework'),
            'id' => $prefix .'home_featured_blocks3',
            'desc' => __("Enter the title for third featured block area", 'framework'),
            'type' => 'hidden',
            'std' => ''
        ),
        ));
/* * **Home Page Meta Box7 *** */
$meta_boxes[] = array(
    'id' => 'template-home7',
   'title' => __('Upcoming Events Area', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		array(
            'name' => __('Switch for upcoming events', 'framework'),
            'id' => $prefix . 'imic_upcoming_events',
            'desc' => __("Select enable or disable to show/hide upcoming events.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Enable', 'framework'),
                '2' => __('Disable', 'framework'),
            ),
			'std' => '1',
        ),
		array(
        'name'    => __( 'Event Category', 'framework' ),
        'id'      => $prefix . 'upcoming_event_taxonomy',
        'desc' => __("Choose Event Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'event-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
            ),
		//Custom More Upcoming Events Title
		array(
            'name' => __('Custom More Upcoming Events Title', 'framework'),
            'id' => $prefix . 'custom_upcoming_events_title',
            'desc' => __("Enter More Upcoming Events Title.", 'framework'),
            'type' => 'text',
        ),
        array(
            'name' => __('Number of Events to show on home page', 'framework'),
            'id' => $prefix . 'events_to_show_on',
            'desc' => __("Enter the number of Events to show on Home page. example - 3 .", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
        ));
/* * **Home Page Meta Box5 *** */
$meta_boxes[] = array(
    'id' => 'template-home5',
    'title' => __('Recent Posts Area', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		array(
            'name' => __('Switch for recent post.', 'framework'),
            'id' => $prefix . 'imic_recent_posts',
            'desc' => __("Select enable or disable to show/hide recent posts.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Enable', 'framework'),
                '2' => __('Disable', 'framework'),
            ),
			'std' => '1',
        ),
		array(
        'name'    => __( 'Post Category', 'framework' ),
        'id'      => $prefix . 'recent_post_taxonomy',
        'desc' => __("Choose Post Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
				'std' => '',
            ),
	//Custom Latest News Title
		array(
            'name' => __('Custom Latest News Title', 'framework'),
            'id' => $prefix . 'custom_latest_news_title',
            'desc' => __("Enter Custom Latest News Title.", 'framework'),
            'type' => 'text',
        ),
        array(
            'name' => __('Number of Recent Posts to show on home page.', 'framework'),
            'id' => $prefix . 'posts_to_show_on',
            'desc' => __("Enter the number of Recent Posts to show on Home page. example - 3 .", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
        ));
/* * **Home Page Meta Box3 *** */
$meta_boxes[] = array(
    'id' => 'template-home3',
    'title' => __('Recent Galleries Area', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		array(
            'name' => __('Switch for gallery', 'framework'),
            'id' => $prefix . 'imic_galleries',
            'desc' => __("Select enable or disable to show/hide galleries.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Enable', 'framework'),
                '2' => __('Disable', 'framework'),
            ),
			'std' => '1',
        ),
		array(
        'name'    => __( 'Gallery Categories', 'framework' ),
        'id'      => $prefix . 'home_gallery_taxonomy',
        'desc' => __("Choose Gallery Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'gallery-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
				'std' => '',
            ),
		//Custom Gallery Title
        array(
            'name' => __('Custom Gallery Title', 'framework'),
            'id' => $prefix . 'custom_gallery_title',
            'desc' => __("Enter Custom Gallery Title.", 'framework'),
            'type' => 'text',
        ),
        array(
            'name' => __('Custom More Galleries Title', 'framework'),
            'id' => $prefix . 'custom_more_galleries_title',
            'desc' => __("Enter Custom More Galleries Title.", 'framework'),
            'type' => 'text',
        ),
        array(
            'name' => __('Custom More Galleries Url', 'framework'),
            'id' => $prefix . 'custom_more_galleries_url',
            'desc' => __("Enter Custom More Galleries Url.", 'framework'),
            'type' => 'url',
        ),
        array(
            'name' => __('Number of Galleries to show on home page', 'framework'),
            'id' => $prefix . 'galleries_to_show_on',
            'desc' => __("Enter the number of Galleries to show on Home page. example - 3 .", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => __('Upload Background Image', 'framework'),
            'id' => $prefix.'galleries_background_image',
            'desc' => __("Upload Background Image", 'framework'),
            'type' => 'image_advanced',
            'max_file_uploads' => 1
        ),
        ));
/* * **Home third Meta Box1 *** */
$meta_boxes[] = array(
    'id' => 'template-h-third-1',
    'title' => __('Latest Sermon Albums', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		array(
            'name' => __('Switch for Sermon Albums', 'framework'),
            'id' => $prefix . 'switch_sermon_album',
            'desc' => __("Select enable or disable to show/hide Sermon Albums posts area.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Enable', 'framework'),
                '2' => __('Disable', 'framework'),
            ),
			'std' => '1',
        ),
		
        array(
            'name' => __('Custom Latest Sermon Albums Title', 'framework'),
            'id' => $prefix . 'custom_albums_title',
            'desc' => __("Enter Custom Latest Sermon Albums Title", 'framework'),
            'type' => 'text',
            'std' => '',
           ),
        array(
            'name' => __('Number of Sermon Albums', 'framework'),
            'id' => $prefix . 'number_of_sermon_albums',
            'desc' => __("Enter Number of Sermon Albums", 'framework'),
            'type' => 'text',
            'std' => '',
           ),
        //Custom All Sermon Albums Url
	array(
            'name' => __('All Sermon Albums Url', 'framework'),
            'id' => $prefix . 'sermon_albums_url',
            'desc' => __("Enter Sermon Albums Url", 'framework'),
            'type' => 'text',
        ),
    ),
);
/* * ** Gallery  Pagination Meta Box 1 *** */
$meta_boxes[] = array(
    'id' => 'template-gallery-pagination1',
    'title' => __('Gallery to show', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
        //Number of Gallery to show
        array(
            'name' => __('Number of Gallery to show', 'framework'),
            'id' => $prefix . 'gallery_pagination_to_show_on',
            'desc' => __("Enter the number of gallery  to show on Gallery page example - 3 .", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
         array(
            'name' => __('Gallery Columns Layout', 'framework'),
            'id' => $prefix . 'gallery_pagination_columns_layout',
            'desc' => __("Enter the number of Columns for Layout  to show on Gallery page example - 3 .", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
    )
);
/* * ** Gallery Masonry Meta Box 1 *** */
$meta_boxes[] = array(
    'id' => 'template-gallery-masonry1',
    'title' => __('Gallery to show', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
        //Number of Gallery to show
        array(
            'name' => __('Number of Gallery to show', 'framework'),
            'id' => $prefix . 'gallery_masonry_to_show_on',
            'desc' => __("Enter the number of gallery  to show on Gallery page example - 3 .", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
       )
);
/* * ** Gallery  Filter Meta Box 1 *** */
$meta_boxes[] = array(
    'id' => 'template-gallery-filter1',
    'title' => __('Gallery to show', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
       array(
            'name' => __('Gallery Columns Layout', 'framework'),
            'id' => $prefix . 'gallery_filter_columns_layout',
            'desc' => __("Enter the number of Columns for Layout  to show on Gallery Filter page example - 3 .", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
    )
);
/* * ** Gallery  Category Meta Box 1 *** */
$meta_boxes[] = array(
    'id' => 'gallery-taxonomies',
    'title' => __('Gallery Categories', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		array(
        'name'    => __( 'Gallery Category', 'framework' ),
        'id'      => $prefix . 'advanced_gallery_taxonomy',
        'desc' => __("Choose Gallery Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'gallery-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
				'std' => '',
            ),
    )
);
/* * ** Event  Category Meta Box 1 *** */
$meta_boxes[] = array(
    'id' => 'events-taxonomies',
    'title' => __('Events Categories', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		array(
        'name'    => __( 'Event Category', 'framework' ),
        'id'      => $prefix . 'advanced_event_list_taxonomy',
        'desc' => __("Choose Event Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'event-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
			'std' => '',
            ),
    )
);
/* * ** Post  Category Meta Box 1 *** */
$meta_boxes[] = array(
    'id' => 'post-taxonomies',
    'title' => __('Post Categories', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		array(
        'name'    => __( 'Post Category', 'framework' ),
        'id'      => $prefix . 'advanced_post_taxonomy',
        'desc' => __("Choose Post Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
				'std' => '',
            ),
    )
);
/* * ** Post  Category Meta Box 1 *** */
$meta_boxes[] = array(
    'id' => 'post-taxonomies-blog',
    'title' => __('Post Categories', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		array(
        'name'    => __( 'Post Category', 'framework' ),
        'id'      => $prefix . 'advanced_blog_taxonomy',
        'desc' => __("Choose Post Category If you are going to set this page as blog.", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
				'std' => '',
            ),
    )
);
/* * ** Staff Page Meta Box 1 *** */
$meta_boxes[] = array(
    'id' => 'template-staff1',
    'title' => __('Staff to show', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
        //Number of Staff to show
        array(
            'name' => __('Number of Staff to show', 'framework'),
            'id' => $prefix . 'staff_to_show_on',
            'desc' => __("Enter the number of Staff  to show on Staff page example - 3 .", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => __('Select orderby', 'framework'),
            'id' => $prefix . 'staff_select_orderby',
            'desc' => __("Select Staff orderby.", 'framework'),
            'type' => 'select',
            'options' => array(
                'ID' => __('ID', 'framework'),
                'menu_order' => __('Menu Order', 'framework'),
            ),
        ),
       )
);
/* * ******************* META BOX REGISTERING ********************** */
/**
 * Register meta boxes
 *
 * @return void
 */
function imic_register_meta_boxes() {
    global $meta_boxes;
    // Make sure there's no errors when the plugin is deactivated or during upgrade
    if (class_exists('RW_Meta_Box')) {
        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
    }
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking Page template, categories, etc.
add_action('admin_init', 'imic_register_meta_boxes');
/* * ******************* META BOX CHECK ********************** */
/**
 * Check if meta boxes is included
 *
 * @return bool
 */
function rw_maybe_include($template_file) {
    // Include in back-end only
    if (!defined('WP_ADMIN') || !WP_ADMIN)
        return false;
    // Always include for ajax
    if (defined('DOING_AJAX') && DOING_AJAX)
        return true;
    // Check for post IDs
    $checked_post_IDs = array();
    if (isset($_GET['post']))
        $post_id = $_GET['post'];
    elseif (isset($_POST['post_ID']))
        $post_id = $_POST['post_ID'];
    else
        $post_id = false;
    $post_id = (int) $post_id;
    if (in_array($post_id, $checked_post_IDs))
        return true;
    // Check for Page template
    $checked_templates = array($template_file);
    $template = get_post_meta($post_id, '_wp_page_template', true);
    if (in_array($template, $checked_templates))
        return true;
// If no condition matched
    return false;
}
?>