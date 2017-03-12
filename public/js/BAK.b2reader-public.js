jQuery(document).ready(function($) {

	'use strict';

	/**
	 * Create our notification
	 */
	function toptalAddNotification( text, url ) {

		var $appendTo = $('body'),
			$content = '<div class="toptal-save-notification"><span class="notification-icon"></span><a href="'+url+'" class="notification-link">'+text+'</a></div>';
		$appendTo.append($content);
		setTimeout(function() {
			$('.toptal-save-notification').addClass('active');
		}, 2500);
		setTimeout(function() {
			$('.toptal-save-notification').removeClass('active');
			setTimeout(function() {
				$('.toptal-save-notification').remove();
			}, 2500);
		}, 32500);

	}
	function sentomailNotification( text,url ) {

		var $appendTo = $('body'),
			$content = '<div class="send-ot-mail-notification"><span class="notification-icon"></span><a href="'+url+'" class="notification-link">'+text+'</a></div>';
		$appendTo.append($content);
		setTimeout(function() {
			$('.send-ot-mail-notification').addClass('active');
		}, 250);
		setTimeout(function() {
			$('.send-ot-mail-notification').removeClass('active');
			setTimeout(function() {
				$('.send-ot-mail-notification').remove();
			}, 250);
		}, 3250);

	}


	if ( $('.toptal-save-button').length ) {

		// ^ this was to check if the button exists, now, let's do something with it
		$('.toptal-save-button').on('click', function(event) {

			// Prevents the default behaviour of the button.
			event.preventDefault();

			// Make sure that the user can't click the button multiple times unless
			// AJAX call is finished.
			var anchor = $(this);
			if ( anchor.data('disabled') ) {

				return false;

			}
			anchor.data('disabled', 'disabled');

			// Let's get some basic variables here that we're going to need.
			var $this = $(this),
				item_id = $this.data('item-id'),
				nonce = $this.data('nonce');

			// Let's do some AJAX
			$.ajax({
				type: 'post',
				url: toptal_save_ajax.ajax_url,
				data: {
					'nonce': nonce,
					'item_id': item_id,
					'action': 'save_unsave_item'
				},
				success: function(data) {
					// If true, remove from saved, else, add to saved.
					if ( data.is_saved == true ) {

						$this.removeClass('saved');
						$this.find('span.toptal-save-text').text(toptal_save_ajax.item_save_text);

					} else {

						$this.addClass('saved');
						$this.find('span.toptal-save-text').text(toptal_save_ajax.item_unsave_text);

						// Show our notification
						toptalAddNotification( toptal_save_ajax.item_saved_text, toptal_save_ajax.saved_page_url );

					}

					anchor.removeData('disabled');
				},
				error: function(error) {
					console.log(error);
				}
			});

		});

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
			url: send_to_ma_mail.ajax_url,
			data: {
				'nonce': nonce,
				'item_id': item_id,
				'the_email': the_email,
				'the_approval': the_approval,
				'action': 'fetch_form_with_email'
			},
			success: function(data) {
				if ( data.is_sent == true ) {

					$this.removeClass('saved');
					//$this.find('span.toptal-save-text').text(send_to_ma_mail.item_sent);

				} else {

					$this.addClass('saved');
					//$this.find('span.toptal-save-text').text(toptal_save_ajax.item_unsave_text);
					// Show our notification
					sentomailNotification( data.msg,data.item_url);

				}

				//anchor.removeData('disabled');
			},
			error: function(error) {
				console.log(error);
			}
		});
		});
	}

});
