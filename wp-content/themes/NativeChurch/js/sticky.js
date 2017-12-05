  jQuery(function($) {
  $(document).ready(function() {
      if ($("body").hasClass("boxed"))
            return false;
        if ($(window).width() > 992) {
            $(".main-menu-wrapper").sticky({topSpacing: 0});
        }
    }
   );
  })