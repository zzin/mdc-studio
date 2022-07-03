<?php

add_filter('big_image_size_threshold', '__return_false');

class KboardObj
{
  public $uid;
  public $link;
  public $title;
  public $signdate;
}

function GetKboard($uid = 1, $num = 5, $link)
{
  global $wpdb;
  $rtnArray = [];
  $results = $wpdb->get_results('SELECT * FROM wp_kboard_board_content WHERE board_id=' . $uid . ' AND status !="trash"  ORDER BY date DESC LIMIT ' . $num);

  if ($results) {
    foreach ($results as $post) {
      $kboardObj = new KboardObj();
      $kboardObj->uid = $post->uid;
      $kboardObj->title = $post->title;
      $kboardObj->signdate = date('Y-m-d', strtotime($post->date));
      $kboardObj->link = $link . '?uid=' . $post->uid . '&mod=document';
      $rtnArray[] = $kboardObj;
    }
  }
  return $rtnArray;
}

if (!function_exists('zeein_posted_title')) :
  function zeein_posted_title()
  {
    the_title('<h2 class="content-title text-4xl font-medium text-black mb-4">', '</h2>');

    $taxonomy = get_the_terms(get_the_ID(), 'portfoliotax');
    if ($taxonomy && !is_wp_error($taxonomy)) {
      $taxonomy_name = array();
      foreach ($taxonomy as $term) {
        $taxonomy_name[] = $term->name;
      }
      $say_taxonomy = join(', ', $taxonomy_name);
      printf('<h3 class="text-xl font-medium mb-2 text-black"><span class="font-normal text-slate-500">Category : </span>%s</h3>', esc_html(strtoupper($say_taxonomy)));
    }

    $tags = get_the_terms(get_the_ID(), 'portfoliotag');
    if ($tags && !is_wp_error($tags)) {
      $tags_name = array();
      foreach ($tags as $term) {
        $tags_name[] = $term->name;
      }
      $say_terms = join(', ', $tags_name);
      printf('<h3 class="text-xl font-medium mb-2 text-black"><span class="font-normal text-slate-500">Tag : </span>%s</h3>', esc_html(strtoupper($say_terms)));
    }
  }
endif;
