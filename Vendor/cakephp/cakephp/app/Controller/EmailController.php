<?php
App::uses("AppController", "Controller");

class EmailController extends AppController {

    public function myview($uuid) {
        $this->set("uuid", $uuid);
    }

    public function sendEmail () {
		$response = $this->request["data"];
		$privatekey = "6Ld7zQMaAAAAACtEa7wfbJODYKNU09FxI8aazRLP";
		$url = "https://www.google.com/recaptcha/api/siteverify";
		$data = array("secret" => $privatekey, "response" => $response["g-recaptcha-response"]);

		$options = array(
			"http" => array(
				"header"  => "Content-type: application/x-www-form-urlencoded\r\n",
				"method"  => "POST",
				"content" => http_build_query($data),
			),
		);

		$context  = stream_context_create($options);
		$json_result = file_get_contents($url, false, $context);
		$result = json_decode($json_result);

		$this->EmailValidator = $this->Components->load('ValidateEmail');
		$emailValid = $this->EmailValidator->validate($response["Contact"]["emailFrom"]);
		
		if (!$result->success) {
			$this->Session->write("captchaError", true);
			$this->redirect("/contact");
		} else if (!$emailValid) {
			$this->Session->write("emailError", true);
			$this->redirect("/contact");
		} else {
			$email = new CakeEmail("default");
			$email->emailFormat("html")
				->to("kamil.wan05@gmail.com")                            
				->from($response["Contact"]["emailFrom"])
				->viewVars(array("message" => $response["Contact"]["message"], "senderName" => $response["Contact"]["senderName"], "emailFrom" => $response["Contact"]["emailFrom"]))
				->template("contact_view", "mytemplate")
				->attachments(array(
					array(         
						"file" => ROOT."/app/webroot/img/bg-pattern.jpg",
						"mimetype" => "image/jpg",
						"contentId" => "background"
					),
					array(         
						"file" => ROOT."/app/webroot/img/wallet.png",
						"mimetype" => "image/png",
						"contentId" => "logo"
					)
				))
				->subject("Contact message from Wallency")
				->send();
			}
	}
}
