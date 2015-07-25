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
	    $mail = new \Helpers\PhpMailer\mail();
	    $mail->setFrom('foodie@zed3.us');
	    $mail->addAddress('shaishofet@gmail.com');
	    $mail->subject('Important Email');
	    $mail->body("<h1>Hey</h1><p>I like this <b>Bold</b> Text!</p>");
	    var_dump($mail->send());
	}
}