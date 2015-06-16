<?php
$ID = get_the_ID();
$image = get_field('image');
$social_image = get_field('social_image');
if ($social_image) {
  $img = $social_image['sizes']['large'];
} else {
  $img = $image['sizes']['large'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FoxYeah</title>
  <meta property="og:title" content="<?php echo the_field('social_header', $ID); ?>" />
  <meta property="og:site_name" content="FoxYeah" />
  <meta property="og:url" content="<?php echo the_permalink($ID); ?>?redirect=true" />
  <meta property="og:description" content="<?php echo the_field('social_teaser', $ID); ?>" />
  <meta property="og:image" content="<?php echo $img; ?>" />
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@firefox">
  <meta name="twitter:creator" content="@firefox">
  <meta name="twitter:title" content="<?php echo the_field('social_header', $ID); ?>">
  <meta name="twitter:description" content="<?php the_field('social_teaser', $ID); ?>">
  <meta name="twitter:image:src" content="<?php echo $img; ?>">
	<?php require('parts/shared/single-redirect.php'); ?>
</head>
<body>

</body>
</html>