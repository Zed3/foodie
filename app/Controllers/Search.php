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

    if (isset($_POST['submit'])) {
    }

    View::renderTemplate('header', $data);
    View::render('search', $data, $error);
    View::renderTemplate('footer', $data);
  }
}