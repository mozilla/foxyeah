<header>

  <header class="header header--main">
    <div class="inner">
      <div class="lockup">
        <h1>FoxYeah</h1>
        <h2>A Firefox Community Initiative</h2>
      </div>
      <span class="menu menu--main">menu</span>
      <div class="intro__copy copy--main">
        <p>Know someone who needs to download Firefox? #FoxYeah you do! Share away.</p>
      </div>
      <ul class="share share--header">
        <li class="share__item">
          <a class="icon icon--facebook" href="<?php echo get_bloginfo('url'); ?>">share on Facebook</a>
        </li>
        <li class="share__item">
          <a class="icon icon--twitter" href="<?php echo get_bloginfo('url'); ?>">share on Twitter</a>
        </li>
        <li class="share__item">
          <a class="icon icon--email" href="" data-thumbnail="<?php echo get_stylesheet_directory_uri(); ?>/images/foxyeah-generic.png">Share via Email</a>
        </li>
      </ul>
      <div class="mentions hidden">
        <span class="mentions__count">...</span>
        <p>#FoxYeah shares on social media</p>
      </div>
    </div>
    <div class="grid-wrapper">
      <ul class="tile-grid">
        <?php
          for ($i=0; $i < 156; $i++) {
            echo "<li class='tile$i'></li>";
          }
         ?>
      </ul>
    </div>

  </header>

  <div class="header header--sticky">
    <div class="inner">
      <h1>FoxYeah</h1>
      <span class="menu">menu</span>
      <div class="intro__copy copy--sticky">
        <p>Love Firefox? Share Firefox.</p>
      </div>
    </div>
  </div>

</header>