<?php

require_once __DIR__ . "/../dao/ReviewsDao.class.php";

class ReviewsService {
    private $reviewDao;

    public function __construct() {
        $this->reviewDao = new ReviewsDao();
    }

    public function addReview($review) {
        return $this->reviewDao->addReview($review);
    }

    public function getReviews() {
        $data = $this->reviewDao->getReviews();
        return ["data" => $data];
    }

    public function getReviewByID($review_id) {
        return $this->reviewDao->getReviewByID($review_id);
    }

    public function deleteReview($review_id) {
        $this->reviewDao->deleteReview($review_id);
    }

    public function editReview($review) {
        $review_id = $review['id'];
        unset($review['id']);

        $this->reviewDao->editReview($review_id, $review);
    }
}

?>