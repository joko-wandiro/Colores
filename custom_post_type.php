<?php
function sinar_products() { 
$cptname	= "Product";
$cptnames	= "Products";
$new_product = __("New Product");
	register_post_type( 'products_msig',
		array('labels' => array(
			'name' => __($cptnames),
			'singular_name' => __($cptname),
			'all_items' => __('All '.$cptnames),
			'add_new_item' => $new_product,
			'new_item' => $new_product,
			'edit_item' => __('Edit '.$cptname),
			'view_item' => __('View '.$cptname),
			'search_items' => __('Search '.$cptname),
			'not_found' =>  __('No '.$cptname.' found in the Database'),
			'not_found_in_trash' => __('No '.$cptname.' found in Trash'),
			),
		'description' => __( '' ),
//		'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
		'rewrite'	=> array( 'slug' => 'products', 'with_front' => false ), /* you can specify its url slug */
		'has_archive' => 'products', /* you can rename the slug here */
		'supports' => array(
							'title', 
							'editor', 
							'author', 
							'thumbnail', 
							'excerpt', 
							//'trackbacks', 
							//'custom-fields', 
							//'comments', 
							'revisions', 
							'page-attributes',
							'post-formats',
							'sticky'),
		'query_var' => true,
		'menu_position' => 20, /*
			5 - below Posts
			10 - below Media
			15 - below Links
			20 - below Pages
			25 - below comments
			60 - below first separator
			65 - below Plugins
			70 - below Users
			75 - below Tools
			80 - below Settings
			100 - below second separator */		
		'public' => true,
//		'publicly_queryable' => true, //default depend on public value
//		'exclude_from_search' => false, //default depend on public value
//		'show_in_nav_menus' => true, //default depend on public value

//		'show_ui' => true, //default depend on public value
//		'show_in_menu' => true, //default depend on SHOW UI
//		'show_in_admin_bar' => true, //default depend on SHOW UI

	 	) /* end of options */
	); /* end of register post type */
	flush_rewrite_rules( false );
	register_taxonomy_for_object_type('category', 'products_msig');
}
add_action( 'init', 'sinar_products');
//end products

//-------- start custom taxonomy categories or tags for post type -----------------------
	/* - START one taxonomy - */
$taxoname = "Category";
$taxonames= "Categories";
register_taxonomy( 'faqs_categories', 
	array('faqs_msig'), /* post type slug, case sensitive, no space allowed */
	array('hierarchical' => true,     /* if this is true, it acts like categories */             
		'labels' => array(
			'name' => __( $taxonames ),
			'singular_name' => __( $taxoname ),
			'search_items' =>  __( 'Search '.$taxonames ),
			'all_items' => __( 'All '.$taxonames ),
			'parent_item' => __( 'Parent '.$taxoname ),
			'parent_item_colon' => __( 'Parent '.$taxoname ),
			'edit_item' => __( 'Edit '.$taxoname ),
			'update_item' => __( 'Update '.$taxoname ),
			'add_new_item' => __( 'Add New '.$taxoname ),
			'new_item_name' => __( 'New '.$taxoname )
		),
		'show_admin_column' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'faqs-category' ),
	)
);	/* - END one taxonomy - */

	/* - START one taxonomy - */
$taxoname = "Category";
$taxonames= "Categories";
register_taxonomy( 'hospital_categories', 
	array('hospital_msig'), /* post type slug, case sensitive, no space allowed */
	array('hierarchical' => true,     /* if this is true, it acts like categories */             
		'labels' => array(
			'name' => __( $taxonames ),
			'singular_name' => __( $taxoname ),
			'search_items' =>  __( 'Search '.$taxonames ),
			'all_items' => __( 'All '.$taxonames ),
			'parent_item' => __( 'Parent '.$taxoname ),
			'parent_item_colon' => __( 'Parent '.$taxoname ),
			'edit_item' => __( 'Edit '.$taxoname ),
			'update_item' => __( 'Update '.$taxoname ),
			'add_new_item' => __( 'Add New '.$taxoname ),
			'new_item_name' => __( 'New '.$taxoname )
		),
		'show_admin_column' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'hospital-category' ),
	)
);	/* - END one taxonomy - */

	/* - START one taxonomy - */
$taxoname = "Type";
$taxonames= "Types";
register_taxonomy( 'hospital_types', 
	array('hospital_msig'), /* post type slug, case sensitive, no space allowed */
	array('hierarchical' => false,     /* if this is true, it acts like categories */             
		'labels' => array(
			'name' => __( $taxonames ),
			'singular_name' => __( $taxoname ),
			'search_items' =>  __( 'Search '.$taxonames ),
			'all_items' => __( 'All '.$taxonames ),
			'parent_item' => __( 'Parent '.$taxoname ),
			'parent_item_colon' => __( 'Parent '.$taxoname ),
			'edit_item' => __( 'Edit '.$taxoname ),
			'update_item' => __( 'Update '.$taxoname ),
			'add_new_item' => __( 'Add New '.$taxoname ),
			'new_item_name' => __( 'New '.$taxoname )
		),
		'show_admin_column' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'hospital-type' ),
	)
);	/* - END one taxonomy - */

//-------- end custom taxonomy

// - METABOX LOCATION ---
function metabox_location(){
		global $post;
		// Noncename needed to verify where the data originated
		echo '<input type="hidden" name="location_noncename" id="location_noncename" value="' . 
		wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
		
		$location = get_post_meta($post->ID, 'location_meta', true);
		$address = get_post_meta($post->ID, 'address_meta', true);
	?>
		<div id="location_box">
			<p>
            <label class="field-label" for="location_meta">Location : </label>
			<select name="location_meta" id="location_meta">
			<option value="">-- Select Location --</option>
			<?php
			$args = array( 'post_type' => 'location', 'numberposts' => '-1' );
			$recent_posts = wp_get_recent_posts( $args );
			foreach( $recent_posts as $recent ){
				if($location==$recent['ID']){$selected="selected";}else{$selected="";}
			?>
				<option value="<?php echo $recent['ID']; ?>" <?php echo $selected; ?>><?php echo $recent['post_title']; ?></option>
			<?php
			}
			?>
			</select>
            </p>
		</div>
		<div id="address_box">
			<p>
            <label class="field-label" for="address_meta">Address : </label>
            <textarea name="address_meta" id="address_meta" class="mb-textarea mb-field"><?php echo $address; ?></textarea>
            </p>
		</div>
	<?php		
}
function add_location() {
	add_meta_box('meta_location_msig', 'Location', 'metabox_location', 'hospital_msig', 'normal');
}
add_action( 'add_meta_boxes', 'add_location' );

// Save the Metabox Data
function save_meta_location($post_id, $post) {
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['location_noncename'], plugin_basename(__FILE__) )) {
	return $post->ID;
	}
	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;
	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.
	
	$meta_data['location_meta'] = $_POST['location_meta'];
	$meta_data['address_meta'] = $_POST['address_meta'];
	
	// Add values of $events_meta as custom fields
	
	foreach ($meta_data as $key => $value) { // Cycle through the $events_meta array!
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}
}
add_action('save_post', 'save_meta_location', 1, 2); // save the custom fields
?>
