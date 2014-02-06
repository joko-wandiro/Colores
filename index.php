<?php get_header(); ?>

<!-- Start Content Section -->
<div class="container" id="content">
	<div class="row-fluid">
		<!-- Start SideBar -->
		<div class="span3">
		<?php get_sidebar(); ?>
		</div>
		<!-- End SideBar -->
		<!-- Start Content - Articles -->
		<div class="span9">
		<?php if( have_posts() ){ ?>
			<div class="wrapper-posts" id="articles">
			<?php 
			global $wp_query;
			$ct= 1;
			$number_of_posts= $wp_query->post_count;
			while( have_posts() ){
				the_post();
				$post= get_post();
			?>
				<div class="post">
				<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php
				$post_by= __("by %s on %s in %s with ", PHANTASMACODE_THEME);
				$categories= get_the_category($post->ID);
				$category= $categories[0];
				$category->link = get_category_link($category->cat_ID);
				?>
				<p class="post-by">
				<?php 
				_e("by ") . the_author() . _e(" on ") . the_date() . _e(" in ");
				?>
				<a href="<?php echo esc_url( $category->link ); ?>" 
				title="<?php echo esc_attr( $category->cat_name ); ?>"><?php echo $category->cat_name; ?></a>
				<?php _e(" with "); ?><a href="<?php echo esc_url( get_comment_link() ); ?>" 
				title="<?php echo esc_attr( get_comments_number() ); ?>"><?php echo comments_popup_link(); ?></a>
				</p>
				<div class="post-feature-image"><?php the_post_thumbnail(); ?></div>
				<div class="content"><?php the_excerpt(); ?></div>
				<div class="read-more"><a href="<?php the_permalink(); ?>"><?php _e("Read More", 
				PHANTASMACODE_THEME); ?></a></div>
				<?php
//				echo "<pre>";
//				print_r(comments_popup_link());
//				echo "</pre>";
				?>				
				</div>
			<?php
				$ct++;
			}
			?>
				<div id="navigation">
				<?php
				// Navigation Page
				$next_posts_link_text= __("Older Entries", PHANTASMACODE_THEME);
				$previous_posts_link_text= __("Newer Entries", PHANTASMACODE_THEME);
				$navigations= array("next_posts_link", "previous_posts_link");
				foreach( $navigations as $nav ){
					$text= $nav . "_text";
				?>
				<div class="<?php echo str_replace("_", "-", $nav); ?>"><?php $nav($$text); ?></div>
				<?php
//					call_user_func($nav);
				}
//				echo "<pre>";
//				var_dump(get_next_posts_link());
//				var_dump(get_previous_posts_link());
//				echo "</pre>";
				?>
				</div>
			</div>
		<?php }
		else{ ?>
			<div>
			<p><?php _e('No posts were found. Sorry!'); ?></p>
			</div>
		<?php } ?>		
		</div>
		<!-- End Content - Articles -->
	</div>
</div>
<!-- End Content Section -->

<?php get_footer(); ?>