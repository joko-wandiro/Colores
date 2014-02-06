<?php get_header(); ?>

<!-- Start Content -->
<div class="container">
<div class="row-fluid">
	<div class="span12">
		<?php
		global $query_string;

		$query_args = explode("&", $query_string);
		$search_query = array();

		foreach($query_args as $key => $string) {
			$query_split = explode("=", $string);
			$search_query[$query_split[0]] = urldecode($query_split[1]);
		}
		$wp_query= new WP_Query($search_query);
		?>
		<?php if ( $wp_query->have_posts() ) : ?>
			<div>
			<h1 class="page-title"><?php printf( __('Search Results for: %s'), '<span>' . get_search_query() . 
			'</span>' ); ?></h1>
			</div>
			<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
			<h2 class=""><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p class="">
			<span class="italic"><?php echo _e("Posted on"); ?></span> <a href="<?php the_permalink(); ?>">
			<?php strtoupper(the_time('l F d, Y')); ?></a>
			</p>
			<div>
			<?php the_excerpt(); ?>
			</div>
			<?php endwhile; ?>
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
		<?php else : ?>
			<h1 class="entry-title"><?php _e( 'Nothing Found'); ?></h1>
			<div class="entry-content">
				<p>
				<?php 
				_e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.');
				?>
				</p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		<?php endif; ?>
	</div>
</div>
</div>
<!-- End Content -->

<?php get_footer(); ?>