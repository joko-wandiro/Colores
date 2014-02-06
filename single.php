<?php get_header(); ?>

<!-- Start Content -->
<div class="container" id="single-page">
<div class="row-fluid">
	<div class="span12">
<?php
	global $wp_query, $post;
//	echo "<pre>";
//	print_r($post);
//	echo "</pre>";
?>

<!-- Print a link to this category -->
	<div>
	<a href="<?php echo bloginfo('url'); ?>"></a>
	</div>
	<div class="page-header">
	<?php 
	$category_obj= get_the_category($post->ID);
	$category_link= get_category_link($category_obj[0]->cat_ID);
	?>
	<div class="breadcrumb-sign">
	<a class="btn" href="<?php echo esc_url( $category_link ); ?>" title="<?php echo strtoupper($category_obj[0]->name); ?>">
	<?php echo __('Back To ') . strtoupper($category_obj[0]->name); ?></a>
	</div>
	</div>
	<?php
	if( have_posts() ){
		while( have_posts() ){
			the_post();
	?>
	<h1 class="post-title"><?php the_title(); ?></h1>
	<p class="post-date italic">
	<?php echo strtoupper(the_time('d F Y')); ?>
	</p>
	<div class="post-content">
	<div class="post-feature-image"><?php the_post_thumbnail(); ?></div>
	<?php the_content(); ?>
	</div>
	
	<div class="separator-line">&nbsp;</div>
	<?php comments_template( '', true ); ?>
	<?php
		}
	}
	else{
	?>
	<p><?php _e('No posts were found. Sorry!'); ?></p>
	<?php
	}
	?>
	</div>
</div>
</div>
<!-- End Content -->

<?php get_footer(); ?>