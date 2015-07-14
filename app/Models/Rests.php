<?php namespace Models;
use Core\Model;

class Rests extends \Core\Model {

  protected $db;

  function __construct(){
    $this->db = \Helpers\Database::get();
  }

  public function get_restaurants() {
    return $this->db->select("SELECT * FROM restaurants");
  }

  public function get_restaurant($id) {
    return $this->db->select("SELECT * FROM restaurants WHERE rest_id = :id LIMIT 1", array(':id' => $id));
  }

  public function get_dishes($rest_id) {
    return $this->db->select("SELECT * FROM dishes WHERE rest_id = :rest_id", array(':rest_id' => $rest_id));
  }

  public function add_restaurant($data) {
    return $this->db->insert("restaurants",$data);
  }

  public function add_dish($data) {
    return $this->db->insert("dishes",$data);
  }

  public function search_dishes($keyword) {
    return $this->db->select('SELECT * FROM dishes WHERE dish_title LIKE :keyword', array(':keyword' => '%' . $keyword . '%'));
  }

  public function parse_from_tenbis(){
  }
}