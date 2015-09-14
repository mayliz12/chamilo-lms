<?php
/* For licensing terms, see /license.txt */
/* 
 * Report from students for learning path 
 */
require_once '../inc/global.inc.php';

$isAllowedToEdit = api_is_allowed_to_edit(null, true);

$lpTable = Database::get_course_table(TABLE_LP_MAIN);

$lpId = isset($_GET['lp_id']) ? boolval($_GET['lp_id']) : false;
$sessionId = api_get_session_id();
$courseId = api_get_course_int_id();
$courseCode = api_get_course_id();
$sessionUsers = SessionManager::get_users_by_session($sessionId, 0);

$userList = [];

$lpInfo = Database::select(
    '*',
    $lpTable,
    array(
        'where' => array(
            'c_id = ? AND ' => $courseId,
            'id = ?' => $lpId
        )
    ),
    'first'
);

foreach ($sessionUsers as $user) {
    $lpTime = Tracking::get_time_spent_in_lp(
        $user['user_id'],
        $courseCode,
        array($lpId),
        $sessionId
    );
    $lpScore = Tracking::get_avg_student_score(
        $user['user_id'],
        $courseCode,
        array($lpId),
        $sessionId
    );
    $lpPogress = Tracking::get_avg_student_progress(
        $user['user_id'],
        $courseCode,
        array($lpId),
        $sessionId
    );
    $lpLastConnection = Tracking::get_last_connection_time_in_lp(
        $user['user_id'],
        $courseCode,
        array($lpId),
        $sessionId
    );
    $lpLastConnection = empty($lpLastConnection) ? '-' : api_convert_and_format_date(
        $lpLastConnection,
        DATE_TIME_FORMAT_LONG
    );

    $userList[] = [
        'id' => $user['user_id'],
        'first_name' => $user['firstname'],
        'last_name' => $user['lastname'],
        'lp_time' => api_time_to_hms($lpTime),
        'lp_score' => is_numeric($lpScore) ? "$lpScore%" : $lpScore,
        'lp_progress' => "$lpPogress%",
        'lp_last_connection' => $lpLastConnection
    ];
}

// View
$interbreadcrumb[] = [
    'url' => api_get_path(WEB_CODE_PATH) . 'newscorm/lp_controller.php',
    'name' => get_lang('LearningPaths')
];

$actions = Display::url(
    Display::return_icon(
        'back.png',
        get_lang('Back'),
        array(),
        ICON_SIZE_MEDIUM
    ),
    api_get_path(WEB_CODE_PATH) . 'newscorm/lp_controller.php?' . api_get_cidreq()
);

$template = new Template(get_lang('StudentScore'));
$template->assign('user_list', $userList);
$template->assign('session_id', api_get_session_id());
$template->assign('course_code', api_get_course_id());
$template->assign('lp_id', $lpId);

$layout = $template->get_template('learnpath/report.tpl');

$template->assign('header', $lpInfo['name']);
$template->assign('actions', $actions);
$template->assign('content', $template->fetch($layout));
$template->display_one_col_template();
