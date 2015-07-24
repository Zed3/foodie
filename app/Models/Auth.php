<?php namespace Models;
use Core\Model;

class Auth extends \Core\Model {

  protected $db;

  function __construct(){
    $this->db = \Helpers\Database::get();
  }

  public function get_user_hash($username){
  	$data = $this->db->select("SELECT user_password FROM users WHERE user_name = :username LIMIT 1", array(':username' => $username));
  	return $data[0]->user_password;
  }

  public function get_user($username){
  	$data = $this->db->select("SELECT * FROM users WHERE user_name = :username  LIMIT 1", array(':username' => $username));
  	return $data[0];
  }

}