<?php
/*
Template Name: Email Unsubscribe
*/

$mandrill_id = $_GET['md_id'];
$mandrill_email = $_GET['md_email'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FoxYeah</title>
  <link href='https://fonts.googleapis.com/css?family=Fira+Sans:300,400' rel='stylesheet' type='text/css'>
  <style>
  body {
    font-family: 'Fira Sans';
    color: #C1C1C1;
    font-weight: 300;
    text-align: center;
    margin-top: 50px;
  }
  .email {
    color: #606060;
    font-weight: 400;
  }
  </style>
</head>
<body>

  <?php if ($mandrill_id && $mandrill_email) : ?>
  <p><span class="email"><?php echo $mandrill_email; ?></span> has been successfully unsubscribed.</p>
  <?php endif; ?>

</body>
</html>