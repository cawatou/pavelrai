jQuery(document).ready(function($){

$(function(){
	$(window).scroll(function(){
		var top = $(this).scrollTop();   		
		if (top==0) {
			$("#undefined-sticky-wrapper").removeClass("is-sticky");
			$(".main-menu-wrapper").removeClass("fixed_menu");
		} else {
			$("#undefined-sticky-wrapper").addClass("is-sticky");
			$(".main-menu-wrapper").addClass("fixed_menu");
		}
	});
});

$(".bwg_standart_thumb_0").wrap("<a class='img-thumbnail'></a>");


/*$('.tel').click(function(event){ 
	event.preventDefault();
	$('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
		function(){ // после выполнения предъидущей анимации
			$('#modal_1').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
		});
});*/


$('.question').click(function(event){
	event.preventDefault();
	$('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
		function(){ // после выполнения предъидущей анимации
			$('#modal_2').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
		});
});



$('.price_btn').click(function(event){ 
	event.preventDefault();
	$('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
		function(){ // после выполнения предъидущей анимации
			$('#modal_3').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
		});
});


$('#content_contacts button').click(function(event){
	event.preventDefault();
	$('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
		function(){ // после выполнения предъидущей анимации
			$('#modal_contact').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
		});
});

$('#bestprice').click(function(event){
	event.preventDefault();
	$('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
		function(){ // после выполнения предъидущей анимации
			$('#modal_bestprice').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
		});
});

$('.add_to_cart_button').click(function(event){
	event.preventDefault();
	$('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
		function(){ // после выполнения предъидущей анимации
			$('#modal_addcart').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
		});
});


$('.col_tel').click(function(event){
	event.preventDefault();
	$('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
		function(){ // после выполнения предъидущей анимации
			$('#modal_fence').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
		});
});



$(document).find('.modal_close, #overlay, .continue_btn').click( function(){
	modal_close();
});





$(".snd_btn").click(function(event){
	$y=$(this).parent().parent().attr('id');
	$title = $('.page-header h1').text();
	//console.log($title);
	message($y, $title);return false;
});

$("#modal_contact .btn").click(function(event){
	console.log('click there');
    sendmsg();
});


$("#fence_btn").click(function(event){
	console.log('hello');
});

function modal_close() {
    $('.modal').animate({opacity: 0, top: '45%'}, 200,  // плавно меняем прозрачность на 0 и одновременно двигаем окно вверх
        function(){ // после анимации
            $(this).css('display', 'none'); // делаем ему display: none;
            $('#overlay').fadeOut(400); // скрываем подложку
        }
    );
    $(".required_filds").each(function(){
        $(this).val("");
    })
}


function message($y, $title){
	var $x=0;
	$y="#"+$y+" .required_filds"
	$($y).each(function(){
		if(!$(this).val()){
			$(this).addClass("red_border"); 
			$x=$x+1;           
		}else{
			$(this).removeClass("red_border");
		}
	});
	
	if($x==0) {
		sendmsg($title);return false;
	}
	//console.log($title);
	//console.log($x);
	//console.log($y);   
}

function sendmsg($title){
  $.ajax({
	type: "POST",
	url: "/wp-content/themes/NativeChurch/mail/modal.php",
	data: {
	  user_name: $("#user_name").val(),
	  user_phone: $("#user_phone").val(),
	  user_name_2m: $("#user_name_2m").val(),
	  user_phone_2m: $("#user_phone_2m").val(),
	  user_mail_2m: $("#user_mail_2m").val(),
	  user_msg_2m: $("#user_msg_2m").val(),
	  user_name_3m: $("#user_name_3m").val(),
	  user_phone_3m: $("#user_phone_3m").val(),
	  model: $title
	}
  })
  .fail(function(){
	alert("break");
  })
  .done(function(msg){
	result = msg;
	if(msg=="welldone"){
        modal_close()
        $('#modal_4').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
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
$("img.attachment-shop_single").unwrap();
				
});


