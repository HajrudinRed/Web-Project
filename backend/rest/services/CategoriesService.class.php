<?php

require_once __DIR__ . "/../dao/CategoriesDao.class.php";

class CategoriesService {
    private $categoriesDao;

    public function __construct() {
        $this->categoriesDao = new CategoriesDao();
    }

    public function addCategory($category) {
        return $this->categoriesDao->addCategory($category);
    }

    public function getCategories() {
        $data = $this->categoriesDao->getCategories();
        return ["data" => $data];
    }

    public function getCategoryByID($category_id) {
        return $this->categoriesDao->getCategoryByID($category_id);
    }

    public function deleteCategory($category_id) {
        $this->categoriesDao->deleteCategory($category_id);
    }

    public function editCategory($category) {
        $category_id = $category['id'];
        unset($category['id']);

        $this->categoriesDao->editCategory($category_id, $category);
    }
}

?>