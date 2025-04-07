<?php

require_once __DIR__ . '/ReviewsDao.class.php';

$reviews_dao = new ReviewsDao();

// Add a new review
$new_review = [
    "rating" => 5,
    "review_text" => "Excellent course!"
];
$added_review = $reviews_dao->addReview($new_review);
print_r($added_review);

// Get all reviews
$reviews = $reviews_dao->getReviews();
print_r($reviews);

// Get a review by ID
$review_id = $added_review['id'];
$review = $reviews_dao->getReviewByID($review_id);
print_r($review);

// Update the review
$updated_review = [
    "rating" => 4,
    "review_text" => "Good course, but could be improved."
];
$reviews_dao->editReview($review_id, $updated_review);
print_r($reviews_dao->getReviewByID($review_id));

// Delete the review
//$reviews_dao->deleteReview($review_id);
//print_r($reviews_dao->getReviews());
?>