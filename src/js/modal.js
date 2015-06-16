'use strict'

var modal = (function($, _, Handlebars, all_posts) {
	var $modal = {};
	var $modal_inner = {};
	var templates;
	var isFirefox = typeof InstallTrigger !== 'undefined';



	Handlebars.registerHelper('if_eq', function(a, b, opts) {
		if(a == b) // Or === depending on your needs
		  return opts.fn(this);
		else
		  return opts.inverse(this);
	});

	Handlebars.registerHelper('breaklines', function(text) {
	    text = Handlebars.Utils.escapeExpression(text);
	    text = text.replace(/(\r\n|\n|\r)/gm, '<br>');
	    return new Handlebars.SafeString(text);
	});


	function open() {
		$modal.fadeIn(250);
		$('body').addClass('modal--open');
		$(document).on('keyup', function(e) {
			if (e.keyCode == 27) {
				close();
			}
		});
	}
	function close() {
		$modal.fadeOut(250, function() {
			$modal_inner.html('');
		});
		$('body').removeClass('modal--open');
	}

	function sanitizeModal(post, download) {

		if(post.post_type === "video") {
			post.youtube_id = getYoutubeId(post.youtube_link);
		}
		post.download = download;
		if(isFirefox) {
			post.download = false;
		}
		if(default_post.generic_modal_text) {
			post.generic_modal_text = default_post.generic_modal_text;
		}
		return post;

	}
	function getYoutubeId(url) {
		var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
		var match = url.match(regExp);
		if (match && match[2].length == 11) {
		  	return match[2];
		} else {
		  	//error
		}
	}
	function getPost(id) {
		id = parseInt(id);

		var found_post = _(all_posts).find(function(post) {
			return post.ID === id;
		});

		if(found_post) {
			return found_post;
		}else {
			return default_post;
		}
	}

	return {
		init: function() {
			$modal = $('.modal');
			$modal_inner = $('.modal__inner');
			templates = {
				email:	Handlebars.templates['email'],
				modal: Handlebars.templates['modal']
			};
		},
		open: function(postid, download) {
			var modal_post = getPost(postid);
		    if(modal_post.post_type === "image" || modal_post.post_type === 'video') {
		    	var html = templates.modal(sanitizeModal(modal_post, download));
				$modal_inner.html(html);
				open();
				ga('send', 'event', {
					'eventCategory': 'Modal',
					'eventAction': 'Open',
					'eventLabel': modal_post.post_name
				});
				$('.icon--close').on('click', function() {
					close();
					ga('send', 'event', {
				        'eventCategory': 'Modal',
				        'eventAction': 'Close',
				        'eventValue': modal_post.post_title
				    });
				});
		    }
		    if(download) {
		    	var referrer = "unavailable";
		    	if(document.referrer) {
		    		referrer = document.referrer;
		    	}
				ga('send', 'event', {
			        'eventCategory': 'Referrer',
			        'eventAction': 'ModalOpen',
			        'eventLabel': referrer,
			        'eventValue': modal_post.post_title
			    });
		    }

		},
		openLegal: function(html) {
			$modal_inner.html(html);
			open();
			ga('send', 'event', {
		        'eventCategory': 'Modal',
		        'eventAction': 'Open',
		        'eventLabel': 'Legal'

		    });
			$('.icon--close').on('click', function() {
				close();
				ga('send', 'event', {
			        'eventCategory': 'Modal',
			        'eventAction': 'Close',
			        'eventValue': 'Legal'
			    });
			});
		},
		email: function(postid) {
			var html = templates.email(sanitizeModal(getPost(postid), redirect));
			var d = $.Deferred();

			if(!_.isEmpty($.trim($modal_inner.html()))) {
				$modal_inner.fadeOut(250, function() {
					d.resolve();
				});
			}else {
				d.resolve();
			}
			$.when(d).done(function() {
				$modal_inner.html(html).fadeIn(250, function() {
					$('#email-form').parsley();
					open();
					$('.icon--close').on('click', function() {
						close();
					});
					$('.button--cancel').on('click', function(e) {
						e.preventDefault();
						close();
					});
				});

			});

		},
		close: function() {
			close();
		}
	}
})($, _, Handlebars, all_posts);