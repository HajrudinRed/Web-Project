<?php

require_once __DIR__ . "/../dao/UserDao.class.php";
require_once __DIR__ . '/../utils/Logger.php';
require_once __DIR__ . "/BaseService.class.php";

class UserService extends BaseService {
    private $userDao;

    public function __construct() {
        $this->userDao = new UserDao();
    }

    public function addUser($user) {
        if (isset($user['password'])) {
            $user['password'] = password_hash($user['password'], PASSWORD_BCRYPT);
        }
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
        $user_id = $user['id'];
        unset($user['id']);
        if (isset($user['password']) && !empty($user['password'])) {
            $user['password'] = password_hash($user['password'], PASSWORD_BCRYPT);
        }

        $this->userDao->editUser($user_id, $user);
    }
}


?>

