<?php
/* For license terms, see /license.txt */
/* For license terms, see /license.txt */

class AdvancedReportsPlugin extends Plugin
{
    const REPORT_STUDENT_BY_SESSION = '1';
    const REPORT_TIME_IN_SESSION = '2';

    protected function __construct()
    {
        $settings = [

        ];

        parent::__construct('0.1', 'Francis Gonzales', $settings);
    }

    /**
     * @return string
     */
    public function get_name()
    {
        return 'advanced_reports';
    }

    /**
     * @return AdvancedReportsPlugin
     */
    public static function create()
    {
        static $result = null;

        return $result ? $result : $result = new self();
    }

    public function install()
    {
        $this->addTab(
            $this->get_lang('advanced_reports'),
            '/plugin/advanced_reports',
       Plugin::TAB_FILTER_NO_STUDENT);
    }

    public function uninstall()
    {
        $key = 'custom_tab_1' . Plugin::TAB_FILTER_NO_STUDENT;

        $this->deleteTab($key);
    }

    public function getReportData($reportId)
    {
        if ($reportId == self::REPORT_STUDENT_BY_SESSION) {
            return $this->studentsBySession($_GET['period']);
        }

        if ($reportId == self::REPORT_TIME_IN_SESSION) {
            return $this->timeInSession($_GET['course_code'], $_GET['session_id']);
        }
    }

    public function timeInSession($course_code = null, $session_id = null)
    {
        $studentList = CourseManager::get_student_list_from_course_code(
            $course_code, true, $session_id
        );

        $nbStudents = count($studentList);
        $GLOBALS['user_ids'] = array_keys($studentList);

        $usersTracking = array();
        if (!empty($nbStudents)) {
            $usersTracking = TrackingCourseLog::get_user_data(
                null, $nbStudents, null, null, false
            );
        }
        // Rename Columns
        $userList[] = array(
            'Código Oficial',
            'Apellido',
            'Nombre',
            'Username',
            'Tiempo en Curso',
            'Progreso Lección',
            'Progreso Ejercicio',
            'Media del Ejercicio',
            'Primera Conexión',
            'Ultima conexión'
        );

        if (!empty($usersTracking)) {
            foreach ($usersTracking as $userRow) {
                $userList[] = array(
                    'official_code' => $userRow[0],
                    'lastname' => $userRow[1],
                    'firstname' => $userRow[2],
                    'username' => $userRow[3],
                    'time' => $userRow[4],
                    'average_progress' => $userRow[5],
                    'exercise_progress' => $userRow[6],
                    'exercise_average_best_attempt' => $userRow[7],
                    //'student_score' => $userRow[8],
                    //'count_assignments' => $userRow[9],
                    //'count_messages' => $userRow[10],
                    //'classes' => $userRow[11],
                    'first_connection' => $userRow[12],
                    'last_connection' => $userRow[13],
                );
            }
        }

        return $userList;
    }

    public function studentsBySession($yearMonth = null)
    {
        $sql = "select
         session.name, count(1) as attendees
         from session_rel_user
        inner join user on session_rel_user.user_id = user.id
        inner join session on session_rel_user.session_id = session.id
        where DATE_FORMAT(session.display_start_date,'%Y%m') = '$yearMonth'
        group by session.id
        order by session.name";

        $result = Database::query($sql);
        $data[] = array(
            'name' => 'LISTA DE SESIONES',
            //'code' => '',
            'attendees' => 'Inscritos'
        );
        $total = 0;
        while ($row = Database::fetch_assoc($result)) {
            //$row['code'] = substr($row['name'], -8);
            $data[] = $row;
            $total += (int)$row['attendees'];
        }

        $data[] = array(
            'name' => 'TOTAL',
            //'code' => '',
            'attendees' => $total
        );

        return $data;
    }
}
