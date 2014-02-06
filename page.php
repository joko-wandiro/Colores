<?php get_header(); ?>

<!-- Start Content -->
<div class="container">
<div class="row-fluid">
	<div class="span8">
	<?php
	if( have_posts() ){
		while( have_posts() ){
			the_post();
	?>
	<h2 class=""><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<p class="">
	<span class="italic"><?php echo _e("Posted on"); ?></span> <a href="<?php the_permalink(); ?>">
	<?php strtoupper(the_time('l F d, Y')); ?></a>
	</p>
	<div>
	<?php the_content(); ?>
	</div>	
	<?php
		}
	}
	?>
	</div>
	<div class="span4">
	<?php get_sidebar(); ?>
	</div>
</div>
</div>
<!-- End Content -->

<?php get_footer(); ?>