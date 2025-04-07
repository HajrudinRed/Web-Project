<?php

require_once __DIR__ . '/InstructorsDao.class.php';
require_once __DIR__ . '/UserDao.class.php';

$user_dao = new UserDao();
$instructors_dao = new InstructorsDao();

// Add a new user (required for the foreign key constraint)
$new_user = [
    "name" => "John Doe",
    "email" => "johndoes@example.com", // need to be unique every time
    "password" => "password123",
    "role" => "instructor"
];
$added_user = $user_dao->addUser($new_user);
print_r($added_user);

// Add a new instructor linked to the user
$new_instructor = [
    "id" => $added_user['id'], // Use the ID of the newly added user
    "bio" => "Experienced software engineer",
    "qualification" => "MSc Computer Science",
    "experience_years" => 10,
    "profile_picture_url" => "https://example.com/profile.jpg"
];
$added_instructor = $instructors_dao->addInstructor($new_instructor);
print_r($added_instructor);

// Get all instructors
$instructors = $instructors_dao->getInstructors();
print_r($instructors);

// Get an instructor by ID
$instructor_id = $added_instructor['id'];
$instructor = $instructors_dao->getInstructorByID($instructor_id);
print_r($instructor);

// Update the instructor
$updated_instructor = [
    "bio" => "Senior software engineer",
    "qualification" => "PhD Computer Science",
    "experience_years" => 12,
    "profile_picture_url" => "https://example.com/new_profile.jpg"
];
$instructors_dao->editInstructors($instructor_id, $updated_instructor);
print_r($instructors_dao->getInstructorByID($instructor_id));

// Delete the instructor
//$instructors_dao->deleteInstructors($instructor_id);
//print_r($instructors_dao->getInstructors());

// Delete the user (optional cleanup)
//$user_dao->deleteUser($added_user['id']);
//print_r($user_dao->getUsers());
?>