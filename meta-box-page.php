<?php
// Start Add Meta Box - Custom Field
add_action("admin_init", "package_page_add_meta");
function package_page_add_meta(){
	add_meta_box("banner-background-package-page", "Banner Background Color", 
	"banner_background_package_page_meta_options", "page", "normal", "high");
}

function banner_background_package_page_meta_options(){
	global $post;
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}
	
	$custom= get_post_custom($post->ID);
	$banner_bg_color= $custom["banner_bg_color"][0];
?>
<style type="text/css">
<?php include('meta_box.css'); ?>
</style>
<div class="location-extras meta-box-wrapper">
	<div>
	<label>Banner Background Color: </label>
	<input type="text" name="banner_bg_color" value="<?php echo $banner_bg_color; ?>" placeholder="Input your Hex Color. Ex: #ffffff" />
	</div>
</div>
<?php
}
// End Add Meta Box - Custom Field

// =====================================================================================================
// Start Save Post
add_action('save_post', 'banner_background_package_page_save_extras');
function banner_background_package_page_save_extras(){
	global $post;
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
		update_post_meta($post->ID, "banner_bg_color", $_POST['banner_bg_color']);
	}
}
// End Save Post
?>