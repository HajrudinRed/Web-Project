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
        $query = "SELECT 
            c.*,
            i.bio as instructor_bio,
            u.name as instructor_name
        FROM courses c
        LEFT JOIN instructors i ON c.instructor_id = i.user_id  
        LEFT JOIN users u ON i.user_id = u.id
        ORDER BY c.created_at DESC";

        return $this->query($query, []);
    }

    public function getCourseByID($course_id) {
        $query = "SELECT 
            c.*,
            i.bio as instructor_bio,
            u.name as instructor_name
        FROM courses c
        LEFT JOIN instructors i ON c.instructor_id = i.user_id  
        LEFT JOIN users u ON i.user_id = u.id
        WHERE c.id = :id";

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
        $query = "UPDATE courses SET 
            title = :title, 
            description = :description, 
            category = :category,
            image_url = :image_url,
            instructor_id = :instructor_id,
            category_id = :category_id
        WHERE id = :id";

        $this->execute($query, [
            'id' => $course_id,
            'title' => $course['title'],
            'description' => $course['description'],
            'category' => $course['category'],
            'image_url' => $course['image_url'] ?? '../assets/img/course-1.jpg',
            'instructor_id' => $course['instructor_id'] ?? null,
            'category_id' => $course['category_id'] ?? null
        ]);
    }
}

?>