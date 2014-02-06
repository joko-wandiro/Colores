<?php
/*
* Template Name: Product
*/
?>
<?php get_header(); ?>
<script>
jQuery(document).ready( function($){
	bxSliderOpts= {
	minSlides: 1,
	maxSlides: 4,
	slideWidth: 250,
	pager: false,
	}
	$('.bxslider').bxSlider(bxSliderOpts);
});
</script>
<!-- Start Content -->
<div class="container">
<div class="row-fluid" id="product-page">
	<div class="span12">
		<h1>Produk</h1>
		<div class="row-fluid">
		<?php
		$post_name= get_query_var('post_name');
		if( !empty($post_name) ){
			$args= array('name'=>$post_name);
		}else{
			$args= array('post_type' => 'products_msig');
		}
		$args['posts_per_page']= 1;
		$query= new WP_Query($args);
		if( $query->have_posts() ){
			while( $query->have_posts() ){
				$query->the_post();
		?>
		<div class="span3">
			<?php 
			if( has_post_thumbnail($post->ID) ){
				the_post_thumbnail($post->ID); 
			}else{
				echo wp_get_attachment_image(266, 'full');
			}
			?>
		</div>
		<div class="span9">
		<div id="main-content">
		<h3 class="title font-source-sans-pro"><?php the_title(); ?></h3>
		<?php the_content(); ?>
		</div>
		</div>
		<?php
			}
		}
		wp_reset_postdata();
		?>
		</div>
		
		<h2 id="pp-choose-product" class="font-lato light center">Pilih Produk</h2>
		<?php
		$query= new WP_Query(array(
		'post_type' => 'products_msig',
//		'category_name'=>'main-products, syariah-products', 
		'posts_per_page'=>-1
		));
		?>
		<ul class="bxslider">
		<?php
		if( $query->have_posts() ){
			while( $query->have_posts() ){
				$query->the_post();
				$custom= get_post_custom();
		?>
				<li>
				<a href="<?php echo get_bloginfo('url') . "/product/" . $post->post_name; ?>">
				<?php 				
				if( MultiPostThumbnails::has_post_thumbnail('post', 'secondary-image') ){
					MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'secondary-image');
				}else{
					echo wp_get_attachment_image(266, 'full');
				}
				?>
				</a>
				<div>
				</div>
				<div>
				<?php 
				the_excerpt();
				?>
				</div>
				</li>
		<?php
			}
		}
		else{
		?>		
			<p><?php _e('No posts were found. Sorry!'); ?></p>
		<?php
		}
		wp_reset_postdata();
		?>		
		</ul>
		<div id="pp-more-description">
		<p>Ingin tahu produk mana yang cocok untuk anda? 
		<a href="<?php echo home_url('/questionnaire'); ?>">klik disini &gt;&gt;</a></p>
		<p>Bicara langsung dengan customer service kami, 
		<a href="<?php echo home_url('/customer-service'); ?>">klik disini &gt;&gt;</a></p>
		</div>
	</div>
</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>