<?php
App::uses("AppController", "Controller");

class TransactionController extends AppController {

	public $uses = array();

	public $components = array("Cookie");

	public function beforeFilter() {
		$this->loadModel("Wallet");
		$this->loadModel("User");
		$this->loadModel("TransactionHistory");
		App::uses("CakeEmail", "Network/Email");
		$this->TransactionHistory->validator()->remove("login");
		if ($this->Session->read("loggedIn"))
			$this->layout = "loggedIn";
		else 
			$this->layout = "default";
		Configure::write("Config.language", $this->Session->read("language"));
		$locale = $this->Session->read("language");
        if ($locale && file_exists(APP . "View" . DS . $locale . DS . $this->viewPath . DS . $this->view . $this->ext)) {
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

	public function deposit () {
		$this->set("currencies", Configure::read("currencies"));
	}

	public function addMoney () {
		$data = $this->request->data["Deposit"];
		$wallet = $this->Wallet->find("first", array("conditions" => array("userUUID" => $this->Session->read("userUUID"))));
		$amount = $wallet["Wallet"][$data["currency"]] + $data["amount"];
		$this->Wallet->updateAll(array($data["currency"] => $amount),array("userUUID" => $this->Session->read("userUUID")));
		$this->TransactionHistory->save(array(
			"id" => null,
			"type" => "deposit",
			"currency_plus" => $data["currency"],
			"currency_minus" => "",
			"money_on_plus" => $data["amount"],
			"money_on_minus" => 0,
			"transaction_date" => date("Y-m-d H:i:s"),
			"wallet_id" => $wallet["Wallet"]["id"]
		));
	}
	
	public function withdraw () {
		$this->set("currencies", Configure::read("currencies"));
	}

	public function checkMoney () {
		$this->autoRender = false;
		$wallet = $this->Wallet->find("first", array("conditions" => array("userUUID" => $this->Session->read("userUUID"))));
		return json_encode($wallet);
	}

	public function substractMoney () {
		$data = $this->request->data["Withdraw"];
		$wallet = $this->Wallet->find("first", array("conditions" => array("userUUID" => $this->Session->read("userUUID"))));
		$amount = $wallet["Wallet"][$data["currency"]] - $data["amount"];
		$this->Wallet->updateAll(array($data["currency"] => $amount),array("userUUID" => $this->Session->read("userUUID")));
		$this->TransactionHistory->save(array(
			"id" => null,
			"type" => "withdraw",
			"currency_plus" => "",
			"currency_minus" => $data["currency"],
			"money_on_plus" => 0,
			"money_on_minus" => $data["amount"],
			"transaction_date" => date("Y-m-d H:i:s"),
			"wallet_id" => $wallet["Wallet"]["id"]
		));
	}

	public function exchangeForm () {
		$wallet = $this->Wallet->find("first", array("conditions" => array("userUUID" => $this->Session->read("userUUID"))));
		$this->set("wallet", $wallet["Wallet"]);
		$this->set("currencies", Configure::read("currencies"));
	}

	public function exchange () {
		$this->autoRender = false;
		$wallet = $this->Wallet->find("first", array("conditions" => array("userUUID" => $this->Session->read("userUUID"))));

		$exchange = $wallet["Wallet"][$this->params["url"]["currencyToExchange"]] - $this->params["url"]["exchangeAmout"];
		$buy = $wallet["Wallet"][$this->params["url"]["currencyToBuy"]] + $this->params["url"]["buyAmount"];
		$this->Wallet->updateAll(array($this->params["url"]["currencyToExchange"] => $exchange, $this->params["url"]["currencyToBuy"] => $buy),array("userUUID" => $this->Session->read("userUUID")));
		$this->TransactionHistory->save(array(
			"id" => null,
			"type" => "exchange",
			"currency_plus" => $this->params["url"]["currencyToBuy"],
			"currency_minus" => $this->params["url"]["currencyToExchange"],
			"money_on_plus" => $this->params["url"]["buyAmount"],
			"money_on_minus" => $this->params["url"]["exchangeAmout"],
			"transaction_date" => date("Y-m-d H:i:s"),
			"wallet_id" => $wallet["Wallet"]["id"]
		));
	}	

	public function getWallet () {
		$this->autoRender = false;
		$wallet = $this->Wallet->find("first", array("conditions" => array("userUUID" => $this->Session->read("userUUID"))));
		$this->response->type("json");
		$this->response->body(json_encode($wallet));
		return $this->response;
	}

	public function changeBaseCurrency () {
		$this->autoRender = false;
		$this->User->updateAll(
			array("base_currency" => "'".$this->params["url"]["currency"]."'"),
			array("UUID" => $this->Session->read("userUUID"))
		);
	}

	public function transferForm() {
		$usersList = $this->User->find("all", array("fields" => array("login", "name", "surname")));
		$this->set("usersList", $usersList);
		$this->set("currencies", Configure::read("currencies"));
	}

	public function transfer() {
		$data = $this->request->data["transferMoney"];

		if ($data["recipientLogin"] == $this->Session->read("userName")) {
			$this->Session->write("transferError", true);
			$this->redirect("/transfer-form");
		}

		$recipient = $this->User->find("first", array(
			"joins" => array(
				array(
					"table" => "wallets",
					"alias" => "Wallet",
					"type" => "INNER",
					"conditions" => array(
						"Wallet.userUUID = User.UUID"
					)
				)
			),
			"conditions" => array(
				"login" => $data["recipientLogin"]
			),
			"fields" => array("User.*", "Wallet.*")
		));

		$sender = $this->User->find("first", array(
			"joins" => array(
				array(
					"table" => "wallets",
					"alias" => "Wallet",
					"type" => "INNER",
					"conditions" => array(
						"Wallet.userUUID = User.UUID"
					)
				)
			),
			"conditions" => array(
				"UUID" => $this->Session->read("userUUID")
			),
			"fields" => array("User.*", "Wallet.*")
		));

		if (!empty($sender) && !empty($recipient)) {
			try  {
				$amount = $sender["Wallet"][$data["currencyToSend"]] - intval($data["amountToSend"]);
				$this->Wallet->updateAll(array($data["currencyToSend"] => $amount), array("userUUID" => $this->Session->read("userUUID")));
				$amount = $recipient["Wallet"][$data["currencyToSend"]] + intval($data["amountToSend"]);
				$this->Wallet->updateAll(array($data["currencyToSend"] => $amount), array("userUUID" => $recipient["User"]["UUID"]));
			} catch (Exception $e) {
				$this->Session->write("dbError", "Error ".$e->getCode()." occured");
			}
		} else {
			$this->Session->write("dbError", "Recipient with such login was not found.");
		}
		$this->TransactionHistory->save(array(
			"id" => null,
			"type" => "transfer",
			"currency_plus" => "",
			"currency_minus" => $data["currencyToSend"],
			"money_on_plus" => 0,
			"money_on_minus" => $data["amountToSend"],
			"transaction_date" => date("Y-m-d H:i:s"),
			"wallet_id" => $sender["Wallet"]["id"]
		));
	}

	public function addToTransactionHistory() {
		$this->autoRender = false;
		$this->loadModel("History");
		$this->History->validator()->remove("login");
		$this->History->save(array("id" => null, "wallet_id" => $this->Session->read("walletId"), "sum" => floor($this->params["sum"]), "date" => date("Y-m-d")));
	}
}
