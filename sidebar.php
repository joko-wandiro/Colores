<?php
if( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar('Primary Sidebar') ){
?>
	<div class="widget">
		<?php get_search_form(); ?>
	</div>
<?php
}
?>