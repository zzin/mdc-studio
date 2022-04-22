<?php
if (!function_exists('ilshin_calendar_admin_menu')) {
  function ilshin_calendar_admin_menu()
  {
    $zeeinSlug = 'edit.php?post_type=reservation';
    add_submenu_page(
      $zeeinSlug,
      __('일신상담예약', 'zeein'),
      __('달력보기', 'zeein'),
      'edit_posts',
      'ilshin_calendar_view',
      'ilshin_calendar_view',
    );
  }
}
add_action('admin_menu', 'ilshin_calendar_admin_menu');

function zeein_get_current_url()
{
  return (is_ssl() ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function ilshin_calendar_view()
{
  $currentUrl = zeein_get_current_url();
  echo '
  <div class="wrap">
  <h1 class="wp-heading-inline">구직상담 예약현황</h1>
  <hr class="wp-header-end mb-3" />';

  date_default_timezone_set('Asia/Seoul');
  // echo date('Y-m-d H:i:s');
  $date = time();
  $day = date('d', $date);
  $month = isset($_GET['month']) ? sprintf('%02d', $_GET['month']) : date('m', $date);
  $year = isset($_GET['year']) ? $_GET['year'] : date('Y', $date);

  $currentToday = date('Y', $date) . date('m', $date) . date('d', $date);
  $currentMonth = '<a href="' . $currentUrl . '&year=' . date('Y', $date) . '&month=' . date('m', $date) . '">오늘기준</a>';
  $first_day = mktime(0, 0, 0, $month, 1, $year);
  $title = date('m', $first_day);
  $day_of_week = date('D', $first_day);
  switch ($day_of_week) {
    case "Sun":
      $blank = 0;
      break;
    case "Mon":
      $blank = 1;
      break;
    case "Tue":
      $blank = 2;
      break;
    case "Wed":
      $blank = 3;
      break;
    case "Thu":
      $blank = 4;
      break;
    case "Fri":
      $blank = 5;
      break;
    case "Sat":
      $blank = 6;
      break;
  }
  $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
  if ($month == 1) {
    $prevMonth = '<a class="link-quick text-xl" href="' . $currentUrl . '&year=' . ($year - 1) . '&month=12">이전달</a>';
  } else {
    $prevMonth = '<a class="link-quick text-xl" href="' . $currentUrl . '&year=' . $year . '&month=' . ($month - 1) . '">이전달</a>';
  }

  if ($month == 12) {
    $nextMonth = '<a class="link-quick text-xl" href="' . $currentUrl . '&year=' . ($year + 1) . '&month=1">다음달</a>';
  } else {
    $nextMonth = '<a class="link-quick text-xl" href="' . $currentUrl . '&year=' . $year . '&month=' . ($month + 1) . '">다음달</a>';
  }

  echo '<table class="table-zeein w-full border-collapse border border-slate-400">';
  echo '<colgroup><col style="width:14.28%;" /><col style="width:14.28%;" /><col style="width:14.28%;" /><col style="width:14.28%;" /><col style="width:14.28%;" /><col style="width:14.28%;" /><col style="width:14.28%;" /></colgroup>';
  echo '<thead class="text-center"><tr><th class="border border-slate-300" colspan="2">' . $prevMonth . '</th><th class="border border-slate-300" colspan="3"><h3 class="text-2xl font-semibold m-0">' . $year . '</h3><h4 class="text-4xl text-blue-600 font-semibold m-1">' . $title . '</h4>' . $currentMonth . '</th><th colspan="2" class="border border-slate-300">' . $nextMonth . '</th></tr><tr><th class="border border-slate-300">일</th><th class="border border-slate-300">월</th><th class="border border-slate-300">화</th><th class="border border-slate-300">수</th><th class="border border-slate-300">목</th><th class="border border-slate-300">금</th><th class="border border-slate-300">토</th></tr></thead>';
  $day_count = 1;
  if ($month - 1 !== 0) {
    $last_month = $month - 1;
  } else {
    $last_month = 12;
  }
  // if ($last_month == '12') {
  //   $year = $year - 1;
  // }

  $last_month_first_day = mktime(0, 0, 0, $last_month, 1, $year);
  // $last_month_days_in_month = cal_days_in_month(0, $last_month, $year);
  $last_month_days_in_month = date('t', mktime(0, 0, 0, $last_month, 1, $year));
  $last_month_day_of_week = date('D', $last_month_days_in_month);
  $last_month_days_to_add_to_last_month_end = $blank;
  $last_month_end = $last_month_days_in_month - $last_month_days_to_add_to_last_month_end;

  while ($blank > 0) {
    $last_month_end++;
    $addClassBg = '';
    if ($day_count == 1) {
      $addClassBg = 'bg-sun';
    } else if ($day_count == 7) {
      $addClassBg = 'bg-sat';
    }
    echo '<td class="' . $addClassBg . ' border border-slate-300"><span class="dummy">' . sprintf('%02d', $last_month_end) . '</span></td>';
    $blank = $blank - 1;
    $day_count++;
  }

  $day_num = 1;
  while ($day_num <= $days_in_month) {
    $dataVar = $year . $month . str_pad($day_num, '2', '0', STR_PAD_LEFT);
    $addClass = '';
    if ($dataVar == $currentToday) {
      $addClass = 'current';
    }

    $args = array(
      'posts_per_page' => -1,
      'post_type'     => 'reservation',
      'post_status'   => array('publish', 'pending', 'private'),
      'meta_query'    => array(
        array(
          'key'       => 'date',
          'compare'   => '=',
          'value'     => $dataVar,
        ),
      ),
      'meta_key'      => 'time',
      'orderby'       => 'meta_value',
      'order'         => 'ASC',
    );

    $the_query = new WP_Query($args);
    $rtn = '';
    if ($the_query->have_posts()) :
      $rtn = '<ul class="ul-has">';
      while ($the_query->have_posts()) : $the_query->the_post();
        $name = get_field('name');
        $time = get_field('time', false, false);
        $status = get_post_status();
        $rtn .= '<li class="item status-' . $status . '"><i class="point"></i><em>' . $time . '</em> ' . $name . '</li>';
      endwhile;
      $rtn .= '</ul>';
    endif;
    wp_reset_postdata();

    $addClassBg = '';
    if ($day_count == 1) {
      $addClassBg = ' bg-sun';
    } else if ($day_count == 7) {
      $addClassBg = ' bg-sat';
    }
    echo '<td class="item ' . $addClass . $addClassBg . ' border border-slate-300"><a href="#" class="link ' . $addClass . '" data-var="' . $dataVar . '">' . sprintf('%02d', $day_num) . '</a>' . $rtn . '</td>';
    $day_num++;
    $day_count++;

    if ($day_count > 7) {
      echo '</tr><tr>';
      $day_count = 1;
    }
  }

  $end_days = 1;
  while ($day_count > 1 && $day_count <= 7) {
    $addClassBg = '';
    if ($day_count == 1) {
      $addClassBg = 'bg-sun';
    } else if ($day_count == 7) {
      $addClassBg = 'bg-sat';
    }
    echo '<td class="' . $addClassBg . ' border border-slate-300"><span class="dummy">' . sprintf('%02d', $end_days) . '</span></td>';
    $day_count++;
    $end_days++;
  }
  echo '</table>';
  echo '<div class="legend mt-4"><ul class="ul-has"><li class="item status-pending"><i class="point"></i>예약 확인</li><li class="item status-publish"><i class="point"></i>발행됨 : 비밀글 체크(검색엔진 비노출)</li><li class="item status-private"><i class="point"></i>비밀글 : 예약 확정</li></ul></div>';
  echo '</div><!-- wrap -->';
}
