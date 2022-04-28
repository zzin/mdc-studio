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
    the_title('<h2 class="content-title text-3xl font-medium text-black">', '</h2>');
    $categories = get_the_category();
    echo '<xmp>';
    print_r($categories);
    echo '</xmp>';
    if (!empty($categories)) {
      foreach ($categories as $category) :
        echo '<xmp>';
        print_r($category);
        echo '</xmp>';
        echo '<span>' . $category . '</span>';
      endforeach;
    }
  }
endif;
