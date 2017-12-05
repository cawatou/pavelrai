<?php
/*
  Template Name: contact
 */
get_header();
$custom = get_post_custom(get_the_ID()); // карта 
?>
<div class="page_content">
	<div id="content_contacts" class="container_content">
		<?php the_content(); ?>
		<div id="contacts_map" class="post-content">
			<?php
				if ($custom['imic_contact_map_display'][0] == 'yes' && !empty($custom['imic_contact_map_box_code'][0])) {
					echo '<div id="gmap">';
					echo $custom['imic_contact_map_box_code'][0];
					echo '</div>';
				}
			?>
			<div id="gmap2">
				<p>База предприятия</p>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2880.972759499308!2d132.0007306625726!3d43.77342429164205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5fb2e8a3109959e3%3A0x329bd80ac902f259!2z0YPQuy4g0KjRgtCw0LHRgdC60L7Qs9C-LCAxMCwg0KPRgdGB0YPRgNC40LnRgdC6LCDQn9GA0LjQvNC-0YDRgdC60LjQuSDQutGA0LDQuSwgNjkyNTAy!5e0!3m2!1sru!2sru!4v1415699743591" width="750" height="350" frameborder="0" style="border:0"></iframe></iframe>
			</div>
			<div class="row">
				<form method="post" id="contactform" name="contactform" class="contact-form" action="<?php echo get_template_directory_uri() ?>/mail/contact.php">
					<div class="col-md-6 margin-15">
						<div class="form-group">
							<input type="text" id="name" name="name"  class="form-control input-lg" placeholder="<?php _e('Имя*','framework'); ?>">
						</div>
						<div class="form-group">
							<input type="email" id="email" name="email"  class="form-control input-lg" placeholder="<?php _e('Email*','framework'); ?>">
						</div>
						<div class="form-group">
							<input type="text" id="phone" name="phone" class="form-control input-lg" placeholder="<?php _e('Телефон*','framework'); ?>">
							<input type ="hidden" name ="image_path" id="image_path" value ="<?php echo get_template_directory_uri() ?>">
							<input id="admin_email" name="admin_email" type="hidden" value ="<?php echo $admin_email; ?>">
							<input id="subject" name="subject" type="hidden" value ="<?php echo $subject_email; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<textarea cols="6" rows="7" id="comments" name="comments" class="form-control input-lg" placeholder="<?php _e('Ваше сообщение','framework'); ?>"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<input id="submit" name="submit" type="submit" class="btn btn-primary btn-lg pull-right" value="<?php _e('Отправить!','framework'); ?>">
					</div>
				</form>
				<div class="clearfix"></div>
				<div id="message"></div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>