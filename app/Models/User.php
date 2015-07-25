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


  public function check_fav($data){
  	$data = $this->db->select("SELECT * FROM favorites WHERE user_id = :user_id AND rest_id = :rest_id AND dish_id = :dish_id LIMIT 1", array(':user_id' => $data['user_id'], ':rest_id' => $data['rest_id'], ':dish_id' => $data['dish_id']));
  	return $data[0];
  }

  public function add_favorite($data) {
    return $this->db->insert("favorites", $data);
  }

  public function del_favorite($data) {
    $where = array(
      'user_id' => $data['user_id'],
      'rest_id' => $data['rest_id'],
      'dish_id' => $data['dish_id']
    );

    return $this->db->delete("favorites", $where);
  }

}
