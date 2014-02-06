<?php
/*
* Template Name: My Smile
*/
?>
<?php get_header(); ?>

<!-- Start Content -->
<div class="container" id="my-smile-page">
<?php
$category_id= get_cat_ID('news');
$category_link= get_category_link($category_id);
?>
<div class="row-fluid">
	<div class="span12">
	<h2 class="title-la font-lato bold">
	Berita
	<span class="pull-right font-lato light italic look-more">
	<a href="<?php echo esc_url($category_link); ?>" title="news">Lihat Semua &gt;&gt;</a></span>	
	</h2>
	</div>
</div>
<div id="" class="row-fluid news">
<?php
$args= array('category_name'=>'news', 'posts_per_page'=>3);
$cat_query= new WP_Query($args);
?>
<?php
if( $cat_query->have_posts() ){
	while( $cat_query->have_posts() ){
		$cat_query->the_post();
?>
		<div class="span4">
			<h2 class=""><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p class="date-section">
			<?php strtoupper(the_time('d F Y')); ?>
			</p>
			<div class="image">
			<?php 
			if( has_post_thumbnail($post->ID) ){
				the_post_thumbnail($post->ID);
			}
			?>
			</div>				
			<div class="desc">
			<?php the_excerpt(); ?>
			<div class="post-link-more"><a class="pull-right normal" href="<?php echo the_permalink(); ?>">
			selanjutnya &gt;&gt;</a></div>
			</div>
			<div class="clear-both">&nbsp;</div>
		</div>
<?php
	}
}
else{
?>
	<p><?php _e('No posts were found. Sorry!'); ?></p>
<?php
}
wp_reset_postdata();
?>
</div>

<?php
// Artikel Section
$category_id= get_cat_ID('artikel');
$category_link= get_category_link($category_id);
?>
<div class="row-fluid">
	<div class="span12">
	<h2 class="title-la font-lato bold">Artikel<span class="pull-right font-lato light italic look-more">
	<a href="<?php echo esc_url($category_link); ?>" title="news">Lihat Semua &gt;&gt;</a></span></h2>
	</div>
</div>
<div id="" class="row-fluid news">
<?php
$args= array('category_name'=>'article', 'posts_per_page'=>3);
$cat_query= new WP_Query($args);
?>
<?php
if( $cat_query->have_posts() ){
	while( $cat_query->have_posts() ){
		$cat_query->the_post();
?>
		<div class="span4">
			<h2 class=""><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p class="date-section">
			<?php strtoupper(the_time('d F Y')); ?>
			</p>
			<div class="image">
			<?php 
			if( has_post_thumbnail($post->ID) ){
				the_post_thumbnail($post->ID);
			}
			?>
			</div>				
			<div class="desc">
			<?php the_excerpt(); ?>
			<div class="post-link-more"><a class="pull-right normal" href="<?php echo the_permalink(); ?>">
			selanjutnya &gt;&gt;</a></div>
			</div>
			<div class="clear-both">&nbsp;</div>
		</div>
<?php
	}
}
else{
?>
	<p><?php _e('No posts were found. Sorry!'); ?></p>
<?php
}
wp_reset_postdata();
?>
</div>
</div>

<!-- End Content -->

<?php get_footer(); ?>