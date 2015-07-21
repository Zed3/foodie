<?php namespace Controllers;

use Core\View,
    Helpers\Url,
    Core\Controller;
use Helpers\SimpleCurl as Curl;
class Json extends Controller {
  public function __construct(){
    parent::__construct();
    //$this->_model = new \Models\Rests();
    $this->_model = new \Models\Rests();

  }

  public function search() {
    $keyword = $_REQUEST['term'];
    $data = $this->_model->search_restaurants($keyword);
    $output = [];
    //prepare data for json
    foreach ($data as $record) {
      $output[] = [
        "id" => $record->rest_id,
        "label" => $record->rest_name
      ];
    }
    $this->put($output);
  }

  public function all_dishes() {
    $data = $this->_model->get_all_dishes();
    $output = [];
    foreach ($data as $item) {
      $output["data"][] = array_values((array)$item);
    }
    $this->put($output);
  }

  public function put($data) {
    // header('Content-disposition: attachment; filename=file.json');
    // header('Content-type: application/json');
    echo json_encode($data);
  }
}