<?php get_header(); ?>
<!-- Start Content -->
<div class="container">
<div class="row-fluid" id="archive">
	<div class="span12">
		<h1><?php echo ucfirst(__("stuff")); ?></h1>
		<?php if( have_posts() ){ ?>
			<?php 
			global $wp_query;
			$ct= 1;
			$number_of_posts= $wp_query->post_count;
			while( have_posts() ){
				the_post();
				$post= get_post();
//				echo "<pre>";
//				echo get_post_type();
//				echo "</pre>";
				if( $ct % 4 == 1 ){
			?>
				<ul class="thumbnails" id="stuff-wrapper">
			<?php
				}
			?>
				<li class="span3">
				<div class="thumbnail">
					<?php MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'stuff-archive-image', 
					$post->ID, "stuff_thumbnail"); ?>
					<div class="caption">
					<h2><a href="<?php the_permalink(); ?>" class="btn"><?php the_title(); ?></a></h2>
					</div>
                </div>
				</li>
			<?php 
				if( $ct % 4 == 0 || $ct == $number_of_posts ){
			?>
				</ul>
			<?php
				}
				$ct++;
			}
			?>
			<?php
			$big = 999999999; // need an unlikely integer
			$args = array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max(1, get_query_var('paged')),
				'total' => $wp_query->max_num_pages,
				'type'=>'array'
			);
			
			$pagination= paginate_links($args);
			// Create Pagination Links follow foundation structure.
			bootstrap_pagination($pagination);
			?>
		<?php }
		else{ ?>
			<div>
			<p><?php _e('No posts were found. Sorry!'); ?></p>
			</div>
		<?php } ?>
	</div>
</div>
</div>
</div>
<!-- End Content -->

<?php get_footer(); ?>