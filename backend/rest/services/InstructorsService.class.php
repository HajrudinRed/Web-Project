<?php

require_once __DIR__ . "/../dao/InstructorsDao.class.php";

class InstructorsService {
    private $instructorsDao;

    public function __construct() {
        $this->instructorsDao = new InstructorsDao();
    }

    public function addInstructor($instructor) {
        return $this->instructorsDao->addInstructor($instructor);
    }

    public function getInstructors() {
        $data = $this->instructorsDao->getInstructors();
        return ["data" => $data];
    }

    public function getInstructorByID($instructor_id) {
        return $this->instructorsDao->getInstructorByID($instructor_id);
    }

    public function deleteInstructor($instructor_id) {
        $this->instructorsDao->deleteInstructors($instructor_id);
    }

    public function editInstructor($instructor) {
        $instructor_id = $instructor['id'];
        unset($instructor['id']);

        $this->instructorsDao->editInstructors($instructor_id, $instructor);
    }
}

?>