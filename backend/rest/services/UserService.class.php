<?php

require_once __DIR__ . "/../dao/UserDao.class.php";

class UserService {
    private $userDao;

    public function __construct() {
        $this->userDao = new UserDao();
    }

    public function addUser($user) {
        $user['password'] = password_hash($user['password'], PASSWORD_BCRYPT);
        return $this->userDao->addUser($user);
    }

    public function getUsers() {
        $data = $this->userDao->getUsers();
        return ["data" => $data];
    }

    public function getUserByID($user_id) {
        return $this->userDao->getUserByID($user_id);
    }

    public function deleteUser($user_id) {
        $this->userDao->deleteUser($user_id);
    }

    public function editUser($user) {
        $user_id = $user['user_id'];
        unset($user['user_id']);

        $this->userDao->editUser($user_id, $user);
    }
}

?>

