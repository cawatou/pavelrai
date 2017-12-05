jQuery(document).ready(function() {
    jQuery('.calendar').prepend('<img id="loading-image" src="' + calenderEvents.homeurl + '/images/loader.gif" alt="Loading..." />');
      jQuery('.calendar').fullCalendar({
        monthNames: calenderEvents.monthNames,
        monthNamesShort: calenderEvents.monthNamesShort,
        dayNames: calenderEvents.dayNames,
        dayNamesShort: calenderEvents.dayNamesShort,
        editable: true,
        eventSources: [
         {
            url: calenderEvents.homeurl + '/includes/json-feed.php',
            type: 'POST',
            data: {
               event_cat_id: jQuery('.event_calendar').attr('id'),
              },
          },jQuery.fullCalendar.gcalFeed(calenderEvents.googlefeeds)
       ],
        timeFormat: calenderEvents.time_format,
        firstDay:calenderEvents.start_of_week,
        loading: function(bool) {
            if (bool)
                jQuery('#loading-image').show();
            else
                jQuery('#loading-image').hide();
        },
    });
});
