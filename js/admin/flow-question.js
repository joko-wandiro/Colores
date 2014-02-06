( function($){
$(document).ready( function(){
	PHC_Accordion= {
		setting_accordion: function($obj){
	    $obj
		.accordion({
		active: false,
		collapsible: true,
		header: "> div > h3",
		})
/*		.sortable({
		placeholder: "ui-state-highlight",
//		axis: "y",
		handle: "h3",
		stop: function( event, ui ) {
		// IE doesn't register the blur when sorting
		// so trigger focusout handlers to remove .ui-state-focus
		ui.item.children("h3").triggerHandler("focusout");
		}
		});*/
		},
		sorting: function(identifier){
			$('#pricing-table-accordion .widget').each( function(key){
				console.log(key);
				id_row= key+1;
				$obj= $(this);
				$obj.find('h3.hndle').find('span:eq(1)').html(identifier + " " + id_row);
			})
//			$obj.parent().parent().prev().find('span:eq(1)').html(title);
		}
	}
	
	PHC_Accordion.setting_accordion($('#pricing-table-accordion'));
	$('#btn-new-plan').live('click', function(){
		$template_form= $('.template-pricing-table-form').clone();
		template_form_html= $template_form.html();
		number_of_section= $('#pricing-table-accordion .widget').length;
		if( number_of_section ){
			number_of_section= $('#pricing-table-accordion .widget:last').attr('data-plan-number');
		}
		number_of_section++;
		$template_form.html(template_form_html.replace(/{plan_number}/g, number_of_section));
		$pricing_table_accordion= $('#pricing-table-accordion');
		$template_form.attr({'data-plan-number': number_of_section}).appendTo($pricing_table_accordion)
		.removeClass('template-pricing-table-form').find('input, select').removeAttr('disabled');
		$pricing_table_accordion.accordion('destroy');
		PHC_Accordion.setting_accordion($pricing_table_accordion);
		
		// sort widget
		PHC_Accordion.sorting("Flow");
	});
	
	$('.btn-remove-plan').live('click', function(){
		$(this).parent().parent().remove();
		// sort widget
		PHC_Accordion.sorting("Flow");
	});
})
})(jQuery);