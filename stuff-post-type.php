<?php
define("PHC_STUFF_POST_TYPE", "stuff");
define("PHC_STUFF_ID_SCRIPT", "stuff");
define('PHC_STUFF_IDENTIFIER', "stuff");

add_action('init', 'phc_stuff_post_type');
function phc_stuff_post_type(){
	// Set Up Arguments
	$support_args= array('title', 'editor', 'thumbnail', 'comments');
	$args= array(
	'public'=>TRUE,
	'exclude_from_search'=>TRUE,
	'publicly_queryable'=>TRUE,
	'show_ui'=>TRUE,
	'query_var'=>PHC_STUFF_POST_TYPE,
	'rewrite'=>array(
		'slug'=>PHC_STUFF_POST_TYPE,
		'with_front'=>FALSE,
	),
	'has_archive'=>TRUE,
	'supports'=>$support_args,
	'labels'=>array(
		'name'=>__('Stuff'),
		'singular_name'=>__('Stuff'),
		'add_new'=>__('Add New Stuff'),
		'add_new_item'=>__('Add New Stuff'),
		'edit_item'=>__('Edit Stuff'),
		'new_item'=>__('New Stuff'),
		'view_item'=>__('View Stuff'),
		'search_items'=>__('Search Stuff'),
		'not_found'=>__('No Stuff Found'),
		'not_found_in_trash'=>__('No Stuff Found In Trash')
	),
	);
	
	// Register It
	register_post_type(PHC_STUFF_POST_TYPE, $args);
}

// Set up the taxonomies. 
add_action('init', 'phc_stuff_register_taxonomies');

// Registers taxonomies.
function phc_stuff_register_taxonomies() {
	// Set up the Plugins taxonomy arguments
	$args = array(
	'hierarchical'=>false,
	'query_var'=>'plugins',
	'show_tagcloud'=>true,
	'rewrite'=>array(
		'slug'=>'plugins',
		'with_front'=>TRUE
	),
	'public' => true,
	'labels'=>array(
		'name'=>'Plugins',
		'singular_name'=>'Plugin',
		'edit_item'=>'Edit Plugin',
		'update_item'=>'Update Plugin',
		'add_new_item'=>'Add New Plugin',
		'new_item_name'=>'New Plugin Name',
		'all_items'=>'All Plugins',
		'search_items'=>'Search Plugins',
		'popular_items'=>'Popular Plugins',
		'separate_items_with_commas'=>'Separate Plugins with commas',
		'add_or_remove_items'=>'Add or remove Plugins',
		'choose_from_most_used'=>'Choose from the most popular Plugins',
	),
	);
	// Register the Plugins taxonomy
	register_taxonomy('plugins', array(PHC_STUFF_POST_TYPE), $args);
}

// Start Add Meta Box - Custom Field
add_action("do_meta_boxes", "phc_stuff_add_meta");
function phc_stuff_add_meta(){
	add_meta_box("stuff-meta", "Stuff Settings", "phc_stuff_meta_options", 
	PHC_STUFF_POST_TYPE, "normal", "high");
}

function phc_stuff_meta_options($post, $metabox){
	global $post;
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}
	
	$custom= get_post_custom($post->ID);
	$meta_fields= array("license", "price", "url");
	$data= array();
	foreach( $meta_fields as $field ){
		$$field= isset($custom[$field][0]) ? $custom[$field][0] : "";
		$data[$field]= isset($custom[$field][0]) ? $custom[$field][0] : "";
	}

	$num_section= count($data) ? count($data) : "";
//	echo "<pre>";
//	print_r($data);
//	echo "</pre>";
//	exit;
	
	wp_enqueue_style(PHC_STUFF_ID_SCRIPT . '_admin_css', get_bloginfo('template_url') . 
	"/js/admin/stuff.css");
	wp_enqueue_script(PHC_STUFF_ID_SCRIPT . '_admin_js', get_bloginfo('template_url') . 
	"/js/admin/stuff.js", array("jquery-ui-core", "jquery-ui-accordion", "jquery-ui-sortable"));
	
	$plugins= array('wordpress', 'opencart', 'jquery');
	$licenses= array('free', 'premium');
	asort($plugins);
