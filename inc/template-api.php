<?php
// https://artisansweb.net/how-to-use-application-passwords-in-wordpress-for-rest-api-authentication/
add_filter('wp_is_application_passwords_available', '__return_true');

// 이미지 scaled 조절하는것 막기
function gc_big_image_size_threshold($threshold)
{
  return 9999; // new threshold
}
add_filter('big_image_size_threshold', 'gc_big_image_size_threshold', 100, 1);

// 파일 업로드시 파일 이름 랜덤하게 바꾸기
add_filter('wp_handle_upload_prefilter', 'custom_upload_filter');
function custom_upload_filter($file)
{
  $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
  if ($fileExtension) {
    $file['name'] = date('YmdHis') . rand(10, 99) . '.' . $fileExtension;
  }
  return $file;
}

add_action("rest_insert_company", function (\WP_Post $post, $request, $creating) {
  $metas = $request->get_param("meta");
  if (is_array($metas)) {
    foreach ($metas as $name => $value) {
      update_post_meta($post->ID, $name, $value);
    }
  }
}, 10, 3);
