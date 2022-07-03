<?php get_header() ?>
<main id="primary" class="site-main" data-barba="container" data-barba-namespace="single">
  <?php
  while (have_posts()) :
    the_post();

    get_template_part('template-parts/content', 'single');

    echo '<ul class="nav-control">';
    echo '<li class="li-next">' . get_next_post_link('<div class="li-title">Next</div>%link', '<span class="text-black">%title</span>') . '</li>';
    echo '<li class="li-prev">' . get_previous_post_link('<div class="li-title">Prev</div>%link', '<span class="text-black">%title</span>') . '</li>';
    echo '</ul>';

  endwhile; // End of the loop.
  ?>
</main>
<?php get_footer() ?>