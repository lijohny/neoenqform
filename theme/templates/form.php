<?php 
    /*
      Template Name: from Page
    */
    get_header();
 ?>

  <section class="page-main">
      <div class="bg-gray-100 min-h-screen flex items-center justify-center flex-col">
          <?php 
            the_content(); 
          ?>
      </div>
  </section>

<?php get_footer(); ?>