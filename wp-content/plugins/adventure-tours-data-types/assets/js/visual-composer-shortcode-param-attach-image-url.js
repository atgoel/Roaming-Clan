!function(){
	var wrap_param = jQuery('#attach-image-url');

	wrap_param.find('.attach-image-url__add-img').on('click', function(e){
		e.preventDefault();
		var frame = wp.media({ multiple: false });

		frame.open();

		frame.on( 'select', function() {
			frame.close();
			wrap_param.find('.attach-image-url__storage').val(frame.state().get('selection').first().attributes.url);
		});
	});
}(window.jQuery);