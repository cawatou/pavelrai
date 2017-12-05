jQuery(document).ready(function(){

jQuery(function(){
	jQuery(window).scroll(function(){
		var top = jQuery(this).scrollTop();   		
		if (top==0) {
			jQuery("#undefined-sticky-wrapper").removeClass("is-sticky");
			jQuery(".main-menu-wrapper").removeClass("fixed_menu");
		} else {
			jQuery("#undefined-sticky-wrapper").addClass("is-sticky");
			jQuery(".main-menu-wrapper").addClass("fixed_menu");
		}
	});
});

jQuery(".bwg_standart_thumb_0").wrap("<a class='img-thumbnail'></a>");


jQuery('.tel').click(function(event){ 
	event.preventDefault();
	jQuery('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
		function(){ // после выполнения предъидущей анимации
			jQuery('#modal_1').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
		});
});


jQuery('.question').click(function(event){
	event.preventDefault();
	jQuery('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
		function(){ // после выполнения предъидущей анимации
			jQuery('#modal_2').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
		});
});



jQuery('.price_btn').click(function(event){ 
	event.preventDefault();
	jQuery('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
		function(){ // после выполнения предъидущей анимации
			jQuery('#modal_3').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
		});
});



jQuery('.modal_close, #overlay').click( function(){ 			
	jQuery('#modal_1, #modal_2, #modal_3, #modal_4').animate({opacity: 0, top: '45%'}, 200,  // плавно меняем прозрачность на 0 и одновременно двигаем окно вверх
		function(){ // после анимации
			jQuery(this).css('display', 'none'); // делаем ему display: none;
			jQuery('#overlay').fadeOut(400); // скрываем подложку
		}
	);
	jQuery(".required_filds").each(function(){
		jQuery(this).val("");
	})
});


jQuery(".snd_btn").click(function(event){
	$y=jQuery(this).parent().parent().attr('id');
	$title = jQuery('.page-header h1').text();
	//console.log($title);
	message($y, $title);return false;
});


function message($y, $title){
	var $x=0;
	$y="#"+$y+" .required_filds"
	jQuery($y).each(function(){
		if(!jQuery(this).val()){
			jQuery(this).addClass("red_border"); 
			$x=$x+1;           
		}else{
			jQuery(this).removeClass("red_border");
		}
	});
	
	if($x==0) {
		sendmsg($title);return false;
	}
	//console.log($title);
	//console.log($x);
	//console.log($y);   
}

function sendmsg(){
  jQuery.ajax({
	type: "POST",
	url: "/wp-content/themes/NativeChurch/mail/modal.php",
	data: {
	  user_name: jQuery("#user_name").val(),
	  user_phone: jQuery("#user_phone").val(),
	  user_name_2m: jQuery("#user_name_2m").val(),
	  user_phone_2m: jQuery("#user_phone_2m").val(),
	  user_mail_2m: jQuery("#user_mail_2m").val(),
	  user_msg_2m: jQuery("#user_msg_2m").val(),
	  user_name_3m: jQuery("#user_name_3m").val(),
	  user_phone_3m: jQuery("#user_phone_3m").val(),
	  model: $title
	}
  })
  .fail(function(){
	alert("break");
  })
  .done(function(msg){
	result = msg;
	if(msg=="welldone"){
	  jQuery(".modal_window").css('display', 'none');
	  jQuery(".required_filds").each(function(){
		jQuery(this).val("");
	  })
	  jQuery('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
		function(){ // после выполнения предъидущей анимации
		jQuery('#modal_4').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
	});
	}   
	else if(msg=="nosend"){      
	  alert("Ошибка отправки формы");
	}
	else if(msg=="nodata"){      
	  alert("Ошибка данных формы");
	}
  })
} 

// Убираем эффект галлереи из карточки товара
jQuery("img.attachment-shop_single").unwrap();
				
});


