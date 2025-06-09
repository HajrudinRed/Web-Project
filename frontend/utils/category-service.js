class CategoryService {
    constructor() {
        this.baseUrl = 'categories';
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

    create(categoryData) {
        return new Promise((resolve, reject) => {
            RestClient.post(this.baseUrl, categoryData, resolve, reject);
        });
    }

    update(id, categoryData) {
        return new Promise((resolve, reject) => {
            RestClient.put(`${this.baseUrl}/${id}`, categoryData, resolve, reject);
        });
    }

    delete(id) {
        return new Promise((resolve, reject) => {
            RestClient.delete(`${this.baseUrl}/${id}`, {}, resolve, reject);
        });
    }
}

const categoryService = new CategoryService();