?>
<div class="pricing-table-extras meta-box-wrapper">
	<div id="extra-section">
		<div>
		<label class="no-cursor"><?php _e("License", PHC_STUFF_IDENTIFIER); ?>:</label>
		<div class="controls-input">
		<?php
		foreach( $licenses as $item ){
			$checked= "";
			if( $item == $license ){
				$checked= " checked=\"\"";
			}
		?>
		<input type="radio" name="license" id="<?php echo $item; ?>" value="<?php echo $item; ?>"<?php echo $checked; ?> />
		<label for="<?php echo $item; ?>"><?php echo ucfirst($item); ?></label>
		<?php
		}
		?>
		</div>
		</div>
		<div>
		<label for="price"><?php _e("Price", PHC_STUFF_IDENTIFIER); ?>:</label>
		<input type="text" name="price" id="price" value="<?php echo $price; ?>" />
		</div>
		<div>
		<label for="url"><?php _e("Url", PHC_STUFF_IDENTIFIER); ?>:</label>
		<input type="text" name="url" id="url" value="<?php echo $url; ?>" />
		</div>		
		</div>
		<a href="" target="_blank"></a>
	</div>
<?php
}
// End Add Meta Box - Custom Field

// Start Save Post
add_action('save_post', 'phc_stuff_save_extras');
function phc_stuff_save_extras(){
	global $post;
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}
	else{
		$meta_fields= array("license", "price", "url");
		if( isset($_POST['license']) && $_POST['license'] == "free" ){
			$_POST['price']= "";
		}
//		header('content-type: text/plain');
//		print_r($_POST);
//		exit;

		// Validate Data
		
		// Save Data
		foreach( $meta_fields as $field ){
			if( isset($_POST[$field]) ){
			$value= $_POST[$field];
			switch( $columns ){
				case "url":
					$value= esc_url_raw($value);
					break;
			}
//			$value= implode(",", $_POST[$field]);
			update_post_meta($post->ID, $field, $value);
			}
		}
	}
}
// End Save Post

// Start Modification Columns
add_filter("manage_edit-stuff_columns", "phc_stuff_edit_columns");
function phc_stuff_edit_columns($columns){
	$columns= array(
	"cb"=>"<input type=\"checkbox\" />",
	"title"=>_x("Title", "column", PHC_STUFF_IDENTIFIER),
	"license"=>_x("License", "column", PHC_STUFF_IDENTIFIER),
	"price"=>_x("Price", "column", PHC_STUFF_IDENTIFIER),
	"url"=>_x("Url", "column", PHC_STUFF_IDENTIFIER),
	"date"=>_x("Date", "column", PHC_STUFF_IDENTIFIER),
	);
	
	return $columns;
}

add_action("manage_stuff_posts_custom_column", "phc_stuff_custom_columns");
function phc_stuff_custom_columns($columns){
	global $post;
	$custom= get_post_custom();
//	echo "<pre>";
//	print_r($custom);
//	echo "</pre>";
//	$meta_fields= array("license", "price", "url");	
	switch( $columns ){
		case "license":
			$license= isset($custom['license'][0]) ? $custom['license'][0] : "";
			$license= '<span class="label label-inverse">' . strtoupper($license) . '</span>';
			echo $license;
			break;
		case "price":
			if( isset($custom['price'][0]) && ! empty($custom['price'][0]) ){
				$price= $custom['price'][0];
				$price= '<span class="label label-inverse">$ ' . $price . '</span>';
			}else{
				$price= "-";
			}
			echo $price;
			break;
		case "url":
			$url= isset($custom['url'][0]) ? esc_url($custom['url'][0]) : "";
			$url= '<a href="' . $url . '"  target="_blank">' . $url . '</a>';
			echo $url;
			break;			
	}
}
// End Modification Columns

// Start Admin Scripts
//add_action('admin_print_scripts', 'phc_s_gallery_responsive_admin_print_scripts');
//function phc_s_gallery_responsive_admin_print_scripts(){
//	wp_enqueue_style(PHC_S_GALLERY_RESPONSIVE_ID_SCRIPT . '_admin_css', 
//	PHC_S_GALLERY_RESPONSIVE_PATH_URL_CSS . "admin.css");
//}

add_action('admin_print_scripts-edit.php', 'phc_s_gallery_responsive_admin_print_scripts_edit');
function phc_s_gallery_responsive_admin_print_scripts_edit(){
//	wp_enqueue_style(PHC_S_GALLERY_RESPONSIVE_ID_SCRIPT . '_edit_css', 
//	PHC_S_GALLERY_RESPONSIVE_PATH_URL_CSS . "edit.css");
	wp_enqueue_style(PHC_STUFF_ID_SCRIPT . '_post_edit_css', get_bloginfo('template_url') . 
	"/js/admin/post-edit.css");	
}
?>