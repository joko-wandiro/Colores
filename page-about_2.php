<?php
/*
* Template Name: About - Kenali Smile 2
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
			<h2 id="kenali-smile-menu-title" class="font-lato bold"><?php single_post_title(); ?></h2>
		<?php
		$post_name= get_query_var('post_name');
		
//		$args= array('category_name'=>'kenali smile', 'orderby'=>'ID', 'order'=>'ASC');
		$args= array('post_type'=>'page', 'post_parent'=>373, 'orderby'=>'title', 'order'=>'ASC');
		$query= new WP_Query($args);
//		echo "<pre>";
//		print_r($query);
//		echo "</pre>";
		if( $query->have_posts() ){
		?>
			<ul class="nav nav-list">
		<?php
			$ct= 1;
			while( $query->have_posts() ){
				$query->the_post();
				if( $ct == 1 && empty($post_name)){
					$post_name= $post->post_name;
				}
				$selected= "";
				$href= get_permalink();
//				$href= "#";
//				if( $post->post_name == $post_name ){
//					$selected= " class=\"active\"";
//				}else{
//					$href= get_bloginfo('url') . "/" . $pagename . "/" . $post->post_name;
//				}
		?>
				<li<?php echo $selected; ?>><a href="<?php echo $href; ?>"><?php the_title(); ?></a></li>
		<?php
			}
		?>
			</ul>
		<?php
		}
		wp_reset_postdata();
		?>
			</div>
			<!-- Start Produk Menu Section -->
			<div id="kenali-smile-menu-products">
				<h2 id="" class="font-lato bold">Produk Kami</h2>
				<h4 id="" class="font-lato bold">Sinarmas MSIG Life Products</h4>
				<?php
				$args= array('category_name'=>'sinarmas msig life products', 'orderby'=>'ID', 'order'=>'ASC');
				$args['posts_per_page']= -1;
				$query= new WP_Query($args);
				if( $query->have_posts() ){
				?>
					<ul class="nav nav-list msig-life-products">
				<?php
					$ct= 1;
					while( $query->have_posts() ){
						$query->the_post();
				?>
						<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php
					}
				?>
					</ul>
				<?php
				}
				wp_reset_postdata();
				?>
				</ul>
				
				<h4 id="" class="font-lato bold">Sinarmas MSIG Life Syariah Product</h4>
				<?php
				$args= array('category_name'=>'sinarmas msig life syariah product', 'orderby'=>'ID', 'order'=>'ASC');
				$args['posts_per_page']= -1;
				$query= new WP_Query($args);
				if( $query->have_posts() ){
				?>
					<ul class="nav nav-list msig-life-syariah-products">
				<?php
					$ct= 1;
					while( $query->have_posts() ){
						$query->the_post();
				?>
						<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php
					}
				?>
					</ul>
				<?php
				}
				wp_reset_postdata();
				?>
				</ul>
			</div>
			<!-- End Produk Menu Section -->
		</div>
		<div class="span8">
		<div class="content">
		<?php 
		$args= array('name'=>$post_name);
		$page_query= new WP_Query($args);
		if( $page_query->have_posts() ){
			while( $page_query->have_posts() ){
				$page_query->the_post();
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