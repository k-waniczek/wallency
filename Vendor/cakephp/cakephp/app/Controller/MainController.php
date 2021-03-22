<?php
App::uses("AppController", "Controller");

class MainController extends AppController {
	public $uses = array();

	public $components = array("Cookie");

	public function beforeFilter() {
		parent::beforeFilter();
		$this->loadModel("Wallet");
		$this->loadModel("User");
		$this->loadModel("TransactionHistory");
		App::uses("CakeEmail", "Network/Email");
		$this->TransactionHistory->validator()->remove("login");
		if ($this->Session->read("loggedIn")) {
			$this->layout = "loggedIn";
		} else { 
			$this->layout = "default";
		}
		if($this->Session->read("language") != null) {
			Configure::write("Config.language", $this->Session->read("language"));
		} else {
			Configure::write("Config.language", "eng");
			$this->Session->write("language", "eng");
		}
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

	public function home () {
		if ($this->Session->read("loggedIn")) {
			$this->redirect("/wallet");
		}
	}

	public function termsOfService () {

	}

	public function privacyPolicy () {

	}

	public function about () {

	}

	public function contact () {

	}

	public function career () {

	}

	public function createRodoCookie () {
		$this->autoRender = false;
		$this->Cookie->write("rodo_accepted", true, true, "6 months");
		$this->set("rodoCookie", $this->Cookie->read("rodo_accepted"));
	}
	
	public function rules () {
		
	}

	public function getHistoryRows () {
		$this->autoRender = false;
		$wallet = $this->Wallet->find("first", array("conditions" => array("userUUID" => $this->Session->read("userUUID"))));
		$history = $this->TransactionHistory->find("all", array("conditions" => array("wallet_id" => $wallet["Wallet"]["id"]), "limit" => 8, "offset" => (intval($this->params["limit"]) - 1) * 8, "order" => array("transaction_date" => "desc")));
		return json_encode($history);
	}

	public function faq () {
		
	}

	public function changeLanguage() {
		$this->autoRender = false;
		$this->Session->write("language", $this->params["lang"]);
	}

	public function login () {

	}

	public function register () {
		$this->set("currencies", Configure::read("currencies"));
	}
}
