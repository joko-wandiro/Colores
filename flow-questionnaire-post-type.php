<?php
define("FLOW_QUESTION_POST_TYPE", "flow-questions");
define("PHC_FLOW_QUESTION_ID_SCRIPT", "flow_questions");
define('PHC_FLOW_QUESTION_IDENTIFIER', "flow-questions");

add_action('init', 'phc_flow_question_post_type');
function phc_flow_question_post_type(){
	// Set Up Arguments
	$args= array(
	'public'=>TRUE,
	'exclude_from_search'=>FALSE,
	'publicly_queryable'=>FALSE,
	'show_ui'=>TRUE,
	'query_var'=>FLOW_QUESTION_POST_TYPE,
	'rewrite'=>array(
		'slug'=>FLOW_QUESTION_POST_TYPE,
		'with_front'=>false,
	),
	'supports'=>array(
		'title',
	),
	'labels'=>array(
		'name'=>__('Flow Questions'),
		'singular_name'=>__('Flow Question'),
		'add_new'=>__('Add New Flow Question'),
		'add_new_item'=>__('Add New Flow Question'),
		'edit_item'=>__('Edit Flow Question'),
		'new_item'=>__('New Flow Question'),
		'view_item'=>__('View Flow Question'),
		'search_items'=>__('Search Flow Questions'),
		'not_found'=>__('No Flow Questions Found'),
		'not_found_in_trash'=>__('No Flow Questions Found In Trash')
	),
	);
	
	// Register It
	register_post_type(FLOW_QUESTION_POST_TYPE, $args);
}

// Start Add Meta Box - Custom Field
add_action("do_meta_boxes", "phc_flow_question_add_meta");
function phc_flow_question_add_meta(){
	add_meta_box("flow-questions-meta", "Flow Questions Settings", "phc_flow_question_meta_options", 
	FLOW_QUESTION_POST_TYPE, "normal", "high");
}

function phc_flow_question_meta_options($post, $metabox){
	global $post;
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}
	
	$custom= get_post_custom($post->ID);
	$meta_fields= array("fq_post_id", "fq_answer", "fq_finish_page");
	$csv_format= array("fq_post_id", "fq_answer");
	foreach( $meta_fields as $field ){
		$$field= $custom[$field][0];
		if( in_array($field, $csv_format) ){
			$$field= explode(",", $custom[$field][0]);
		}
	}

	$args= array(
	'post_type'=>'question_msig',
	'posts_per_page'=>-1
	);
	$questions_dt= new WP_Query($args);
	$questions= $questions_dt->get_posts();
	wp_reset_postdata();
	
	$args= array(
	'post_type'=>'products_msig',
	'posts_per_page'=>-1
	);
	$products_msig_dt= new WP_Query($args);
	$products= $products_msig_dt->get_posts();
	wp_reset_postdata();
	
	$num_section= isset($fq_post_id) ? count($fq_post_id) : "";
//	header('content-type: text/plain');
/*	echo "<pre>";
//	print_r($custom);
	print_r($fq_post_id);
	print_r($fq_answer);
	print_r($fq_finish_page);
	echo "</pre>";*/
//	exit;
	
	wp_enqueue_style(PHC_FLOW_QUESTION_ID_SCRIPT . '_admin_css', get_bloginfo('template_url') . 
	"/js/admin/flow-question.css");
	wp_enqueue_script(PHC_FLOW_QUESTION_ID_SCRIPT . '_admin_js', get_bloginfo('template_url') . 
	"/js/admin/flow-question.js", array("jquery-ui-core", "jquery-ui-accordion", "jquery-ui-sortable"));
