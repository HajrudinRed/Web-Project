<?php

require_once __DIR__ . '/../services/CoursesService.class.php';

Flight::set('coursesService', new CoursesService());

Flight::group('/courses', function() {

    /**
     * @OA\Get(
     *      path="/courses",
     *      tags={"courses"},
     *      summary="Get all courses",
     *      @OA\Response(
     *           response=200,
     *           description="Get all courses"
     *      )
     * )
     */
    Flight::route('GET /', function() {
        $data = Flight::get('coursesService')->getCourses();
        Flight::json(["data" => $data]);
    });

    /**
     * @OA\Get(
     *      path="/courses/{course_id}",
     *      tags={"courses"},
     *      summary="Get course by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Course data, or false if course does not exist"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="course_id", example="1", description="Course ID")
     * )
     */
    Flight::route('GET /@course_id', function($course_id) {
        $course = Flight::get('coursesService')->getCourseByID($course_id);
        Flight::json($course, 200);
    });

    /**
     * @OA\Post(
     *      path="/courses",
     *      tags={"courses"},
     *      summary="Add or update a course",
     *      @OA\Response(
     *           response=200,
     *           description="Course data, or exception if course is not added properly"
     *      ),
     *      @OA\RequestBody(
     *          description="Course data payload",
     *          @OA\JsonContent(
     *              required={"title", "description", "category"},
     *              @OA\Property(property="id", type="integer", example="1", description="Course ID"),
     *              @OA\Property(property="title", type="string", example="Introduction to Programming", description="Course title"),
     *              @OA\Property(property="description", type="string", example="Learn the basics of programming.", description="Course description"),
     *              @OA\Property(property="category", type="string", example="Programming", description="Course category")
     *          )
     *      )
     * )
     */
    Flight::route('POST /', function() {
        $payload = Flight::request()->data->getData();

        if (isset($payload['id']) && !empty($payload['id'])) {
            $course = Flight::get('coursesService')->editCourse($payload);
        } else {
            unset($payload['id']);
            $course = Flight::get('coursesService')->addCourse($payload);
        }

        Flight::json(['message' => "Course successfully saved.", 'data' => $course]);
    });

    /**
     * @OA\Put(
     *      path="/courses/{course_id}",
     *      tags={"courses"},
     *      summary="Edit course by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Updated course data"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="course_id", example="1", description="Course ID"),
     *      @OA\RequestBody(
     *          description="Course data payload",
     *          @OA\JsonContent(
     *              required={"title", "description", "category"},
     *              @OA\Property(property="title", type="string", example="Introduction to Programming", description="Course title"),
     *              @OA\Property(property="description", type="string", example="Learn the basics of programming.", description="Course description"),
     *              @OA\Property(property="category", type="string", example="Programming", description="Course category")
     *          )
     *      )
     * )
     */
    Flight::route('PUT /@course_id', function($course_id) {
        $payload = Flight::request()->data->getData();
        $payload['id'] = $course_id;

        $course = Flight::get('coursesService')->editCourse($payload);
        Flight::json(['message' => "Course successfully updated.", 'data' => $course]);
    });

    /**
     * @OA\Delete(
     *      path="/courses/{course_id}",
     *      tags={"courses"},
     *      summary="Delete course by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Deleted course data or 500 status code exception otherwise"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="course_id", example="1", description="Course ID")
     * )
     */
    Flight::route('DELETE /@course_id', function($course_id) {
        if (empty($course_id)) {
            Flight::halt(500, "You must provide a valid course ID!");
        }

        Flight::get('coursesService')->deleteCourse($course_id);
        Flight::json(['message' => "Course successfully deleted."]);
    });

});

?>