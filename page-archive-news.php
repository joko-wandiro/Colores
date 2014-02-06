<?php
/*
* Template Name: Archive News
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
	<div class="row-fluid" id="archive-news">
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
		global $post;
		$page_id= get_query_var('page_id');
		$page_name= get_query_var('pagename');
		$args= array('post_type'=>'page', 'post_parent'=>373, 'orderby'=>'date', 'order'=>'ASC');
		$query= new WP_Query($args);
//		echo "<pre>";
//		print_r($post->post_title);
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
		
<!--		<h2><?php _e($post->post_title); ?></h2>-->
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
				
		$args= array('category_name'=>$category_name, 'paged'=>$paged, 'posts_per_page'=>8);
		$regex_gallery= '/gallery|videos|photos/';
		if( ! preg_match($regex_gallery, $page_name) ){
			unset($args['paged']);
			$limit= array('posts_per_page'=>-1);
			$args= array_merge($args, $limit);
		}
				
		global $more;
		$query= new WP_Query($args);
		$category_posts_dt= $query->get_posts();
//		$category_posts= ( $page_name != "gallery" ) ? array() : $category_posts_dt;
		$category_posts= array();
//			echo "<pre>";
//			print_r($page_name);
//			echo "</pre>";
		if( preg_match($regex_gallery, $page_name) ){
			$args['category_name']= "photos";
			$args['paged']= ( $page_name == "photos" ) ? get_query_var('paged') : 1;
			$photos_query= new WP_Query($args);
			$photos_posts= $photos_query->get_posts();
//			echo "<pre>";
//			print_r($photos_query->post_count);
//			echo "</pre>";
						
			$args['category_name']= "videos";
			$args['paged']= ( $page_name == "videos" ) ? get_query_var('paged') : 1;
			$videos_query= new WP_Query($args);
			$videos_posts= $videos_query->get_posts();
//			echo "<pre>";
//			echo "\n========Photos==========\n";
//			print_r($videos_query->post_count);
//			echo "</pre>";
			
			$category_posts['photos']= $photos_posts;
			$category_posts['videos']= $videos_posts;
		}
/*		echo "<pre>";
//		print_r($page_name);
//		echo "\n";
//		echo get_query_var('paged');
//		print_r($category_posts);
		$pattern= get_shortcode_regex();
		print_r($pattern);
		echo "</pre>";*/
		
		if( empty($category_posts) ){
		foreach( $category_posts_dt as $item ){
			if( $page_name != "gallery" ){
			$year= date("Y", strtotime($item->post_date));
			$category_posts[$year][]= $item;
			}
		}
		}
		
		if( $query->have_posts() ){
			if( ! preg_match($regex_gallery, $page_name) ){
		?>			
			<ul id="myTab" class="nav nav-tabs">
			<?php 
			$ct= 1;
			$number_of_posts= $query->post_count;
			foreach( $category_posts as $key=>$posts ){
				$query->the_post();
				$selected= "";
				if( $ct == 1 ){
					$selected= "active";
				}
				$more = 0;
			?>
				<li class="<?php echo $selected; ?>">
				<a href="#year-<?php echo $key; ?>" data-toggle="tab"><?php echo $key; ?></a></li>
			<?php 
				$ct++;
			}
			?>
			</ul>
			
			<div id="myTabContent" class="tab-content">
			<?php 
			$ct= 1;
			$number_of_posts= $query->post_count;
			foreach( $category_posts as $key=>$posts ){
				$query->the_post();
				$more = 0;
				$selected= "";
				if( $ct == 1 ){
					$selected= "active";
				}				
			?>
				<div class="tab-pane fade in <?php echo $selected; ?>" id="year-<?php echo $key; ?>">
				<ul>
			<?php
				foreach( $posts as $subkey=>$post ){
			?>
				<li>
				<div class="date">
				<?php echo date("d/m/Y", strtotime($post->post_date)); ?>
				</div>
				<div class="permalink">
				<a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a>
				</div>
				</li>
			<?php 
				}
			?>
				</ul>
				</div>
			<?php
				$ct++;
			}
			?>
			</div>
			<?php
			}
			else{
			foreach( $category_posts as $key=>$posts ){
				$title_section= ucfirst($key);
				$post_query= $key . "_query";
				$number_of_posts= $$post_query->post_count;
				$ct= 1;
			?>
			<h2><?php _e($title_section); ?></h2>
			<?php				
				foreach( $posts as $subkey=>$post ){
					if( $ct % 4 == 1 ){
			?>
					<div class="row-fluid gallery-news-rows">
			<?php
					}
			?>
				<div class="span3">
				<div><?php echo get_the_post_thumbnail($post->ID); ?></div>
				<div><?php echo date("d/m/Y", strtotime($post->post_date)); ?></div>
				<div><?php echo get_the_excerpt($post->ID); ?></div>
				</div>
			<?php 
					if( $ct % 4 == 0 || $ct == $number_of_posts ){
			?>
					</div>
			<?php
					}
					$ct++;
				}
				$big = 999999999; // need an unlikely integer
				if( $page_name == "gallery" ){
					$pagenum_link= str_replace('page', $key.'/page', get_pagenum_link($big));
				}else{
					$pagenum_link= ( $page_name != $key ) ? str_replace($page_name, $key, get_pagenum_link($big)) : 
					get_pagenum_link($big);
				}
//				$pagenum_link= get_pagenum_link($big);
				$args = array(
				'base' => str_replace( $big, '%#%', esc_url($pagenum_link) ),
				'format' => '?paged=%#%',
				'current' => max(1, get_query_var('paged')),
//				'total' => $$post_query->max_num_pages,
				'total' => $query->max_num_pages,
				'type'=>'array'
				);
				$args['current']= ( $page_name == $key ) ? get_query_var('paged') : 1;
				$pagination= paginate_links($args);
				// Create Pagination Links follow foundation structure.
				bootstrap_archive_news_pagination($pagination);			
			?>			
			<?php
			}
			}
			?>
		<?php 
		}
		else{ 
		?>
<!--			<div>
			<p><?php _e('No posts were found. Sorry!'); ?></p>
			</div>-->
		<?php } ?>
	</div>
	</div>
</div>
<!-- End Content -->

<?php get_footer(); ?>