<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package   WordPress
 * @subpackage  Starkers
 * @since     Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) );



?>

<?php

// We should store this in the function theme directory
$post_types = get_post_types(array(
    'public'   => true,
   '_builtin' => false
));

/*
NEW CDN STURRRF
*/

$site_url = get_site_url();

if ($site_url == 'http://testmozilla.wpengine.com/foxyeah' || $site_url == 'https://testmozilla.wpengine.com/foxyeah') {
  $env = 'staging';
  if (!empty($wpe_netdna_domains[0]['zone'])) {
    $wp_content = 'https://testmozilla.wpengine.com/foxyeah/files/';
    $cdn_base = '//' . $wpe_netdna_domains[0]['zone'] . '-wpengine.netdna-ssl.com/foxyeah/files/';
  }
} else {
  $env = 'production';
  $wp_content = 'https://foxyeah.mozilla.org/files/';
  $cdn_base = '//49g0kt2jjo6x43h6d190uav8-wpengine.netdna-ssl.com/foxyeah/files/';
}

$all_posts = array();
foreach ($post_types as $key => $value) {

  $posts_in_category = get_posts(array(
    'post_type' => $value,
    'numberposts' => -1
  ));

  foreach($posts_in_category as $v) {

    if (has_post_thumbnail($v->ID)) {

      $full = wp_get_attachment_image_src(get_post_thumbnail_id($v->ID), 'full');
      $medium = wp_get_attachment_image_src(get_post_thumbnail_id($v->ID), 'medium');

      $v->url = $full[0];
      $v->image = array(
          "sizes" => array(
              "medium" => $medium[0]
            ),
          "url" => $full[0]
       );

    }

    $v->permalink = get_permalink($v->ID);
    $v->bitly = wp_get_shortlink($v->ID);

    $arr = array_merge(get_fields($v->ID), (array)$v);

    if (isset($GLOBALS['wpe_netdna_domains'])) {

      $arr['image']['sizes']['thumbnail'] = str_replace($GLOBALS['wp_content'], $GLOBALS['cdn_base'], $arr['image']['sizes']['thumbnail']);
      $arr['image']['sizes']['medium'] = str_replace($GLOBALS['wp_content'], $GLOBALS['cdn_base'], $arr['image']['sizes']['medium']);
      $arr['image']['sizes']['large'] = str_replace($GLOBALS['wp_content'], $GLOBALS['cdn_base'], $arr['image']['sizes']['large']);
      $arr['social_image']['sizes']['thumbnail'] = str_replace($GLOBALS['wp_content'], $GLOBALS['cdn_base'], $arr['social_image']['sizes']['thumbnail']);
      $arr['social_image']['sizes']['medium'] = str_replace($GLOBALS['wp_content'], $GLOBALS['cdn_base'], $arr['social_image']['sizes']['medium']);
      $arr['social_image']['sizes']['large'] = str_replace($GLOBALS['wp_content'], $GLOBALS['cdn_base'], $arr['social_image']['sizes']['large']);
      $arr['image']['sizes']['url'] = str_replace($GLOBALS['wp_content'], $GLOBALS['cdn_base'], $arr['image']['sizes']['url']);
      $arr['image']['tile'] = str_replace($GLOBALS['wp_content'], $GLOBALS['cdn_base'], $arr['image']['tile']);
      $arr['image']['url'] = str_replace($GLOBALS['wp_content'], $GLOBALS['cdn_base'], $arr['image']['url']);

    }

    $all_posts[] = $arr;

  }
}

parse_str($_SERVER['QUERY_STRING'], $redirect_vars);

$legal = get_posts( array(
  'name' => 'legal',
  'post_type' => 'page'
  ) );

$privacy = get_posts(array(
  'name' => 'privacy',
  'post_type' => 'page'
  ));


?>

<?php

  $sort_object = get_field_object('default_sort_type', 'option');
  $default_sort_type = get_field('default_sort_type', 'option');
  if(empty($default_sort_type)) {
      $default_sort_type = "Featured";
  }
?>
<div class="filters inner">
  <p>
  Share a foxy reason to download Firefox. <br class="filters--break">
  View <a class="filter__action" href=""><?php echo the_field('default_sort_type', 'option'); ?></a> first.</p>
  <ul class="filter__options">
    <?php foreach($sort_object['choices'] as $key => $value): ?>
    <? if ($value !== $default_sort_type): ?>
    <li data-sort-by="<?php echo strtolower($value) ?>"><?php echo $value; ?></li>
    <? else: ?>
    <li class="active" data-sort-by="<?php echo strtolower($value) ?>"><?php echo $value; ?></li>
    <? endif; ?>
    <?php endforeach; ?>
  </ul>
</div>

<div class="tiles-container">
  <ul class="tiles">

  </ul>
</div>

<div class="load-more">
  <span>Load more</span>
</div>

<?php /* Hide the modal for now
<div class="modal modal--welcome">
  <div class="welcome-banner">
    <span class="icon icon--close">close</span>
    WELCOME TO <h1>FoxYeah</h1>
    <p>Did you know 1 out of 2 of your friends will download Firefox if you just ask them?</p>
    <span class="button button--pill">Start Sharing</span>
  </div>
</div>
*/ ?>

<!-- Put these libraries into minification up front -->
<script>
  <?php include('default_post.php'); ?>
  <?php
  if(isset($privacy[0])) {

    ?>
    var privacy = <?php echo json_encode($privacy[0]) ?>;
    <?php
  }
  ?>

  <?php
  if(isset($legal)) {
    ?>
    var legal = <?php echo json_encode($legal[0]) ?>;
    <?php
  }
  ?>
  var super_stamp = <?php echo json_encode($super_stamp); ?>;
  var default_post = <?php echo json_encode($default_post) ?>;
  var all_posts = <?php echo json_encode($all_posts); ?>;

  var default_sort_type = <?php echo json_encode($default_sort_type); ?>;
  <?php
  // Pagination Count
  $pagination_count = get_field('pagination_count', 'option');
  if(empty($pagination_count)) {
    $pagination_count = 12;
  }
  ?>
  var pagination_count = <?php echo json_encode($pagination_count); ?>;

</script>

<script>
  var base_url = '<?php echo bloginfo('url'); ?>';
  <?php
    if(isset($redirect_vars)) {
      ?>
        var redirect = <?php echo json_encode($redirect_vars) ?>;
      <?php
    }
  ?>
</script>








<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>
