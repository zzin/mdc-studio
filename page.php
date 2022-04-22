<?php get_header() ?>
<main id="primary" class="site-main" data-barba="container" data-barba-namespace="page-<?= $slug ?>">
  <?php
  while (have_posts()) : the_post();
    get_template_part('template-parts/content-page', $slug);
  endwhile; // End of the loop.
  ?>
</main>
<?php get_footer() ?>