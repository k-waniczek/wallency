<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class MainController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public $components = array('Cookie');

	public function beforeFilter() {
		$this->loadModel('Wallet');
		$this->loadModel('User');
		if($this->Session->read('loggedIn'))
			$this->layout = 'loggedIn';
		else 
			$this->layout = 'default';
	}

/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */

	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		if (in_array('..', $path, true) || in_array('.', $path, true)) {
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
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

	public function home () {
		if($this->Session->read('loggedIn')) {
			$this->redirect('/wallet');
		}
	}

	public function profile () {
		$wallet = $this->Wallet->find('first', array('conditions' => array('userUUID' => $this->Session->read('userUUID'))));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.ratesapi.io/api/latest?base=".strtoupper($this->Session->read("baseCurrency")));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = json_decode(curl_exec($ch),true);
		curl_close($ch);

		$this->set('wallet', $wallet);
		$this->set('currencies', Configure::read('currencies'));
		$this->set('apiResult', $result);
		// var_dump($result);
		// echo "<hr>";
		// debug($wallet);
		// die;
		// $this->WalletAmount = $this->Components->load('WalletAmount');
		// debug($this->WalletAmount->walletAmount());
		// die;
	}

	public function login () {

	}

	public function register () {
		$this->set('currencies', Configure::read('currencies'));
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
		$this->Cookie->write('rodo_accepted', true, true, '6 months');
		$this->Log('createRodoCookie');
		$this->set('rodoCookie', $this->Cookie->read('rodo_accepted'));
	}

	public function wallet () {
		if($this->Session->read('loggedIn')) {

			$cryptoCurrencies = ['bitcoin', 'ethereum', 'tether', 'XRP', 'litecoin', 'eos', 'tezos'];
			$resources = ['oil', 'gold', 'copper', 'silver', 'palladium', 'platinum', 'nickel', 'aluminum'];

			$wallet = $this->Wallet->find('first', array('conditions' => array('userUUID' => $this->Session->read('userUUID'))));

			$this->set('wallet', $wallet);
			$this->set('currencies', Configure::read('currencies'));
			$this->set('cryptoCurrencies', $cryptoCurrencies);
			$this->set('resources', $resources);

		}
	}

	public function activate () {
		$this->loadModel('User');
		$uuid = $this->params->query['uuid'];
		$user = $this->User->find('first', array('conditions' => array('UUID' => $uuid)));
		
		if($user['User']['verified'] == 0) {
			$this->User->updateAll(array('verified' => 1),array('UUID' => $uuid));
			$this->set('alreadyVerified', 0);
		} else {
			$this->set('alreadyVerified', 1);
		}
	}

	public function deposit () {
		$this->set('currencies', Configure::read('currencies'));
	}

	public function addMoney () {
		$data = $this->request->data['Deposit'];
		$wallet = $this->Wallet->find('first', array('conditions' => array('userUUID' => $this->Session->read('userUUID'))));
		$amount = $wallet['Wallet'][$data['currencies']] + $data['amount'];
		$this->Wallet->updateAll(array($data['currencies'] => $amount),array('userUUID' => $this->Session->read('userUUID')));
	}
	
	public function withdraw () {
		$this->set('currencies', Configure::read('currencies'));
	}

	public function checkMoney () {
		$this->autoRender = false;
		$wallet = $this->Wallet->find('first', array('conditions' => array('userUUID' => $this->Session->read('userUUID'))));
		return json_encode($wallet);
	}

	public function substractMoney () {
		$data = $this->request->data['Withdraw'];
		$wallet = $this->Wallet->find('first', array('conditions' => array('userUUID' => $this->Session->read('userUUID'))));
		$amount = $wallet['Wallet'][$data['currencies']] - $data['amount'];
		$this->Wallet->updateAll(array($data['currencies'] => $amount),array('userUUID' => $this->Session->read('userUUID')));
	}

	public function rules () {
		
	}

	public function changePasswordForm () {
		
	}

	public function changePassword () {
		$data = $this->request->data['changePassword'];
		$user = $this->User->find('first', array('conditions' => array('password' => $data['currentPassword'])));

		if(isset($user)) {
			if($data['newPasswordConfirm'] == $data['newPassword']) {
				$this->User->updateAll(array('password' => "'".$data['newPassword']."'"),array('password' => $data['currentPassword']));
			}
		}
	}

	public function exchangeForm () {
		$wallet = $this->Wallet->find('first', array('conditions' => array('userUUID' => $this->Session->read('userUUID'))));
		$this->set("wallet", $wallet['Wallet']);
		$this->set('currencies', Configure::read('currencies'));
	}

	public function exchange () {
		$this->autoRender = false;
		$wallet = $this->Wallet->find('first', array('conditions' => array('userUUID' => $this->Session->read('userUUID'))));

		$exchange = $wallet['Wallet'][$this->params['url']['currencyToExchange']] - $this->params['url']['exchangeAmout'];
		$buy = $wallet['Wallet'][$this->params['url']['currencyToBuy']] + $this->params['url']['buyAmount'];
		$this->Wallet->updateAll(array($this->params['url']['currencyToExchange'] => $exchange, $this->params['url']['currencyToBuy'] => $buy),array('userUUID' => $this->Session->read('userUUID')));
	}	

	public function getWallet () {
		$this->autoRender = false;
		$wallet = $this->Wallet->find('first', array('conditions' => array('userUUID' => $this->Session->read('userUUID'))));
		$this->Log(print_r($wallet, true));
		$this->response->type('json');
		$this->response->body(json_encode($wallet));
		return $this->response;
	}

	public function changeBaseCurrency () {
		$this->User->updateAll(
			array('base_currency' => "'".$this->params['url']['currency']."'"),
			array('UUID' => $this->Session->read('userUUID'))
		);
	}

	public function transferForm() {
		$this->set('currencies', Configure::read('currencies'));
	}

	public function transfer() {
		$data = $this->request->data['transferMoney'];

		$recipient = $this->User->find('first', array(
			'joins' => array(
				array(
					'table' => 'wallets',
					'alias' => 'Wallet',
					'type' => 'INNER',
					'conditions' => array(
						'Wallet.userUUID = User.UUID'
					)
				)
			),
			'conditions' => array(
				'login' => $data['recipientLogin']
			),
			'fields' => array('User.*', 'Wallet.*')
		));

		$sender = $this->User->find('first', array(
			'joins' => array(
				array(
					'table' => 'wallets',
					'alias' => 'Wallet',
					'type' => 'INNER',
					'conditions' => array(
						'Wallet.userUUID = User.UUID'
					)
				)
			),
			'conditions' => array(
				'UUID' => $this->Session->read('userUUID')
			),
			'fields' => array('User.*', 'Wallet.*')
		));

		if(!empty($sender) && !empty($recipient)) {
			try  {
				$amount = $sender['Wallet'][$data['currencyToSend']] - intval($data['amountToSend']);
				$this->Wallet->updateAll(array($data['currencyToSend'] => $amount), array('userUUID' => $this->Session->read('userUUID')));
				$amount = $recipient['Wallet'][$data['currencyToSend']] + intval($data['amountToSend']);
				$this->Wallet->updateAll(array($data['currencyToSend'] => $amount), array('userUUID' => $recipient['User']['UUID']));
			} catch (Exception $e) {
				$this->Session->write("dbError", "Error ".$e->getCode()." occured");
			}
		} else {
			$this->Session->write("dbError", "Recipient with such login was not found.");
		}
	}
}
