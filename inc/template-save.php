<?php

if (!defined('ABSPATH')) exit;

function curl($url)
{
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $g = curl_exec($ch);
  curl_close($ch);
  return $g;
}

function get_url_fsockopen($url)
{
  $URL_parsed = parse_url($url);

  $host = $URL_parsed["host"];
  $port = $URL_parsed["port"];
  if ($port == 0)
    $port = 80;

  $path = $URL_parsed["path"];
  if ($URL_parsed["query"] != "")
    $path .= "?" . $URL_parsed["query"];

  $out = "GET $path HTTP/1.0\r\nHost: $host\r\n\r\n";

  $fp = fsockopen($host, $port, $errno, $errstr, 30);

  if (!$fp) {
    echo "$errstr ($errno)\n";
  } else {
    fputs($fp, $out);
    $body = false;
    $in = '';
    while (!feof($fp)) {
      $s = fgets($fp, 128);
      if ($body)
        $in .= $s;
      if ($s == "\r\n")
        $body = true;
    }
    fclose($fp);
    echo $in;
  }
}

function get_url_content($url)
{

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, true);

  $html = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  $inc = 1;
  while ($http_code == 301 || $http_code == 302) {
    $header = curl_getinfo($ch, CURLINFO_HEADER_OUT);
    curl_close($ch);
    list($header, $html) = explode("\n\n", $html, 2);
    preg_match('/Location: (.*?)\n/', $header, $matches);
    $url = $matches[1];
    if (strlen(trim($url)) <= 0)
      return "[" . $http_code . "] forwarding error, not found url.";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($inc++ > 5) {
      curl_close($ch);
      return "to many forwarding...";
    }
  }
  curl_close($ch);
  return substr($html, strpos($html, '<?xml'));;
}

