<?php
get_header();
$this_term = get_query_var('term');
$class = (is_active_sidebar('event-sidebar'))?9:12;
echo '<div class="container">
      <div class="row"><div class="col-md-'.$class.'" id="ajax_events"><div class="listing events-listing">
	<header class="listing-header">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<h3>' . __('All events', 'framework') . '</h3>
		  </div>
		  <div class="listing-header-sub col-md-6 col-sm-6">';
    $currentEventTime = date('Y-m');
    $prev_month = date('Y-m', strtotime('-1 month', strtotime($currentEventTime)));
    $next_month = date('Y-m', strtotime('+1 month', strtotime($currentEventTime)));
    echo '<h5>' . date_i18n('F', strtotime($currentEventTime)) . '</h5>
				<nav class="next-prev-nav">
					<a href="javascript:" class="upcomingEvents" rel="'.$this_term.'" id="' . $prev_month . '"><i class="fa fa-angle-left"></i></a>
					<a href="javascript:" class="upcomingEvents" rel="'.$this_term.'" id="' . $next_month . '"><i class="fa fa-angle-right"></i></a>
				</nav>
		  </div>
	  </div>
	</header>
	<section class="listing-cont">
	  <ul>';
    $today = date('Y-m');
	$curr_month = date('Y-m-t', strtotime('-1 month', strtotime($currentEventTime)));
    $currentTime = date(get_option('time_format'));
    query_posts(array(
        'post_type' => 'event',
		'event-category'=>$this_term,
        'meta_key' => 'imic_event_start_dt',
		
        'meta_query' => array(
            'relation' => 'AND',
			array(
                'key' => 'imic_event_frequency_end',
                'value' => $curr_month,
                'compare' => '>'
            ),
            array(
                'key' => 'imic_event_start_dt',
                'value' => date('Y-m-t', strtotime($currentEventTime)),
                'compare' => '<='
            )),
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'posts_per_page' => -1
            )
    );
    $count = 0;
	$sinc = 1;
	$sp = array();
    if (have_posts()) {
        while (have_posts()):the_post();
            $custom_event = get_post_custom(get_the_ID());
            $eventStartDate = strtotime(get_post_meta(get_the_ID(),'imic_event_start_dt',true));
            $eventStartTime = strtotime(get_post_meta(get_the_ID(),'imic_event_start_tm',true));
            $eventMonth = date('n', $eventStartDate);
			$frequency = get_post_meta(get_the_ID(),'imic_event_frequency',true);
			$frequency_count = '';
			$frequency_count = get_post_meta(get_the_ID(),'imic_event_frequency_count',true);
			if($frequency>0) { $frequency_count = $frequency_count; } else { $frequency_count = 0; }
			$seconds = $frequency*86400;
			$sai = 0;
			while($sai<=$frequency_count) {
			$icon = "";
			$eventStartDate = $custom_event['imic_event_start_dt'][0];
			$eventStartTime = $custom_event['imic_event_start_tm'][0];
			$eventStartDate = strtotime($eventStartDate.' '.$eventStartTime);
			if($frequency==30) {
			$eventStartDate = strtotime("+".$sai." month", $eventStartDate);
			}
			else {
			$sv = $sai*$seconds;
			$eventStartDate = $eventStartDate+$sv;
			}
			$sn = date('Y-m-t',strtotime($currentEventTime));
			$month_start_date = date('Y-m-1',strtotime($currentEventTime));
			if($eventStartDate>=strtotime($month_start_date)&&($eventStartDate<=strtotime($sn))) {
            if (strtotime($currentEventTime) == strtotime($today)) {
                if ($eventStartDate == strtotime(date('Y-m-d'))) {
                    if ($eventStartTime > strtotime($currentTime)) {
						$sp[$eventStartDate+$sinc] = get_the_ID();
						$sinc++;
                        $count++;
                    }
                } elseif ($eventStartDate > strtotime(date('Y-m-d'))) {
					$sp[$eventStartDate+$sinc] = get_the_ID();
						$sinc++;
                    $count++;
                }
            } else {
				$sp[$eventStartDate+$sinc] = get_the_ID();
						$sinc++;
                $count++;
            } } $sai++; }
        endwhile; 
    }if ($count == 0) {
        echo '<li class="item event-item">	
			  <div class="event-detail">
				<h4>' . __('Sorry, there are no events for this month.', 'framework') . '</h4>
			  </div>
			</li>';
    } ksort($sp);
	foreach($sp as $key =>$value) {
                                
				$satime = get_post_meta($value,'imic_event_start_tm',true);
				$satime = strtotime($satime);
			        $date_converted=date('Y-m-d',$key );
                                $custom_event_url =  imic_query_arg($date_converted,$value);
                                echo '<li class="item event-item">	
				  <div class="event-date"> <span class="date">' . date_i18n('d', $key) . '</span> <span class="month">' .imic_global_month_name($key). '</span> </div>
				  <div class="event-detail">
                                      <h4><a href="'.$custom_event_url.'">' . get_the_title($value).'</a>'.imicRecurrenceIcon($value).'</h4>';
                $stime = '';
                if ($satime != '') {
                    $stime = ' | ' . date(get_option('time_format'), $satime);
                }
                echo '<span class="event-dayntime meta-data">' . __(date('l', $key),'framework') . $stime . '</span> </div>
				  <div class="to-event-url">
					<div><a href="' .$custom_event_url.'" class="btn btn-default btn-sm">' . __('Details', 'framework') . '</a></div>
				  </div>
				</li>';
	}
    echo '</ul>
	</section>
  </div></div>';
if(is_active_sidebar('event-sidebar')) { ?>
        <!-- Start Sidebar -->
        <div class="col-md-3 sidebar">
<?php dynamic_sidebar('event-sidebar'); ?>
        </div><?php } ?>
        <!-- End Sidebar -->
    </div>
</div>
<?php get_footer(); ?>