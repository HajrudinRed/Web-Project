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
        $query = "SELECT 
            i.*,
            u.name as user_name,
            u.email as user_email
        FROM instructors i
        LEFT JOIN users u ON i.user_id = u.id
        WHERE u.role = 'instructor'
        ORDER BY i.id
    ";

        return $this->query($query, []);
    }

    public function getInstructorByID($instructor_id) {
        $query = "SELECT 
            i.*,
            u.name as user_name,
            u.email as user_email
        FROM instructors i
        LEFT JOIN users u ON i.user_id = u.id
        WHERE i.id = :id";

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
        $query = "UPDATE instructors SET 
            bio = :bio, 
            qualification = :qualification, 
            experience_years = :experience_years, 
            specialization = :specialization,
            profile_picture_url = :profile_picture_url 
        WHERE id = :id";

        $this->execute($query, [
            'id' => $instructor_id,
            'bio' => $instructor['bio'],
            'qualification' => $instructor['qualification'],
            'experience_years' => $instructor['experience_years'],
            'specialization' => $instructor['specialization'] ?? null,
            'profile_picture_url' => $instructor['profile_picture_url']
        ]);
    }
}

?>