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
		$subject =  "[Foodie] - $delivery->rest_name";
		$message = "<h3>המשלוח ממסעדת $delivery->rest_name סופק לחברה</h3>";
		$message .= "<hr/>";
		$message .= "Sent via <a href=''>Foodie</a>";
	    $mail = new \Helpers\PhpMailer\Mail();
//	    $mail->SMTPDebug = 2;                               // Enable verbose debug output
	    $mail->CharSet = 'UTF-8';
	    $mail->isSMTP();                                    // Set mailer to use SMTP
	    $mail->Host = 'smtp.gmail.com'; 					// Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                             // Enable SMTP authentication
	    $mail->Username = GMAIL_UN;
	    $mail->Password = GMAIL_PASS;
	    $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 465;                                  // TCP port to connect, tls=587, ssl=465
	    $mail->From = GMAIL_UN;

	    $mail->addAddress(MAIL_TO);
	    $mail->subject($subject);
	    $mail->body($message);

	    $mail->FromName = 'Trusteer Foodie';
	    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	    $mail->isHTML(false);                                  // Set email format to HTML
	    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	    if(!$mail->send()) {
	        echo 'Mailer Error: ' . $mail->ErrorInfo;
	    }
	}


	private function mail() {	
	}
}