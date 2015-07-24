<?php namespace Models;
use Core\Model;

class User extends \Core\Model {

  protected $db;

  function __construct(){
    $this->db = \Helpers\Database::get();
  }

  public function get_fav_dishes($user_id){
  	$data = $this->db->select("SELECT * FROM favorites JOIN dishes USING(dish_id, rest_id) JOIN restaurants USING(rest_id) WHERE user_id = :user_id", array(':user_id' => $user_id));
  	return $data;
  }

}