<?php namespace Controllers;
use Core\View,
    Helpers\Url,
    Helpers\Session,
    Helpers\Password,
    Core\Controller;
use Helpers\SimpleCurl as Curl;
class Mail extends Controller {

	function test() {
		$to      = 'shaishofet@gmail.com';
		$subject = 'the subject';
		$message = 'hello';
		$headers = 'From: foodie@zed3.us' . "\r\n" .
		    'Reply-To: foodie@zed3.us' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
	    // $mail = new \Helpers\PhpMailer\mail();
	    // $mail->setFrom('foodie@zed3.us');
	    // $mail->addAddress('shaishofet@gmail.com');
	    // $mail->subject('Important Email');
	    // $mail->body("<h1>Hey</h1><p>I like this <b>Bold</b> Text!</p>");
	    // var_dump($mail->send());
	}


	function send_delivery($delivery) {
		$to      = 'shaishofet@gmail.com';
		$subject = "[Food] $delivery->rest_name";

$message = '<html><body>';
$message .= "<h3>המשלוח ממסעדת $delivery->rest_name סופק לחברה</h3>";
$message .= '<p>Send via <a href="http://foodie.zed3.us">Foodie</a></p>';
$message .= '</body></html>';		

		$headers = 'From: foodie@zed3.us' . "\r\n" .
		    'Reply-To: foodie@zed3.us' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

// Additional headers
$headers .= 'From: Foodie <foodie@zed3.us>' . "\r\n";

		mail($to, $subject, $message, $headers);
	    // $mail = new \Helpers\PhpMailer\mail();
	    // $mail->setFrom('foodie@zed3.us');
	    // $mail->addAddress('shaishofet@gmail.com');
	    // $mail->subject('Important Email');
	    // $mail->body("<h1>Hey</h1><p>I like this <b>Bold</b> Text!</p>");
	    // var_dump($mail->send());
	}


	private function mail() {
		$to      = 'shaishofet@gmail.com';
		$subject = 'the subject';
		$message = 'hello';
		$headers = 'From: foodie@zed3.us' . "\r\n" .
		    'Reply-To: foodie@zed3.us' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
	    // $mail = new \Helpers\PhpMailer\mail();
	    // $mail->setFrom('foodie@zed3.us');
	    // $mail->addAddress('shaishofet@gmail.com');
	    // $mail->subject('Important Email');
	    // $mail->body("<h1>Hey</h1><p>I like this <b>Bold</b> Text!</p>");
	    // var_dump($mail->send());
	}
}