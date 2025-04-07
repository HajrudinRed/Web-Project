<?php

require_once __DIR__ . '/CoursesDao.class.php';

$courses_dao = new CoursesDao();

// Add a new course
$new_course = [
    "title" => "Introduction to Programming",
    "description" => "Learn the basics of programming.",
    "category" => "Programming"
];
$added_course = $courses_dao->addCourse($new_course);
print_r($added_course);

// Get all courses
$courses = $courses_dao->getCourses();
print_r($courses);

// Get a course by ID
$course_id = $added_course['id'];
$course = $courses_dao->getCourseByID($course_id);
print_r($course);

// Update the course
$updated_course = [
    "title" => "Advanced Programming",
    "description" => "Learn advanced programming concepts.",
    "category" => "Advanced Programming"
];
$courses_dao->editCourse($course_id, $updated_course);
print_r($courses_dao->getCourseByID($course_id));

// Delete the course
//$courses_dao->deleteCourse($course_id);
//print_r($courses_dao->getCourses());
?>