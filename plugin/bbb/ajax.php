<?php
/**
 * This script initiates a video conference session, calling the BigBlueButton API.
 *
 * @package chamilo.plugin.bigbluebutton
 */
$course_plugin = 'bbb'; //needed in order to load the plugin lang variables
$cidReset = true;

require_once __DIR__.'/../../main/inc/global.inc.php';

$action = isset($_REQUEST['a']) ? $_REQUEST['a'] : null;
$meetingId = isset($_REQUEST['meeting']) ? intval($_REQUEST['meeting']) : 0;
$plugin = BBBPlugin::create();
$bbb = new bbb('', '');

switch ($action) {
    case 'check_m4v':
        if (!api_is_platform_admin()) {
            api_not_allowed();
            exit;
        }

        if (!$meetingId) {
            exit;
        }

        if ($bbb->checkDirectMeetingVideoUrl($meetingId)) {
            $meetingInfo = Database::select(
                '*',
                'plugin_bbb_meeting',
                ['where' => ['id = ?' => intval($meetingId)]],
                'first'
            );

            $url = $meetingInfo['video_url'].'/capture.m4v';
            $link = Display::url(
                Display::return_icon('save.png', get_lang('DownloadFile')),
                $meetingInfo['video_url'].'/capture.m4v',
                ['target' => '_blank']
            );

            header('Content-Type: application/json');
            echo json_encode(['url' => $url, 'link' => $link]);
        }
        break;
    case 'meetings':
        $apiUrlMeetings = 'http://'.$bbb->api->getGetMeetingsUrl();
        $enableRooms = api_get_configuration_value('bigbluebutton_rooms_enabled');
        $meetingsXML = new SimpleXMLElement($apiUrlMeetings,0,true);
        $listRooms = $tpmRooms = [];
        $rooms = [];
        $list = [];
        //Meetings;
        if($meetingsXML->returncode == 'SUCCESS'){

            if(!$meetingsXML->messageKey == 'noMeetings'){
                foreach ($meetingsXML->meetings->meeting as $route){
                    $listRooms[]=$route;
                }

                foreach ($listRooms as $room){
                    $courseCode = (string)$room->attendeePW;
                    $courseInfo = api_get_course_info($courseCode);
                    $rooms['meeting_name'] = (string)$room->meetingName;
                    $rooms['meeting_id'] = (string)$room->internalMeetingID;
                    $rooms['course_code'] = $courseCode;
                    $rooms['course_name'] = $courseInfo['name'];
                    $rooms['meeting_create'] = (string)$room->createDate;
                    $rooms['count_participants'] = (string)$room->participantCount;
                    $rooms['recording'] = (string)$room->recording;
                    $tpmRooms[] = $rooms;
                }
                $list['message'] = $plugin->get_lang('OpenRooms');
                $countRooms = count($listRooms);
                $list['count'] = $countRooms;
                $list['rooms'] = $tpmRooms;

            } else {
                $list['message'] =  $plugin->get_lang('ThereAreNoOpenRooms');
                $list['count'] = 0;
            }
            header('Content-Type: application/json');
            echo json_encode($list);
        }

        break;
}
