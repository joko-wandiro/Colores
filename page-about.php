<?php
/*
* Template Name: About - Kenali Smile
*/
?>
<?php get_header(); ?>

<!-- Start Content -->
<div class="container" id="about-page">
	<div class="row-fluid">
		<div class="span12">
		<div class="page-header">
		<div class="category-title font-lato bold"><?php single_post_title(); ?></div>
		</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<div id="kenali-smile-menu">
			<h2 id="kenali-smile-menu-title" class="font-lato bold"><?php _e("Kenali Smile"); ?></h2>
		<?php
		$page_id= get_query_var('page_id');
		$page_name= get_query_var('pagename');
		$args= array('post_type'=>'page', 'post_parent'=>373, 'orderby'=>'date', 'order'=>'ASC');
		$query= new WP_Query($args);
		if( $query->have_posts() ){
		?>
			<div class="accordion" id="sidebar-left-kenali-smile">
		<?php
			$ct= 1;
			while( $query->have_posts() ){
				$query->the_post();
				if( $post->post_name == 'profil-smile' && $page_name == 'kenali-smile' ){
					$page_name= $post->post_name;
				}
				$selected= "";
				$href= "#";
				if( $post->post_name == $page_name ){
					$selected= " active";
				}else{
					$href= get_permalink();
				}
				$href= get_permalink();
				
				$args= array('post_type'=>'page', 'post_parent'=>$post->ID);
				$subquery= new WP_Query($args);
				$child_page= $subquery->get_posts();
		?>
				<div class="accordion-group">
					<div class="accordion-heading">
					<?php
					if( count($child_page) ){
					?>
					<button class="btn btn-small pull-right" type="button" data-toggle="collapse" 
					data-target="#collapse-<?php echo $post->post_name; ?>">
					<i class="icon-chevron-down icon-white"></i></button>
					<?php
					}
					?>					
					<a class="accordion-toggle<?php echo $selected; ?>" href="<?php echo $href; ?>">
					<?php the_title(); ?>
					</a>
					</div>
					<?php
					if( count($child_page) ){
						foreach( $child_page as $key=>$item ){
							$child_page[$item->post_name]= $item;
							unset($child_page[$key]);
						}
						$accordion_stat= "";
						if( array_key_exists($page_name, $child_page) ){
							$accordion_stat= " in";
						}
					?>
					<div id="collapse-<?php echo $post->post_name; ?>" 
					class="accordion-body collapse<?php echo $accordion_stat; ?>">
						<?php
						foreach( $child_page as $item ){
							$selected= "";
							if( $item->post_name == $page_name ){
								$selected= "active";
							}
						?>
						<div class="accordion-inner">
						<a class="<?php echo $selected; ?>" href="<?php echo get_permalink($item->ID); ?>">
						<?php echo get_the_title($item->ID); ?>
						</a>
						</div>
						<?php
						}
						?>
					</div>					
					<?php
					}
					?>	
				</div>				
		<?php
				$ct++;
			}
		?>
			</div>
		<?php
		}
		wp_reset_postdata();
		?>
			</div>
		</div>
		<div class="span8">
		<div class="content">
		<?php 
		global $wp_query;
		
		if( $page_name == "profil-smile" ){
			$args= array('pagename'=>'kenali-smile/'.$page_name);
			$wp_query= new WP_Query($args);
		}
		
		if( $wp_query->have_posts() ){
			while( $wp_query->have_posts() ){
				$wp_query->the_post();
				the_content();
			}
		}else{
		?>
			<p><?php _e('No posts were found. Sorry!'); ?></p>
		<?php
		}
		wp_reset_postdata();
		?>
		</div>
		</div>
	</div>
</div>
<!-- End Content -->

<?php get_footer(); ?>