(function ($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	jQuery(document).ready(function (s) {
		s('input[name="go"]').on('click', function (event) {
			event.preventDefault();
			var name = s('input[name="name"]').val();
			var url = document.location.href + '&ajax=feed';
			ajax(url, name);
			
			timer();
		});
		s('input[name="ttt"]').on('click', function (event) {
			event.preventDefault();
			var name = s('input[name="name"]').val();
			var url = document.location.href + '&ajax=csv';
			ajax(url, name);

			timer();
		});

		s('a#c_all').on('click',function (event) {
			event.preventDefault();
			s('li.choose').each(function () {

				s('input[type="checkbox"]').attr('checked','checked');
				s('input[type="checkbox"]').attr('value','1');
			});
		});
		s('a#d_all').on('click',function (event) {
			event.preventDefault();
			s('li.choose').each(function () {

				s('input[type="checkbox"]').removeAttr('checked');
				s('input[type="checkbox"]').removeAttr('value');
			});
		});


		function timer() {
	var i = 0;
	setInterval(function () {
		i = i + 1;
		s('div.meter').removeAttr('style');
		s('span#meter').css('width', i+'%');
		if(i % 20 == 0){
		//	location.reload();
			var url = document.location.href + '&ajax=check';

			//ajax_res(url);
		};
		if (i == 100){
		//	location.reload();
		}

	},1000);

}
		function ajax(url, name) {

			s.ajax({
				type: 'post',
				url: url,
				data: {'name': name},
				response: 'json',
				success: function (response) {
					var url = document.location.href + '&ajax=check';

					//ajax_res(url);
				}
			});

		};

	/*	function ajax_res(url) {

			s.ajax({
				type: 'post',
				url: url,
				data: {},
				response: 'html',
				success: function (response) {
					if(response !== ""){

						s('a#url').attr('href', response);
						s('a#url').text(response);
					//	location.reload();
					}
				}
			});

		};*/

	});
})(jQuery);