function _themename_front_end_post()
{
  require_once(ABSPATH . 'wp-admin/includes/image.php');
  require_once(ABSPATH . 'wp-admin/includes/file.php');
  require_once(ABSPATH . 'wp-admin/includes/media.php');

  if (isset($_POST['cpt_nonce_field']) && wp_verify_nonce($_POST['cpt_nonce_field'], 'cpt_nonce_action')) {
    // wh_log($_POST);
    // wh_log($_FILES);
    $postType = $_POST['post_type'];
    if ($postType == 'company') {
      // 채용의뢰서
      $company_name           = @$_POST['company_name'];
      $company_type           = @$_POST['company_type'];
      $company_post           = @$_POST['company_post'];
      $company_address1       = @$_POST['company_address1'];
      $company_address2       = @$_POST['company_address2'];
      $company_tel            = @$_POST['company_tel'];
      $company_logo           = @$_FILES['company_logo'];
      $company_total          = @$_POST['company_total'];
      $company_regular        = @$_POST['company_regular'];
      $incharge_name          = @$_POST['incharge_name'];
      $incharge_position      = @$_POST['incharge_position'];
      $incharge_email         = @$_POST['incharge_email'];
      $incharge_homepage      = @$_POST['incharge_homepage'];
      $incharge_task          = @$_POST['incharge_task'];
      $employee_regular       = @$_POST['employee_regular'];
      $employee_temporary     = @$_POST['employee_temporary'];
      $employee_recommend     = @$_POST['employee_recommend'];
      $employee_educate       = @$_POST['employee_educate'];
      $employee_scores        = @$_POST['employee_scores'];
      $employee_certificate   = @$_POST['employee_certificate'];
      $employee_document      = @$_POST['employee_document'];
      $employee_attach        = @$_FILES['employee_attach'];
      $work_time_start        = @$_POST['work_time_start'];
      $work_time_end          = @$_POST['work_time_end'];
      $work_overtime          = @$_POST['work_overtime'];
      $work_saturday          = @$_POST['work_saturday'];
      $work_sunday            = @$_POST['work_sunday'];
      $pay_month              = @$_POST['pay_month'];
      $pay_annual             = @$_POST['pay_annual'];
      $pay_probation          = @$_POST['pay_probation'];
      $pay_money              = @$_POST['pay_money'];
      $pay_etc                = @$_POST['pay_etc'];
      $method_type            = @$_POST['method_type'];
      $method_etc             = @$_POST['method_etc'];
      $method_deadline        = @$_POST['method_deadline'];
      $method_document        = @$_POST['method_document'];
      $method_document_etc    = @$_POST['method_document_etc'];
      $note                   = @$_POST['note'];
      $chk_together           = @$_POST['chk_together'];

      // wh_log($chk_together);
      // wh_log($company_logo);
      // wh_log($employee_attach);
      // $postType              = $_POST['post_type'];

      $post_infomation = array(
        'post_title'      => wp_strip_all_tags($company_name . '[' . $company_tel . '/' . $incharge_name . ']'),
        'post_type'       => $postType,
        'post_content'    => $note,
        'post_status'     => 'pending'
      );

      $post_id = wp_insert_post($post_infomation);
      if ($post_id) {
        update_field('field_60152e182afe1', $company_name, $post_id);
        update_field('field_60152e2b2afe2', $company_type, $post_id);
        update_field('field_60152f822afe3', $company_post, $post_id);
        update_field('field_60152f992afe4', $company_address1, $post_id);
        update_field('field_60152fa32afe5', $company_address2, $post_id);
        update_field('field_60152fba2afe6', $company_tel, $post_id);
        // update_field('field_60152fc22afe7', $company_logo, $post_id);
        update_field('field_60152fd82afe8', $company_total, $post_id);
        update_field('field_60152ff82afe9', $company_regular, $post_id);
        update_field('field_601530a22afea', $incharge_name, $post_id);
        update_field('field_6015311e2afeb', $incharge_position, $post_id);
        update_field('field_601531362afec', $incharge_email, $post_id);
        update_field('field_6015313f2afed', $incharge_homepage, $post_id);
        update_field('field_6015314c2afee', $incharge_task, $post_id);
        update_field('field_6015316e2afef', $employee_regular, $post_id);
        update_field('field_601531c52aff0', $employee_temporary, $post_id);
        update_field('field_601532302aff1', $employee_recommend, $post_id);
        update_field('field_601532552aff2', $employee_educate, $post_id);
        update_field('field_6015330e2aff3', $employee_scores, $post_id);
        update_field('field_601533382aff4', $employee_certificate, $post_id);
        update_field('field_6015335d2aff5', $employee_document, $post_id);
        // update_field('field_601533cc2aff6', $employee_attach, $post_id);
        update_field('field_6015342f2aff7', $work_time_start, $post_id);
        update_field('field_60153b65d287c', $work_time_end, $post_id);
        update_field('field_601534392aff8', $work_overtime, $post_id);
        update_field('field_601534822aff9', $work_saturday, $post_id);
        update_field('field_601534de2affa', $work_sunday, $post_id);
        update_field('field_601535252affb', $pay_month, $post_id);
        update_field('field_601535f52affe', $pay_annual, $post_id);
        update_field('field_601535a72affc', $pay_probation, $post_id);
        update_field('field_601535be2affd', $pay_money, $post_id);
        update_field('field_601536432afff', $pay_etc, $post_id);
        update_field('field_601536a82b000', $method_type, $post_id);
        update_field('field_601537022b001', $method_etc, $post_id);
        update_field('field_601537292b002', $method_deadline, $post_id);
        update_field('field_6015377c2b003', $method_document, $post_id);
        update_field('field_601537ca2b004', $method_document_etc, $post_id);
        update_field('field_601537e32b005', $note, $post_id);
        update_field('field_61e91680a7bd1', $chk_together, $post_id);
      }

      $company_logo_id = null;
      if ($company_logo['name']) {
        $company_logo_id = media_handle_upload('company_logo', $post_id);
        if (is_wp_error($company_logo_id)) {
          // error
          echo '파일 저장중 오류가 발생했습니다.(logo)<br/>관리자에게 문의해 주세요.';
          wp_die();
        } else {
          // success
          update_field('field_60152fc22afe7', $company_logo_id, $post_id);
        }
      }

      $employee_attach_id = null;
      if ($employee_attach['name']) {
        $employee_attach_id = media_handle_upload('employee_attach', $post_id);
        if (is_wp_error($employee_attach_id)) {
          // error
          echo '파일 저장중 오류가 발생했습니다.(attach)<br/>관리자에게 문의해 주세요.';
          wp_die();
        } else {
          // success
          update_field('field_601533cc2aff6', $employee_attach_id, $post_id);
        }
      }

      // 채용의뢰서 협력학교 저장
      // https://ksmediajob.com/wp-json/wp/v2/company
      // REST API를 이용한 저장
      // 기본 접속정보

      $cnt = count($chk_together);
      if ($cnt > 1) {
        // 협력학교에 다른 학교가 체크되어 있다면

        $companyLogoId = null;
        $employeeAttachId = null;

        $username = 'recruit';
        $app = array(
          'yn' => array(
            'password'  => '1vfj 8u3n Cupu hdIR q7mu x4lS',
            'url'       => 'https://youngnakjob.com/wp-json/wp/v2/company',
            'urlMedia'  => 'https://youngnakjob.com/wp-json/wp/v2/media/'
          ),
          'ks' => array(
            'password'  => '1dR5 8CjP dfEM Zo9I vOmB yk4n',
            'url'       => 'https://ksmediajob.com/wp-json/wp/v2/company',
            'urlMedia'  => 'https://ksmediajob.com/wp-json/wp/v2/media/'
          ),
          'st' => array(
            'password'  => 'bcVd ekjN 8Fph HCMZ VwGk ugtM',
            'url'       => 'https://seoultourjob.com/wp-json/wp/v2/company',
            'urlMedia'  => 'https://seoultourjob.com/wp-json/wp/v2/media/'
          )
        );

        for ($i = 1; $i < $cnt; $i++) {
          $ctApp = $app[$chk_together[$i]];
          $url = $ctApp['url'];
          $urlMedia = $ctApp['urlMedia'];
          $application_password = $ctApp['password'];

          if ($company_logo_id !== null) {
            $file =  curl(wp_get_attachment_url($company_logo_id));
            // $file =  file_get_contents(wp_get_attachment_url($company_logo_id));
            $fileName = basename(wp_get_attachment_url($company_logo_id));
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $urlMedia);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
            curl_setopt($ch, CURLOPT_TIMEOUT, 86400);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
              'Content-Disposition: form-data; filename="' . $fileName . '"',
              'Authorization: Basic ' . base64_encode($username . ':' . $application_password),
            ]);
            $result = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);
            // 정상적으로 저장이 되었으면
            if ($result) {
              $json = curl($urlMedia . '?search=' . $fileName);
              $data = json_decode($json, TRUE);
              $companyLogoId = $data[0]['id'];
            }
          }

          if ($employee_attach_id !== null) {
            $file =  curl(wp_get_attachment_url($employee_attach_id));
            $fileName = basename(wp_get_attachment_url($employee_attach_id));

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $urlMedia);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
            curl_setopt($ch, CURLOPT_TIMEOUT, 864000);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
              'Content-Disposition: form-data; filename="' . $fileName . '"',
              'Authorization: Basic ' . base64_encode($username . ':' . $application_password),
            ]);

            $result = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);
            // 정상적으로 저장이 되었으면
            if ($result) {
              $json = curl($urlMedia . '?search=' . $fileName);
              $data = json_decode($json, TRUE);
              $employeeAttachId = $data[0]['id'];
            }
          }

          $metaArray = array(
            'company_name'          => $company_name,
            'company_type'          => $company_type,
            'company_post'          => $company_post,
            'company_address1'      => $company_address1,
            'company_address2'      => $company_address2,
            'company_tel'           => $company_tel,
            'company_logo'          => $companyLogoId,
            'company_total'         => $company_total,
            'company_regular'       => $company_regular,
            'incharge_name'         => $incharge_name,
            'incharge_position'     => $incharge_position,
            'incharge_email'        => $incharge_email,
            'incharge_homepage'     => $incharge_homepage,
            'incharge_task'         => $incharge_task,
            'employee_regular'      => $employee_regular,
            'employee_temporary'    => $employee_temporary,
            'employee_recommend'    => $employee_recommend,
            'employee_educate'      => $employee_educate,
            'employee_scores'       => $employee_scores,
            'employee_certificate'  => $employee_certificate,
            'employee_document'     => $employee_document,
            'employee_attach'       => $employeeAttachId,
            'work_time_start'       => $work_time_start,
            'work_time_end'         => $work_time_end,
            'work_overtime'         => $work_overtime,
            'work_saturday'         => $work_saturday,
            'work_sunday'           => $work_sunday,
            'pay_month'             => $pay_month,
            'pay_annual'            => $pay_annual,
            'pay_probation'         => $pay_probation,
            'pay_money'             => $pay_money,
            'pay_etc'               => $pay_etc,
            'method_type'           => $method_type,
            'method_etc'            => $method_etc,
            'method_deadline'       => $method_deadline,
            'method_document'       => $method_document,
            'method_document_etc'   => $method_document_etc,
            'note'                  => $note,
            'chk_together'          => $chk_together
          );

          $api_response = wp_remote_post(
            $url,
            array(
              'headers'  => array(
                'Authorization' => 'Basic ' . base64_encode($username . ':' . $application_password),
              ),
              'body'  => array(
                'title'        => wp_strip_all_tags($company_name . '[' . $company_tel . '/' . $incharge_name . ']'),
                'status'      => 'pending',
                'meta'        =>  $metaArray
              )
            )
          );
        }
      }
    } elseif ($postType == 'resume') {
      // 이력서 및 자기소개서(재학생, 졸업생)
      $name_ko = @$_POST['name_ko'];                                      // field_601a7c7f8a8df
      $name_en = @$_POST['name_en'];                                      // field_601a7ca28a8e0
      $photo = @$_FILES['photo'];                                         // field_601a7ccd8a8e2
      $birthday = @$_POST['birthday'];                                    // field_601a7d148a8e3
      $phone = @$_POST['phone'];                                          // field_601a7d458a8e4
      $email1 = @$_POST['inputEmail1'];                                   //
      $email2 = @$_POST['inputEmail2'];                                   //
      $selectEmail = @$_POST['selectEmail'];
      if ($selectEmail == '1') {
        $email = trim($email1) . '@' . trim($email2);                     // field_601a7d4d8a8e5
      } else {
        $email = trim($email1) . '@' . trim($selectEmail);
      }
      $post = @$_POST['post'];                                            // field_601a7d728a8e6
      $address1 = @$_POST['address1'];                                    // field_601a7da58a8e7
      $address2 = @$_POST['address2'];                                    // field_601a7db18a8e8
      // 취미들 field_601a7db68a8e9
      $hobby = @$_POST['inputHobby'];                                     // field_6048e057de752
      // 특기들 field_601a7dea8a8ea
      $specialty = @$_POST['inputSpecialty'];                             // field_6048e084de753
      // $education = @$_POST['inputEducation'];                             // field_601ab8f58806f
      $educationPeriod = @$_POST['inputEducationPeriod'];                 // field_601ab93788070
      $educationSchool = @$_POST['inputEducationSchool'];                 // field_601ab96388071
      $educationMajor = @$_POST['inputEducationMajor'];                   // field_601ab97888072
      $educationLocation = @$_POST['inputEducationLocation'];             // field_601ab98788073
      // $certification = @$_POST['inputCertification'];                     // field_601ada0eb47c8
      $certificationName = @$_POST['inputCertificationName'];             // field_601ada1cb47c9
      $certificationLevel = @$_POST['inputCertificationLevel'];           // field_601ada49b47ca
      $certificationDate = @$_POST['inputCertificationDate'];             // field_601ada57b47cb
      $certificationIssuer = @$_POST['inputCertificationIssuer'];         // field_601ada86b47cc
      // $awards = @$_POST['inputAwards']                                    // field_601adafa27e7d
      $awardsName = @$_POST['inputAwardsName'];                           // field_601adb1927e7e
      $awardsDetails = @$_POST['inputAwardsDetails'];                     // field_601adb2c27e7f
      $awardsSince = @$_POST['inputAwardsSince'];                         // field_601adb4b27e80
      $awardsAgency = @$_POST['inputAwardsAgency'];                       // field_601adb6a27e81
      // $volunteer = @$_POST['inputVolunteer'];                             // field_601adba227e82
      $volunteerSince = @$_POST['inputVolunteerSince'];                   // field_601adbdf27e83
      $volunteerType = @$_POST['inputVolunteerType'];                     // field_601adbf027e84
      $volunteerIssuer = @$_POST['inputVolunteerIssuer'];                 // field_601adc0227e85
      $volunteerDetails = @$_POST['inputVolunteerDetails'];               // field_601adc5127e86

      $growth = @$_POST['growth'];                                        // field_601adc7783c72
      $character = @$_POST['character'];                                  // field_601adcb283c73
      $life = @$_POST['life'];                                            // field_601adcce83c74
      $motive = @$_POST['motive'];                                        // field_601adce683c75
      $writer = @$_POST['writer'];                                        // field_601add0b83c76
      $signdate = @$_POST['signdate'];                                    // field_601add1f83c77

      $cntHobby = count($hobby);
      $cntSpecialty = count($specialty);
      $cntEducation = count($educationPeriod);
      $cntCertification = count($certificationName);
      $cntAwards = count($awardsName);
      $cntVolunteer = count($volunteerSince);

      $post_infomation = array(
        'post_title'    => wp_strip_all_tags($name_ko . '[' . $birthday . '/' . $phone . ']'),
        'post_type'      => $postType,
        'post_status'    => 'pending'
      );

      $post_id = wp_insert_post($post_infomation);
      if ($post_id) {
        // category update
        $taxonomy = $_POST['post_category'];
        wp_set_object_terms($post_id, $taxonomy, 'resume_category', true);

        update_field('field_601a7c7f8a8df', $name_ko, $post_id);
        update_field('field_601a7ca28a8e0', $name_en, $post_id);
        update_field('field_601a7d148a8e3', $birthday, $post_id);
        update_field('field_601a7d458a8e4', $phone, $post_id);
        update_field('field_601a7d4d8a8e5', $email, $post_id);
        update_field('field_601a7d728a8e6', $post, $post_id);
        update_field('field_601a7da58a8e7', $address1, $post_id);
        update_field('field_601a7db18a8e8', $address2, $post_id);
        update_field('field_601a7db68a8e9', $hobby, $post_id);
        update_field('field_601a7dea8a8ea', $specialty, $post_id);
        update_field('field_601adc7783c72', $growth, $post_id);
        update_field('field_601adcb283c73', $character, $post_id);
        update_field('field_601adcce83c74', $life, $post_id);
        update_field('field_601adce683c75', $motive, $post_id);
        update_field('field_601add0b83c76', $writer, $post_id);
        update_field('field_601add1f83c77', $signdate, $post_id);

        if ($photo) {
          $attachment_id = media_handle_upload('photo', $post_id);
          if (is_wp_error($attachment_id)) {
            // error
            echo '파일 저장중 오류가 발생했습니다.<br/>관리자에게 문의해 주세요.';
          } else {
            // success
            update_field('field_601a7ccd8a8e2', $attachment_id, $post_id);
            update_post_meta($post_id, '_thumbnail_id', $attachment_id);
          }
        }

        if ($cntHobby) {
          $hobbies = array();
          for ($i = 0; $i < $cntHobby; $i++) {
            if (isset($hobby[$i]) && trim($hobby[$i]) != '') {
              $value = array(
                'hobby' => $hobby[$i]
              );
              array_push($hobbies, $value);
            }
          }
          update_field('field_601a7db68a8e9', $hobbies, $post_id);
        }

        if ($cntSpecialty) {
          $specialties = array();
          for ($i = 0; $i < $cntSpecialty; $i++) {
            if (isset($specialty[$i]) && trim($specialty[$i]) != '') {
              $value = array(
                'specialty' => $specialty[$i]
              );
              array_push($specialties, $value);
            }
          }
          update_field('field_601a7dea8a8ea', $specialties, $post_id);
        }

        if ($cntEducation) {
          $educations = array();
          for ($i = 0; $i < $cntEducation; $i++) {
            if (isset($educationPeriod[$i]) && trim($educationPeriod[$i]) != '') {
              $value = array(
                'period'     => $educationPeriod[$i],
                'school'     => $educationSchool[$i],
                'major'     => $educationMajor[$i],
                'location'     => $educationLocation[$i]
              );
              array_push($educations, $value);
            }
          }
          update_field('field_601ab8f58806f', $educations, $post_id);
        }

        if ($cntCertification) {
          $certification = array();
          for ($i = 0; $i < $cntCertification; $i++) {
            if (isset($certificationName[$i]) && trim($certificationName[$i]) != '') {
              $value = array(
                'name'      => $certificationName[$i],
                'level'     => $certificationLevel[$i],
                'date'      => $certificationDate[$i],
                'issuer'    => $certificationIssuer[$i]
              );
              array_push($certification, $value);
            }
          }
          update_field('field_601ada0eb47c8', $certification, $post_id);
        }

        if ($cntAwards) {
          $awards = array();
          for ($i = 0; $i < $cntAwards; $i++) {
            if (isset($awardsName[$i]) && trim($awardsName[$i]) != '') {
              $value = array(
                'name'        => $awardsName[$i],
                'details'     => $awardsDetails[$i],
                'since'       => $awardsSince[$i],
                'agency'      => $awardsAgency[$i]
              );
              array_push($awards, $value);
            }
          }
          update_field('field_601adafa27e7d', $awards, $post_id);
        }

        if ($cntVolunteer) {
          $volunteer = array();
          for ($i = 0; $i < $cntVolunteer; $i++) {
            if (isset($volunteerSince[$i]) && trim($volunteerSince[$i]) != '') {
              $value = array(
                'since'        => $volunteerSince[$i],
                'type'         => $volunteerType[$i],
                'issuer'       => $volunteerIssuer[$i],
                'details'      => $volunteerDetails[$i]
              );
              array_push($volunteer, $value);
            }
          }
          update_field('field_601adba227e82', $volunteer, $post_id);
        }
      }
    } elseif ($postType == 'interview') {
      // 재학생 : 면접 후기
      $company                = $_POST['company'];                // field_601c380867ce4
      $student_id             = $_POST['student_id'];             // field_601c381567ce5
      $student_name           = $_POST['student_name'];           // field_601c382867ce6
      $interview_date         = $_POST['interview_date'];         // field_601c383067ce7
      $interview_location     = $_POST['interview_location'];     // field_601c388167ce8
      $interview_time         = $_POST['interview_time'];         // field_601c38a167ce9
      $interview_method       = $_POST['interview_method'];       // field_601c38af67cea
      $interview_type         = $_POST['interview_type'];         // field_601c38d067ceb
      $interview_step         = $_POST['interview_step'];         // field_601c38db67cec
      $interview_mood         = $_POST['interview_mood'];         // field_601c38e667ced
      $interview_question     = $_POST['interview_question'];     // field_601c390f67cee
      $interview_etc          = $_POST['interview_etc'];          // field_601c392767cef

      $post_infomation = array(
        'post_title'          => wp_strip_all_tags($company . '[' . $student_name . '■' . $interview_date . ']'),
        'post_type'           => $postType,
        'post_status'         => 'pending'
      );
      $post_id = wp_insert_post($post_infomation);
      if ($post_id) {
        update_field('field_601c380867ce4', $company, $post_id);
        update_field('field_601c381567ce5', $student_id, $post_id);
        update_field('field_601c382867ce6', $student_name, $post_id);
        update_field('field_601c383067ce7', $interview_date, $post_id);
        update_field('field_601c388167ce8', $interview_location, $post_id);
        update_field('field_601c38a167ce9', $interview_time, $post_id);
        update_field('field_601c38af67cea', $interview_method, $post_id);
        update_field('field_601c38d067ceb', $interview_type, $post_id);
        update_field('field_601c38db67cec', $interview_step, $post_id);
        update_field('field_601c38e667ced', $interview_mood, $post_id);
        update_field('field_601c390f67cee', $interview_question, $post_id);
        update_field('field_601c392767cef', $interview_etc, $post_id);
      }
    } elseif ($postType == 'pass') {
      $company = @$_POST['company'];                              // field_601c3d6199a55
      $student_id = @$_POST['student_id'];                        // field_601c3d6a99a56
      $student_name = @$_POST['student_name'];                    // field_601c3d7499a57
      $successful_document = @$_POST['successful_document'];      // field_601c3d8d99a58
      $successful_question = @$_POST['successful_question'];      // field_601c3db599a59
      $successful_opinion = @$_POST['successful_opinion'];        // field_601c3dc999a5a

      $post_infomation = array(
        'post_title'          => wp_strip_all_tags($company . '[' . $student_name . '■' . $student_id . ']'),
        'post_type'           => $postType,
        'post_status'         => 'pending'
      );
      $post_id = wp_insert_post($post_infomation);
      if ($post_id) {
        update_field('field_601c3d6199a55', $company, $post_id);
        update_field('field_601c3d6a99a56', $student_id, $post_id);
        update_field('field_601c3d7499a57', $student_name, $post_id);
        update_field('field_601c3d8d99a58', $successful_document, $post_id);
        update_field('field_601c3db599a59', $successful_question, $post_id);
        update_field('field_601c3dc999a5a', $successful_opinion, $post_id);
      }
      wp_safe_redirect($_POST['_wp_http_referer'] . '?mode=save');
      exit;
    } elseif ($postType == 'reservation') {
      // 구직상담 예약
      $name                   = $_POST['name'];
      $student_id             = $_POST['student_id'];
      $phone                  = $_POST['phone'];
      $date                   = $_POST['date'];
      $time                   = $_POST['time'];

      $tempDate               = new DateTime($date);
      $sayDate                = $tempDate->format('Ymd');

      $post_information = array(
        'post_title'          => wp_strip_all_tags($name . '[' . $date . '■' . $time . ']' . $phone),
        'post_type'           => $postType,
        'post_status'         => 'pending'
      );
      $post_id = wp_insert_post($post_information);
      if ($post_id) {
        update_field('field_601d6d19193d2', $name, $post_id);
        update_field('field_601d6d22193d3', $student_id, $post_id);
        update_field('field_601d6d3f193d4', $phone, $post_id);
        update_field('field_601d6d52193d5', $sayDate, $post_id);
        update_field('field_601d6dbe193d6', $time, $post_id);
      }
    }

    wp_safe_redirect($_POST['_wp_http_referer'] . '?mode=save');
    exit;
  }
}
add_action('template_redirect', '_themename_front_end_post', 99);

function user_acf_save_post($post_id)
{
  if (get_current_user_id()) {
    update_post_meta($post_id, '_edit_last', get_current_user_id()); //update last modified by
  } else {
    update_post_meta($post_id, '_edit_last', '1'); // default super admin
  }
}

// run after save post
add_action('save_post', 'user_acf_save_post', 10);
