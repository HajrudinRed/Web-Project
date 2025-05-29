<?php

require_once __DIR__ . '/UserDao.class.php';

$user_dao = new UserDao();

$user_dao = new UserDao();
print_r($user_dao->getUsers());

for ($i = 1; $i <= 10; $i++) {
    $new_user = [
        "name" => "User $i",
        "email" => "user$i@example.com",
        "password" => "password$i",
        "role" => ($i % 3 == 0 ? "admin" : ($i % 2 == 0 ? "instructor" : "student"))
    ];
    $added_user = $user_dao->addUser($new_user);
    print_r($added_user);
}

/*
// Add a new user
$new_user = [
    "name" => "John Doe",
    "email" => "johndoe@example.com",
    "password" => "password123",
    "role" => "student"
];
$added_user = $user_dao->addUser($new_user);
print_r($added_user);

// Get all users
$users = $user_dao->getUsers();
print_r($users);

// Get a user by ID
$user_id = $added_user['id'];
$user = $user_dao->getUserByID($user_id);
print_r($user);

// Update the user
$updated_user = [
    "name" => "John Smith",
    "email" => "johnsmith@example.com",
    "password" => "newpassword123",
    "role" => "admin"
];
$user_dao->editUser($user_id, $updated_user);
print_r($user_dao->getUserByID($user_id));

// Delete the user
//$user_dao->deleteUser($user_id);
//print_r($user_dao->getUsers());
?>
*/