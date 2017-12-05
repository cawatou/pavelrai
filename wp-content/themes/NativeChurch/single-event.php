<?php get_header();
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
while(have_posts()):the_post();
$transaction_id=isset($_REQUEST['tx'])?$_REQUEST['tx']:'';
if($transaction_id!='') {
	global $wpdb;
	$table_name = $wpdb->prefix . "imic_payment_transaction";
	$payment_array=imic_validate_payment($transaction_id);
	$st = $payment_array['payment_status'];
	$user_id=isset($_REQUEST['item_number'])?$_REQUEST['item_number']:'';
	$cause_id=strstr($user_id, '-', true);
	$cause_name=get_the_title($cause_id);
	if(!empty($transaction_id)&&!empty($st)){
		$sql_select="select transaction_id from $table_name WHERE `transaction_id` = '$transaction_id'";
		$data =$wpdb->get_results($sql_select,ARRAY_A)or print mysql_error();
		if(empty($data)){
			$amt=isset($_REQUEST['amt'])?$_REQUEST['amt']:'';
			$sql = "UPDATE $table_name SET transaction_id='$transaction_id',status='$st' WHERE cause_id='$user_id'";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}else{}
	}
}
$registration_status = get_post_meta(get_the_ID(),'imic_event_registration_status',true);
$pageOptions = imic_page_design(); //page design options ?>
<div <?php post_class('container'); ?> id="post-<?php the_ID(); ?>">
    <div class="row">
    <?php if(isset($_REQUEST['tx'])){ ?>
                <div class="col-md-12 appear-animation bounceInRight appear-animation-visible" data-appear-animation="bounce-in-up">
                    <div class="alert alert-info fade in">
                        <?php _e('Thanks for registering this event.','framework'); ?>
                    </div>
                </div>
                <?php } ?>
    	<div class="<?php echo $pageOptions['class']; ?>"> 
			<?php
			$event_registration_fee = get_post_meta(get_the_ID(),'imic_event_registration_fee',true);
            $eventStartDate = strtotime(get_post_meta(get_the_ID(), 'imic_event_start_dt', true));
            $eventEndDate = strtotime(get_post_meta(get_the_ID(), 'imic_event_end_dt', true));
            $eventStartTime = get_post_meta(get_the_ID(), 'imic_event_start_tm', true);
            $eventStartTime = strtotime($eventStartTime);
            if ($eventStartTime != '') {
            $eventStartTime = date(get_option('time_format'), $eventStartTime);
            }
            $eventEndTime = get_post_meta(get_the_ID(), 'imic_event_end_tm', true);
            $eventEndTime = strtotime($eventEndTime);
            if ($eventEndTime != '' && $eventEndTime != 'time') {
            $eventEndTime = date(get_option('time_format'), $eventEndTime);
            }
            $stime = '';
            $etime = '';
            if ($eventStartTime != '' && $eventStartTime != 'time') {
                $stime = $eventStartTime;
            }
            if ($eventEndTime != '') {
                $etime = ' - ' . $eventEndTime;
            }
            /** Event Details Manage * */
            $date = '';
            $event_date = get_query_var('event_date');
            if(!empty($event_date)) {
            $eventStartDate = date_i18n(get_option('date_format'), strtotime($event_date));
            $s_day_name = date_i18n('l', strtotime($event_date));
            $daysTemp = imic_day_diff(get_the_ID());
            if ($daysTemp > 0) {
            $end_date = strtotime("+" . $daysTemp . " day", strtotime($event_date));
            $e_day_name = date_i18n('l', $end_date);
            $eventEndDate = date_i18n(get_option('date_format'), $end_date);
            } else {
            $e_day_name = '';
            $eventEndDate = '';
            }
            if (!empty($eventStartDate) && !empty($eventEndDate) && $eventStartDate !== $eventEndDate) {
            $date = '<strong>' . $s_day_name . '</strong> | ' . $eventStartDate . __(' to ', 'framework') . ' <strong>' . $e_day_name . '</strong> | ' . $eventEndDate;
            } else {
            if (!empty($eventStartDate)) {
            $date = '<strong>' . $s_day_name . '</strong> | ' . $eventStartDate;
            }
            }
            } else {
            if (!empty($eventStartDate) && !empty($eventEndDate) && $eventStartDate !== $eventEndDate) {
            $date = '<strong>' . date_i18n('l', $eventStartDate) . '</strong> | ' . date_i18n(get_option('date_format'), $eventStartDate) . __(' to ', 'framework') . ' <strong>' . date_i18n('l', $eventEndDate) . '</strong> | ' . date_i18n(get_option('date_format'), $eventEndDate);
            } else {
            if (!empty($eventStartDate)) {
            $date = '<strong>' . date_i18n('l', $eventStartDate) . '</strong> | ' . date_i18n(get_option('date_format'), $eventStartDate);
            }
            }
            }
            $eventDetailIcons = array('fa-calendar', 'fa-clock-o', 'fa-map-marker', 'fa-phone');
            $eventDetailsData = array($date, $stime . $etime, get_post_meta(get_the_ID(), 'imic_event_address', true), get_post_meta(get_the_ID(), 'imic_event_contact', true));
            $eventValues = array_filter($eventDetailsData, 'strlen');
            /** Event Persons Manage * */
			if($registration_status==1) {
            $eventPersonDetails = array(__('Attendees','framework'),__('Staff members','framework'),__('Registration','framework'));
            if((is_plugin_active('Payment-Imithemes/causes.php'))&&($registration_status==1)) {
            $eventPersonData = array(get_post_meta(get_the_ID(), 'imic_event_attendees', true), get_post_meta(get_the_ID(), 'imic_event_staff_members', true),imic_get_currency_symbol(get_option('paypal_currency_options')).get_post_meta(get_the_ID(),'imic_event_registration_fee',true));
            }
            else{
            $eventPersonData = array(get_post_meta(get_the_ID(), 'imic_event_attendees', true), get_post_meta(get_the_ID(), 'imic_event_staff_members', true));    
            }
            $eventPersonValues = array_filter($eventPersonData, 'strlen'); }
			else {
			$eventPersonDetails = array(__('Attendees','framework'),__('Staff members','framework'));
            $eventPersonData = array(get_post_meta(get_the_ID(), 'imic_event_attendees', true), get_post_meta(get_the_ID(), 'imic_event_staff_members', true));
            $eventPersonValues = array_filter($eventPersonData, 'strlen');
			}
			$event_email = get_post_meta(get_the_ID(),'imic_event_email',true);
			$event_email = ($event_email!='')?$event_email:get_option('admin_email');
            ?>
            <header class="single-post-header clearfix">
            <nav class="btn-toolbar pull-right">
            <a href="javascript:" onclick="window.print();" class="btn btn-default" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php _e('Print','framework'); ?>" rel="tooltip"><i class="fa fa-print"></i></a>
            <a href="mailto:<?php echo $event_email; ?>" class="btn btn-default" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php _e('Contact us','framework'); ?>" rel="tooltip"><i class="fa fa-envelope"></i></a>
            <?php $imic_event_address=get_post_meta(get_the_ID(), 'imic_event_address', true);
            if(!empty($imic_event_address)){
            echo '<a href="http://maps.google.com/?q='.$imic_event_address.'" class="btn btn-default" data-placement="bottom" data-toggle="tooltip" data-original-title="'.__('Event Address','framework').'" rel="tooltip" target="_blank"><i class="fa fa-map-marker"></i></a>';   
            }
			if((is_plugin_active('Payment-Imithemes/causes.php'))&&($registration_status==1)) {
			if(is_user_logged_in()) {
			echo '<a href="#" id="donate-popup" class="btn btn-primary donate-paypal" data-toggle="modal" data-target="#PaymentModal">'.__('Register','framework').'</a>'; }
			else {
				echo '<a href="#" id="login-register" class="btn btn-primary donate-paypal" data-toggle="modal" data-target="#PaymentModal">'.__('Register','framework').'</a>';
			} }
            ?>
            </nav>
            <h2 class="post-title"><?php the_title(); ?></h2>
            </header>
            <article class="post-content">
            <div class="event-description">
            <?php
            if (has_post_thumbnail()) :
            the_post_thumbnail('full', array('class' => "img-responsive"));
            endif;
            ?>
            <div class="spacer-20"></div>
            <div class="row">
            <div class="col-md-8">
            <?php if (!empty($eventValues)) { ?>
            <div class="panel panel-default">
            <div class="panel-heading">
            <h3 class="panel-title"><?php _e('Event details', 'framework'); ?></h3>
            </div>
            <div class="panel-body">
            <ul class="info-table">
            <?php
            $index = 0;
            foreach ($eventDetailsData as $edata) {
            if (!empty($edata)) {
            echo '<li class="event-custom"><i class="fa ' . $eventDetailIcons[$index] . '"></i> ' . $edata . '</li>';
            }
            $index++;
            }
            ?>
            </ul>
            </div>
            </div>
            <?php } ?>
            </div>
            <div class="col-md-4">
            <?php
            if (!empty($eventPersonValues)) {
            echo '<ul class="list-group">';
            $flag = 0;
            foreach ($eventPersonData as $epdata) {
            if (!empty($epdata)) {
            echo '<li class="list-group-item"><span class="badge">' . $epdata . '</span>' . $eventPersonDetails[$flag] . '</li>';
            }
            $flag++;
            }
            echo '</ul>';
            }
            ?>
            </div>
            </div>
            <?php the_content(); ?>
            </div>
            </article>
            <?php
            endwhile;
            ?>
    	</div>
        <div class="modal fade" id="PaymentModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="PaymentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            	<h4 class="modal-title" id="myModalLabel"><?php _e('Register for Event: ','framework'); ?><span class="accent-color payment-to-cause"><?php the_title(); ?></span></h4>
                            </div>
                            <div class="modal-body">
                            	<?php if(is_user_logged_in()) { echo do_shortcode('[imic_events amount="'.$event_registration_fee.'" event_id="'.get_the_ID().'" description="'.get_the_title().'"]'); } else { ?>
                                <div class="tabs">
                                  <ul class="nav nav-tabs">
                                    <li class="active"> <a data-toggle="tab" href="#login-user-form"> <?php _e('Login','framework'); ?> </a> </li>
                                    <li> <a data-toggle="tab" href="#register-user-form"> <?php _e('Register','framework'); ?> </a> </li>
                                  </ul>
                                  <div class="tab-content">
                                    <div id="login-user-form" class="tab-pane active">
                                      <form id="login" action="login" method="post">
										<?php 
                                        $redirect_login= get_post_meta(get_the_ID(),'imic_login_redirect_options',true);
                                        $redirect_login=!empty($redirect_login)?$redirect_login:  home_url();
                                        ?>
                                        <input type ="hidden" class ="redirect_login" name ="redirect_login" value =""/>
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input class="form-control input1" id="loginname" type="text" name="loginname">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input class="form-control input1" id="password" type="password" name="password">
                                        </div>
                                        <div class="checkbox">
                                        <input type="checkbox" checked="checked" value="true" name="rememberme" id="rememberme" class="checkbox"> <?php _e('Remember Me!','framework'); ?>
                                        </div>
                                        <input class="submit_button btn btn-primary button2" type="submit" value="<?php _e('Login Now','framework'); ?>" name="submit">
                                        <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?><p class="status"></p>
                                        </form>
                                    </div>
                                    <div id="register-user-form" class="tab-pane">
                                      <form method="post" id="registerform" name="registerform" class="register-form">
                                        <input type ="hidden" class ="redirect_register" name ="redirect_register" value =""/>
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input type="text" name="username" id="username" class="form-control" placeholder="<?php _e('Username','framework'); ?>">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="<?php _e('Email','framework'); ?>">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input type="password" name="pwd1" id="pwd1" class="form-control" placeholder="<?php _e('Password','framework'); ?>">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-refresh"></i></span>
                                        <input type="password" name="pwd2" id="pwd2" class="form-control" placeholder="<?php _e('Repeat Password','framework') ?>">
                                        </div>
                                        <br>
                                        <input type="hidden" name="image_path" id="image_path" value="<?php echo get_template_directory_uri(); ?>">                             
                                        <input type="hidden" name="task" id="task" value="register" />
                                        <button type="submit" id="submit" class="btn btn-primary"><?php _e('Register Now','framework'); ?></button>
                                        </form><div class="clearfix"></div>
                                        <div id="message"></div>
                                    </div>
                                  </div>
                                </div><?php } ?>
                            </div>
                            <div class="modal-footer">
                            	<p class="small short"><?php echo (get_option('registration_form_info')!='')?get_option('registration_form_info'):'If you would prefer to call in your registration, please call 1800.785.876'; ?></p>
                            </div>
                        </div>
                        </div>
                    </div>
        <?php if(!empty($pageOptions['sidebar'])){ ?>
        <!-- Start Sidebar -->
        <div class="col-md-3 sidebar">
            <?php dynamic_sidebar($pageOptions['sidebar']); ?>
        </div>
        <!-- End Sidebar -->
        <?php } ?>
    </div>
</div>
<?php get_footer(); ?>