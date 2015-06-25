$(document).ready(function($) {


  // Set random header
  var randomHeader = Math.floor(Math.random() * 3) + 1;
  $('.grid-wrapper').addClass('grid'+randomHeader);


  var isFirefox = typeof InstallTrigger !== 'undefined';
  // Load All Posts
  // We'll get this from the index
  posts.init(all_posts, '.tiles');

  $('.load-more').on('click', function() {
      ga('send', 'event', {
          'eventCategory': 'Menu',
          'eventAction': 'LoadMorePosts'
      });
      posts.paginate();
  });


  /**
  *   Redirect Load Modal
  **/
  modal.init();
  if(!_.isEmpty(redirect)) {
    if(!_.isUndefined(redirect.post)) {

      modal.open(redirect.post, true);
    }

  }


  /**
  * LEGAL AND PRIVACY BUTTONS
  **/

  var legal_template = Handlebars.templates['legal'];
  $('#privacy_policy').on('click', function(e) {
    e.preventDefault();
    modal.openLegal(legal_template(privacy.post_content));
  });


  // Load social mentions count
  // jQuery.sharedCount = function (url, fn) {
  //   url = encodeURIComponent(url || location.href);
  //   var domain = '//plus.sharedcount.com'; /* SET DOMAIN */
  //   var apikey = default_post.share_counter_api_key /*API KEY HERE*/
  //   var arg = {
  //       data: {
  //           url: url,
  //           apikey: apikey,
  //           cache_bust: (new Date()) -0
  //       },
  //       url: domain + '/url',
  //       dataType: 'json'
  //   };
  //   if ('withCredentials' in new XMLHttpRequest) {
  //       arg.success = fn;
  //   } else {
  //       var cb = 'sc_' + url.replace(/\W/g, '');
  //       window[cb] = fn;
  //       arg.jsonpCallback = cb;
  //       arg.dataType += 'p';
  //   }
  //   return jQuery.ajax(arg);
  // };

  // // Get SharedCount data
  // $.sharedCount('https://foxyeah.mozilla.org', function (data) {
  //   var total = data.Facebook.total_count +
  //               data.GooglePlusOne +
  //               data.LinkedIn +
  //               data.Pinterest +
  //               data.StumbleUpon +
  //               data.Twitter;
  //   var pretttTotal = numeral(total).format('0,0');
  //   if (total > 1000) {
  //     $('.mentions').removeClass('hidden');
  //     $('.mentions__count').text(pretttTotal);
  //   }
  // });

  imagesLoaded('.grid-wrapper', function() {
    $('.tile-grid').addClass('active');
  });





  var stickyHeader = $('.header--sticky');
  var stickyHeaderOffset = 256;

  function handleScroll(e) {
    var scrollThreshold = (window.pageYOffset >= stickyHeaderOffset ? true : false);
    if (scrollThreshold && stickyHeader.not('stuck')) {
      stickyHeader.addClass('stuck');
    } else {
      stickyHeader.removeClass('stuck');
    }
  }

  window.onscroll = handleScroll;

  $('.header--sticky h1').on('click', function() {
    $('html, body').animate({ scrollTop: 0 }, 500);
  });

  $('.tiles').on('click', '.zoom', function(e) {

    var id = $(this).parent('.tiles__item').attr('id').match(/\d+/)[0];

    modal.open(id);
    resizeFunction(); // trigger modal fit

  });



  // http://stackoverflow.com/questions/4068373/center-a-popup-window-on-screen
  function popupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
  }

  function composeTweetURL(text, extras) {
    var encoded = encodeURIComponent(text + extras);
    var url = 'https://twitter.com/intent/tweet?text=' + encoded;
    return url;
  }


  function escapeHtml(unsafe) {
      return unsafe
           .replace(/&/g, "&amp;")
           .replace(/</g, "&lt;")
           .replace(/>/g, "&gt;")
           .replace(/"/g, "&quot;")
           .replace(/'/g, "#039;");
   }

  // share icons click
  $(document).on('click', '.share__item .icon', function(e) {

    e.preventDefault();

    var el = $(this);
    var post_id;


    post_id = $(this).parents().parents().data("id");

    // get id
    if (!post_id) {
      post_id = 0;
    }
    var parentPost = posts.getPost(post_id);

    // Facebook
    if (el.is('.icon--facebook')) {

      ga('send', 'event', {
        'eventCategory': 'Social',
        'eventAction': 'Share',
        'eventLabel': 'Facebook',
        'eventValue': parentPost.post_title
      });
      var u = el.attr('href');
      var url = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(u);
      popupCenter(url, 'Facebook', 550, 450);

      setLocalClick('facebook', post_id, parentPost.bitly);

    // Twitter
    } else if (el.is('.icon--twitter')) {
      ga('send', 'event', {
        'eventCategory': 'Social',
        'eventAction': 'Share',
        'eventLabel': 'Twitter',
        'eventValue': parentPost.post_title
      });

      var text = $.parseHTML(parentPost.tweet);

      var url = composeTweetURL(text[0].data, ' - ' + parentPost.bitly);
      popupCenter(url, 'Tweet', 550, 450);

      setLocalClick('twitter', post_id, parentPost.bitly);

    // Email
    } else if (el.is('.icon--email')) {

      modal.email(parentPost.ID);
      resizeFunction(); // trigger modal fit

      ga('send', 'event', {
        'eventCategory': 'Social',
        'eventAction': 'Share',
        'eventLabel': 'Email',
        'eventValue': parentPost.post_title
      });

      setLocalClick('email', post_id, parentPost.bitly);

    }

  });


  function setLocalClick(medium, id, bitly) {

    var item = localStorage.getItem(medium);

    if (item === null) {
      var empty = [];
      localStorage.setItem(medium, JSON.stringify(empty));
      item = localStorage.getItem(medium);
    }

    var itemArray = JSON.parse(item);
    var itemExists = itemArray.indexOf(id);

    if (itemExists === -1) {
      itemArray.push(id);
      localStorage.setItem(medium, JSON.stringify(itemArray));
      // increment NOW

      var popularity = $('#share'+id);
      var popularityCount = +(popularity.text());


      popularity.text(popularityCount + 1);

      // send bitly
      bitly = bitly.replace(/^https?:\/\//,'https://').replace('mzl.la', 'bit.ly');
      $.post(bitly);

    }

  };




  // Filters

  var $filterAction = $('.filter__action');
  var $filterOptions = $('.filter__options');
  var $filterItems = $filterOptions.find('li');

  function toggleFilterOptions() {
    $filterAction.toggleClass('open');
    $filterOptions.toggleClass('open');
  }

  $('.filter__action').on('click', function(e) {
    e.preventDefault();
    toggleFilterOptions();
  });

  $('body').on('click', function(e) {
    var target = e.target.classList[0];
    if (target === 'filter__action') return;
    if ($filterOptions.is('.open')) {
      toggleFilterOptions();
    }
  });

  $filterItems.on('click', function() {
    $filterItems.removeClass('active');
    var el = $(this);
    var sortByValue = (el.data('sort-by'));
    el.addClass('active');
    var text = el.text();
    $filterAction.text(text);
    posts.sortBy(sortByValue);
    ga('send', 'event', {
      'eventCategory': 'Menu',
      'eventAction': 'SortBy',
      'eventLabel': text
    });
  });


  $(document).on('submit', 'form', function(e) {

    e.preventDefault();
    ga('send', 'event', {
        'eventCategory': 'Social',
        'eventAction': 'Share',
        'eventLabel': 'EmailSubmit'
    });

    var el = $(this);
    var url = el.attr('action');
    var data = el.serialize();

    // console.log(data);

    // return;

    $('input[type=submit]').attr('disabled', 'disabled');
    createSpinner();
    $('.spinner').fadeIn();

    $.ajax({
      type: 'POST',
      url: base_url + '/send-email',
      data: data,
      success: function(raw) {
        var data = JSON.parse(raw);
        // console.log(data);
        if (data.status === 'ok') {
          $('form')[0].reset();
        }
        $('input[type=submit]').removeAttr('disabled');
        $('.form__response').slideDown().text(data.message).delay(3000).slideUp();
        $('.spinner').hide();
        ga('send', 'event', {
          'eventCategory': 'Social',
          'eventAction': 'Share',
          'eventLabel': 'EmailSent'
        });
      },
      error: function() {
        ga('send', 'event', {
          'eventCategory': 'Error',
          'eventAction': 'EmailError'
        });
      }
    });

  });

  function createSpinner() {
    var opts = {
      lines: 11, // The number of lines to draw
      length: 4, // The length of each line
      width: 2, // The line thickness
      radius: 5, // The radius of the inner circle
      corners: 1, // Corner roundness (0..1)
      rotate: 0, // The rotation offset
      direction: 1, // 1: clockwise, -1: counterclockwise
      color: '#000', // #rgb or #rrggbb or array of colors
      speed: 1, // Rounds per second
      trail: 57, // Afterglow percentage
      shadow: false, // Whether to render a shadow
      hwaccel: false, // Whether to use hardware acceleration
      className: 'spinner', // The CSS class to assign to the spinner
      zIndex: 2e9, // The z-index (defaults to 2000000000)
      top: '50%', // Top position relative to parent
      left: '50%' // Left position relative to parent
    };
    var target = document.getElementById('spinner');
    var spinner = new Spinner(opts).spin(target);
  }

  // alert('test');


  // Mobile "menu" toggle

  $('.menu--main').on('click', function() {
    $(this).toggleClass('menu--open');
    $('.header--main, .copy--main, .share--header').toggleClass('menu--open');
    ga('send', 'event', {
      'eventCategory': 'Menu',
      'eventAction': 'Open',
      'eventLabel': 'Mobile'
    });
  });

  $('.modal__outer').on('click', function(e) {
    var closeList = ['modal__inner', 'figure'];
    if (closeList.indexOf(e.target.classList[0]) > -1) {
      modal.close();
    }
  });

  var resizeTimer;

  function resizeFunction() {

      var width = $(window).width();
      if (width >= 768) {
        $('.menu--open').toggleClass('menu--open');
      }


      var windowHeight = $(window).height();
      var modalFooterHeight = $('.modal__footer').height();
      var figureHeight = windowHeight - modalFooterHeight - 30; // 15px border x2 (top & bottom)
      $('.figure--image').height(figureHeight);

      var videoHeight = $('.modal--video').height();
      var videoOffset = figureHeight - videoHeight;
      $('.modal--video').css('margin-top', videoOffset / 2);

  };

  $(window).resize(function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(resizeFunction, 150);
  });

  resizeFunction();


  /* ESC key close modal */
  $(document).keyup(function(e) {
    if (e.keyCode == 27) {
      modal.close();
    }
  });

  /* Welcome Banner */
  var $modalWelcome = $('.modal--welcome');
  var $welcomeBanner = $('.welcome-banner');
  var hasSeenWelcome = localStorage.getItem('welcome');

  if (!hasSeenWelcome) {
    $modalWelcome.css('display', 'block');
  }

  $welcomeBanner.on('click', function() {
    modal.close();
    if (!hasSeenWelcome) {
      localStorage.setItem('welcome', true);
    }
  });

});