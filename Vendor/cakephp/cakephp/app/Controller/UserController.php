<?php
App::uses("AppController", "Controller");

class UserController extends AppController {

	public $uses = array();

	public function beforeFilter() {
		parent::beforeFilter();
		$this->loadModel("User");
		$this->loadModel("Wallet");
		App::uses("CakeText", "Utility");
		App::uses("CakeEmail", "Network/Email");
		if ($this->Session->read("loggedIn")) {
			$this->layout = "loggedIn";
		} else { 
			$this->layout = "default";
		}
		Configure::write("Config.language", $this->Session->read("language"));
        $locale = $this->Session->read("language");
        if ($locale && file_exists(APP . "View" . DS . $locale . DS . $this->viewPath . DS . $this->view . $this->ext)) {
            // e.g. use /app/View/fra/Pages/tos.ctp instead of /app/View/Pages/tos.ctp
            $this->viewPath = $locale . DS . $this->viewPath;
        }
	}

	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect("/");
		}
		if (in_array("..", $path, true) || in_array(".", $path, true)) {
			throw new ForbiddenException();
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact("page", "subpage", "title_for_layout"));

		try {
			$this->render(implode("/", $path));
		} catch (MissingViewException $e) {
			if (Configure::read("debug")) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

	public function registerUser() {
		$this->autoRender = false;
		$data = $this->request->data["RegisterUser"];
		$this->loadModel("Wallet");
		$this->User->set($data);
		$uuid = CakeText::uuid();

		$response = $this->request["data"];
		$privatekey = "6Ld7zQMaAAAAACtEa7wfbJODYKNU09FxI8aazRLP";
		$url = "https://www.google.com/recaptcha/api/siteverify";
		$dataCaptcha = array("secret" => $privatekey, "response" => $response["g-recaptcha-response"]);

		$options = array(
			"http" => array(
				"header"  => "Content-type: application/x-www-form-urlencoded\r\n",
				"method"  => "POST",
				"content" => http_build_query($dataCaptcha),
			),
		);

		$context  = stream_context_create($options);
		$json_result = file_get_contents($url, false, $context);
		$result = json_decode($json_result);
		
		if ($result->success) {
			try {
				$dateDiff = date_diff(new DateTime($data["birth_date"]), new DateTime("NOW"));
				$adult = $dateDiff->y >= 18 ? true : false;
			} catch (Exception $e) {
				echo $e->getMessage();
			}

			try {
				if (filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
					$emailDomain = explode("@", $data["email"]);
					if (filter_var(gethostbyname(dns_get_record($emailDomain[1], DNS_MX)[0]["target"]), FILTER_VALIDATE_IP)) {
						$emailValid = true;
					} else {
						$emailValid = false;
					}
				} else {
					$emailValid = false;
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}

			if ($this->User->validates() && $adult) {
				$this->User->save(array("id" => null, "login" => $data["login"], "name" => $data["name"], "surname" => $data["surname"], "password" => hash("SHA384", md5($data["password"])), "email" => $data["email"], "birthdate" => $data["birth_date"] .= " 00:00:00", "UUID" => $uuid, "base_currency" => $data["baseCurrency"], "verified" => 0));
				$this->Wallet->validator()->remove("login");
				$this->Wallet->save(array(
					"id" => null,
					"modified" => null,
					"created" => null,
					"userUUID" => $uuid,
					"usd" => 0,
					"eur" => 500,
					"chf" => 0,
					"pln" => 0,
					"gbp" => 0,
					"jpy" => 0,
					"cad" => 0,
					"rub" => 0,
					"cny" => 0,
					"czk" => 0,
					"try" => 0,
					"nok" => 0,
					"huf" => 0,
					"bitcoin" => 0,
					"ethereum" => 0,
					"lumen" => 0,
					"XRP" => 0,
					"litecoin" => 0,
					"eos" => 0,
					"Yearn-finance" => 0,
					"oil" => 0,
					"gold" => 0,
					"copper" => 0,
					"silver" => 0,
					"palladium" => 0,
					"platinum" => 0,
					"nickel" => 0,
					"aluminum" => 0
				));
				
				$email = new CakeEmail("default");
				$email->emailFormat("html")
					->to($data["email"])                            
					->from(array("frezi12345cr@gmail.com" => "wallency"))
					->viewVars(array("uuid" => $uuid))
					->template("myview", "mytemplate")
					->attachments(array(
						array(         
							"file" => ROOT."/app/webroot/img/wallency-email.jpg",
							"mimetype" => "image/jpg",
							"contentId" => "background"
						),
						array(         
							"file" => ROOT."/app/webroot/img/icon-email.jpg",
							"mimetype" => "image/jpg",
							"contentId" => "icon"
						)
					))
					->subject("subject")
					->send();
				$this->redirect("/login");
			} else {
				$this->log(print_r($this->User->validationErrors, true), "validation");
			}
		} else {
			$this->Session->write("captchaError", true);
			$this->redirect("/register");
		}
	}

	public function wallet () {
		if ($this->Session->read("loggedIn")) {

			$cryptoCurrencies = ["bitcoin", "ethereum", "lumen", "XRP", "litecoin", "eos", "Yearn-finance"];
			$resources = ["oil", "gold", "copper", "silver", "palladium", "platinum", "nickel", "aluminum"];

			$wallet = $this->Wallet->find("first", array("conditions" => array("userUUID" => $this->Session->read("userUUID"))));
			$userBaseCurrency = $this->User->find("first", array("conditions" => array("UUID" => $this->Session->read("userUUID"))))["User"]["base_currency"];

			$this->set("wallet", $wallet);
			$this->set("currencies", Configure::read("currencies"));
			$this->set("cryptoCurrencies", $cryptoCurrencies);
			$this->set("resources", $resources);
			$this->set("userBaseCurrency", $userBaseCurrency);

			App::uses("HttpSocket", "Network/Http");
			$httpSocket = new HttpSocket();
			$response = $httpSocket->get("https://www.bankier.pl/surowce/notowania");
			$html = file_get_contents("https://stackoverflow.com/questions/ask");
			$this->set("response", str_replace("\"", "'", str_replace("\n", "", htmlentities($response))));

		} else {
			$this->redirect("/home");
		}
		
	}

	public function loginUser () {
		$this->autoRender = false;
		$data = $this->request->data["LoginUser"];
		$this->loadModel("Wallet");
		$userData = $this->User->find("first", array("conditions" => array("login" => $data["loginOrEmail"], "password" => hash("SHA384", md5($data["password"])))));
		if (empty($userData)) {
			$userData = $this->User->find("first", array("conditions" => array("email" => $data["loginOrEmail"], "password" => $data["password"])));
		} 
		
		if (empty($userData)) {
			$this->Session->write("loginError", true);
			$this->redirect("/login");
		}

		if ($userData["User"]["verified"] == false) {
			$this->Session->write("verificationError", true);
			$this->redirect("/login");
		}

		$walletId = $this->Wallet->find("first", array("conditions" => array("userUUID" => $userData["User"]["UUID"]), "fields" => "id"));

		
		$this->Session->write("loggedIn", true);
		$this->Session->write("userName", $userData["User"]["login"]);
		$this->Session->write("userUUID", $userData["User"]["UUID"]);
		$this->Session->write("walletId", $walletId["Wallet"]["id"]);
		$this->Session->write("baseCurrency", $userData["User"]["base_currency"]);
		$this->redirect("/wallet");
	
	}

	public function logout () {
		$this->autoRender = false;
		$this->Session->write("loggedIn", false);
		$this->redirect("/home");
	}

	public function activate () {
		$this->loadModel("User");
		$uuid = $this->params->query["uuid"];
		$user = $this->User->find("first", array("conditions" => array("UUID" => $uuid)));
		
		if ($user["User"]["verified"] == 0) {
			$this->User->updateAll(array("verified" => 1),array("UUID" => $uuid));
			$this->set("alreadyVerified", 0);
		} else {
			$this->set("alreadyVerified", 1);
		}
	}

	public function changePasswordForm () {
		if(!$this->Session->read("loggedIn")) {
			$this->redirect("/home");
		}
	}

	public function changePassword () {
		$this->autoRender = false;
		$data = $this->request->data["changePassword"];
		$user = $this->User->find("first", array("conditions" => array("password" => hash("SHA384", md5($data["currentPassword"])))));

		

		if (!empty($user) && isset($user)) {
			if ($data["newPasswordConfirm"] == $data["newPassword"]) {
				$regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-._]).{8,}$/";
				$match = preg_match($regex, $data["newPassword"]);
				if ($match) {
					$this->User->updateAll(array("password" => "'".hash("SHA384", md5($data["newPassword"]))."'"),array("password" => hash("SHA384", md5($data["currentPassword"]))));
					$this->Session->write("passwordChanged", true);
					$this->redirect("/change-password-form");
				} else {
					$this->Session->write("passwordRegexError", true);
					$this->redirect("/change-password-form");
				}
				
			} else {
				$this->Session->write("passwordMatchError", true);
				$this->redirect("/change-password-form");
			}
		} else {
			$this->Session->write("oldPasswordError", true);
			$this->redirect("/change-password-form");
		}
	}

	public function profile () {
		if(!$this->Session->read("loggedIn")) {
			$this->redirect("/home");
		}
		$this->loadModel("History");
		$this->loadModel("Wallet");
		$wallet = $this->Wallet->find("first", array("conditions" => array("userUUID" => $this->Session->read("userUUID"))));
		$history = $this->History->find("all", array("conditions" => array("wallet_id" => $wallet["Wallet"]["id"])));
		$this->set("history", $history);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.ratesapi.io/api/latest?base=".strtoupper($this->Session->read("baseCurrency")));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = json_decode(curl_exec($ch),true);
		curl_close($ch);

		$this->set("currencies", Configure::read("currencies"));
		$this->set("apiResult", $result);
	}

	public function history () {
		$this->loadModel("TransactionHistory");
		if(!$this->Session->read("loggedIn")) {
			$this->redirect("/home");
		}
		$wallet = $this->Wallet->find("first", array("conditions" => array("userUUID" => $this->Session->read("userUUID"))));
		$history = $this->TransactionHistory->find("all", array("conditions" => array("wallet_id" => $wallet["Wallet"]["id"]), "order" => array("transaction_date" => "desc"), "limit" => 8));
		$this->set("history", $history);
		$historyCount = $this->TransactionHistory->find("count", array("conditions" => array("wallet_id" => $wallet["Wallet"]["id"])));
		$this->set("rowCount", $historyCount);
	}
}
