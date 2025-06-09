class ReviewService {
    constructor() {
        this.baseUrl = 'reviews';
    }

    getAll() {
        return new Promise((resolve, reject) => {
            RestClient.get(this.baseUrl, resolve, reject);
        });
    }

    getById(id) {
        return new Promise((resolve, reject) => {
            RestClient.get(`${this.baseUrl}/${id}`, resolve, reject);
        });
    }

    create(reviewData) {
        return new Promise((resolve, reject) => {
            RestClient.post(this.baseUrl, reviewData, resolve, reject);
        });
    }

    update(id, reviewData) {
        return new Promise((resolve, reject) => {
            RestClient.put(`${this.baseUrl}/${id}`, reviewData, resolve, reject);
        });
    }

    delete(id) {
        return new Promise((resolve, reject) => {
            RestClient.delete(`${this.baseUrl}/${id}`, {}, resolve, reject);
        });
    }
}

const reviewService = new ReviewService();