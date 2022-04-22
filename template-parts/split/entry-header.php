<?php
$headerTitle = trim(get_the_title());
$headerBg = wp_get_attachment_image_src(get_post_thumbnail_id($post->post_parent), 'single-post-thumbnail');
?>
<header class="entry-header h-96 flex items-center justify-center relative bg-black overflow-hidden">
  <img src="<?= $headerBg[0] ?>" class="w-full h-full object-cover" alt="">
  <div class="absolute inset-0 flex items-center justify-center">
    <h2 class=" text-6xl font-medium z-10 text-white uppercase"><?= $headerTitle; ?></h2>
  </div>
</header>