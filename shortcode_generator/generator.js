(function($, undefined) {

$(function() {
	$('#pricing-shortcode-pricing-options').change(function() {
		var hide = $(this).val()*6+2;
		
		$('#pricing-shortcode .form-table tr').show();
		$('#pricing-shortcode .form-table tr:nth-child(n+'+hide+')').hide();
	});

	var get_price_option = function(name, num) {
		var el = $('#pricing-shortcode-'+name+'-'+num);
		
		return el.is(':checkbox')? el.is(':checked') : el.val();
	}
	
	$('#pricing-shortcode .generate-shortcode').click(function(e) {
		var count = $('#pricing-shortcode-pricing-options').val();
		var result = '[pricing]';
		var opts = ['title', 'amount', 'featured', 'button_link', 'button_text'];

		for(i=1; i<=count; i++) {
			var sub_result = ' [price';
			
			for(j in opts) {
				sub_result += ' '+opts[j]+'="'+get_price_option(opts[j], i)+'"';
			}
			
			sub_result += '] ' + get_price_option('description', i) + ' [/price]';
			
			result += sub_result;
		}
		
		result += ' [/pricing]';
		send_to_editor("\n"+result+"\n");
		e.preventDefault();
	});
});

})(jQuery);