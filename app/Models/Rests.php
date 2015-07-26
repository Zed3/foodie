<?php namespace Models;
use Core\Model;

class Rests extends \Core\Model {

  protected $db;

  function __construct(){
    $this->db = \Helpers\Database::get();
  }

  public function get_restaurants() {
    $query = "
      SELECT restaurants.*, REPLACE(rest_logo, 'https', 'http') AS rest_logo, avg_delivery_time FROM restaurants LEFT JOIN
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
          CONCAT(AVG(HOUR(arrived) * 60 + MINUTE(arrived)) DIV 60,
                  ':',
                  LPAD(ROUND(AVG(HOUR(arrived) * 60 + MINUTE(arrived)) MOD 60),
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
      SELECT restaurants.*, REPLACE(rest_logo, 'https', 'http') AS rest_logo, avg_delivery_time FROM restaurants LEFT JOIN
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

  public function get_all_dishes() {
    return $this->db->select("SELECT dish_title, dish_desc, dish_price, rest_name FROM dishes JOIN restaurants USING(rest_id) LIMIT 10000");
  }

  public function add_restaurant($data) {
    return $this->db->insert("restaurants",$data);
  }

  public function update_restaurant($data) {
    $where = array('rest_id' => $data['rest_id']);
    return $this->db->update("restaurants",$data, $where);

  }

   function add_dish($data) {
    return $this->db->insert("dishes",$data);
  }

  public function search_dishes($keyword) {
    return $this->db->select('SELECT * FROM dishes JOIN restaurants USING(rest_id) WHERE dish_title LIKE :keyword OR dish_desc LIKE :keyword LIMIT 100', array(':keyword' => '%' . $keyword . '%'));
  }

  public function search_restaurants($keyword) {
    return $this->db->select('SELECT * FROM restaurants WHERE rest_name LIKE :keyword', array(':keyword' => '%' . $keyword . '%'));
  }

  public function advanced_search($sql, $params){
    return $this->db->select($sql, $params);
  }

  public function parse_from_tenbis(){
  }

  public function now(){
    $res = $this->db->select("SELECT CURRENT_TIMESTAMP AS now");
    return $res[0]->now;
  }

  public function fetch_today_deliveries(){
    return $this->db->select("SELECT * FROM delivery_times JOIN restaurants USING(rest_id) WHERE DATE(timestamp) = DATE(CURRENT_TIMESTAMP) AND arrived IS NULL");
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
    $where = array('report_id' => $data['report_id']);
    return $this->db->update("delivery_times",$data, $where);
  }

  public function check_delivery($data){
    return $this->db->select("SELECT * FROM delivery_times WHERE DATE(timestamp) = DATE(CURRENT_TIMESTAMP) AND rest_id = :rest_id AND total_delivery = :total_delivery", array(':rest_id' => $data['rest_id'], ':total_delivery' => $data['total_delivery']));
  }

  public function add_delivery($data){
    return $this->db->insert("delivery_times", $data);
  }

  public function add_favorite($data) {
    return $this->db->insert("favorites", $data);
  }

}