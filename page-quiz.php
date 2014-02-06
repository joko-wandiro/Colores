<?php
/*
Template Name: Quiz
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
	<div class="container">
    <?php
		if(empty($_POST['quiz'])){
    ?>
		<div class="row-fluid">
			<div class="span12">
<?php 
				$quiz = get_post_meta( $post->ID, 'question', true ); 
				$ii = 1;
				$tquiz = count($quiz);
				$wquiz = 100*$tquiz;
				$equiz = 100/$tquiz;
?>
                <div id="content-question-and-answer">
                    <form name="questionnaire" method="post" action="<?php echo home_url('/questionnaire/?test=result'); ?>" class="questions">
                        <div class="quiz" style="width:<?php echo $wquiz."%"; ?>;">
                        <input type="hidden" value="" name="quiz" id="quiz" class="loading" /> 
<?php
                        foreach($quiz as $qz){
?>
                            <div id="cqna-forms" style="width:<?php echo $equiz."%"; ?>;">
                                <h3 class="red-text">Question <?php echo $ii; ?></h3>
                                <h2><?php echo $qz['quiz'];?></h2>
                                <p>Pilih yang sesuai dengan kondisi anda</p>
                                <div class="btn-group">
                                    <button class="btn btn-super-large font-lato trans3 yes">Yes</button>
                                    <button class="btn btn-super-large font-lato trans3 no">No</button>
                                </div>
                            </div>
<?php
                        $ii++;
                        }
?>
                        </div>
                    </form>
                </div>
			</div>
		</div>
	<?php
		}else{
			$src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full');
			$img = $src[0];
			echo '<img src="'.$img.'" />';
	?>
    	<h1>Your Test Result is</h1>
        <pre>
        <?php echo var_dump($_POST); ?>
        </pre>
        <div id="tes-result">
<?php
				$results = get_post_meta( $post->ID, 'Results', true ); 
				foreach($results as $result){
?>
		<div class="row-fluid">
			<div class="span8">
            <h3><?php echo $result['title']; ?></h3>
            <h4>Baik</h4>
            <div><?php echo $result['description']; ?></div>
            </div>
            <div class="span4">
            <h3>Rating</h3>
            <img src="<?php echo get_template_directory_uri(); ?>/img/star2.png" />
            </div>
        </div>
    <?php
				}
		?>
	</div>
    <div class="gradline"></div>
		<h2 id="pp-choose-product" class="font-lato light center">Produk Untuk Anda</h2>
		<?php
		$query= new WP_Query(array(
		'category_name'=>'sinarmas-msig-life-products, sinarmas-msig-life-syariah-product', 
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
		<p>Ingin tahu produk mana yang cocok untuk anda? <a href="<?php echo home_url('/questionnaire'); ?>">klik disini &gt;&gt;</a></p>
		<p>Bicara langsung dengan customer service kami, <a href="<?php echo home_url('/customer-service'); ?>">klik disini &gt;&gt;</a></p>
		</div>
        
        <?php
		}
	?>
	</div>
<?php get_footer(); ?>