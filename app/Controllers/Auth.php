<?php namespace Controllers;

use Core\View,
    Helpers\Url,
    Helpers\Session,
    Helpers\Password,
    Core\Controller;
use Helpers\SimpleCurl as Curl;
class Auth extends Controller {
  public function __construct(){
    parent::__construct();
    //$this->_model = new \Models\Rests();
    $this->_model = new \Models\Auth();

  }

  public function logout(){
  	Session::destroy();
  	Url::redirect();
  }

  public function login(){
  	$data['title'] = 'Login';
  	if (Session::get('logged')) {
  		Url::redirect();
  	}

  	if (isset($_POST['submit'])) {
  		$username = $_POST['username'];
  		$password = $_POST['password'];

  		if (Password::verify($password, $this->_model->get_user_hash($username)) != 0) {
			Session::set('logged', true);
			Session::set('user', $this->_model->get_user($username));
			Url::redirect();
  		} else {
  			$error[] = "Wrong username or password";
  		}
  	}

	View::renderTemplate('header', $data);
	View::render('login', $data, $error);
	View::renderTemplate('footer', $data);
  
  }
}