<?php
/*
Template Name: Send Email
*/

include('default_post.php');

// $recaptcha = $_POST['g-recaptcha-response'];

// if (empty($recaptcha)) {

//     $response = array(
//         'status' => 'error',
//         'message' => 'Error. Please click the checkbox above.'
//     );

//     header('Content-Type: application/json');
//     echo json_encode($response);

//     exit();

// } else {

//     $ip = $_SERVER["REMOTE_ADDR"];

//     $params = array(
//         'secret' => get_field('mandrill_secret','option'),
//         'response' => $recaptcha,
//         'remoteip' => $ip
//     );

//     $body = http_build_query($params);

//     $ch = curl_init();

//     curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify' );
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
//     curl_setopt($ch, CURLOPT_POST, 1 );
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

//     $result = curl_exec ($ch);

//     curl_close($ch);

//     $data = json_decode($result);
//     $success = $data->success;

//     if ($success != 1) {

//         $response = array(
//             'status' => 'error',
//             'message' => 'Something went wrong. Please try again.'
//         );

//         header('Content-Type: application/json');
//         echo json_encode($response);

//         exit();

//     } else {

//         sendEmail($default_post);

//     }

// }

// function sendEmail($default_post) {

    $to = $_POST['to'];
    $from = $_POST['from'];
    $id = $_POST['id'];
    // $subject = $_POST['subject'];
    // $subject = stripslashes(utf8_encode($subject));
    // $body = $_POST['body'];
    // $body = nl2br(htmlspecialchars(stripslashes($body)));

    // Check if postsID exists
    $post = get_post($id);

    if (!is_null($post) && (int)$id >= 1) {

        $subject = get_field('email_subject', $id);
        $body = get_field('email_body', $id);
        $from_name = $from . ' (via FoxYeah)';
        $post_type = get_post_type($id);
        $permalink = get_permalink($id);

        switch($post_type) {
            case image :
                $tile_src = get_field('image', $id);
                $tile_image = $tile_src['sizes']['large'];
                break;
            case video :
                $tile_src =  wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large');
                $tile_image = $tile_src[0];
                break;
        }

    } else {

        $subject = $default_post['email_subject'];
        $from_name = $from . ' (via FoxYeah)';
        $post_type = $default_post['post_type'];
        $tile_image = $default_post['image']['url'];
        $permalink = $default_post['permalink'];
        $body = $default_post['email_body'];

    }

    $mandrill_key = get_field('mandrill_key','option');

    $uri = 'https://mandrillapp.com/api/1.0/messages/send-template.json';

    $body = nl2br(htmlspecialchars(stripslashes($body)));

    $post_string = '{
                "key": "'.$mandrill_key.'",
                    "template_name": "litmus",
                    "template_content": [{
                    "name": "",
                        "content": ""
                }],
                    "message": {
                    "subject": '.json_encode($subject).',
                        "from_email": "'. get_field('firefox_email','option') .'",
                        "from_name": "'.$from_name.'",
                        "to": [{
                        "email": "'.$to.'",
                            "name": "",
                            "type": "to"
                    }],
                        "headers": {
                        "Reply-To": "noreply@foxyeah.com"
                    },
                        "global_merge_vars": [{
                        "name": "PERMALINK",
                            "content": "'.$permalink.'"
                    }, {
                        "name": "TILE_IMAGE",
                            "content": "'.$tile_image.'"
                    }, {
                        "name": "SENDER_NAME",
                            "content": "'.$from.'"
                    }, {
                        "name": "BODY",
                            "content": '.json_encode($body).'
                    }]
                }
            }';


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uri);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);


    // Return error from cURL, if present
    $result = curl_exec($ch);
    $data = json_decode($result, true);
    $status = $data['0']['status'];
    $reject_reason = $data['0']['reject_reason'];
    $response = array();

    if ($status == 'error') {

        $response['status'] = 'error';
        $response['message'] = 'Something went wrong. Please try again.';

    } else if ($status == 'sent' && is_null($reject_reason)) {

        $response['status'] = 'ok';
        $response['message'] = 'Email successfully sent!';

    } else if ($reject_reason == 'unsub') {

        $response['status'] = 'error';
        $response['message'] = 'Error. This user has unsubscribed.';

    } else {

        $response = $result;

    }

    // header('Content-Type: application/json');
    echo json_encode($response);


// }