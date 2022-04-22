<?php
if (!function_exists('wh_log')) :
	function wh_log($log_msg)
	{
		$baseFolder = trailingslashit(wp_upload_dir()['basedir']) . "log";
		if (!file_exists($baseFolder)) {
			wp_mkdir_p($baseFolder);
		}
		$log_file_data = $baseFolder . '/log_' . date('d-M-Y') . '.log';
		// if you don't add `FILE_APPEND`, the file will be erased each time you add a log
		file_put_contents($log_file_data, print_r($log_msg, true) . "\n", FILE_APPEND);
	}
endif;

function _themename_remove_menus()
{
	$current_user = wp_get_current_user();
	remove_menu_page('edit-comments.php'); // Comments
	if (in_array('editor', (array) $current_user->roles)) {
		remove_menu_page('edit.php'); // 포스터
		remove_menu_page('edit.php?post_type=page'); // 페이지
		remove_menu_page('tools.php'); // 도구
	}
	if (in_array('contributor', (array) $current_user->roles)) {
		remove_menu_page('edit.php'); // 포스터
		remove_menu_page('edit.php?post_type=page'); // 페이지
		remove_menu_page('edit.php?post_type=resume'); // 이력서 및 자소서
		remove_menu_page('edit.php?post_type=interview'); // 면접후기
		remove_menu_page('edit.php?post_type=pass'); // 합격자 수기
		remove_menu_page('edit.php?post_type=graduate'); // 구직등록카드
		remove_menu_page('edit.php?post_type=reservation'); // 구직상담예약
		remove_menu_page('profile.php'); // 프로필
		remove_menu_page('tools.php'); // 도구
	}
}
add_action('admin_init', '_themename_remove_menus');

function _themename_admin_bar_menu($wp_admin_bar)
{
	$current_user = wp_get_current_user();
	if (in_array('editor', (array) $current_user->roles)) {
		$wp_admin_bar->remove_node('edit');
		$wp_admin_bar->remove_node('new-content');
		$wp_admin_bar->remove_node('comments');
		// $wp_admin_bar->remove_node( 'new-post' );
		// $wp_admin_bar->remove_node( 'new-page' );
		// $wp_admin_bar->remove_node( 'new-link' );
		// $wp_admin_bar->remove_node( 'new-media' );
	}
}
add_action('admin_bar_menu', '_themename_admin_bar_menu', 999);

function _themename_admin_menu()
{
	// add_menu_page( '', '', 'read', 'wp-menu-separator', '', '', '22' );
	global $menu;
	$menu[21] = ['', 'read', '', '', 'wp-menu-separator'];

	// author, subscriber 등급 삭제
	global $wp_roles;
	$roles_to_remove = array('author', 'subscriber');
	foreach ($roles_to_remove as $role) {
		if (isset($wp_roles->roles[$role])) {
			$wp_roles->remove_role($role);
		}
	}
}
add_action('admin_menu', '_themename_admin_menu');

function _themename_change_role_name()
{
	global $wp_roles;
	$wp_roles->roles['administrator']['name'] = '최고관리자';
	$wp_roles->roles['editor']['name'] = '부운영자';
	$wp_roles->roles['contributor']['name'] = '채용정보확인';
}
add_action('init', '_themename_change_role_name');
