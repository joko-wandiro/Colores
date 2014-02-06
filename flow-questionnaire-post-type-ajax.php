<?php
// Enqueue Script
add_action('init', 'question_msig_js');
function question_msig_js() {
	// Enqueue the script
//	wp_enqueue_script('products', get_bloginfo('template_url') . '/js/products.js');
	
	// Get current page protocol
	$protocol = isset( $_SERVER['HTTPS']) ? 'https://' : 'http://';
	// Output admin-ajax.php URL with same protocol as current page
	$params = array(
	'ajaxurl'=>admin_url('admin-ajax.php', $protocol),
	'loading_text'=>'<h1>Loading...</h1>',
	'feedback_selector'=>'#pch-bpt-wim-post-html',
	);
	wp_localize_script('question_msig_js', 'question_msig_js_params', $params);
}

// Ajax handler
add_action('wp_ajax_question_msig_post_type_ajax', 'question_msig_post_type_ajax');
function question_msig_post_type_ajax(){
	global $post;
	extract($_POST);
	
	$output= "";
	// Check Flow is Finish / not
	$page= question_msig_check_is_finish_page();
	
	if( empty($page) ){
		// Next Question
		
	}else{
		// Finish Page
		
	}
	
	// Output Data
	echo json_encode($output);
	exit;
}

/**
 * Check Flow is finish. Return Data Finish Page or Recommended Product
 *
 * @param array $args Ex: array(
 * 'fq_post_id'=>'csv_value',
 * 'fq_answer'=>'csv_value',
 * )
 * @return WP_Query Object from Recommended Product
 */
function question_msig_check_is_finish_page($args=""){
	$wp_query= array();
	if( ! empty($args) ){
	extract($args);
//	$fq_post_id= "4444,903";
//	$fq_answer= "Yes,No";
	$cond= array(
	'post_type'=>'flow-questions',
	'meta_query' => array(
		array(
		'key'=>'fq_post_id',
		'value'=>$fq_post_id,
		),
		array(
		'key'=>'fq_answer',
		'value'=>$fq_answer,
		)
	)
	);
	$wp_query= new WP_Query($cond);	
	$posts= $wp_query->get_posts();
	if( ! empty($posts) ){
		$custom= get_post_custom($posts[0]->ID);

		$cond= array(
		'post_type'=>'products_msig',
		'p'=>$custom['fq_finish_page'][0],
		);
		$wp_query= new WP_Query($cond);
	}
	}
	return $wp_query;
	
//	while( $wp_query->have_posts() ){
//		$wp_query->the_post();
//		the_title();
//		the_content();
//	}
//	exit;
//	return $custom['fq_finish_page'][0];

//	echo "<pre>";
//	print_r($posts);
//	echo "\n";
//	print_r($custom['fq_finish_page'][0]);	
//	echo "</pre>";
}
?>