<?php namespace Controllers;

use Core\View,
    Helpers\Url,
    Helpers\Session,
    Core\Controller;
use Helpers\SimpleCurl as Curl;
class User extends Controller {
  private $_model;
  private $_user;

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

  public function dishes() {
    $user_id = $this->_user->user_id;
    $data['results_dishes'] = $this->_model->get_fav_dishes($user_id);

    View::renderTemplate('header', $data);
    View::render('fav_dishes', $data);
    View::renderTemplate('footer', $data);	
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
}