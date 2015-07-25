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
  	$data['title'] = 'התחברות';
  	if (Session::get('logged')) {
  		Url::redirect();
  	}

  	if (isset($_POST['submit'])) {
  		$username = $_POST['username'];
  		$password = $_POST['password'];

  		if (Password::verify($password, $this->_model->get_user_hash($username)) != 0) {
        $this->login_user($username);        
  		} else {
  			$error[] = "Wrong username or password";
  		}
  	}

	View::renderTemplate('header', $data);
	View::render('login', $data, $error);
	View::renderTemplate('footer', $data);
  
  }

  public function login_user($username) {
    Session::set('logged', true);
    Session::set('user', $this->_model->get_user($username));
    Url::redirect();    
  }

  public function register(){
    if (Session::get('logged')) {
      Url::redirect();
    }
    
    $data['title'] = 'הרשמה';
    if(isset($_POST['submit'])){
      $username = $_POST['username'];
      $password = $_POST['password'];
      $email = $_POST['email'];
      if($username == ''){
        $error[] = 'שם משתמש הוא שדה נדרש';
      }

      if ($this->_model->get_user($username)) {
        $error[] = 'שם המשתמש תפוס, בעסה';
      }

      if($password == ''){
        $error[] = 'צריך סיסמא כדי להירשם, אחרת כל אחד יוכל להיכנס במקומך...';
      }
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $error[] = 'כדי להירשם צריך מייל, למקרה ששכחת את הסיסמא';
      }
      if(!$error){
        $postdata = array(
          'user_name' => $username,
          'user_password' => \helpers\password::make($password),
          'user_email' => $email
        );
        $this->_model->add_user($postdata);
        $this->login_user($username);
//        Session::set('message','User Added');
        Url::redirect();
      }
    }
    View::renderTemplate('header',$data);
    View::render('register',$data,$error);
    View::renderTemplate('footer',$data);
  }

}