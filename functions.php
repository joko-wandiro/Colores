<?php
define('TEMP_URL', get_bloginfo('template_url') . "/");
define('TEMPPATH', get_bloginfo('stylesheet_directory'));
define('JS_PATH', TEMP_URL . "/js/");
define('CSS_PATH', TEMP_URL . "/css/");
define('IMAGES', TEMPPATH . "/images/");
define('PHANTASMACODE_THEME', "phantasmacode-theme");

//add_action('wp', 'phantasmacode_insert_article');
function phantasmacode_insert_article() {
    global $post;
	$post_array= $post->to_array();
	$post_custom= get_post_custom($post_array['ID']);
	for( $i=2; $i<=25; $i++ ){
		unset($post_array['ID']);
		// Insert Sample Data for Article
//		$post_array['post_title']= "Article Title" . $i;
//		$post_array['post_content']= "Content Testing Article " . $i;
		// Insert Sample Data for Stuff
		$post_array['post_title']= "Article " . $i;
		$post_array['post_content']= "Content Article " . $i;
		$res= wp_insert_post($post_array);
		foreach( $post_custom as $custom_key=>$custom_value ){
			add_post_meta($res, $custom_key, $custom_value[0], TRUE);
		}
		
//		echo "<pre>";
//		print_r($res);
//		echo "</pre>";
	}

//	echo "<pre>";
//	print_r($post_array);
//	echo "#####################################################################################\n";
//	print_r($post_custom);
//	echo "</pre>";
}

add_action("init", "theme_enqueue_scripts");
function theme_enqueue_scripts(){
	global $pagenow, $wp_scripts;
	if( ! is_admin() && ! in_array($pagenow, array('wp-login.php', 'wp-register.php')) ){ // FrontEnd Site
		// Add Javascript Files
		wp_enqueue_script('jquery');
		wp_enqueue_script('bootstrap_js', JS_PATH. 'bootstrap.min.js');
		wp_enqueue_script('bootstrap_collapse', JS_PATH. 'bootstrap-collapse.js');
		wp_enqueue_script('main_js', JS_PATH. 'main.js');

		// Add Stylesheet Files
		wp_enqueue_style('main_css', TEMP_URL.'style.css', FALSE);
		wp_enqueue_style('font_css', 'http://fonts.googleapis.com/css?family=Duru+Sans', FALSE);
	}
}

// Add Support for Featured Images 
if( function_exists('add_theme_support') ){
	add_theme_support('post-thumbnails');
	add_image_size('stuff_thumbnail', 220, 220, TRUE);
}

// Add Extra Query Vars for Project Page
add_filter('query_vars', 'add_extra_vars');
function add_extra_vars($public_query_vars) {
	$public_query_vars[] = 'replytocom';
	return $public_query_vars;
}

add_filter('cancel_comment_reply_link', 'custom_cancel_comment_reply_link', 10, 3);
function custom_cancel_comment_reply_link($arg1, $arg2, $arg3) {
	$replytocom= get_query_var('replytocom');
	if( ! empty($replytocom) ){
		return '<a rel="nofollow" id="cancel-comment-reply-link" class="btn" href="' . $arg2 . '">Cancel</a>';
	}
	return $arg1;
}

// Set Post Per Page
add_action('pre_get_posts', 'pch_theme_pre_get_posts', 10, 1);
function pch_theme_pre_get_posts($query){
	global $pagename, $post;
    if ( ! is_admin() ){
		$post_type= isset($query->query['post_type']) ? $query->query['post_type'] : "";
		
		// Archive Page
		if ( is_archive() && $post_type == "stuff" ){
			$query->set('posts_per_page', 8);
		}
        return;
	}
}

// Set Excerpt Length
function custom_excerpt_length( $length ) {
	return 25;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

function director_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'director_excerpt_more', 10);

function custom_get_the_date($date, $d) {
	return date("d F Y", strtotime($date));
}
//add_filter('get_the_date', 'custom_get_the_date', 10);

add_theme_support('nav-menus');
// Register Nav Menus
if( function_exists('register_nav_menus') ){
	register_nav_menus(array(
	'primary'=>__('Primary Navigation', 'sinarmas'),
	'secondary'=>__('Secondary Navigation', 'sinarmas'),
	));
}

