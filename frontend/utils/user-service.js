class UserService {
    constructor() {
        this.baseUrl = 'users';
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

    create(userData) {
        return new Promise((resolve, reject) => {
            RestClient.post(this.baseUrl, userData, resolve, reject);
        });
    }

    update(id, userData) {
        return new Promise((resolve, reject) => {
            RestClient.put(`${this.baseUrl}/${id}`, userData, resolve, reject);
        });
    }

    delete(id) {
        return new Promise((resolve, reject) => {
            RestClient.delete(`${this.baseUrl}/${id}`, {}, resolve, reject);
        });
    }

    // Additional methods specific to user management
    changePassword(userId, passwordData) {
        return new Promise((resolve, reject) => {
            RestClient.put(`${this.baseUrl}/${userId}/password`, passwordData, resolve, reject);
        });
    }

    getUsersByRole(role) {
        return new Promise((resolve, reject) => {
            RestClient.get(`${this.baseUrl}?role=${role}`, resolve, reject);
        });
    }
}

const userService = new UserService();