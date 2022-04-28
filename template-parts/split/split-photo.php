<div class="photo--wrap relative overflow-hidden <?= $args['class'] ?>">
  <img src="<?= get_stylesheet_directory_uri() ?>/assets/public/images/<?= $args['bg'] ?>">
  <img class="photo--wrap-img w-full object-cover absolute inset-0" src="<?= $args['img'] ?>">
  <a href="<?= get_permalink($args['post']->ID) ?>">
    <div class="photo--wrap-title absolute inset-0 bg-black/80 z-10 flex items-center justify-center opacity-0">
      <h3 class="h3 text-white text-3xl font-medium scale-0 opacity-0 text-center"><?= $args['post']->post_title ?></h3>
    </div>
  </a>
</div>