<?php
/*
Template Name: main-page-tamplate
Template Post Type: post, page
*/

get_header();?>

<!-- Get Touch Section -->
<div id="get-touch">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6 col-md-offset-1">
        <h3>Cost for your home renovation project</h3>
        <p>Get started today and complete our form to request your free estimate</p>
      </div>
      <div class="col-xs-12 col-md-4 text-center"><a href="#contact" class="btn btn-custom btn-lg page-scroll">Free Estimate</a></div>
    </div>
  </div>
</div>
<!-- About Section -->
<div id="about">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6"> <img src="<?php bloginfo('template_url'); ?>/assets/img/about.jpg" class="img-responsive" alt=""> </div>
      <div class="col-xs-12 col-md-6">
        <div class="about-text">
          <h2>Who We Are</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          <h3>Why Choose Us?</h3>
          <div class="list-style">
            <div class="col-lg-6 col-sm-6 col-xs-12">
              <ul>
                <li>Years of Experience</li>
                <li>Fully Insured</li>
                <li>Cost Control Experts</li>
                <li>100% Satisfaction Guarantee</li>
              </ul>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-12">
              <ul>
                <li>Free Consultation</li>
                <li>Satisfied Customers</li>
                <li>Project Management</li>
                <li>Affordable Pricing</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Services Section -->
<div id="services">
  <div class="container">
    <div class="section-title">
      <h2>Our Services</h2>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="service-media"> <img src="<?php bloginfo('template_url'); ?>/assets//img/services/service-1.jpg" alt=" "> </div>
        <div class="service-desc">
          <h3>New Home Construction</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed dapibus leo nec ornare diam sedasd commodo nibh ante facilisis bibendum dolor feugiat at.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-media"> <img src="<?php bloginfo('template_url'); ?>/assets/img/services/service-2.jpg" alt=" "> </div>
        <div class="service-desc">
          <h3>Home Additions</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed dapibus leo nec ornare diam sedasd commodo nibh ante facilisis bibendum dolor feugiat at. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-media"> <img src="<?php bloginfo('template_url'); ?>/assets/img/services/service-3.jpg" alt=" "> </div>
        <div class="service-desc">
          <h3>Bathroom Remodels</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed dapibus leo nec ornare diam sedasd commodo nibh ante facilisis bibendum dolor feugiat at.</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="service-media"> <img src="<?php bloginfo('template_url'); ?>/assets/img/services/service-4.jpg" alt=" "> </div>
        <div class="service-desc">
          <h3>Kitchen Remodels</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed dapibus leo nec ornare diam sedasd commodo nibh ante facilisis bibendum dolor feugiat at.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-media"> <img src="<?php bloginfo('template_url'); ?>/assets/img/services/service-5.jpg" alt=" "> </div>
        <div class="service-desc">
          <h3>Windows & Doors</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed dapibus leo nec ornare diam sedasd commodo nibh ante facilisis bibendum dolor feugiat at.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-media"> <img src="<?php bloginfo('template_url'); ?>/assets/img/services/service-6.jpg" alt=" "> </div>
        <div class="service-desc">
          <h3>Decks & Porches</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed dapibus leo nec ornare diam sedasd commodo nibh ante facilisis bibendum dolor feugiat at.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Gallery Section -->
<div id="portfolio">
  <div class="container">
    <div class="section-title">
      <h2>Our Works</h2>
    </div>
    <div class="row">
      <div class="portfolio-items">

<?php
 $table3 = carbon_get_theme_option('slide_our_works');
 ?>
  <?php
 if ( $table3 ):
 foreach ( $table3 as $tr3 ): ?>
       <div class="col-sm-6 col-md-4 col-lg-4">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="<?php echo $tr3['our_works_photo']; ?>" title="<?php echo $tr3['our_works_name']; ?>" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4><?php echo $tr3['our_works_name']; ?></h4>
              </div>
              <img src="<?php echo $tr3['our_works_photo']; ?>" class="img-responsive" alt="<?php echo $tr3['our_works_name']; ?>"> </a> </div>
          </div>
        </div>
<?php endforeach; ?>
<?php endif; ?>

      </div>
    </div>
  </div>
</div>
<!-- Testimonials Section -->
<div id="testimonials">
  <div class="container">
    <div class="section-title">
       <?php if(carbon_get_theme_option('thestimonials_title')){?>
      <h2><?php echo  esc_attr(carbon_get_theme_option('thestimonials_title')); ?></h2>
      <?php } ?>
    </div>
    <div class="row">

<?php
 $table3 = carbon_get_theme_option('slide_thestimonials');
