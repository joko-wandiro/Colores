<?php
define('PHC_THEME_ID_SCRIPT', "phc_theme");
define("PHC_THEME_MENU_CAPABILITY", "manage_options");
define("PHC_THEME_MENU_SLUG_SETTINGS", PHC_THEME_ID_SCRIPT . "_settings");
define("PHC_THEME_MENU_TITLE_SETTINGS", __("Settings"));
	
add_action('admin_menu', 'phc_s_gallery_responsive_create_menu_settings');
function phc_s_gallery_responsive_create_menu_settings(){
	$function= "phc_theme_settings_page";
	// Create Theme Options Page
	add_theme_page(PHC_THEME_MENU_TITLE_SETTINGS, PHC_THEME_MENU_TITLE_SETTINGS, PHC_THEME_MENU_CAPABILITY, 
	PHC_THEME_MENU_SLUG_SETTINGS, $function);
	
	add_action('admin_init', 'phc_theme_register_settings');
}

function phc_theme_register_settings(){
	register_setting('phc_theme_settings_page_vars', 
	'phc_theme_settings_vars');
}

function phc_theme_settings_page(){
	global $wp_scripts;

	wp_enqueue_style(PHC_THEME_ID_SCRIPT . '_theme_options_css', JS_PATH . "admin/theme-options.css");
	wp_enqueue_script(PHC_THEME_ID_SCRIPT . '_theme_options_js', JS_PATH . "admin/theme-options.js", 
	array("jquery-ui-sortable", "jquery-ui-accordion", "jquery-ui-tabs"));
	
	$args= array(
	'post_type'=>'page',
	'posts_per_page'=>-1
	);
	$query= new WP_Query($args);
	$pages_dt= array();
	while( $query->have_posts() ){
		$query->the_post();
		$post= get_post();
		$custom= get_post_custom($post->ID);
		$pages_dt[$post->ID]= $post->post_title;
	}
	wp_reset_postdata();
	
	$phc_theme_settings_vars= get_option('phc_theme_settings_vars');
//	echo "<pre>";
//	print_r($phc_theme_settings_vars);
//	echo "</pre>";
	if( !empty($phc_theme_settings_vars) ){
		extract($phc_theme_settings_vars);
	}
?>
	<div class="wrap" id="<?php echo PCH_BPT_WIM_IDENTIFIER; ?>">
	<?php screen_icon('generic'); ?>
	<h2><?php _e('Settings'); ?></h2>
	<form method="POST" action="options.php">
	<?php settings_fields('phc_theme_settings_page_vars'); ?>
	<div id="tabs">
	<ul>
	<li><a href="#tabs-slider-navigation"><?php _e("Slider Navigation"); ?></a></li>
	<li><a href="#tabs-social-media"><?php _e("Social Media"); ?></a></li>
	<li><a href="#tabs-credits"><?php _e("Credits"); ?></a></li>
	</ul>
	<div id="tabs-slider-navigation">
	<div>
	<button type="button" id="btn-new-page" class="button-primary">
	<?php _e("New Page"); ?></button>
	</div>
	<!-- Start Slider Navigation Element -->
	<div class="group widget template-slider-navigation-form">
	<div class="btn-icon-header phc-icon-delete" 
	title="<?php _e("Delete"); ?>">
	<button class="button-secondary btn-remove-page" type="button">
	<?php _e("Remove"); ?></button>
	</div>
	<h3 class="hndle">
	<span><?php _e("Page"); ?> {page_number}</span>
	</h3>
	<div class="slider-navigation-section">
		<div>
		<label class=""><?php echo __("Select Page"); ?></label>
		<select name="phc_theme_settings_vars[slider_navigation][]" disabled="disabled">
		<?php
		foreach( $pages_dt as $page_id=>$page_value ){
		?>
		<option value="<?php echo $page_id; ?>"><?php echo $page_value; ?></option>
		<?php
		}
		?>
		</select>
		</div>
	</div>
	</div>
	<!-- End Slider Navigation Element -->
	
	<div id="slider-navigation-accordion">
	<?php
	$num_section= count($slider_navigation);
	if( ! empty($num_section) ){
	for( $ct=0; $ct<$num_section; $ct++ ){
		$page_number= $ct+1;
		
	?>
		<div class="group widget" data-page-number="<?php echo $page_number; ?>">
		<div class="btn-icon-header phc-icon-delete" 
		title="<?php _e("Delete"); ?>">
		<button class="button-secondary btn-remove-image" type="button">
		<?php _e("Remove"); ?></button>
		</div>
		<h3 class="hndle">
		<span><?php _e("Page"); ?> 
		<?php echo $page_number; ?></span>
		</h3>
		<div class="slider-navigation-section">
			<div>
			<label class=""><?php echo __("Select Page"); ?></label>
			<select name="phc_theme_settings_vars[slider_navigation][]">
			<?php
			foreach( $pages_dt as $page_id=>$page_value ){
			$selected= "";
			if( $page_id == $slider_navigation[$ct] ){
				$selected= " selected=\"\"";
			}
			?>
			<option value="<?php echo $page_id; ?>"<?php echo $selected; ?>><?php echo $page_value; ?></option>
			<?php
			}
			?>
			</select>
			</div>
		</div>
		</div>
	<?php
	}
	}
	?>
	</div>
	</div>
	<div id="tabs-social-media">
	<table class="form-table">
	<tr valign="top">
	    <th scope="row">
		<div><?php _e("Forrst"); ?></div>
		</th>
	    <td>
		<input type="text" name="phc_theme_settings_vars[social_media][forrst]" 
		value="<?php echo (isset($social_media['forrst'])) ? $social_media['forrst'] : ""; ?>" />
	   	</td>
   	</tr>
	<tr valign="top">
	    <th scope="row">
		<div><?php _e("Facebook"); ?></div>
		</th>
	    <td>
		<input type="text" name="phc_theme_settings_vars[social_media][facebook]" 
		value="<?php echo (isset($social_media['facebook'])) ? $social_media['facebook'] : ""; ?>" />
	   	</td>
   	</tr>
	<tr valign="top">
	    <th scope="row">
		<div><?php _e("Twitter"); ?></div>
		</th>
	    <td>
		<input type="text" name="phc_theme_settings_vars[social_media][twitter]" 
		value="<?php echo (isset($social_media['twitter'])) ? $social_media['twitter'] : ""; ?>" />
	   	</td>
   	</tr>	
	</table>
	</div>
	<div id="tabs-credits">
	<div>
	<button type="button" id="btn-new-credit" class="button-primary">
	<?php _e("Add Credit"); ?></button>
	</div>
	<!-- Start Credit Element -->
	<div class="group widget template-credit-form">
	<div class="btn-icon-header phc-icon-delete" 
	title="<?php _e("Delete"); ?>">
	<button class="button-secondary btn-remove-credit" type="button">
	<?php _e("Remove"); ?></button>
	</div>
	<h3 class="hndle">
	<span><?php _e("Credit"); ?> {credit_number}</span>
	</h3>
	<div class="credit-section">
		<div>
		<label class=""><?php echo __("Label"); ?></label>
		<input name="phc_theme_settings_vars[credits][label][]" type="text" value="" disabled="disabled" />
		</div>
		<div>
		<label class=""><?php echo __("Url"); ?></label>
		<input name="phc_theme_settings_vars[credits][url][]" type="text" value="" disabled="disabled" />
		</div>
	</div>
	</div>
	<!-- End Credit Element -->
	
	<div id="credit-accordion">
	<?php
	$num_section= count($credits['label']);
	if( ! empty($num_section) ){
	for( $ct=0; $ct<$num_section; $ct++ ){
		$credit_number= $ct+1;	
	?>
		<div class="group widget" data-credit-number="<?php echo $credit_number; ?>">
		<div class="btn-icon-header phc-icon-delete" 
		title="<?php _e("Delete"); ?>">
		<button class="button-secondary btn-remove-credit" type="button">
		<?php _e("Remove"); ?></button>
		</div>
		<h3 class="hndle">
		<span><?php _e("Credit"); ?> 
		<?php echo $credit_number; ?></span>
		</h3>
		<div class="credit-section">
			<div>
			<label class=""><?php echo __("Label"); ?></label>
			<input name="phc_theme_settings_vars[credits][label][]" type="text" 
			value="<?php echo ( isset($credits['label'][$ct]) ) ? $credits['label'][$ct] : ""; ?>" />
			</div>
			<div>
			<label class=""><?php echo __("Url"); ?></label>
			<input name="phc_theme_settings_vars[credits][url][]" type="text" 
			value="<?php echo ( isset($credits['url'][$ct]) ) ? $credits['url'][$ct] : ""; ?>" />
			</div>
		</div>
		</div>
	<?php
	}
	}
	?>
	</div>
	</div>	
	</div>
	<div class="btn-group-controls">
	<input type="submit" name="save" 
	value="<?php esc_attr_e("Save"); ?>" class="button-primary" />
	</div>
	</form>
	</div>
<?php
}
?>