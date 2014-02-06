<?php
/*
* Template Name: Archive News Backup
*/
?>
<?php get_header(); ?>
<!-- Start Content -->
<div class="container">
	<div class="row-fluid">
		<div class="span12">
		<div class="page-header">
		<div class="category-title font-lato bold"><?php single_post_title(); ?></div>
		</div>
		</div>
	</div>
	<div class="row-fluid" id="archive">
	<div class="span4">
			<div id="kenali-smile-menu">
			<h2 id="kenali-smile-menu-title" class="font-lato bold"><?php 
			if(ICL_LANGUAGE_CODE=='en'){
				_e("Knowing SMiLe");
			}else{
				_e("Kenali SMiLe");
			}
			?></h2>
		<?php
		$page_id= get_query_var('page_id');
		$page_name= get_query_var('pagename');
		$args= array('post_type'=>'page', 'post_parent'=>373, 'orderby'=>'date', 'order'=>'ASC');
		$query= new WP_Query($args);
//		echo "<pre>";
//		print_r($page_name);
//		echo "</pre>";
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
				if( $page_name == "berita-smile" ){
					$nav_content= $child_page;
				}
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
	<style>
.berita-smile {font-size:1.2em;}
.berita-smile ul:first-child>li {
float: left;
list-style: none;
margin: 0 .5em;
}
.berita-smile ul>li>a {
padding: .5em 1em;
background: #f00;
color: #fff;
}
.berita-smile ul {
clear: both;
height: 2em;
}
	</style>
		<h1><?php echo ucfirst(single_cat_title('', FALSE)); ?></h1>
		<div class="berita-smile">
		<ul>
<?php 
		$args= array('post_type'=>'page', 'post_parent'=>1286);
		$query= new WP_Query($args);
		$nav_content= $query->get_posts();
		foreach( $nav_content as $item ){
			$selected= "";
			if( $item->post_name == $page_name ){
				$selected= "active";
			}
		?>
		<li>
		<a class="<?php echo $selected; ?>" href="<?php echo get_permalink($item->ID); ?>">
		<?php echo get_the_title($item->ID); ?>
		</a>
		</li>
		<?php
		}
		?>
		</ul>
		</div>
<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			echo "<div class='berita-smile'>";
			the_content();
			echo "</div>";
		} // end while
	} // end if
?>
		<?php 
		$paged= (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args= array('paged'=>$paged);
		$category_name= $page_name;
		if( $page_name == "berita-smile" ){
			$category_name= "news";
		}
		$args= array('category_name'=>$category_name, 'paged'=>$paged);
		global $more;
		$query= new WP_Query($args);
//		echo "<pre>";
//		print_r($args);
//		echo "</pre>";
		if( $query->have_posts() ){
		?>
			<?php 
			$ct= 1;
			$number_of_posts= $query->post_count;
			while( $query->have_posts() ){
				$query->the_post();
				$more = 0;
				if( $ct % 2 == 1 ){
			?>
				<div class="row-fluid news-row">
			<?php
				}
			?>
			<div class="span6">
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
				<?php the_content('read more..'); ?>
				</div>
			</div>
			<?php 
				if( $ct % 2 == 0 || $ct == $number_of_posts ){
			?>
				</div>
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
				'total' => $query->max_num_pages,
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
<!-- End Content -->

<?php get_footer(); ?>