<?php
// ajax
add_action('wp_ajax_nopriv_zeein_print_by_ajax', 'zeein_print_by_ajax');
add_action('wp_ajax_zeein_print_by_ajax', 'zeein_print_by_ajax');

if (!function_exists('zeein_print_by_ajax')) {
  function zeein_print_by_ajax()
  {
    $targetId = $_POST['target'];
    $targetPost = $_POST['post'];
    // 채용정보
    if ($targetPost === 'company') {
      $company_type_field         = @get_field_object('company_type', $targetId);
      $company_type_value         = @get_field('company_type', $targetId);
      $company_type               = $company_type_field['choices'][$company_type_value];

      $company_post               = @get_field('company_post', $targetId);
      $company_address1           = @get_field('company_address1', $targetId);
      $company_address2           = @get_field('company_address2', $targetId);

      $employee_educate_field     = @get_field_object('employee_educate', $targetId);
      $employee_educate_value     = @get_field('employee_educate', $targetId);

      $employee_document_field    = @get_field_object('employee_document', $targetId);
      $employee_document_value    = @get_field('employee_document', $targetId);

      $work_overtime_field        = @get_field_object('work_overtime', $targetId);
      $work_overtime_value        = @get_field('work_overtime', $targetId);
      $work_overtime              = $work_overtime_field['choices'][$work_overtime_value];

      $work_saturday_field        = @get_field_object('work_saturday', $targetId);
      $work_saturday_value        = @get_field('work_saturday', $targetId);
      $work_saturday              = $work_saturday_field['choices'][$work_saturday_value];

      $work_sunday_field          = @get_field_object('work_sunday', $targetId);
      $work_sunday_value          = @get_field('work_sunday', $targetId);
      $work_sunday                = $work_sunday_field['choices'][$work_sunday_value];

      $pay_month_field            = @get_field_object('pay_month', $targetId);
      $pay_month_value            = @get_field('pay_month', $targetId);
      $pay_month                  = $pay_month_field['choices'][$pay_month_value];

      $pay_etc_field              = @get_field_object('pay_etc', $targetId);
      $pay_etc_value              = @get_field('pay_etc', $targetId);

      $method_type_field          = @get_field_object('method_type', $targetId);
      $method_type_value          = @get_field('method_type', $targetId);

      $method_document_field      = @get_field_object('method_document', $targetId);
      $method_document_value      = @get_field('method_document', $targetId);

      // $method_document_etc_field  = @get_field_object('method_document-etc', $targetId);
      // $method_document_etc_value  = @get_field('method_document_etc', $targetId);

      $companyArray = [
        'company_name'            => @get_field('company_name', $targetId),
        'company_type'            => $company_type,
        'company_address'         => '[' . $company_post . '] ' . $company_address1 . ' ' . $company_address2,
        'company_tel'             => @get_field('company_tel', $targetId),
        'company_logo'            => @get_field('company_logo', $targetId)['url'],
        'company_total'           => @get_field('company_total', $targetId),
        'company_regular'         => @get_field('company_regular', $targetId),
        'incharge_name'           => @get_field('incharge_name', $targetId),
        'incharge_position'       => @get_field('incharge_position', $targetId) ? '[' . @get_field('incharge_position', $targetId) . ']' : '',
        'incharge_email'          => @get_field('incharge_email', $targetId),
        'incharge_homepage'       => @get_field('incharge_homepage', $targetId),
        'incharge_task'           => @get_field('incharge_task', $targetId),
        'employee_regular'        => @get_field('employee_regular', $targetId),
        'employee_temporary'      => @get_field('employee_temporary', $targetId),
        'employee_recommend'      => @get_field('employee_recommend', $targetId),
        'employee_educate'        => $employee_educate_field['choices'],
        'employee_scores'         => @get_field('employee_scores', $targetId),
        'employee_certificate'    => @get_field('employee_certificate', $targetId),
        'employee_document'       => $employee_document_field['choices'],
        'employee_attach'         => @get_field('employee_attach', $targetId)['url'],
        'work_time_start'         => @get_field('work_time_start', $targetId),
        'work_time_end'           => @get_field('work_time_end', $targetId),
        'work_overtime'           => $work_overtime,
        'work_saturday'           => $work_saturday,
        'work_sunday'             => $work_sunday,
        'pay_month'               => $pay_month,
        'pay_annual'              => @get_field('pay_annual', $targetId),
        'pay_probation'           => @get_field('pay_probation', $targetId),
        'pay_money'               => @get_field('pay_money', $targetId),
        'pay_etc'                 => $pay_etc_field['choices'],
        'method_type'             => $method_type_field['choices'],
        'method_etc'              => @get_field('method_etc', $targetId) ? '(' . @get_field('method_etc', $targetId) . ')' : '',
        'method_deadline'         => @get_field('method_deadline', $targetId),
        'method_document'         => $method_document_field['choices'],
        'method_document_etc'     => @get_field('method_document_etc', $targetId) ? '(' . @get_field('method_document_etc', $targetId) . ')' : '',
        'note'                    => @get_field('note', $targetId),
      ];

      $rtn = '<section class="section">';
      $rtn .= '<h1>채&nbsp;&nbsp;용&nbsp;&nbsp;의&nbsp;&nbsp;뢰&nbsp;&nbsp;서</h1>';

      $rtn .= '<h2>회사정보</h2>';
      $rtn .= '<table class="table-print">';
      $rtn .= '<colgroup><col style="width: 10%;" /><col style="width: 40%;" /><col style="width: 10%;" /><col style="width: 40%;" /></colgroup>';
      $rtn .= '<tr><th>회사명</th><td>' . $companyArray['company_name'] . '</td><th>업종</th><td>' . $companyArray['company_type'] . '</td></tr>';
      $rtn .= '<tr><th>회사주소</th><td colspan="3">' . $companyArray['company_address'] . '</td></tr>';
      $rtn .= '<tr><th>전화번호</th><td>' . $companyArray['company_tel'] . '</td><th>근무자</th><td> 전체 : ' . $companyArray['company_total'] . ' / 상시 : ' . $companyArray['company_regular'] . '</td></tr>';
      $rtn .= '</table>';

      $rtn .= '<h2>담당자 정보</h2>';
      $rtn .= '<table class="table-print">';
      $rtn .= '<colgroup><col style="width: 10%;" /><col style="width: 40%;" /><col style="width: 10%;" /><col style="width: 40%;" /></colgroup>';
      $rtn .= '<tr><th>이름(직책)</th><td>' . $companyArray['incharge_name'] . $companyArray['incharge_position'] . '</td><th>이메일</th><td>' . $companyArray['incharge_email'] . '</td></tr>';
      $rtn .= '<tr><th>홈페이지</th><td>' . $companyArray['incharge_homepage'] . '</td><th>담당업무</th><td>' . $companyArray['incharge_task'] . '</td></tr>';
      $rtn .= '</table>';

      $rtn .= '<h2>채용인원 및 자격</h2>';
      $rtn .= '<table class="table-print">';
      $rtn .= '<colgroup><col style="width: 10%;" /><col style="width: 23%;" /><col style="width: 10%;" /><col style="width: 23%;" /><col style="width: 10%;" /><col style="width: 24%;" /></colgroup>';
      $rtn .= '<tr><th>정규직인원</th><td>' . $companyArray['employee_regular'] . '</td><th>비정규직인원</th><td>' . $companyArray['employee_temporary'] . '</td><th>추천인원</th><td>' . $companyArray['employee_recommend'] . '</td></tr>';
      $rtn .= '<tr><th>지원자격</th><td><ul class="ul-checkbox">';
      foreach ((array)$companyArray['employee_educate'] as $choice => $value) {
        $class = '';
        if (in_array($choice, (array)$employee_educate_value)) {
          $class = 'active';
        }
        $rtn .= '<li class="' . $choice . ' ' . $class . '">' . $value . '</li>';
      }
      $rtn .= '</ul></td><th>성적</th><td>' . $companyArray['employee_scores'] . '</td><th>자격증및기타</th><td>' . $companyArray['employee_certificate'] . '</td></tr>';
      $rtn .= '<tr><th>제출서류</th><td colspan="5"><ul class="ul-checkbox">';
      foreach ((array)$companyArray['employee_document'] as $choice => $value) {
        $class = '';
        if (in_array($choice, (array)$employee_document_value)) {
          $class = 'active';
        }
        $rtn .= '<li class="' . $choice . ' ' . $class . '">' . $value . '</li>';
      }
      $rtn .= '</ul></td></tr>';
      $rtn .= '</table>';

      $rtn .= '<h2>근무시간</h2>';
      $rtn .= '<table class="table-print">';
      $rtn .= '<colgroup><col style="width: 10%;" /><col style="width: 40%;" /><col style="width: 10%;" /><col style="width: 40%;" /></colgroup>';
      $rtn .= '<tr><th>근무시간</th><td>' . $companyArray['work_time_start'] . ' ~ ' . $companyArray['work_time_end'] . '</td><th>잔업여부</th><td>' . $work_overtime . '</td></tr>';
      $rtn .= '<tr><th>토요일 근무</th><td>' . $work_saturday . '</td><th>일요일 근무</th><td>' . $work_sunday . '</td></tr>';
      $rtn .= '</table>';

      $rtn .= '<h2>급여</h2>';
      $rtn .= '<table class="table-print">';
      $rtn .= '<colgroup><col style="width: 10%;" /><col style="width: 15%;" /><col style="width: 10%;" /><col style="width: 15%;" /><col style="width: 10%;" /><col style="width: 15%;" /><col style="width: 10%;" /><col style="width: 15%;" /></colgroup>';
      $rtn .= '<tr><th>연봉</th><td>' . $companyArray['pay_annual'] . '</td><th>수습기간</th><td>' . $companyArray['pay_month'] . '</td><th>수습급여</th><td>' . $companyArray['pay_probation'] . '</td><th>수습후 급여</th><td>' . $companyArray['pay_money'] . '</td></tr>';
      $rtn .= '<tr><th>기타수당</th><td colspan="7"><ul class="ul-checkbox">';
      foreach ((array)$companyArray['pay_etc'] as $choice => $value) {
        $class = '';
        if (in_array($choice, (array)$pay_etc_value)) {
          $class = 'active';
        }
        $rtn .= '<li class="' . $choice . ' ' . $class . '">' . $value . '</li>';
      }
      $rtn .= '</ul></td></tr>';
      $rtn .= '</table>';

      $rtn .= '<h2>전형방법 및 기타</h2>';
      $rtn .= '<table class="table-print">';
      $rtn .= '<colgroup><col style="width: 10%;" /><col style="width: 65%;" /><col style="width: 10%;" /><col style="width: 15%;" /></colgroup>';
      $rtn .= '<tr><th>전형방법</th><td><ul class="ul-checkbox">';
      foreach ((array)$companyArray['method_type'] as $choice => $value) {
        $class = '';
        if (in_array($choice, (array)$method_type_value)) {
          $class = 'active';
        }
        $rtn .= '<li class="' . $choice . ' ' . $class . '">' . $value . '</li>';
      }
      $rtn .= '</ul>' . $companyArray['method_etc'] . '</td><th>서류접수마감</th><td class="text-red-600">' . $companyArray['method_deadline'] . '</td></tr>';
      $rtn .= '<tr><th>서류접수</th><td colspan="3"><ul class="ul-checkbox">';
      foreach ((array)$companyArray['method_document'] as $choice => $value) {
        $class = '';
        if (in_array($choice, (array)$method_document_value)) {
          $class = 'active';
        }
        $rtn .= '<li class="' . $choice . ' ' . $class . '">' . $value . '</li>';
      }
      $rtn .= '</ul>' . $companyArray['method_document_etc'] . '</td></tr>';
      $rtn .= '<tr><th>특기사항</th><td colspan="3">' . $companyArray['note'] . '</td></tr>';
      $rtn .= '</table>';

      $rtn .= '</section>';
      echo $rtn;
      wp_die();
    } elseif ($targetPost === 'resume') {
      // 이력서 및 자기소개서
      $photo = @get_field('photo', $targetId);
      $nameKo = @get_field('name_ko', $targetId);
      $nameEn = @get_field('name_en', $targetId);
      $nameCn = @get_field('name_cn', $targetId);
      $birthday = @get_field('birthday', $targetId);
      $phone = @get_field('phone', $targetId);
      $email = @get_field('email', $targetId);
      $address = '[' . @get_field('post', $targetId) . ']' . @get_field('address1', $targetId) . ' ' . @get_field('address2', $targetId);

      if (have_rows('hobbies', $targetId)) {
        while (have_rows('hobbies', $targetId)) : the_row();
          $hobbyArr[] = get_sub_field('hobby');
        endwhile;
        $hobby = implode(', ', $hobbyArr);
      }
      if (have_rows('specialties', $targetId)) {
        while (have_rows('specialties', $targetId)) : the_row();
          $specialtyArr[] = get_sub_field('specialty');
        endwhile;
        $specialty = implode(', ', $specialtyArr);
      }

      $rtn = '<section class="section">';
      $rtn .= '<h1>이&nbsp;&nbsp;력&nbsp;&nbsp;서</h1>';
      $rtn .= '<h2>기본정보</h2>';
      $rtn .= '<ul class="ul-table"><li class="photo"><figure><div class="bg-image" style="background-image:url(' . $photo['url'] . ');"></div></figure></li><li class="info">';
      $rtn .= '<table class="table-print"><colgroup><col style="width:8%;" /><col style="width:7%;" /><col style="width:35%;" /><col style="width:15%;" /><col style="width:35%;" /></colgroup>';
      $rtn .= '<tr><th rowspan="3">이름</th><th>한글</th><td>' . $nameKo . '</td><th>생년월일</th><td>' . $birthday . '</td></tr>';
      $rtn .= '<tr><th>한자</th><td>' . $nameCn . '</td><th>핸드폰</th><td>' . $phone . '</td></tr>';
      $rtn .= '<tr><th>영문</th><td>' . $nameEn . '</td><th>이메일</th><td>' . $email . '</td></tr>';
      $rtn .= '<tr><th colspan="2">주소</th><td colspan="3">' . $address . '</td></td></tr>';
      $rtn .= '<tr><th colspan="2">취미</th><td>' . $hobby . '</td></td><th>특기</th><td>' . $specialty . '</td></tr>';
      $rtn .= '</table>';
      $rtn .= '</li></ul>';

      if (have_rows('education', $targetId)) {
        $rtn .= '<h2>학력사항</h2>';
        $rtn .= '<table class="table-print">';
        $rtn .= '<colgroup><col style="width: 25%;"/><col style="width: 35%;" /><col style="width: 20%;" /><col style="width: 20%;" /></colgroup>';
        $rtn .= '<thead><tr><th>재학기간</th><th>학교명</th><th>전공</th><th>소재지</th></tr></thead>';
        $rtn .= '<tbody>';
        while (have_rows('education', $targetId)) : the_row();
          $period = @get_sub_field('period');
          $school = @get_sub_field('school');
          $major = @get_sub_field('major');
          $location = @get_sub_field('location');
          $rtn .= '<tr><td>' . $period . '</td><td>' . $school . '</td><td>' . $major . '</td><td>' . $location . '</td></tr>';
        endwhile;
        $rtn .= '</tbody>';
        $rtn .= '</table>';
      }

      if (have_rows('certification', $targetId)) {
        $rtn .= '<h2>자격증</h2>';
        $rtn .= '<table class="table-print">';
        $rtn .= '<colgroup><col style="width: 40%;"/><col style="width: 20%;" /><col style="width: 20%;" /><col style="width: 20%;" /></colgroup>';
        $rtn .= '<thead><tr><th>자격증명/시험명</th><th>등급</th><th>취득일자</th><th>발행기관</th></tr></thead>';
        $rtn .= '<tbody>';
        while (have_rows('certification', $targetId)) : the_row();
          $name = get_sub_field('name');
          $level = get_sub_field('level');
          $date = get_sub_field('date');
          $issuer = get_sub_field('issuer');
          $rtn .= '<tr><td>' . $name . '</td><td>' . $level . '</td><td>' . $date . '</td><td>' . $issuer . '</td></tr>';
        endwhile;
        $rtn .= '</tbody>';
        $rtn .= '</table>';
      }

      if (have_rows('awards', $targetId)) {
        $rtn .= '<h2>수상경력</h2>';
        $rtn .= '<table class="table-print">';
        $rtn .= '<colgroup><col style="width: 30%;"/><col style="width: 20%;" /><col style="width: 20%;" /><col style="width: 30%;" /></colgroup>';
        $rtn .= '<thead><tr><th>대회명/교육명</th><th>수상내용/교육내용</th><th>수상일자/교육기관</th><th>수여기관/시행기괸</th></tr></thead>';
        $rtn .= '<tbody>';
        while (have_rows('awards', $targetId)) : the_row();
          $name = get_sub_field('name');
          $details = get_sub_field('details');
          $since = get_sub_field('since');
          $agency = get_sub_field('agency');
          $rtn .= '<tr><td>' . $name . '</td><td>' . $details . '</td><td>' . $since . '</td><td>' . $agency . '</td></tr>';
        endwhile;
        $rtn .= '</tbody>';
        $rtn .= '</table>';
      }

      if (have_rows('volunteer', $targetId)) {
        $rtn .= '<h2>주요활동 및 경험(봉사활동, 동아리 활동 등)</h2>';
        $rtn .= '<table class="table-print">';
        $rtn .= '<colgroup><col style="width: 30%;"/><col style="width: 10%;" /><col style="width: 20%;" /><col style="width: 40%;" /></colgroup>';
        $rtn .= '<thead><tr><th>활동기간</th><th>구분</th><th>활동기관</th><th>활동내용</th></tr></thead>';
        $rtn .= '<tbody>';
        while (have_rows('volunteer', $targetId)) : the_row();
          $since = get_sub_field('since');
          $type = get_sub_field('type');
          $issuer = get_sub_field('issuer');
          $details = get_sub_field('details');
          $rtn .= '<tr><td>' . $since . '</td><td>' . $type . '</td><td>' . $issuer . '</td><td>' . $details . '</td></tr>';
        endwhile;
        $rtn .= '</tbody>';
        $rtn .= '</table>';
      }
      $rtn .= '</section>';
      $rtn .= '<section class="section">';
      $rtn .= '<h1>자&nbsp;&nbsp;기&nbsp;&nbsp;소&nbsp;&nbsp;개&nbsp;&nbsp;서</h1>';
      if ($growth = @get_field('growth', $targetId)) {
        $rtn .= '<h2>성장과정</h2>';
        $rtn .= '<table class="table-print"><tr><td class="description">' . $growth . '</td></tr></table>';
      }
      if ($character = @get_field('character', $targetId)) {
        $rtn .= '<h2>성격 및 장단점</h2>';
        $rtn .= '<table class="table-print"><tr><td class="description">' . $character . '</td></tr></table>';
      }
      if ($life = @get_field('life', $targetId)) {
        $rtn .= '<h2>학교생활</h2>';
        $rtn .= '<table class="table-print"><tr><td class="description">' . $life . '</td></tr></table>';
      }
      if ($motive = @get_field('motive', $targetId)) {
        $rtn .= '<h2>지원동기 및 입사 후 포부</h2>';
        $rtn .= '<table class="table-print"><tr><td class="description">' . $motive . '</td></tr></table>';
      }

      $rtn .= '<h5>상기 기재사항이 사실과 다름없음을 확인합니다.</h5>';
      $rtn .= '</section>';
      echo $rtn;
      wp_die();
    } elseif ($targetPost === 'interview') {
      // 재학생 : 면접후기
      $company = @get_field('company', $targetId);
      $student_id = @get_field('student_id', $targetId);
      $student_name = @get_field('student_name', $targetId);
      $interview_date = @get_field('interview_date', $targetId);
      $interview_location = @get_field('interview_location', $targetId);
      $interview_time = @get_field('interview_time', $targetId);
      $interview_method = @get_field('interview_method', $targetId);
      $interview_type = @get_field('interview_type', $targetId);
      $interview_step = @get_field('interview_step', $targetId);
      $interview_mood = @get_field('interview_mood', $targetId);
      $interview_question = @get_field('interview_question', $targetId);
      $interview_etc = @get_field('interview_etc', $targetId);
      $rtn = '<section class="section">';
      $rtn .= '<h1>면&nbsp;&nbsp;접&nbsp;&nbsp;후&nbsp;&nbsp;기</h1>';
      $rtn .= '<h2>기본정보</h2>';
      $rtn .= '<table class="table-print">';
      $rtn .= '<colgroup><col style="width: 10%;" /><col style="width: 30%;" /><col style="width: 10%;" /><col style="width: 20%;" /><col style="width: 10%;" /><col style="width: 20%;" /></colgroup>';
      $rtn .= '<tbody>';
      $rtn .= '<tr><th>회사명</th><td>' . $company . '</td><th>학번</th><td>' . $student_id . '</td><th>이름</th><td>' . $student_name . '</td></tr>';
      $rtn .= '</tbody>';
      $rtn .= '</table>';
      $rtn .= '<h2>면접정보</h2>';
      $rtn .= '<table class="table-print">';
      $rtn .= '<colgroup><col style="width: 10%;" /><col style="width: 30%;" /><col style="width: 10%;" /><col style="width: 20%;" /><col style="width: 10%;" /><col style="width: 20%;" /></colgroup>';
      $rtn .= '<tbody>';
      $rtn .= '<tr><th>면접일시</th><td>' . $interview_date . '</td><th>면접장소</th><td>' . $interview_location . '</td><th>면접시간</th><td>' . $interview_time . '</td></tr>';
      $rtn .= '<tr><th>면접방식</th><td>' . $interview_method . '</td><th>면접유형</th><td colspan="3">' . $interview_type . '</td></tr>';
      $rtn .= '<tr><th>면접절차</th><td colspan="5">' . $interview_step . '</td></tr>';
      $rtn .= '<tr><th>면접분위기</th><td colspan="5">' . $interview_mood . '</td></tr>';
      $rtn .= '<tr><th>면접질문</th><td colspan="5">' . $interview_question . '</td></tr>';
      $rtn .= '<tr><th>소감/기타</th><td colspan="5">' . $interview_etc . '</td></tr>';
      $rtn .= '</tbody>';
      $rtn .= '</table>';
      $rtn .= '</section>';
      echo $rtn;
      wp_die();
    } elseif ($targetPost === 'pass') {
      $company = @get_field('company', $targetId);
      $student_id = @get_field('student_id', $targetId);
      $student_name = @get_field('student_name', $targetId);
      $successful_document = @get_field('successful_document', $targetId);
      $successful_question = @get_field('successful_question', $targetId);
      $successful_opinion = @get_field('successful_opinion', $targetId);
      $rtn = '<section class="section">';
      $rtn .= '<h1>합&nbsp;&nbsp;격&nbsp;&nbsp;자&nbsp;&nbsp;수&nbsp;&nbsp;기</h1>';
      $rtn .= '<h2>기본정보</h2>';
      $rtn .= '<table class="table-print">';
      $rtn .= '<colgroup><col style="width: 10%;" /><col style="width: 30%;" /><col style="width: 10%;" /><col style="width: 20%;" /><col style="width: 10%;" /><col style="width: 20%;" /></colgroup>';
      $rtn .= '<tbody>';
      $rtn .= '<tr><th>회사명</th><td>' . $company . '</td><th>학번</th><td>' . $student_id . '</td><th>이름</th><td>' . $student_name . '</td></tr>';
      $rtn .= '</tbody>';
      $rtn .= '</table>';
      $rtn .= '<h2>면접정보</h2>';
      $rtn .= '<table class="table-print">';
      $rtn .= '<colgroup><col style="width: 10%;" /><col style="width: 90%;" /></colgroup>';
      $rtn .= '<tbody>';
      $rtn .= '<tr><th>면접준비</th><td>' . $successful_document . '</td></tr>';
      $rtn .= '<tr><th>질문/답변</th><td>' . $successful_question . '</td></tr>';
      $rtn .= '<tr><th>합격소감</th><td>' . $successful_opinion . '</td></tr>';
      $rtn .= '</tbody>';
      $rtn .= '</table>';
      $rtn .= '</section>';
      echo $rtn;
      die();
    }
  }
}
