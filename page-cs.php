<?php
/*
Template Name: Customer Service
*/
?>
<?php get_header(); ?>

	<div class="container font-source-sans-pro cs-page">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<h1><?php the_title(); ?></h1>
		<div class="row-fluid">
			<div class="span8">
				<?php the_content(); ?>
            </div>
            <div class="span4">
            	<?php
					$sidebar = get_post_meta( $post->ID, 'cs-sidebar', true );
					echo $sidebar[0]['sidebar'];
                ?>
            </div>
		</div>
		<?php endwhile; endif; ?>
    </div>
<?php get_footer(); ?>