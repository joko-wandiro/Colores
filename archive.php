<?php get_header(); ?>
<!-- Start Content -->
<div class="container">
<div class="row-fluid" id="archive">
	<div class="span12">
		<h1><?php echo ucfirst(single_cat_title('', FALSE)); ?></h1>
		<?php if( have_posts() ){ ?>
			<div class="accordion" id="accordion">
				<div class="accordion-group">
			<?php 
			global $wp_query;
			$ct= 1;
			$number_of_posts= $wp_query->post_count;
			while( have_posts() ){
				the_post();
				$post= get_post();
			?>
					<div class="accordion-heading">
					<div class="row-fluid accordion-toggle" data-toggle="collapse" data-parent="#accordion" 
					data-target="#collapse-<?php echo $post->post_name; ?>">
						<div class="span3 accordion-toggle-date">
						<?php strtoupper(the_time('d F Y')); ?>
						</div>
						<div class="span9 accordion-toggle-title">
						<?php the_title(); ?>
						</div>					
					</div>
					
					</div>
					<div id="collapse-<?php echo $post->post_name; ?>" class="accordion-body collapse">
					<div class="accordion-inner">
						<div class="row-fluid">
						<div class="span2 accordion-inner-read-more">
						<a class="btn" href="<?php the_permalink(); ?>"><?php _e("Read More"); ?></a>
						</div>
						<div class="span10 accordion-inner-excerpt">
						<?php the_excerpt(); ?>
						</div>
						</div>
					</div>
					</div>
			<?php
				$ct++;
			}
			?>
				</div>
			</div>
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