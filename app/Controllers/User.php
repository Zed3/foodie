<?php namespace Controllers;

use Core\View,
    Helpers\Url,
    Helpers\Session,
    Core\Controller;
use Helpers\SimpleCurl as Curl;
class User extends Controller {
  private $_model;
  private $_user;
  public $user_id;

  public function __construct(){
    parent::__construct();
    $this->_model = new \Models\User();
    $this->get_current_user();
  }

  public function get_current_user() {
  	if ($this->_user) return $this->_user;
  	if (Session::get('user')) {
    	$this->_user = Session::get('user');
    }
  	return $this->_user;
  }

  public function current_user_id() {
    return $this->_user->user_id;
  }

  public function dishes() {
    $data['title'] = "מנות מועדפות";
    $user_id = $this->_user->user_id;
    $data['results_dishes'] = $this->_model->get_fav_dishes($user_id);
    $data['random_dishes'] = $data['results_dishes'] ?: $this->_model->get_rand_dishes(20);

    View::renderTemplate('header', $data);
    View::render('fav_dishes', $data);
    View::render('random_dish', $data);    
    View::renderTemplate('footer', $data);  
  }

  public function get_fav_dishes_for_rest($rest_id) {
    $user_id = $this->_user->user_id;
    return $this->_model->get_fav_dishes($user_id, $rest_id);
  }

  public function rand_dish() {
    $data['title'] = "מנה בהפתעה";
    $data['random_dishes'] = $this->_model->get_rand_dishes(20);

    View::renderTemplate('header', $data);
    View::render('random_dish', $data);    
    View::renderTemplate('footer', $data);  
  }

  public function manage_favorite($rest_id, $dish_id=null) {
    $user_id = $this->_user->user_id;
    $data = array(
      'user_id' => $user_id,
      'rest_id' => $rest_id,
      'dish_id' => $dish_id
    );

    if ($this->_model->check_fav($data)) {
      $this->_model->del_favorite($data);   
    } else {
      $this->_model->add_favorite($data);
    }
  }

  public function add_favorite($rest_id, $dish_id=null) {
    $user_id = $this->_user->user_id;
    $data = array(
      'user_id' => $user_id,
      'rest_id' => $rest_id,
      'dish_id' => $dish_id
    );

    $this->_model->add_favorite($data);    
  } 

  public function del_favorite($rest_id, $dish_id=null) {
    $user_id = $this->_user->user_id;

    $data = array(
      'user_id' => $user_id,
      'rest_id' => $rest_id,
      'dish_id' => $dish_id
    );

    $this->_model->del_favorite($data);    
  } 
}