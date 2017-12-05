<?php
get_header();
$pageOptions = imic_page_design(); //page design options 
$custom = get_post_custom(get_the_ID());?>
<div class="container">
<div class="row">
<div class="<?php echo $pageOptions['class']; ?>"> 
<header class="single-post-header clearfix">
<div class="pull-right sermon-actions">
<?php
if (!empty($custom['imic_sermons_url'][0])) {
echo '<a href="' . $custom['imic_sermons_url'][0] . '" class="play-video-link" data-placement="top" data-toggle="tooltip" data-original-title="' . __('Video', 'framework') . '" rel="tooltip"><i class="fa fa-video-camera"></i></a>';
}
$attach_full_audio= imic_sermon_attach_full_audio(get_the_ID());
if(!empty($attach_full_audio)) {
echo'<a href="' . $attach_full_audio . '" class="play-audio-link" data-placement="top" data-toggle="tooltip" data-original-title="' . __('Audio', 'framework') . '" rel="tooltip"><i class="fa fa-headphones"></i></a>';
}
if (!empty($attach_full_audio)) {
echo '<a href="' . get_template_directory_uri() . '/download/download.php?file=' . $attach_full_audio . '" data-placement="top" data-toggle="tooltip" data-original-title="' . __('Download Audio', 'framework') . '" rel="tooltip"><i class="fa fa-download"></i></a>';
}
$attach_pdf= imic_sermon_attach_full_pdf(get_the_ID());
if (!empty($attach_pdf)){
echo '<a href="' . get_template_directory_uri() . '/download/download.php?file=' . $attach_pdf . '" data-placement="top" data-toggle="tooltip" data-original-title="' . __('Download PDF', 'framework') . '" rel="tooltip"><i class="fa fa-book"></i></a>';
}
?>
</div>
<h2 class="post-title"><?php the_title(); ?></h2>
</header>
<article class="post-content">
<?php
if (!empty($custom['imic_sermons_url'][0])) {
    echo '<div class="video-container">' . imic_video_embed($custom['imic_sermons_url'][0], '200', '150') . '</div>';
}
if (!empty($attach_full_audio)) {
?>
<div class="audio-container">
<audio class="audio-player" src="<?php echo $attach_full_audio; ?>" type="audio/mp3" controls></audio>
</div>
<?php
}
while (have_posts()):the_post();
the_content();
/** Sermon Tags * */
$tag= get_the_term_list(get_the_ID(), 'sermons-tag', '', ', ', '');
if(!empty($tag)){
echo '<div class="post-meta">';
echo '<i class="fa fa-tags"></i>';
echo $tag;
echo '</div>';
}
endwhile;
?>
</article>
<?php comments_template('', true); ?> 
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