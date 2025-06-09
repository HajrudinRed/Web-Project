class InstructorService {
    constructor() {
        this.baseUrl = 'instructors';
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

    create(instructorData) {
        return new Promise((resolve, reject) => {
            RestClient.post(this.baseUrl, instructorData, resolve, reject);
        });
    }

    update(id, instructorData) {
        return new Promise((resolve, reject) => {
            RestClient.put(`${this.baseUrl}/${id}`, instructorData, resolve, reject);
        });
    }

    delete(id) {
        return new Promise((resolve, reject) => {
            RestClient.delete(`${this.baseUrl}/${id}`, {}, resolve, reject);
        });
    }
}

const instructorService = new InstructorService();