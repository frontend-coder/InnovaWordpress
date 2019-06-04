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
      <div class="get_touch_box">
        <div class="get_touch_box_left">
         <?php if(carbon_get_theme_option('callaction_title')){?>
          <h3><?php echo carbon_get_theme_option('callaction_title'); ?></h3>
        <?php } ?>
        <?php if(carbon_get_theme_option('callaction_descr')){?>
          <p><?php echo carbon_get_theme_option('callaction_descr'); ?>
        </p>
      <?php } ?>
    </div>
    <div class="get_touch_box_righr">
     <?php if(carbon_get_theme_option('header_actionbutton')){?>
       <a href="#contact" class="btn btn-custom btn-lg page-scroll">
         <?php echo carbon_get_theme_option('header_actionbutton'); ?>
       </a>
     <?php } ?>
   </div>
 </div>
</div>
</div>
</div>

<!-- About Section -->
<div id="about">
  <div class="container">
    <div class="row">

<div class="about_box">
<div class="about_box_item">
   <?php if(carbon_get_theme_option('who_we_are_photo')){?>
        <img src="<?php echo  esc_url(carbon_get_theme_option('who_we_are_photo')); ?>" class="img-responsive" alt="">
    <?php } ?>
</div>

<div class="about_box_item">
      <div class="about-text">
         <?php if (carbon_get_theme_option('who_we_are_title')) {?>
          <h2><?php echo  esc_attr(carbon_get_theme_option('who_we_are_title')); ?></h2><?php } ?>

        <?php if(carbon_get_theme_option('who_deskr')){?>
         <p><?php echo  esc_attr(carbon_get_theme_option('who_deskr')); ?> </p>
       <?php } ?>
       <?php if(carbon_get_theme_option('who_deskr_title')){?>
        <h3><?php echo  esc_attr(carbon_get_theme_option('who_deskr_title')); ?></h3>
      <?php } ?>
      <div class="list-style">
       <ul>
        <?php
        $who_deskr_list = carbon_get_theme_option('who_deskr_list');
        ?>
        <?php
        if ( $who_deskr_list ):
         foreach ( $who_deskr_list as $wdl ): ?>
           <li><?php echo $wdl['who_deskr_listing']; ?></li>
         <?php endforeach; ?>
       <?php endif; ?>
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
     <?php if(carbon_get_theme_option('our_services_title')){?>
      <h2><?php echo  esc_attr(carbon_get_theme_option('our_services_title')); ?></h2>
    <?php } ?>
  </div>
  <div class="row">
    <div class="services_box">
      <?php
      $slide_our_services = carbon_get_theme_option('slide_our_services');
      ?>
      <?php
      if ( $slide_our_services ):
       foreach ( $slide_our_services as $slos ): ?>
         <div class="services_box_items">
          <div class="service-media">
            <img src="<?php echo $slos['our_services_photo']; ?>" alt="Мы предлагаем услугу <?php echo $slos['our_services_name']; ?>"> </div>
            <div class="service-desc">
              <h3><?php echo $slos['our_services_name']; ?></h3>
              <p><?php echo $slos['our_services_descr']; ?>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
</div>
</div>

<!-- Gallery Section -->
<div id="portfolio">
  <div class="container">
    <div class="section-title">
      <?php if(carbon_get_theme_option('our_works_title')){?>
        <h2><?php echo  esc_attr(carbon_get_theme_option('our_works_title')); ?></h2>
      <?php } ?>
    </div>
    <div class="row">
      <div class="portfolio-bixing">
        <?php
        $table3 = carbon_get_theme_option('slide_our_works');
        ?>
        <?php
        if ( $table3 ):
         foreach ( $table3 as $tr3 ): ?>
           <div class="portfolio-items">
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

 <div class="portfolio-bixing">
  <?php
    $table3 = carbon_get_theme_option('slide_thestimonials');
// var_dump($table3);
    ?>
    <?php
    if ( $table3 ):
     foreach ( $table3 as $tr3 ): ?>
   <div class="portfolio-items">
        <div class="testimonial">
          <div class="testimonial-image"> <img src="<?php echo $tr3['thestimonials_photo']; ?>" alt="Отзыв от <?php echo $tr3['thestimonials_name']; ?>"> </div>
          <div class="testimonial-content">
            <p><?php echo $tr3['thestimonials_text']; ?></p>
            <div class="testimonial-meta"> - <?php echo $tr3['thestimonials_name']; ?> </div>
          </div>
        </div>
      </div>
  <?php endforeach; ?>
  <?php endif; ?>
</div>
</div>
</div>
</div>
<!-- Contact Section -->
<!--      <?php
$footer_contactform_shotcode = carbon_get_theme_option('footer_contactform_shotcode');
         innova_debug($footer_contactform_shotcode);
         ?> -->

<div id="contact">
  <div class="container">
    <div class="row">
      <div class="contact_block">
        <div class="contact_block_left">
          <div class="section-title">
           <?php if(carbon_get_theme_option('footer_contactform_title')){?>
            <h2><?php echo  esc_attr(carbon_get_theme_option('footer_contactform_title')); ?></h2>
          <?php } ?>
          <?php if(carbon_get_theme_option('footer_contactform_descr')){?>
            <p> <?php echo  esc_attr(carbon_get_theme_option('footer_contactform_descr')); ?></p>
          <?php } ?>
        </div>
  <?php if(carbon_get_theme_option('footer_contactform_shotcode')){?>
        <div id="contactForm">
          <?php $footer_contactform_shotcode = carbon_get_theme_option('footer_contactform_shotcode'); echo do_shortcode( $footer_contactform_shotcode);  ?>
        </div>
        <?php } ?>
      </div>

      <div class="contact_block_right">
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
  </div>
</div>

 <div class="row">
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

<?php get_footer(); ?>