

var posts = (function($, Handlebars, _, Isotope, imagesLoaded, Modernizr, default_post) {

	/** Global Variables **/
    var all_posts = {};
    var $container = $('.tiles');
    var pagination = {
        index: 0,
        limit: parseInt(pagination_count),
        sort_type: ''
    };
    var evergreens;
    var popularityTotal = 0;
    var isFirefox = typeof InstallTrigger !== 'undefined';
    Handlebars.partials = Handlebars.templates;
    /**********************/

    /** Mixins **/
    // Sets small images
    // Check in index.php for reference
    _.mixin({
        imgSmall: function(obj) {
            if(obj.image) {
                if(obj.image.mime_type === "image/gif") {
                    obj.image.tile = obj.image.url;
                }else {
                    if(window.devicePixelRatio <= 1) {
                        obj.image.tile = obj.image.sizes.medium;
                    }else {
                        obj.image.tile = obj.image.url;
                    }
                }
            }
            return obj;
        }
    });

    /** Special Deferred Extension **/
    $.whenall = function(arr) { return $.when.apply($, arr); };
    /** **/

    // http://stackoverflow.com/questions/3066586/get-string-in-yyyymmdd-format-from-js-date-object
    Date.prototype.yyyymmdd = function() {
        var yyyy = this.getFullYear().toString();
        var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
        var dd  = this.getDate().toString();
        return yyyy + (mm[1]?mm:"0"+mm[0]) + (dd[1]?dd:"0"+dd[0]); // padding
    };


    // Numeral helper
    Handlebars.registerHelper('prettyNumber', function(number) {

        var format = (number > 1000 ? '0.0a' : '0a');
        var prettyNumber = numeral(number).format(format);
        return new Handlebars.SafeString(prettyNumber);
    });

    var templates = {
        'image': Handlebars.templates['image'],
        'video': Handlebars.templates['video'],
        'holiday': Handlebars.templates['holiday'],
        'evergreen': Handlebars.templates['evergreen']
    };


    function print_post(postObj) {
    	var post_template = _(templates).find(function(val, key) {
    		return postObj.post_type == key;
    	});
    	if(post_template) {
    		// returns the html formatted post
    		return post_template(postObj);
    	}else {
    		//return error to console
    		console.log(postObj.post_type +" template not found. Check the handlebars tempalate to make sure we have it loaded.");
    	}
    }
    function shuffle(array) {
        if (!array) {
            array = all_posts;
        }
        var currentIndex = array.length,
            temporaryValue, randomIndex;

        // While there remain elements to shuffle...
        while (0 !== currentIndex) {

            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            // And swap it with the current element.
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }
        return array;
    }
    function sortBy(sort_type) {
        // take off the top if its an evergreen, we'll put it on at the end
        if(_.first(all_posts).post_type === 'evergreen') {
            all_posts = _(all_posts).reject({post_type: 'evergreen', stamp: true});
        }
        switch(sort_type) {
            case 'videos':
                sortByVideo();
                break;
            case 'video':
                sortByVideo();
                break;
            case 'popular':
                sortByPopularity();
                break;
            case 'community':
                sortByCommunity();
                break;
            case 'featured':
                sortByFeatured();
                break;
            default:
                sortByNewest();
        }

        // RElayout with new order
        pagination.index = 0;
        pagination.sort_type = sort_type;
        $container.isotope('remove', $container.isotope('getItemElements'));
        all_posts = _(all_posts).value();
        if(!isFirefox) {
            all_posts.unshift(super_stamp);
        }else {
            if(_.first(evergreens)) {
                all_posts.unshift(_.sample(evergreens));
            }
        }

        print_posts(all_posts);
    }
    function sortByNewest() {
    	var newPosts = _(all_posts).sortBy(function(val) {
            return val.post_date;
        }).reverse();
        all_posts = newPosts;
    }
    function sortByVideo() {
        var newPosts = _(all_posts).sortBy(function(val){
            if(val.post_type === 'video') {
                return 1;
            }else {
                return -1;
            }
        }).reverse();
        all_posts = newPosts;
    }
    function sortByPopularity() {
        var newPosts = _(all_posts).sortBy(function(val) {
            return val.popularity;
        }).reverse();
        all_posts = newPosts;
    }
    function sortByCommunity() {
        var newPosts = _(all_posts).sortBy(function(val){

            if(_.isEmpty(val.inspired_by_name)) {
                return 1;
            }else {
                return -1;
            }

        });
        all_posts = newPosts;
    }
    function sortByFeatured() {
        var newPosts = _(all_posts).sortBy(function(val) {
            if(val.featured !== 'yes') {
                return 1;
            }else {
                return -1;
            }
        });
        all_posts = newPosts;
    }

    function fetchBitly(post) {
        var link = encodeURIComponent(post.bitly);
        var token = default_post.bitly_api_key;
        var url = 'https://api-ssl.bitly.com/v3/link/clicks?access_token=' + token + '&link=' + link;
        var popularity;
        // console.log(url);

        $.ajax({
            url: url,
            timeout: 2000,
            success: function (data) {
                if(data.status_txt === 'OK') {
                    popularity = data.data.link_clicks;
                }
                post.deferred.resolve(post);
                if(popularity) {
                    post['popularity'] = popularity;
                    if(popularity >= 1) {
                        popularityTotal += popularity;
                    }
                }else {
                    post['popularity'] = 0;
                }
            },
            error: function (err, textStatus) {
                // console.log("Fetch BItly Error: " + textStatus);
                post['popularity'] = 0;
                post.deferred.resolve(post);
                ga('send', 'event', {
                    'eventCategory': 'Error',
                    'eventAction': 'BitlyFetch',
                    'eventLabel': 'Unabletofetch'
                });
            },
            cache: false
        });
    }

    /**
    *
    */
    function print_posts(arrElems) {

        // Set pagination params
        var range = _.range(pagination.index, (pagination.limit + pagination.index));
        pagination.index += pagination.limit;
        if(pagination.index > all_posts.length) {
            pagination.index = all_posts.length;
        }
        var elems = _(arrElems).filter(function(val, key) {
            return _(range).contains(key);
        });
        // if there are no more posts - remove that button


        var html = _(elems).map(function(post) {
            return print_post(post);
        }).join(" ");

        var $html = $(html);
        imagesLoaded($html, function(val) {
            $html = _($html).reject(function(val) {
                return typeof val.id === 'undefined';
            });
            setTimeout(function() {
                $container.append($html).isotope('appended', $html).isotope('layout');
            } ,100);
            if(_.isEmpty(elems) || elems.length < pagination.limit) {
                //console.log(elems);

                $('.load-more').fadeOut();
            }else {
                if(_.last(elems).ID === _.last(all_posts).ID) {
                    $('.load-more').fadeOut();
                }else {
                    $('.load-more').fadeIn();
                }

            }
        });

    }

    return {
    	init: function(postsArr, containerClass) {
            // first lets filter the stamp, better known as evergreen
            evergreens = _(postsArr).filter({post_type: "evergreen", stamp: true});
            var filtered_posts = _(postsArr).reject({post_type: "evergreen", stamp:true});

            // Filter out holiday tiles that aren't within the date
            var currentDate = new Date();
            currentDate = currentDate.yyyymmdd();
            filtered_posts = _(filtered_posts).reject(function(val) {
                if(val.post_type === 'holiday') {
                    if(val.start_date < currentDate) {
                        if(val.end_date > currentDate) {

                        }else {
                            return true;
                        }
                    }else {
                        return true;
                    }
                }
            });

            // push an evergreen to the top? why not. if not firefox, push the super stamp

            if(!isFirefox) {
                filtered_posts.unshift(super_stamp);
            }else {

                if(_.sample(evergreens)) {
                    filtered_posts.unshift(_.sample(evergreens));
                }
            }

            postsArr = filtered_posts;

            // Lets set the highres pixels right here before we do anything with isotope
            // pagination limit
            _(postsArr).map(function(val) {
                // created a custom mixin to set the proper url
                return _(val).imgSmall();
            });


            // Grab share count on all the posts
            _(postsArr).map(function(val) {
                val.deferred = $.Deferred();
            });

            _(postsArr).each(function(val) {
                fetchBitly(val);
            });


            $.whenall(_(postsArr).map(function(val){return val.deferred})).done(function() {

                if(containerClass) {
                    $container = $(containerClass);
                }
                $container.isotope({
                    itemSelector: '.tiles__item',
                    layoutMode: 'masonry',
                });
                all_posts = arguments;

                pagination.sort_type = default_sort_type.toLowerCase();
                sortBy(default_sort_type.toLowerCase());

                var prettyTotal = numeral(popularityTotal).format('0,0');

                if (popularityTotal >= 1) {
                    $('.mentions').removeClass('hidden');
                    $('.mentions__count').text(prettyTotal);
                }
            });


    	},
        print_first_post: function() {
            var first = _.first(all_posts);

        },
        print_to_console: function() {
        	console.log(all_posts);
        },
        print_all_posts: function() {

            var elems = _(all_posts).map(function(post) {
                return $.parseHTML(print_post(post));

                //imagesLoaded();
            });
            imagesLoaded(elems, function(val) {
                var arrLength = val.elements.length;
                _(val.elements).each(function(val, key) {
                    $container.isotope().append(val).isotope('appended', val);
                    fetchCount(val);
                });
            });

        },
        paginate: function() {



            print_posts(all_posts);
        },
        shuffle: function() {
        	all_posts = shuffle(all_posts);
        },
        sortBy: function(sort_type) {
            // take off the top if its an evergreen, we'll put it on at the end
            sortBy(sort_type);
        },

        getPost: function(id) {
            id = parseInt(id);
            var the_post = _(all_posts).find(function(post) {
                return post.ID === id;
            });
            if(!the_post) {
                the_post = default_post;
            }
            return the_post;
        }
    };
})($, Handlebars, _, Isotope, imagesLoaded, Modernizr, default_post);
