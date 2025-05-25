<?php
require_once __DIR__ . '/BaseDao.class.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthDao extends BaseDao {
   public $table_name;

   public function __construct() {
       $this->table_name = "users";
       parent::__construct($this->table_name);
   }


   public function get_user_by_email($email) {
       $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
       return $this->query_unique($query, ['email' => $email]);
   }
}
