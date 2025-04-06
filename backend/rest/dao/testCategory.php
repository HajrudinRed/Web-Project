<?php

require_once __DIR__ . '/CategoriesDao.class.php';

$categories_dao = new CategoriesDao();

// Add a new category
$new_category = [
    "name" => "Programming",
    "number_of_courses" => 10,
    "image_url" => "https://example.com/image.jpg",
    "description" => "Learn programming languages"
];
$added_category = $categories_dao->addCategory($new_category);
print_r($added_category);

// Get all categories
$categories = $categories_dao->getCategories();
print_r($categories);

// Get a category by ID
$category_id = $added_category['id'];
$category = $categories_dao->getCategoryByID($category_id);
print_r($category);

// Update the category
$updated_category = [
    "name" => "Advanced Programming",
    "number_of_courses" => 15,
    "image_url" => "https://example.com/new_image.jpg",
    "description" => "Advanced programming topics"
];
$categories_dao->editCategory($category_id, $updated_category);
print_r($categories_dao->getCategoryByID($category_id));

// Delete the category
//$categories_dao->deleteCategory($category_id);
//print_r($categories_dao->getCategories());
?>