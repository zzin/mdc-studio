<?php

if (!defined('ABSPATH')) exit;

// show featured images in dashboard

add_filter('manage_resume_posts_columns', 'zeein_manage_resume_posts_columns');
function zeein_manage_resume_posts_columns($columns)
{
  $columns['zeein_thumb'] = __('Featured Image');
  wh_log($columns);
  return $columns;
}
add_action('manage_resume_posts_custom_column', 'zeein_show_post_thumbnail_column', 5, 2);
function zeein_show_post_thumbnail_column($columns, $id)
{
  switch ($columns) {
    case 'zeein_thumb':
      if (function_exists('the_post_thumbnail')) {
        echo the_post_thumbnail('thumbnail');
      }
  }
}

// 채용의뢰서
if (!function_exists('zeein_company_table_head')) {
  function zeein_company_table_head($defaults)
  {
    $defaults['print'] = 'Print';
    $defaults['together'] = '협력학교';
    $defaults['since'] = '모집기간';
    unset($defaults['date']);
    $defaults['date'] = '작성날짜';
    return $defaults;
  }
  add_filter('manage_company_posts_columns', 'zeein_company_table_head');
}

if (!function_exists('zeein_manage_edit_company_sortable_columns')) {
  function zeein_manage_edit_company_sortable_columns($columns)
  {
    $columns['since'] = 'method_deadline';
    return $columns;
  }
  add_filter('manage_edit-company_sortable_columns', 'zeein_manage_edit_company_sortable_columns');
}

if (!function_exists('zeein_company_table_content')) {
  function zeein_company_table_content($column_name, $post_id)
  {
    global $wpdb;
    if ($column_name === 'print') {
      echo '<button type="button" class="button button-print" id="company-' . $post_id . '">자세히보기</button>';
    }
    if ($column_name === 'together') {
      $field_key = 'field_61e91680a7bd1';
      $chkField = get_field_object($field_key, $post_id);
      $chkValue = get_field($field_key, $post_id);
      echo '<ul class="flex flex-row -mx-1">';
      foreach ((array)$chkField['choices'] as $choice => $value) {
        $class = '';
        if (in_array($choice, (array)$chkValue)) {
          $class = 'bg-primary text-white';
        }
        echo '<li class="px-1 m-0"><span class="text-xs p-1 rounded-md ' . $class . '">' . $value . '</span></li>';
      }
      echo '</ul>';
    }
    if ($column_name === 'since') {
      $since = (string)get_field('field_601537292b002', $post_id);
      $today = date('Y/m/d');
      $strSince = strtotime($since);
      $strToday = strtotime($today);
      if ($strSince < $strToday) {
        echo '<span class="text-slate-400 line-through">' . $since . '</span>';
      } else {
        echo '<span class="font-medium text-black">' . $since . '</span>';
      }
    }
  }
  add_action('manage_company_posts_custom_column', 'zeein_company_table_content', 10, 2);
}
// 정렬하기
function zeein_pre_get_posts($query)
{
  if (!is_admin()) return;
  $orderby = $query->get('orderby');
  if ($orderby === 'method_deadline') {
    $query->set('meta_key', 'method_deadline');
    $query->set('orderby', 'meta_value_num');
  }
}
add_action('pre_get_posts', 'zeein_pre_get_posts');

// 이력서 및 자소서
if (!function_exists('zeein_resume_table_head')) {
  function zeein_resume_table_head($defaults)
  {
    $defaults['print'] = 'Print';
    unset($defaults['date']);
    $defaults['date'] = 'Date';
    return $defaults;
  }
  add_filter('manage_resume_posts_columns', 'zeein_resume_table_head');
}

if (!function_exists('zeein_resume_table_content')) {
  function zeein_resume_table_content($column_name, $post_id)
  {
    if ($column_name == 'print') {
      echo '<button type="button" class="button button-print" id="resume-' . $post_id . '">자세히보기</button>';
    }
  }
  add_action('manage_resume_posts_custom_column', 'zeein_resume_table_content', 10, 2);
}

// 재학생 : 면접후기
if (!function_exists('zeein_interview_table_head')) {
  function zeein_interview_table_head($defaults)
  {
    $defaults['print'] = 'Print';
    unset($defaults['date']);
    $defaults['date'] = 'Date';
    return $defaults;
  }
  add_filter('manage_interview_posts_columns', 'zeein_interview_table_head');
}

if (!function_exists('zeein_interview_table_content')) {
  function zeein_interview_table_content($column_name, $post_id)
  {
    if ($column_name == 'print') {
      echo '<button type="button" class="button button-print" id="interview-' . $post_id . '">자세히보기</button>';
    }
  }
  add_action('manage_interview_posts_custom_column', 'zeein_interview_table_content', 10, 2);
}

// 재학생 : 합격자 수기
if (!function_exists('zeein_pass_table_head')) {
  function zeein_pass_table_head($defaults)
  {
    $defaults['print'] = 'Print';
    unset($defaults['date']);
    $defaults['date'] = 'Date';
    return $defaults;
  }
  add_filter('manage_pass_posts_columns', 'zeein_pass_table_head');
}

if (!function_exists('zeein_pass_table_content')) {
  function zeein_pass_table_content($column_name, $post_id)
  {
    if ($column_name == 'print') {
      echo '<button type="button" class="button button-print" id="pass-' . $post_id . '">자세히보기</button>';
    }
  }
  add_action('manage_pass_posts_custom_column', 'zeein_pass_table_content', 10, 2);
}
