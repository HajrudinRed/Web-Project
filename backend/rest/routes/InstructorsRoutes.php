<?php

require_once __DIR__ . '/../services/InstructorsService.class.php';

Flight::set('instructorsService', new InstructorsService());

Flight::group('/instructors', function() {

    /**
     * @OA\Get(
     *      path="/instructors",
     *      tags={"instructors"},
     *      summary="Get all instructors",
     *      @OA\Response(
     *           response=200,
     *           description="Get all instructors"
     *      )
     * )
     */
    Flight::route('GET /', function() {
        $data = Flight::get('instructorsService')->getInstructors();
        Flight::json(["data" => $data]);
    });

    /**
     * @OA\Get(
     *      path="/instructors/{instructor_id}",
     *      tags={"instructors"},
     *      summary="Get instructor by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Instructor data, or false if instructor does not exist"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="instructor_id", example="1", description="Instructor ID")
     * )
     */
    Flight::route('GET /@instructor_id', function($instructor_id) {
        $instructor = Flight::get('instructorsService')->getInstructorByID($instructor_id);
        Flight::json($instructor, 200);
    });

    /**
     * @OA\Post(
     *      path="/instructors",
     *      tags={"instructors"},
     *      summary="Add or update an instructor",
     *      @OA\Response(
     *           response=200,
     *           description="Instructor data, or exception if instructor is not added properly"
     *      ),
     *      @OA\RequestBody(
     *          description="Instructor data payload",
     *          @OA\JsonContent(
     *              required={"bio", "qualification", "experience_years", "profile_picture_url"},
     *              @OA\Property(property="id", type="integer", example="1", description="Instructor ID"),
     *              @OA\Property(property="bio", type="string", example="Experienced instructor", description="Instructor bio"),
     *              @OA\Property(property="qualification", type="string", example="PhD in Computer Science", description="Instructor qualification"),
     *              @OA\Property(property="experience_years", type="integer", example="10", description="Years of experience"),
     *              @OA\Property(property="profile_picture_url", type="string", example="http://example.com/image.jpg", description="Profile picture URL")
     *          )
     *      )
     * )
     */
    Flight::route('POST /', function() {
        $payload = Flight::request()->data->getData();

        if (isset($payload['id']) && !empty($payload['id'])) {
            $instructor = Flight::get('instructorsService')->editInstructor($payload);
        } else {
            unset($payload['id']);
            $instructor = Flight::get('instructorsService')->addInstructor($payload);
        }

        Flight::json(['message' => "Instructor successfully saved.", 'data' => $instructor]);
    });

    /**
     * @OA\Put(
     *      path="/instructors/{instructor_id}",
     *      tags={"instructors"},
     *      summary="Edit instructor by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Updated instructor data"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="instructor_id", example="1", description="Instructor ID"),
     *      @OA\RequestBody(
     *          description="Instructor data payload",
     *          @OA\JsonContent(
     *              required={"bio", "qualification", "experience_years", "profile_picture_url"},
     *              @OA\Property(property="bio", type="string", example="Experienced instructor", description="Instructor bio"),
     *              @OA\Property(property="qualification", type="string", example="PhD in Computer Science", description="Instructor qualification"),
     *              @OA\Property(property="experience_years", type="integer", example="10", description="Years of experience"),
     *              @OA\Property(property="profile_picture_url", type="string", example="http://example.com/image.jpg", description="Profile picture URL")
     *          )
     *      )
     * )
     */
    Flight::route('PUT /@instructor_id', function($instructor_id) {
        $payload = Flight::request()->data->getData();
        $payload['id'] = $instructor_id;

        $instructor = Flight::get('instructorsService')->editInstructor($payload);
        Flight::json(['message' => "Instructor successfully updated.", 'data' => $instructor]);
    });

    /**
     * @OA\Delete(
     *      path="/instructors/{instructor_id}",
     *      tags={"instructors"},
     *      summary="Delete instructor by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Deleted instructor data or 500 status code exception otherwise"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="instructor_id", example="1", description="Instructor ID")
     * )
     */
    Flight::route('DELETE /@instructor_id', function($instructor_id) {
        if (empty($instructor_id)) {
            Flight::halt(500, "You must provide a valid instructor ID!");
        }

        Flight::get('instructorsService')->deleteInstructor($instructor_id);
        Flight::json(['message' => "Instructor successfully deleted."]);
    });

});

?>