?>
<div class="pricing-table-extras meta-box-wrapper">
	<div>
	<button type="button" id="btn-new-plan" class="button-primary">
	<?php _e("New Flow", PHC_FLOW_QUESTION_IDENTIFIER); ?></button>
	</div>
	<!-- Start Flow Question Element -->
	<div class="group widget template-pricing-table-form">
	<div class="btn-icon-header phc-icon-delete" title="<?php _e("Remove", PHC_FLOW_QUESTION_IDENTIFIER); ?>">
	<button class="button-secondary btn-remove-plan" type="button">
	<?php _e("Remove", PHC_FLOW_QUESTION_IDENTIFIER); ?></button>
	</div>
	<h3 class="hndle"><span>Flow {plan_number}</span></h3>
	<div class="pricing-table-section">
		<input type="hidden" name="plan_id[]" value="{plan_number}" disabled="disabled" />
		<div>
		<label><?php _e("Question", PHC_FLOW_QUESTION_IDENTIFIER); ?>:</label>
		<select name="fq_post_id[]" disabled="disabled">
		<?php
		foreach( $questions as $item ){
			$selected= "";
			if( $item->ID == $fq_post_id ){
				$selected= " selected=\"selected\"";
			}
		?>
		<option value="<?php echo $item->ID; ?>"<?php echo $selected; ?>>
		<?php echo $item->post_title; ?></option>
		<?php
		}
		?>
		</select>
		</div>
		<div>
		<label><?php _e("Answer", PHC_FLOW_QUESTION_IDENTIFIER); ?>:</label>
		<input type="text" name="fq_answer[]" value="" disabled="disabled" />
		</div>
	</div>
	</div>
	<!-- End Flow Question Element -->
	
	<div id="pricing-table-accordion">
	<?php
	if( !empty($num_section) ){
	for( $ct=0; $ct<$num_section; $ct++ ){
		$feature_stat= "";
		if( $plan_id[$ct] == $set_feature ){
			$feature_stat= " checked=\"checked\"";
		}
		$feature_id= $plan_id[$ct];
	?>
		<div class="group widget" data-plan-number="<?php echo $feature_id; ?>">
		<div class="btn-icon-header phc-icon-delete" title="<?php _e("Remove", PHC_FLOW_QUESTION_IDENTIFIER); ?>">
		<button class="button-secondary btn-remove-plan" type="button">
		<?php _e("Remove", PHC_FLOW_QUESTION_IDENTIFIER); ?></button>
		</div>
		<h3 class="hndle"><span>Flow <?php echo $ct+1; ?></span></h3>
		<div class="pricing-table-section">
			<input type="hidden" name="plan_id[]" value="{plan_number}" />
			<div>
			<label><?php _e("Question", PHC_FLOW_QUESTION_IDENTIFIER); ?>:</label>			
			<select name="fq_post_id[]">
			<?php
			foreach( $questions as $item ){
				$selected= "";
				if( $item->ID == $fq_post_id[$ct] ){
					$selected= " selected=\"selected\"";
				}
			?>
			<option value="<?php echo $item->ID; ?>"<?php echo $selected; ?>>
			<?php echo $item->post_title; ?></option>
			<?php
			}
			?>
			</select>
			</div>
			<div>
			<label><?php _e("Answer", PHC_FLOW_QUESTION_IDENTIFIER); ?>:</label>
			<input type="text" name="fq_answer[]" value="<?php echo esc_attr($fq_answer[$ct]); ?>" />
			</div>
		</div>
		</div>
	<?php
	}
	}
	?>
	</div>

	<div id="extra-section">
		<div>
		<label for="fq_finish_page"><?php _e("Finish Page", PHC_FLOW_QUESTION_IDENTIFIER); ?>:</label>
		<select name="fq_finish_page" id="fq_finish_page">
		<?php
		foreach( $products as $item ){
			$selected= "";
			if( $item->ID == $fq_finish_page ){
				$selected= " selected=\"selected\"";
			}
		?>
		<option value="<?php echo $item->ID; ?>"<?php echo $selected; ?>>
		<?php echo $item->post_title; ?></option>
		<?php
		}
		?>
		</select>
		</div>
		</div>
	</div>
<?php
}
// End Add Meta Box - Custom Field

// Start Save Post
add_action('save_post', 'phc_flow_question_save_extras');
function phc_flow_question_save_extras(){
	global $post;
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}
	else{
		$meta_fields= array("fq_post_id", "fq_answer", "fq_finish_page");
		$csv_format= array("fq_post_id", "fq_answer");
//		header('content-type: text/plain');
//		print_r($_POST);
//		exit;
		// Validate Data
		
		// Save Data
		foreach( $meta_fields as $field ){
			$value= $_POST[$field];
			if( in_array($field, $csv_format) ){
				$value= implode(",", $_POST[$field]);
			}
			update_post_meta($post->ID, $field, $value);
		}
	}
}
// End Save Post
?>