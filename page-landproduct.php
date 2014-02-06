<?php
/*
* Template Name: Landing Products
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
	<div class="row-fluid" id="landing-product">
		<div class="span12">
	<?php
	if(have_posts()){
		while(have_posts()){
			the_post();
			$custom= get_post_custom($post->ID);
	?>
			<div class="container">
			<div class="page-header">
				<h1><?php the_title(); ?></h2>
			</div>
			</div>
			<div class="headimg" style="background-color: <?php echo $custom['banner_bg_color'][0]; ?>">
			<?php 
			if ( has_post_thumbnail() ) {
				$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full');
				$thumbnailSrc = $src[0];
				echo '<img src="'.$thumbnailSrc.'" class=""/>';
			}
			?>
			</div>
			<div class="container">
				<div class="row-fluid" id="landing-product">
				<?php
					//<div class="span7 scontent font-source-sans-pro">
					//	<?php the_content(); 
					//</div>
				?>
					<div class="span2"></div>
					<div class="span8">
	<?php
if(is_page(909)){$pt = "single-youth";}//-43
if(is_page(938)){$pt = "newly-married";}//-35
if(is_page(943)){$pt = "married-with-baby";}//-36
if(is_page(954)){$pt = "married-with-young-children";}//-44
if(is_page(957)){$pt = "nearing-retirement";}//-38
if(is_page(959)){$pt = "golden-age";}//-39
$args = array(
	'post_type' => 'products_msig',
	'products_categories' => array($pt,),
);
$query = new WP_Query( $args );
if ($query->have_posts()){
	?><div class="accordion font-lato" id="category1"><?php
	for($ii=1;$ii<3;$ii++){
		if($ii==1){$href = "Agency";}else{$href = "Bancassurance"; $link = " &amp; Others";}
?>
  <div class="accordion-group">
	<div class="accordion-heading">
	  <a class="accordion-toggle" data-toggle="collapse" data-parent="#category1" href="#<?php echo $href; ?>"><?php echo $href.$link; ?><span class="acrow"></span></a>
	</div>
	<div id="<?php echo $href; ?>" class="accordion-body collapse">
	  <div class="accordion-inner">
		<div class="accordion" id="cat<?php echo $ii; ?>">
		<?php
			$cat2 = array("Saving","Life","Health");
			foreach($cat2 as $cat){
				if($cat=="Saving"){$subt = " &amp; Investment";}
				elseif($cat=="Life"){$subt = " &amp; Protection";}else{$subt="";}
			?>
			  <div class="accordion-group">
				<div class="accordion-heading">
				  <a class="accordion-toggle" data-toggle="collapse" data-parent="#cat<?php echo $ii; ?>" href="#<?php echo $cat.$ii; ?>"><?php echo $cat.$subt; ?><span class="acrow"></span></a>
				</div>
				<div id="<?php echo $cat.$ii; ?>" class="accordion-body collapse">
				  <div class="accordion-inner">
					<ul>
					<?php
						if($ii==1){$href="agency";}else{$href="bancassurance-others";}
						if($cat=="Saving"){$subt = "saving-investment";}else{$subt="health";}
						if($cat=="Life"){$subt = "life-protection";}else{$subt="health";}
						while ($query->have_posts()){
							$query->the_post();
							if (has_term(array($href),"products_categories")){
								if (has_term(array($subt),"products_categories")){
									echo '<li><a href="'.get_permalink().'">' . get_the_title() . '</a></li>';
								}
							}
						}
					?>
					</ul>
				  </div>
				</div>
			  </div>
			<?php
			}
		?>	  
		</div>
	  </div>
	</div>
  </div>
<?php
	}
	?></div><?php
}
//else {echo " no posts found";}
wp_reset_postdata();
	?>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12"></div>
				</div>
				<div class="row-fluid">
					<div class="span12">
		<!--h2 id="pp-choose-product" class="font-lato light center">Pilih Produk</h2-->
		<?php
		$args = array(
			'post_type' => 'products_msig',
			'products_categories' => array($pt,),
			'posts_per_page'=>-1
		);
		$query= new WP_Query($args);
		?>
		<ul class="bxslider">
		<?php
		if( $query->have_posts() ){
			while( $query->have_posts() ){
				$query->the_post();
				$custom= get_post_custom();
		?>
				<li>
				<a href="<?php echo get_permalink(); ?>">
				<?php 				
				if( MultiPostThumbnails::has_post_thumbnail('post', 'secondary-image') ){
					MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'secondary-image');
				}else{
					echo wp_get_attachment_image(266, 'full');
				}
				?>
				</a>
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
			<?php }
			} ?>
		</div><?php // end span 12?>
	</div>
<?php get_footer(); ?>