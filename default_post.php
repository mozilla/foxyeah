
<?php

    $download_cdn_url = 'https://49g0kt2jjo6x43h6d190uav8-wpengine.netdna-ssl.com/foxyeah/files/2015/06/tile_download.png';

    //echo $tweet;
    $default_post = array(
		'ID' => 0,
    	'image'=> get_field('image', 'option'),
    	'post_name' => "Foxyeah",
    	'twitter_copy' => get_field('tweet', 'option'),
    	'subject' => get_field('social_subject','option'),
    	'post_type' => 'image',
        'tweet' => get_field('tweet', 'option'),
    	'permalink' => get_site_url(),
        'bitly' => get_field('site_bitly','option'),
        'body' => get_field('social_body', 'option'),
        'google_captcha_sitekey' => get_field('google_captcha_sitekey','option'),
        'email_subject' => get_field('email_subject', 'option'),
        'email_body' => get_field('email_body','option'),
        'share_counter_api_key' => get_field('share_counter_api_key', 'option'),
        'generic_modal_text' => get_field('generic_modal_text','option'),
        'social_header' => get_field('social_subject','option'),
        'social_body' => get_field('social_body','option'),
        'bitly_api_key' => get_field('bitly_api_key', 'option')
		);
    $super_stamp = array(
        "ID" => 1,
        "post_name" => "Download Firefox Super Stamp",
        "image" => array(
            "url" => $download_cdn_url,
            "title" => "Evergreen_download_firefox",
            "sizes" => array(
                "medium" => $download_cdn_url,
                )
            ),
        "title" => "Download Firefox",
        "link" => "http://mozilla.org/firefox/personal/?utm_source=foxyeahsite&utm_medium=referral&utm_content=evergreen-download-tile&utm_campaign=sc-2015-foxyeah",
        "stamp" => true,
        "post_type" => "evergreen"
        );
    // $evergreen_nonff = array(
    //     'ID' => 0,
    //     'image'=> get_field('image', 'option'),
    //     'post_name' => "Foxyeah",
    //     'twitter_copy' => get_field('tweet', 'option'),
    //     'subject' => get_field('social_subject','option'),
    //     'post_type' => 'image',
    //     'tweet' => get_field('tweet', 'option'),
    //     'permalink' => get_site_url(),
    //     'bitly' => get_field('site_bitly','option'),
    //     'body' => get_field('social_body', 'option'),
    //     'google_captcha_sitekey' => get_field('google_captcha_sitekey','option'),
    //     'email_subject' => get_field('email_subject', 'option'),
    //     'email_body' => get_field('email_body','option'),
    //     'share_counter_api_key' => get_field('share_counter_api_key', 'option'),
    //     'generic_modal_text' => get_field('generic_modal_text','option'),
    //     'social_header' => get_field('social_subject','option'),
    //     'social_body' => get_field('social_body','option'),
    //     'bitly_api_key' => get_field('bitly_api_key', 'option')
    //     );
?>