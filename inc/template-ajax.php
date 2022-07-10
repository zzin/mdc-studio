<?php
// ajax

function zeein_saveRequest_ajax_handler()
{
  check_ajax_referer('zeein-save', 'security');
  parse_str($_POST['data'], $postArray);
  $companyName      = $postArray['company-name'];
  $companyManager   = $postArray['company-manager'];
  $companyPhone     = $postArray['company-phone'];
  $companyEmail     = $postArray['company-email'];

  $projectScope     = $postArray['scope'];
  $projectComment     = $postArray['project-comment'];

  $rtnMsg = '';
  $rtnMsg .= '회사명 : ' . $companyName . '<br />';
  $rtnMsg .= '담당자 : ' . $companyManager . '<br />';
  $rtnMsg .= '연락처 : ' . $companyPhone . '<br />';
  $rtnMsg .= '이메일 : ' . $companyEmail . '<br />';
  $rtnMsg .= '<hr />';
  $rtnMsg .= $projectComment;

  $savePost = array(
    'post_title'        => wp_strip_all_tags($companyName . ' - ' . implode('/', $projectScope) . ' [' . $companyManager . '] ' . $companyPhone . '(' . $companyEmail . ')'),
    'post_content'      => $rtnMsg,
    'post_status'       => 'pending',
    'post_type'         => 'request',
  );
  $postId = wp_insert_post($savePost, true);
  if ($postId) {
    echo 'success';
  } else {
    echo 'fail';
  }
  wp_die();
}
add_action('wp_ajax_saveRequest', 'zeein_saveRequest_ajax_handler');
add_action('wp_ajax_nopriv_saveRequest', 'zeein_saveRequest_ajax_handler');
