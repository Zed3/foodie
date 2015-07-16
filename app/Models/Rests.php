<?php namespace Models;
use Core\Model;

class Rests extends \Core\Model {

  protected $db;

  function __construct(){
    $this->db = \Helpers\Database::get();
  }

  public function get_restaurants() {
    $query = "
      SELECT restaurants.*, avg_delivery_time FROM restaurants JOIN
(SELECT
    rest_id,
    CONCAT(AVG(HOUR(timestamp) * 60 + MINUTE(timestamp)) DIV 60,
            ':',
            LPAD(ROUND(AVG(HOUR(timestamp) * 60 + MINUTE(timestamp)) MOD 60),
                    2,
                    0)) AS avg_delivery_time
FROM
    delivery_times GROUP BY rest_id) AS avg_times
      USING(rest_id)
    ";
    return $this->db->select($query);
  }

  public function get_restaurant_avg_delivery_time($rest_id) {
    $query = "
      SELECT
          rest_id,
          CONCAT(AVG(HOUR(timestamp) * 60 + MINUTE(timestamp)) DIV 60,
                  ':',
                  LPAD(ROUND(AVG(HOUR(timestamp) * 60 + MINUTE(timestamp)) MOD 60),
                          2,
                          0)) AS avg_delivery_time
      FROM
          delivery_times
      WHERE rest_id = :rest_id
    ";
    $result = $this->db->select($query, array(':rest_id' => $rest_id));
    return $result[0]->avg_delivery_time;
  }

  public function get_restaurant($id) {
//    return $this->db->select("SELECT * FROM restaurants WHERE rest_id = :id LIMIT 1", array(':id' => $id));
    $query = "
      SELECT restaurants.*, avg_delivery_time FROM restaurants JOIN
(SELECT
    rest_id,
    CONCAT(AVG(HOUR(timestamp) * 60 + MINUTE(timestamp)) DIV 60,
            ':',
            LPAD(ROUND(AVG(HOUR(timestamp) * 60 + MINUTE(timestamp)) MOD 60),
                    2,
                    0)) AS avg_delivery_time
FROM
    delivery_times WHERE rest_id = :id) AS avg_times
      USING(rest_id)
 WHERE rest_id = :id      
      LIMIT 1
    ";
    return $this->db->select($query, array(':id' => $id));

  }

  public function get_dishes($rest_id) {
    return $this->db->select("SELECT * FROM dishes WHERE rest_id = :rest_id LIMIT 300", array(':rest_id' => $rest_id));
  }

  public function add_restaurant($data) {
    return $this->db->insert("restaurants",$data);
  }

  public function add_dish($data) {
    return $this->db->insert("dishes",$data);
  }

  public function search_dishes($keyword) {
    return $this->db->select('SELECT * FROM dishes JOIN restaurants USING(rest_id) WHERE dish_title LIKE :keyword OR dish_desc LIKE :keyword', array(':keyword' => '%' . $keyword . '%'));
  }

  public function parse_from_tenbis(){
  }

  public function delivery_report($data){

    /*
SELECT
    rest_id,
    CONCAT(AVG(HOUR(timestamp) * 60 + MINUTE(timestamp)) DIV 60,
            ':',
            LPAD(ROUND(AVG(HOUR(timestamp) * 60 + MINUTE(timestamp)) MOD 60),
                    2,
                    0)) AS avg_delivery_time
FROM
    delivery_times
GROUP BY rest_id
    */
    return $this->db->insert("delivery_times",$data);
  }
}