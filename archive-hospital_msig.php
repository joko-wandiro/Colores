<?php get_header(); ?>
<div class="container" id="provider-hospital">
<div class="row-fluid">
	<div class="span12">
		<div class="page-header">
			<h1>Provider Hospital</h1>
		</div>
	</div>
	<?php
	global $wp_query, $current_site;
	// Get All Taxonomy hospital_categories
	$args= array(
	'hide_empty'=>FALSE
	);
	$hospital_categories= get_terms('hospital_categories', $args);
	
	// Get All Taxonomy hospital_types
	$args= array(
	'hide_empty'=>FALSE
	);
	$hospital_types= get_terms('hospital_types', $args);
	$hospital_msig_posts= $wp_query->posts;
	
	$location= new WP_Query(array('post_type'=>'location', 'posts_per_page'=>-1));
//	echo "<pre>";
//	print_r($wp_query);
//	echo "</pre>";
	$form_action_url= home_url('provider-hospital');
	?>
	<div class="span6" id="form-search">
	<form class="form-horizontal" action="<?php echo $form_action_url; ?>" method="GET">
		<input type="hidden" name="is_search_hospital" value="1" />
		<div class="control-group">
			<label class="control-label" for="hospital_categories"><?php echo _e("Kategori"); ?></label>
			<div class="controls">
			<select name="hospital_categories" id="hospital_categories">
			<option value=""><?php echo _e("-- Pilihan Kategori --"); ?></option>
			<?php
			foreach( $hospital_categories as $item ){
			?>
			<option value="<?php echo $item->slug; ?>"><?php echo $item->name; ?></option>
			<?php
			}
			?>
			</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="hospital_types"><?php echo _e("Tipe"); ?></label>
			<div class="controls">
			<select name="hospital_types" id="hospital_types">
			<option value=""><?php echo _e("-- Pilihan Tipe --"); ?></option>
			<?php
			foreach( $hospital_types as $item ){
			?>
			<option value="<?php echo $item->slug; ?>"><?php echo $item->name; ?></option>
			<?php
			}
			?>
			</select>
			</div>
		</div>
		<div id="second-panel-search" class="font-source-sans-pro bold">
		<?php echo _e("Cari (isi salah satu)"); ?>
		</div>
		<div class="control-group">
			<label class="control-label" for="title"><?php echo _e("Nama"); ?></label>
			<div class="controls">
			<input type="text" name="title" id="title" value="" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="location_meta"><?php echo _e("Lokasi"); ?></label>
			<div class="controls">
			<select name="location_meta" id="location_meta">
			<option value=""><?php echo _e("-- Pilihan Lokasi --"); ?></option>
			<?php 
			while( $location->have_posts() ){
				$location->the_post();
			?>
				<option value="<?php echo $post->ID; ?>"><?php the_title(); ?></option>
			<?php 
			}
			?>
			</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="address_meta"><?php echo _e("Alamat"); ?></label>
			<div class="controls">
			<input type="text" name="address_meta" id="address_meta" value="" />
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
			<button type="submit" class="btn pull-right">Cari</button>
			</div>
		</div>
	</form>
	</div>
	<div class="span12">
		<table>
		<thead>
		<tr>
			<th width="40%"><?php echo _e("Nama"); ?></th>
			<th width="20%"><?php echo _e("Lokasi"); ?></th>
			<th width="40%"><?php echo _e("Alamat"); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php
		$num_post= count($_GET);
		if( $num_post ){
		// Get Query using taxonomy
		$args= array(
		'post_type'=>'hospital_msig',
		'paged'=>get_query_var('paged'),
		'meta_query'=>array(),
		'tax_query'=>array()
		);
		$args_location_meta= array(
		'key'=>'location_meta',
		'value'=>$_GET['location_meta'],
		);
		if( !empty($_GET['location_meta']) ){
			$args['meta_query'][]= $args_location_meta;
		}
		
		$args_address_meta= array(
		'key'=>'address_meta',
		'value'=>$_GET['address_meta'],
		);
		if( !empty($_GET['address_meta']) ){
			$args['meta_query'][]= $args_address_meta;
		}
		
		$args_hospital_categories= array(
		'taxonomy'=>'hospital_categories',
		'field'=>'slug',
		'terms'=>$_GET['hospital_categories']
		);
		if( !empty($_GET['hospital_categories']) ){
			$args['tax_query'][]= $args_hospital_categories;
		}
				
		$args_hospital_types= array(
		'taxonomy'=>'hospital_types',
		'field'=>'slug',
		'terms'=>$_GET['hospital_types']
		);
		if( !empty($_GET['hospital_types']) ){
			$args['tax_query'][]= $args_hospital_types;
		}
		
		$search_post= new WP_Query($args);
		$wp_query= $search_post;
		}		
		?>
		<?php if( have_posts() ){ ?>
		<?php 		
		$ct= 1;
		$number_of_posts= $wp_query->post_count;
		while( have_posts() ){
			the_post();
			$custom= get_post_custom();
			$location= get_post($custom['location_meta'][0]);
		?>
		<tr>
			<td class="title"><?php the_title(); ?></td>
			<td><?php echo $location->post_title; ?></td>
			<td><?php echo $custom['address_meta'][0]; ?></td>
		</tr>
		<?php 
		}
		wp_reset_postdata();
		?>
		</tbody>
		</table>
		<?php
		$big = 999999999; // need an unlikely integer
		$args = array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max(1, get_query_var('paged')),
			'total' => $wp_query->max_num_pages,
			'type'=>'array'
		);
		
		$pagination= paginate_links($args);
		// Create Pagination Links follow foundation structure.
		bootstrap_pagination($pagination);
		
		$slug_archive= $wp_query->queried_object->rewrite['slug'];
//		echo "<pre>";
//		print_r($_GET);
//		echo "</pre>";
		$params_get= implode("&", $_GET);
		?>
		<div>
		<a class="btn pull-right" href="<?php site_url(); ?><?php echo "?" . $_SERVER['QUERY_STRING']; ?>
		&export=true&format=xls&filename=provider-hospital">Download List Provider</a>
		</div>
		<?php }
		else{ ?>
			<div>
			<p><?php _e('No posts were found. Sorry!'); ?></p>
			</div>
		<?php } ?>
	</div>
</div>
<div class="row-fluid"><div class="span12"></div></div>
</div>
<!-- End Content -->

<?php get_footer(); ?>