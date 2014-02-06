jQuery(document).ready( function($){
	$('#commentform').addClass('form-horizontal');
	
	control_group_html= '<div class="control-group btn-groups-submit">' + 
	'<div class="controls">' + 
	'</div>' +
	'</div>';
	
	$(control_group_html).appendTo($('#commentform'));
	$('.form-submit').appendTo('.btn-groups-submit .controls').find('#submit').addClass('btn');

	$('#btn-subscribe').live('click', function(e){
		e.preventDefault();
		$obj= $(this);
		alert("I'm still setting newsletter, Hope you can waiting !");
	})
	
	
})

// Start Slider Navigation Script
jQuery(document).ready( function($){
	$('.slider-navigation-tabs').hide();
	
	// Set Active Class on First Slider
	$first_slider_navigation_tabs= $('.slider-navigation-tabs li[data-slide-number="1"]');
	$first_slider_navigation_tabs.addClass('active');
	slider_title= $first_slider_navigation_tabs.find('.title').html();
	slider_content= $first_slider_navigation_tabs.find('.content').html();
	$('#tab-navigation .tab-navigation-header').find('.title').html(slider_title);
	$('#tab-navigation .tab-navigation-content').html(slider_content);
	
	$('#tab-navigation .btn-tab-navigation-left').live('click', function(){
		$obj= $(this);
		$slider_navigation_tabs= $('.slider-navigation-tabs');
		slide_number= $('li.active', $slider_navigation_tabs).attr('data-slide-number');
		
		if( slide_number == 1 ){
			slide_number= $('.slider-navigation-tabs li').length;
		}else{
			slide_number--;
		}
//		console.log(slide_number);
		$prev_slide= $('.slider-navigation-tabs li[data-slide-number="' + slide_number + '"]');
		prev_slide_title= $prev_slide.find('.title').html();
		prev_slide_content= $prev_slide.find('.content').html();
		$('#tab-navigation .tab-navigation-header').find('.title').html(prev_slide_title);
		$('#tab-navigation .tab-navigation-content').html(prev_slide_content);
		$('li', $slider_navigation_tabs).removeClass('active');
		$prev_slide.addClass('active');
	})
	
	$('#tab-navigation .btn-tab-navigation-right').live('click', function(){
		$obj= $(this);
		$slider_navigation_tabs= $('.slider-navigation-tabs');
		slide_number= $('li.active', $slider_navigation_tabs).attr('data-slide-number');
		
		if( slide_number == $('li', $slider_navigation_tabs).length ){
			slide_number= $('.slider-navigation-tabs li:first').attr('data-slide-number');
		}else{
			slide_number++;
		}
//		console.log(slide_number);
		$prev_slide= $('.slider-navigation-tabs li[data-slide-number="' + slide_number + '"]');
		prev_slide_title= $prev_slide.find('.title').html();
		prev_slide_content= $prev_slide.find('.content').html();
		$('#tab-navigation .tab-navigation-header').find('.title').html(prev_slide_title);
		$('#tab-navigation .tab-navigation-content').html(prev_slide_content);
		$('li', $slider_navigation_tabs).removeClass('active');
		$prev_slide.addClass('active');
	})	

//	$('.logo').hover( function(){
//		$obj= $(this);
//		$obj.parent().parent().addClass('orange');
//	},
//	function(){
//		$obj.parent().parent().removeClass('orange');
//	})
})
// End Slider Navigation Script
