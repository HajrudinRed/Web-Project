class CourseService {
    constructor() {
        this.baseUrl = 'courses';
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

    create(courseData) {
        return new Promise((resolve, reject) => {
            RestClient.post(this.baseUrl, courseData, resolve, reject);
        });
    }

    update(id, courseData) {
        return new Promise((resolve, reject) => {
            RestClient.put(`${this.baseUrl}/${id}`, courseData, resolve, reject);
        });
    }

    delete(id) {
        return new Promise((resolve, reject) => {
            RestClient.delete(`${this.baseUrl}/${id}`, {}, resolve, reject);
        });
    }
}

const courseService = new CourseService();