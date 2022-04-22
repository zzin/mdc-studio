<?php
get_header();
?>
<main id="primary" class="site-main" data-barba="container" data-barba-namespace="page-home">
  <div class="swiper" data-component="swiper-horizontal">
    <div class="swiper-wrapper">
      <?php
      $portfolios = get_field('slide');
      if (isset($portfolios)) :
        foreach ($portfolios as $portfolio) :
          $featuredImageUrl = get_the_post_thumbnail_url($portfolio->ID, 'full');
          echo '
          <div class="swiper-slide">
            <div class="swiper-slide-bg" style="background-image:url(' . $featuredImageUrl . ')"></div>
          </div>
          ';
        endforeach;
      endif;
      ?>
    </div>
  </div>
  <div class="container-full py-10">
    <h2 class="text-5xl text-black font-semibold mb-6">May you be worthy of your life.</h2>
    <h3 class="text-xl">당신의 삶속에 가치있게 깃들길</h3>
  </div>
  <div class="container-full mb-4">
    <div class="relative">
      <div class="relative columns-1 md:columns-2 lg:columns-3 gap-4">
        <?php
        $boxClass = array(
          'sm',
          'lg',
          'lg',

          'lg',
          'lg',
          'sm',

          'lg',
          'sm',
          'lg'
        );


        $arrClass = array(
          'aspect-w-16 aspect-h-9',
          'aspect-w-1 aspect-h-1 mt-4',
          'aspect-w-1 aspect-h-1 mt-4',
          'aspect-w-1 aspect-h-1 mt-4 lg:mt-0',
          'aspect-w-1 aspect-h-1 mt-4',
          'aspect-w-16 aspect-h-9 mt-4',
          'aspect-w-1 aspect-h-1 mt-4 lg:mt-0',
          'aspect-w-16 aspect-h-9 mt-4',
          'aspect-w-1 aspect-h-1 mt-4'
        );

        $posts = get_posts(array(
          'post_type'       => 'portfolio',
          'post_status'     => 'publish',
          'posts_per_page'  => 9,
        ));
        if ($posts) :
          $num = 0;
          foreach ($posts as $post) :
            $postImage = get_the_post_thumbnail_url($post->ID, 'full');
            $wrpClass = ($num === 0) ? '' : 'mt-4';
            $bgImg = ($boxClass[$num++] === 'sm') ? 'empty-hd.png' : 'empty.png';
            echo '
              <div class="photo--wrap relative overflow-hidden ' . $wrpClass . '">
                <img src="' . get_stylesheet_directory_uri() . '/assets/public/images/' . $bgImg . '">
                <img class="photo--wrap-img w-full object-cover absolute inset-0" src="' . $postImage . '">
                <a href="' . get_permalink($post->ID) . '">
                  <div class="photo--wrap-title absolute inset-0 bg-black/80 z-10 flex items-center justify-center opacity-0">
                    <h3 class="h3 text-white text-3xl font-medium scale-0 opacity-0 text-center">' . $post->post_title . '</h3>
                  </div>
                </a>
              </div>
              ';

          // echo '
          // <div class="photo--wrap relative overflow-hidden ' . $arrClass[$num++] . '">
          //   <img class="photo--wrap-img w-full object-cover" src="' . $postImage . '">
          //   <div class="photo--wrap-title absolute inset-0 bg-black/80 z-10 flex items-center justify-center opacity-0">
          //     <h3 class="h3 text-white text-3xl font-medium scale-0 opacity-0 text-center">' . $post->post_title . '</h3>
          //   </div>
          // </div>
          // ';
          endforeach;
        endif;
        ?>

      </div>
    </div>
  </div>
</main><!-- #main -->

<?php
get_footer();
