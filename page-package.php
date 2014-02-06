<?php
/*
* Template Name: Package
*/
?>
<?php get_header(); ?>

<script>
/*
jQuery(document).ready( function($){
	optsTable= {
	fields: ["desc", "pearl", "ruby", "diamond"],
	tablet_portrait: { show: ["desc", "pearl", "ruby", "diamond"] },
	phone: { show: ["pearl", "ruby", "diamond"] },
	}
	$('.pricing-table').jwTable(optsTable);
})
*/
</script>
<!-- Start Content -->
<!-- Start Content Section -->
<?php
if( have_posts() ){
	while( have_posts() ){
		the_post();
		$custom= get_post_custom($post->ID);
?>
<div id="banner" class="wrapper-full-block" style="background-color: <?php echo $custom['banner_bg_color'][0]; ?>">
<?php
echo get_the_post_thumbnail($post->ID, 'banner_package_page');
?>
</div>
	
<div class="container">
<div class="row-fluid" id="package-page">
	<div class="span2">&nbsp;</div>
	<div class="span8">	
	<div class="article">
	<?php the_content(); ?>
	</div>	
	</div>
	<div class="span2">&nbsp;</div>
</div>
<?php
	}
}
?>
<div id="pricing-table" class="text-center">
	<div class="row-fluid">
		<div class="span3"></div>
		<h2 class="span7 font-lato bold">Choose a Package</h2>
	</div>
	<div class="row-fluid">
		<div class="span3"></div>
		<div class="span7">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
              	<?php
			  	$title_pack = get_post_meta( $post->ID, 'title_package', true );
				foreach($title_pack as $pack){
                ?>
                <td>
                	<?php if($pack['highlight']=='yes'){
							echo '<div class="ptp-txt">Recommended</div>';
					}?>
                </td>
                <?php
				}
                ?>
			  </tr>
			  <tr>
              	<?php
				foreach($title_pack as $pack){
					if($pack['highlight']=='yes'){
						$pack['color']=adjustcolor($pack['color'],20);
						$bgwhite = "#ffffff";
					}else{ $bgwhite = ""; }
                ?>
				<td style="background:<?php echo $pack['color']; ?>;">
                <div class="pricing-table-title font-lato bold" style="background:<?php echo adjustcolor($pack['color'],-50); ?>;"><?php echo $pack['title']; ?></div>
                <div class="ptp-start-from font-source-sans-pro normal">start from</div>
                <div class="ptp-price font-lato bold"><?php echo $pack['price']; ?></div>
                <div class="ptp-description cloud" style="background:<?php echo $bgwhite; ?>;"><span class="font-lato italic" style="background:<?php echo $pack['color']; ?>;">Schedule for appoinment</span></div>
                </td>
                <?php
				}
                ?>
			  </tr>
			</table>
		</div>
	</div>
	<?php
	?>
		<?php
        $listpack = get_post_meta( $post->ID, 'menu_package', true );
		$ii=0;
        foreach($listpack as $list){
			$list_packs = explode(",", $list['package-name']);
			foreach($list_packs as $index => $word){
				$list_packs[$index] = trim($word);
			}
		?>
	<div class="row-fluid text-center" style="color:#000;">
		<div class="span3" style="text-align:left;"><?php echo $list['name']; ?></div>
		<div class="span7">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
              <?php
			  $ww = 100/count($title_pack);
				foreach($title_pack as $pack){
		            if($list['type']=='value'){
						if(in_array($pack['title'],$list_packs)){
							$print = $list['value'];
						}else{$print="";}
					}
		            if($list['type']=='checklist'){
						if(in_array($pack['title'],$list_packs)){
							$print = '<span class="icon-checklist-green">&nbsp;</span>';
						}else{$print="";}
					}
		            if($list['type']=='multiple'){
						$vals = explode(",",$list['value']);
						foreach($vals as $index => $word){
							$vals[$index] = trim($word);
						}
						$vall = array_combine($list_packs,$vals);
						if(in_array($pack['title'],$list_packs)){
							$print = $vall[$pack['title']];
						}else{$print="";}
					}
					echo '<td width="'.$ww.'%">'.$print.'</td>';
				}
              ?>
			  </tr>
			</table>
		</div>
	</div>
        <?php
        }
        ?>
	<div class="row-fluid">
		<div class="span3"></div>
		<div class="span7">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
              	<?php
				foreach($title_pack as $pack){
					if($pack['highlight']=='yes'){
						$pack['color']=adjustcolor($pack['color'],20);
						$bgwhite = "#ffffff";
					}else{ $bgwhite = ""; }
                ?>
				<td style="background:<?php echo $pack['color']; ?>;">
                <div class="ptp-description cloud" style="background:<?php echo $bgwhite; ?>;"><span class="font-lato italic" style="background:<?php echo $pack['color']; ?>;">Schedule for appoinment</span></div>
                </td>
                <?php
				}
                ?>
			  </tr>
			</table>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span2">&nbsp;</div>
	<div class="span8">	
		<div>
		Jika anda masih bingung paket mana yang tepat bagi anda, bisa hubungi Call Center kami di 0-800-1401217 atau 
		isi form disini dan kami akan hubungi anda.		
		</div>
	</div>
	<div class="span2">&nbsp;</div>
</div>
<div class="row-fluid">
	<div class="span12">&nbsp;</div>
</div>

</div>
<!-- End Content -->

<?php get_footer(); ?>