<?php
/*
  Template Name: agent
 */
get_header();
?>
<div class="page_content">
	<div class="container_content agent_page">
        <form id="agent_form" >
            <div class="col-md-6">
                <p><strong>Ваш личный менеджер, Павел Рай</strong></p>
                <p>Услуга по вызову менеджера бесплатно</p>

                <div class="form-group">
                    <input type="text" class="form-control" id="q_name" aria-describedby="emailHelp" placeholder="Введите ваше имя">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" id="q_phone" aria-describedby="emailHelp" placeholder="Введите номер телефона">
                </div>

                <button type="submit" class="btn btn-primary center-block">Задать вопрос</button>
            </div>
            <div class="col-md-6">
                <img src="/wp-content/uploads/2018/03/New-Project-6.png" alt="agent">
            </div>
        </form>
        <?php the_content() ?>
        <?=q_form()?>
	</div>	
</div>
<?php get_footer(); ?>