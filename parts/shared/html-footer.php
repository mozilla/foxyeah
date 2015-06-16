	<script>
	var templateUrl = '<?= get_bloginfo("template_url"); ?>';
	</script>

	<!-- <![if !IE]> -->
	    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
	<!-- <![endif]>-->
		<script src="<?php echo get_stylesheet_directory_uri(); ?>/main.min.js?v=<?php echo get_version(); ?>"></script>

	<?php wp_footer(); ?>

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', '<?php echo the_field('google_analytics','option'); ?>', 'auto');
	  ga('send', 'pageview');

	</script>

	</body>
</html>