// var_dump($table3);

 ?>
  <?php
 if ( $table3 ):
 foreach ( $table3 as $tr3 ): ?>
      <div class="col-md-4">
        <div class="testimonial">
          <div class="testimonial-image"> <img src="<?php echo $tr3['thestimonials_photo']; ?>" alt="Отзыв от <?php echo $tr3['thestimonials_name']; ?>"> </div>
          <div class="testimonial-content">
            <p><?php echo $tr3['thestimonials_text']; ?></p>
            <div class="testimonial-meta"> - <?php echo $tr3['thestimonials_name']; ?> </div>
          </div>
<div class="per__social">

<ul>
<?php
 $table555 = carbon_get_theme_option('slide_socialspytwo2');
var_dump($table555);
print_r($table555);
?>
  <?php
 if (  ! empty( $table555) ):
 foreach ( $table555 as $tr555 ): ?>
  <li><i class="<?php echo $tr555['social_icon_two2']; ?>"></i></li>
  <?php endforeach; ?>
  <?php endif; ?>
  </ul>
 </div>

        </div>
      </div>
<?php endforeach; ?>
<?php endif; ?>

    </div>
  </div>
</div>
<!-- Contact Section -->
<?php
 $crb_slides = carbon_get_theme_option('crb_slides');
$slide_fragments = carbon_get_theme_option('slide_fragments');
print_r($crb_slides);
?>
<?php
if (  ! empty( $crb_slides) ):
 foreach ( $crb_slides as $crb ): ?>
<div>
  <p><?php echo $crb['image']; ?></p>
<ul>
  <?php  foreach ( $crb_slides as $crb ): ?>
  <li><?php echo $crb['fragment_text']; ?>^<?php echo $crb['fragment_position']; ?> </li>
<?php endforeach; ?>
</ul>
</div>
 <?php endforeach; ?>
  <?php endif; ?>










<div id="contact">
  <div class="container">
    <div class="col-md-8">
      <div class="row">
        <div class="section-title">
   <?php if(carbon_get_theme_option('footer_contactform_title')){?>
          <h2><?php echo  esc_attr(carbon_get_theme_option('footer_contactform_title')); ?></h2>
 <?php } ?>
<?php if(carbon_get_theme_option('footer_contactform_descr')){?>
  <p> <?php echo  esc_attr(carbon_get_theme_option('footer_contactform_descr')); ?></p>
 <?php } ?>
  </div>
        <div>
<? echo do_shortcode( '[contact-form-7 id="16" title="главная форма"]');  ?>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-md-offset-1 contact-info">




        <div class="contact-item">
          <?php if(carbon_get_theme_option('footer_contact_title')){?>
        <h4><?php echo  esc_attr(carbon_get_theme_option('footer_contact_title')); ?></h4>
<?php } ?>
<?php if(carbon_get_theme_option('footer_contact_adress')){
  echo wpautop( carbon_get_theme_option( 'footer_contact_adress' ) );
 } ?>

      </div>


     <div class="contact-item">
       <?php if(carbon_get_theme_option('footer_contact_phone')){?>

        <p><span>Телефон</span>
            <?php echo  esc_attr(carbon_get_theme_option('header_phpne')); ?><br>
         <?php echo  esc_attr(carbon_get_theme_option('footer_contact_phone')); ?></p>
<?php } ?>
      </div>

     <div class="contact-item">
   <?php if(carbon_get_theme_option('footer_contact_email')){?>
        <p><span>Email</span> <?php echo  esc_attr(carbon_get_theme_option('footer_contact_email')); ?></p>
<?php } ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
 <!--        <div class="social">
 <ul>

 <?php
 $table1 = carbon_get_post_meta( get_the_ID(), 'slide_socialspyfoure' );
 ?>
  <?php
 if ( $table1 ):
 foreach ( $table1 as $tr1 ): ?>
 <li><a target="_blank" href="<?php echo $tr1['social_links_foure']; ?>"><i class="<?php echo $tr1['social_icon_foure']; ?>"></i></a></li>
<?php endforeach; ?>
<?php endif; ?>
  </ul>
        </div> -->

        <div class="social">
 <ul>

 <?php
 $table2 = carbon_get_theme_option('slide_socialspytwo');
 ?>
  <?php
 if ( $table2 ):
 foreach ( $table2 as $tr2 ): ?>
 <li><a target="_blank" href="<?php echo $tr2['social_links_two']; ?>"><i class="<?php echo $tr2['social_icon_two']; ?>"></i></a></li>
<?php endforeach; ?>
<?php endif; ?>
  </ul>
        </div>

      </div>
    </div>
  </div>
</div>


<?php get_footer(); ?>