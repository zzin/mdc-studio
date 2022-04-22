<?php

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
