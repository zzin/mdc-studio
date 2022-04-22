<?php get_header() ?>
<main id="primary" class="site-main" data-barba="container" data-barba-namespace="single">
  <?php
  while (have_posts()) :
    the_post();

    get_template_part('template-parts/content', 'single');

    echo '<ul class="relative flex w-full justify-between bg-white z-10">';
    echo '<li>' . get_previous_post_link() . '</li>';
    echo '<li>' . get_next_post_link() . '</li>';
    echo '</ul>';
  // the_post_navigation(
  //   array(
  //     'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'zeein') . '</span> <span class="nav-title">%title</span>',
  //     'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'zeein') . '</span> <span class="nav-title">%title</span>',
  //   )
  // );

  endwhile; // End of the loop.
  ?>
</main>
<?php get_footer() ?>