<?php
$ID = get_the_ID();
$image = wp_get_attachment_url(get_post_thumbnail_id($ID));
$youtube_link = get_field('youtube_link');
parse_str( parse_url( $youtube_link, PHP_URL_QUERY ), $params );
$youtube_id = $params['v'];
$shortlink = preg_replace("(^https?://)", "", wp_get_shortlink());
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FoxYeah</title>
  <meta property="og:image" content="<?php echo $image; ?>" />
  <meta property="og:video" content="https://www.youtube.com/v/<?php echo $youtube_id; ?>" />
  <meta property="og:video:secure_url" content="https://www.youtube.com/v/<?php echo $youtube_id; ?>" />
  <meta property="og:url" content="<?php echo the_permalink($ID); ?>?redirect=true" />
  <meta property="og:title" content="<?php echo the_field('social_header', $ID); ?>" />
  <meta property="og:description" content="<?php echo the_field('social_teaser', $ID); echo ' ' . $shortlink; ?>" />
  <meta property="og:video:width" content="640" />
  <meta property="og:video:height" content="360" />
  <meta property="og:type" content="movie" />
  <meta property="og:video:type" content="application/x-shockwave-flash" />
  <meta name="twitter:card" content="player">
  <meta name="twitter:site" content="@firefox">
  <meta name="twitter:creator" content="@firefox">
  <meta name="twitter:url" content="http://www.youtube.com/watch?v=<?php echo $youtube_id; ?>">
  <meta name="twitter:title" content="<?php echo the_field('social_header', $ID); ?>">
  <meta name="twitter:description" content="<?php the_field('social_teaser', $ID); ?>">
  <meta name="twitter:image" content="<?php echo $image; ?>">
  <meta name="twitter:player" content="https://www.youtube.com/embed/<?php echo $youtube_id; ?>">
  <meta name="twitter:player:width" content="1280">
  <meta name="twitter:player:height" content="720">
  <?php require('parts/shared/single-redirect.php'); ?>
</head>
<body>
</body>
</html>