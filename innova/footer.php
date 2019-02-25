<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package innova
 */

?>

<!-- Footer Section -->
<div id="footer">
  <div class="container text-center">
  <?php if(carbon_get_theme_option('footer_copyright')){
$footer_copyright = carbon_get_theme_option('footer_copyright');

  	?>
  <?php echo wpautop($footer_copyright); ?>
<?php } ?>
  </div>
</div>
<!--
<script type="text/javascript" src="js/jquery.1.11.1.js"></script>

<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/SmoothScroll.js"></script>
<script type="text/javascript" src="js/nivo-lightbox.js"></script>
<script type="text/javascript" src="js/jqBootstrapValidation.js"></script>
<script type="text/javascript" src="js/contact_me.js"></script>
<script type="text/javascript" src="js/main.js"></script> -->
<?php wp_footer(); ?>
</body>
</html>