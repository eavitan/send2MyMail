jQuery(document).ready(function($) {
	'use strict';
	function sentomailNotification( text,url ) {

		var $appendTo = $('body'),
			$content = '<div class="send-ot-mail-notification"><span class="notification-icon"></span><a href="'+url+'" class="notification-link">'+text+'</a></div>';
		$appendTo.append($content);
		setTimeout(function() {
			$('.send-ot-mail-notification').addClass('active');
		}, 1);
		setTimeout(function() {
			$('.send-ot-mail-notification').removeClass('active');
			setTimeout(function() {
				$('.send-ot-mail-notification').remove();
			}, 1);
		}, 10000);

	}

	if ( $('#send-to-mail-box').length ) {
	$('#send-to-mail-box form').submit(function(event){
		event.preventDefault();

		var $this = $(this),
		item_id = $this.data('item-id'),
		nonce = $this.data('nonce'),
		the_email = $this.find('input[type="email"]').val(),
		the_approval = $this.find('input[type="checkbox"]').is(':checked');

		// Let's do some AJAX
		$.ajax({
			type: 'post',
			url: send_2_my_mail.ajax_url,
			data: {
				'nonce': nonce,
				'item_id': item_id,
				'email_to_send_the_article': the_email,
				'approve-newsletters': the_approval,
				'action': 'fetch_form_with_email'
			},
			success: function(data) {
				if ( data.is_sent == true ) {
					$this.removeClass('saved');
					sentomailNotification( data.msg,data.item_url);
					$('#send-to-mail-box form').hide(250);
				} else {
					$this.addClass('saved');
					sentomailNotification( data.msg,data.item_url);

				}
			},
			error: function(error) {
				console.log(error);
			}
		});
		});
	}

});
