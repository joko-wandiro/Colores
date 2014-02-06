<?php get_header(); ?>

<!-- Start Content -->
<div class="container" id="single-page">
<div class="row-fluid">
	<div class="span12">
		<div>
		<a href="<?php echo bloginfo('url'); ?>"></a>
		</div>
		<div class="page-header">
		<?php 
		$archive_link= get_post_type_archive_link("stuff");
		?>
		<div class="breadcrumb-sign">
		<a class="btn" href="<?php echo esc_url($archive_link); ?>" 
		title="<?php echo strtoupper(__("stuff")); ?>"><?php echo __('Back To ') . 
		strtoupper(__("stuff")); ?></a>
		</div>
		</div>
	</div>
	<div class="span12 no-margin-left">
<?php
	global $wp_query, $post;
//	echo "<pre>";
//	print_r($post);
//	echo "</pre>";
?>

<!-- Print a link to this category -->
	<?php
	if( have_posts() ){
		while( have_posts() ){
			the_post();
			$post= get_post();
			$custom= get_post_custom();
//			echo "<pre>";
//			print_r($post);
//			print_r($custom);
//			echo "</pre>";
	?>
	<div class="row-fluid">
		<div class="span10">
		<h1 class="post-title"><?php the_title(); ?></h1>
		<p class="post-date italic">
		<?php echo strtoupper(the_time('d F Y')); ?>
		</p>
		<div class="post-content">
		<div class="post-feature-image"><?php the_post_thumbnail(); ?></div>
		<?php the_content(); ?>
		</div>
		</div>
		<div class="span2">
		<?php
		if( $custom['license'][0] == "free" ){
			$txt_btn= __("Donate");
			$txt_price= __("Free");
		}else{
			$txt_btn= __("Buy Now");
			$txt_price= "$ " . $custom['price'][0];
		}
		?>
		<div id="price-area-wrapper">
		<div class="block-price block"><?php echo $txt_price; ?></div>
		<div>
		<a href="<?php echo esc_url($custom['url'][0]); ?>" class="btn full">
		<?php echo $txt_btn; ?></a>
		</div>
		</div>
	</div>
	<!-- Start Comments Form -->
	<div class="row-fluid">
	<div class="span12">
	<div class="separator-line">&nbsp;</div>
	<?php comments_template( '', true ); ?>
	</div>
	</div>
	<!-- End Comments Form -->	
	<?php
		}
	}
	else{
	?>
	<p><?php _e('No posts were found. Sorry!'); ?></p>
	<?php
	}
	?>
	</div>
</div>
</div>
</div>
<!-- End Content -->

<?php get_footer(); ?>