// Register Sidebar
if( function_exists('register_sidebar') ){
	register_sidebar(array(
		'name'=>__('Primary Sidebar', 'primary-sidebar'),
		'id'=>'primary-widget-area',
		'description'=>__('The Primary Widget Area', 'dir'),
		'before_widget'=>'<div class="widget">',
		'after_widget'=>'</div>',
		'before_title'=>'<h3 class="title-widget">',
		'after_title'=>'</h3>'
	));
	register_sidebar(array(
		'name'=>__('Shortcodes', 'shortcodes'),
		'id'=>'shortcodes-widget-area',
		'description'=>__('The Shortcodes Widget Area', 'dir'),
		'before_widget'=>'<div class="widget">',
		'after_widget'=>'</div>',
		'before_title'=>'<h3 class="title-widget">',
		'after_title'=>'</h3>'
	));
	register_sidebar(array(
		'name'=>__('News Sidebar', 'news-sidebar'),
		'id'=>'news-widget-area',
		'description'=>__('The News Widget Area', 'dir'),
		'before_widget'=>'<div class="widget news">',
		'after_widget'=>'</div>',
		'before_title'=>'<h3 class="title-widget font-lato italic">',
		'after_title'=>'</h3>'
	));
	register_sidebar(array(
		'name'=>__('News Footer Sidebar', 'news-footer-sidebar'),
		'id'=>'news-footer-widget-area',
		'description'=>__('The News Footer Widget Area', 'dir'),
		'before_widget'=>'<div class="widget news">',
		'after_widget'=>'</div>',
		'before_title'=>'<h3 class="title-widget font-lato italic">',
		'after_title'=>'</h3>'
	));
	register_sidebar(array(
		'name'=>__('Sidebar Left Kenali Smile', 'sidebar-left-kenali-smile'),
		'id'=>'sidebar-left-kenali-smile',
		'description'=>__('Sidebar Left Kenali Smile Area', 'dir'),
		'before_widget'=>'<div class="widget news">',
		'after_widget'=>'</div>',
		'before_title'=>'<h3 class="title-widget font-lato italic">',
		'after_title'=>'</h3>'
	));		
}
		
// Start Override Menu
add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );
function add_menu_parent_class($items){
	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	
	foreach( $items as $item ){
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'dropdown';
			$item->hasChild= TRUE;
		}
	}
	
	return $items;
}

class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {
	// add classes to ul sub-menus
	function start_lvl( &$output, $depth ) {
		// depth dependent classes
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array('sub-menu', 'dropdown-menu');
		$class_names = implode( ' ', $classes );
		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}
	
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		if( $item->hasChild ){
			$attributes.= ' class="' . esc_attr("dropdown-toggle") . '" data-toggle="' . esc_attr('') . '"';
		}
		$item_output .= '<a'. $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if( $item->hasChild ){
			$item_output.= '<b class="caret"></b>';
		}
		$item_output .= '</a>';
		$item_output .= $args->after;
		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
// End Override Menu

// Pagination Bootstrap - Support structure Bootstrap
function bootstrap_pagination($pagination=array()){
	if( !empty($pagination) ){
?>
	<div class="pagination">
	<ul>
<?php
	foreach( $pagination as $paging ){
		$current= "";
		$pattern= "#current#";
		if( preg_match($pattern, $paging) ){
			$current= "current";
		}
		
		$pattern_link= "#(prev|next)#";
		$class_add= ( preg_match($pattern_link, $paging) ) ? " block" : "";
?>
		<li class="<?php echo $current . $class_add; ?>">
		<?php
		if( ! preg_match($pattern_link, $paging) ){
		?>
		<?php echo $paging; ?>
		<?php
		}else{
			$patterns= array('&laquo; Previous', 'Next &raquo;');
			$replacements= array('<i class="icon-arrows-pagination-left"></i>', 
			'<i class="icon-arrows-pagination-right"></i>');
			echo str_replace($patterns, $replacements, $paging);
		}
		?>
		</li>
<?php
	}
?>
	</ul>
	</div>
<?php
	}
}

function phantasmacode_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		<div class="row-fluid">
		<div class="span1">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		</div>
		<div class="span11">
		<div class="comment-author vcard">
		<h2><?php echo get_comment_author_link(); ?></h2>
		<?php #printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
		</div>
		<?php if ($comment->comment_approved == '0') : ?>
		<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
		<br />
		<?php endif; ?>
		
