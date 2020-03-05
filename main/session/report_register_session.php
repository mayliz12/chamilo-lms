<?php

use Chamilo\CoreBundle\Entity\Course;
use Chamilo\CoreBundle\Entity\Session;
use Chamilo\CoreBundle\Entity\SessionCategory;
use Chamilo\CoreBundle\Entity\SessionRelCourseRelUser;

/**
 * @author  Bart Mollet, Julio Montoya lot of fixes
 *
 * @package chamilo.admin
 */
$cidReset = true;
require_once __DIR__.'/../inc/global.inc.php';

// setting the section (for the tabs)
$this_section = SECTION_PLATFORM_ADMIN;

$codePath = api_get_path(WEB_CODE_PATH);
$tool_name = get_lang('SessionOverview');

$tbl_session = Database::get_main_table(TABLE_MAIN_SESSION);
$tbl_sessioncategory = Database::get_main_table(TABLE_MAIN_SESSION_CATEGORY);
$em = Database::getManager();

$sessionCategoryRepository = $em->getRepository('ChamiloCoreBundle:SessionCategory');
$sessionCategory = $sessionCategoryRepository->findAll();


$listCategory = [];

foreach ($sessionCategory as $category){
    $listCategory[$category->getId()] = $category->getName();
}

$sessionRepository = $em->getRepository('ChamiloCoreBundle:Session');
$sessions = $sessionRepository->findAll();

$form = new FormValidator('session_report', 'post', api_get_self(),[],[]);
$form->addSelect('category_session', get_lang('SessionsCategories'), $listCategory);
$form->addDatePicker('date_start', get_lang('DateStart'), false);
$form->addDatePicker('date_end', get_lang('DateEnd'), false);
$content = $form->returnForm();

$listSession = [];
foreach ($sessions as $session){

    $listSession[] = [
        'id' => $session->getId(),
        'name' => $session->getName(),
        'duration' => $session->getDuration(),
        'number_users' => $session->getnbrUsers(),
        'number_courses' => $session->getnbrCourses(),
        'display_start_date' => $session->getDisplayStartDate(),
            'display_end_date' => $session->getDisplayEndDate(),

    ];
}

$tpl = new Template($tool_name);
$tpl->assign('form_search', $content);
$tpl->assign('sessions', $listSession);
$layout = $tpl->get_template('session/report_register_session.tpl');
$tpl->display($layout);
