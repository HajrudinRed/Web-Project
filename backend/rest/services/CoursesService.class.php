<?php

require_once __DIR__ . "/../dao/CoursesDao.class.php";

class CoursesService {
    private $coursesDao;

    public function __construct() {
        $this->coursesDao = new CoursesDao();
    }

    public function addCourse($course) {
        return $this->coursesDao->addCourse($course);
    }

    public function getCourses() {
        $data = $this->coursesDao->getCourses();
        return ["data" => $data];
    }

    public function getCourseByID($course_id) {
        return $this->coursesDao->getCourseByID($course_id);
    }

    public function deleteCourse($course_id) {
        $this->coursesDao->deleteCourse($course_id);
    }

    public function editCourse($course) {
        $course_id = $course['id'];
        unset($course['id']);

        $this->coursesDao->editCourse($course_id, $course);
    }
}

?>