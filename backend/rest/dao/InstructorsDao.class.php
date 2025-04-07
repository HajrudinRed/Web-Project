<?php

require_once __DIR__ . "/BaseDao.class.php";

class InstructorsDao extends BaseDao {
    public function __construct() {
        parent::__construct("instructors");
    }

    public function addInstructor($instructor) {
        return $this->insert("instructors", $instructor);
    }    

    public function getInstructors() {
        $query = "SELECT * 
        FROM instructors";

        return $this->query($query, []);
    }

    public function getInstructorByID($instructor_id) {
        $query = "SELECT * 
        FROM instructors
        WHERE id = :id";

        return $this->query_unique($query, [
            "id" => $instructor_id
        ]);
    }

    public function deleteInstructors($instructor_id) {
        $query = "DELETE FROM instructors WHERE id = :id";
        $this->execute($query, [
            'id' => $instructor_id
        ]);
    }

    public function editInstructors($instructor_id, $instructor) {
        $query = "UPDATE instructors SET bio = :bio, qualification = :qualification, experience_years = :experience_years, profile_picture_url = :profile_picture_url WHERE id = :id";

        $this->execute($query, [
            'id' => $instructor_id,
            'bio' => $instructor['bio'],
            'qualification' => $instructor['qualification'],
            'experience_years' => $instructor['experience_years'],
            'profile_picture_url' => $instructor['profile_picture_url']
        ]);
    }
}

?>