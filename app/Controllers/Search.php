<?php namespace Controllers;

use Core\View,
    Helpers\Url,
    Core\Controller;
use Helpers\SimpleCurl as Curl;
class Search extends Controller {
  private $_model;
  private $_rests_file = 'rests.json';

  public function __construct(){
    parent::__construct();
    $this->_model = new \Models\Rests();
  }

  public function search_post() {
    if (isset($_REQUEST['q'])) {
      $this->search($_REQUEST['q']);
    } else {
      Url::redirect();
    }
  }

  public function search($keyword)
  {
    $data['title'] = 'חיפוש';
    $data['results_dishes'] = $this->_model->search_dishes($keyword);
    $data['results_restaurants'] = $this->_model->search_restaurants($keyword);
    $data['keyword'] = $keyword;

    View::renderTemplate('header', $data);
    View::render('search_results', $data);
    View::renderTemplate('footer', $data);
  }

  public function advanced_search() {
    $data['title'] = 'חיפוש מתקדם';
    $data['sub_load'] = 1;

    if (isset($_REQUEST['submit'])) {

      //build up query
      $query = 'SELECT * FROM dishes JOIN restaurants USING(rest_id) WHERE ';
      $conds = [];
      $params = [];

      if ($_REQUEST['dish_title']) {
        $conds[] = '(dish_title LIKE :dish_title OR dish_desc LIKE :dish_title)';
        $params[':dish_title'] = '%' . $_REQUEST['dish_title'] . '%';
      }

      if ($_REQUEST['is_kosher']) {
        $conds[] = 'rest_kosher = 1';
      }

      if ($_REQUEST['dish_image']) {
        $conds[] = 'dish_image <> ""';
      }

      if ($_REQUEST['price_from']) {
        $conds[] = 'dish_price >= :price_from';
        $params[':price_from'] = $_REQUEST['price_from'];
      }

      if ($_REQUEST['price_to']) {
        $conds[] = 'dish_price <= :price_to';
        $params[':price_to'] = $_REQUEST['price_to'];
      }

      $query .= implode(" AND ", $conds);
      $query .= " LIMIT 100";

      if ($conds) $data['results_dishes'] = $this->_model->advanced_search($query, $params);
    }

    View::renderTemplate('header', $data);
    View::render('search', $data, $error);

    if ($data['results_dishes']) {  View::render('search_results', $data); }

    View::renderTemplate('footer', $data);
  }
}