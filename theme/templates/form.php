<?php 
    /*
      Template Name: from Page
    */
    get_header();
 ?>

  <section class="page-main">
      <div class="bg-gray-100 min-h-screen flex items-center justify-center flex-col">
          <h1 class="text-center text-5xl text-[#f36d45] font-semibold mb-24">Neo contact form</h1>
          <?php the_content(); ?>
      </div>
  </section>

<?php get_footer(); ?>