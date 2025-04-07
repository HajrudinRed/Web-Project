<?php

require_once __DIR__ . "/BaseDao.class.php";

class ReviewsDao extends BaseDao {
    public function __construct() {
        parent::__construct("reviews");
    }

    public function addReview($review) {
        return $this->insert("reviews", $review);
    }    

    public function getReviews() {
        $query = "SELECT * 
        FROM reviews";

        return $this->query($query, []);
    }

    public function getReviewByID($review_id) {
        $query = "SELECT * 
        FROM reviews
        WHERE id = :id";

        return $this->query_unique($query, [
            "id" => $review_id
        ]);
    }

    public function deleteReview($review_id) {
        $query = "DELETE FROM reviews WHERE id = :id";
        $this->execute($query, [
            'id' => $reviews_id
        ]);
    }

    public function editReview($review_id, $review) {
        $query = "UPDATE reviews SET rating = :rating, review_text = :review_text WHERE id = :id";

        $this->execute($query, [
            'id' => $review_id,
            'rating' => $review['rating'],
            'review_text' => $review['review_text'],
            
        ]);
    }
}

?>