		<div class="comment-meta commentmetadata">
		<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
		/* translators: 1: date, 2: time */
		printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a>
		<?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
		</div>

		<div class="comment-text"></div>
		<?php comment_text() ?>

		<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</div>		
		</div>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
        }
		
function bootstrap_archive_news_pagination($pagination=array()){
	if( !empty($pagination) ){
?>
	<div class="pagination">
	<ul>
<?php
	foreach( $pagination as $paging ){
		$current= "";
		$pattern= "#current#";
		if( preg_match($pattern, $paging) ){
			$current= "current";
		}
		
		$pattern_link= "#(prev|next)#";
?>
		<li class="<?php echo $current; ?>">
		<?php echo $paging; ?>
		</li>
<?php
	}
?>
	</ul>
	</div>
<?php
	}
}

add_filter( 'show_admin_bar', '__return_false' );
function hide_abar() {
?>
	<style type="text/css">
		.show-admin-bar {
			display: none;
		}
	</style>
<?php
}
function hide_a_bar() {
    add_filter( 'show_admin_bar', '__return_false' );
    add_action( 'admin_print_scripts-profile.php', 
         'hide_abar' );
}
add_action( 'init', 'hide_a_bar' , 9 );

function example_remove_dashboard_widgets() {
	global $wp_meta_boxes;
	// Main column:
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	
	// Side Column:
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );

// Custom thanks admin
function wpse_edit_footer()
{
    add_filter( 'admin_footer_text', 'wpse_edit_text', 11 );
}
function wpse_edit_text($content) {
    return "Developed by <a href='http://www.drifesolution.com/'>Drife Solution</a>";
}
add_action( 'admin_init', 'wpse_edit_footer' );

function login_logo_url($url) {
    return home_url();
}
add_filter( 'login_headerurl', 'login_logo_url' );

function login_logo_title($title) {
    return 'Sinarmas MSIG';
}
add_filter( 'login_headertitle', 'login_logo_title' );

function my_login_head() {
	echo "
	<style>
	body.login #login h1 a {
		background: url('".get_bloginfo('template_url')."/img/msig_logo.png') no-repeat scroll center #fff;
		height: 80px;
		border-radius: .2em;
		padding:1em;
		margin-left:-.75em;
		margin-bottom:.5em;
	}
	</style>
	";
}
add_action("login_head", "my_login_head");

// Add Extra Query Vars for Project Page

// MultiPostThumbnails
if (class_exists('MultiPostThumbnails')) {
	new MultiPostThumbnails(
		array(
			'label'=>'Stuff Archive Image',
			'id'=>'stuff-archive-image',
			'post_type'=>'stuff'
    	)
	);
}

require_once('stuff-post-type.php');
require_once('pages/theme-options.php');

// Support Shortcode on Widget Text
add_filter('widget_text', 'do_shortcode');

//WP_Widget_Recent_Posts
add_action('init', 'phantasmacode_rewrite');
function phantasmacode_rewrite() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}

/*function widget($atts) {
    
    global $wp_widget_factory;
    
    extract(shortcode_atts(array(
        'widget_name' => FALSE
    ), $atts));
    
    $widget_name = wp_specialchars($widget_name);
    
    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));
        
        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;
    
    ob_start();
    the_widget($widget_name, $instance, array('widget_id'=>'arbitrary-instance-'.$id,
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
    
}

add_shortcode('widget','widget');*/
// Ex: [widget widget_name="Your_Custom_Widget"]

// Add Shortcodes
add_shortcode('phc_wp_widget_calendar', 'phc_wp_widget_calendar_do');
function phc_wp_widget_calendar_do($atts, $content=null){
	$default= array('id'=>"", 'type'=>"post");
	extract(shortcode_atts($default, $atts));
	return the_widget( 'WP_Widget_Calendar' );
}
?>