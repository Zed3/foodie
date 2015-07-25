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

  public function get_fav_dishes_for_rest($user_id, $rest_id){
  	$data = $this->db->select("SELECT * FROM favorites JOIN dishes USING(dish_id, rest_id) JOIN restaurants USING(rest_id) WHERE user_id = :user_id AND rest_id = :rest_id", array(':user_id' => $user_id, ':rest_id' => $rest_id));
  	return $data;
  }

  public function get_rand_dishes($limit=20){
  	$data = $this->db->select("SELECT * FROM dishes JOIN restaurants USING(rest_id) WHERE dish_price > 20 ORDER BY RAND() LIMIT :limit", array(':limit' => $limit));
  	return $data;
  }
}