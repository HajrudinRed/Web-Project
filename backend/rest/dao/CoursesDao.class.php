<?php

require_once __DIR__ . "/BaseDao.class.php";

class CoursesDao extends BaseDao {
    public function __construct() {
        parent::__construct("courses");
    }

    public function addCourse($course) {
        return $this->insert("courses", $course);
    }    

    public function getCourses() {
        $query = "SELECT * 
        FROM courses";

        return $this->query($query, []);
    }

    public function getCourseByID($course_id) {
        $query = "SELECT * 
        FROM courses
        WHERE id = :id";

        return $this->query_unique($query, [
            "id" => $course_id
        ]);
    }

    public function deleteCourse($course_id) {
        $query = "DELETE FROM courses WHERE id = :id";
        $this->execute($query, [
            'id' => $course_id
        ]);
    }

    public function editCourse($course_id, $course) {
        $query = "UPDATE courses SET title = :title, description = :description, category = :category WHERE id = :id";

        $this->execute($query, [
            'id' => $course_id,
            'title' => $course['title'],
            'description' => $course['description'],
            'category' => $course['category'],
            
        ]);
    }
}

?>