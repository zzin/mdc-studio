<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php get_template_part('template-parts/split/entry', 'header-solid'); ?>
  <div class="container-full mx-auto px-6 lg:px-8 py-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-4 md:gap-y-6 gap-x-6">
      <?php
      $posts = get_posts(array(
        'post_type'       => 'portfolio',
        'post_status'     => 'publish',
        'posts_per_page'  => -1,
      ));
      if ($posts) :
        foreach ($posts as $post) :
          $postImage = get_the_post_thumbnail_url($post->ID, 'full');
      ?>
          <div class="photo--wrap relative overflow-hidden">
            <img src="<?= get_stylesheet_directory_uri() ?>/assets/public/images/empty.png">
            <img class="photo--wrap-img w-full object-cover absolute inset-0" src="<?= $postImage ?>">
            <a href="<?= get_permalink($post->ID) ?>">
              <div class="photo--wrap-title absolute inset-0 bg-black/80 z-10 flex items-center justify-center opacity-0">
                <h3 class="h3 text-white text-3xl font-medium scale-0 opacity-0 text-center"><?= $post->post_title ?></h3>
              </div>
            </a>
          </div>
      <?php
        endforeach;
      endif;
      ?>
    </div>
  </div>
</article>