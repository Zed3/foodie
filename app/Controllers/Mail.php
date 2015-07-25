<?php namespace Controllers;
use Core\View,
    Helpers\Url,
    Helpers\Session,
    Helpers\Password,
    Core\Controller;
use Helpers\SimpleCurl as Curl;
class Mail extends Controller {

	function test() {
	    $mail = new \Helpers\PhpMailer\mail();
	    $mail->setFrom('noreply@domain.com');
	    $mail->addAddress('shaishofet@gmail.com');
	    $mail->subject('Important Email');
	    $mail->body("<h1>Hey</h1><p>I like this <b>Bold</b> Text!</p>");
	    $mail->send();
	}
}