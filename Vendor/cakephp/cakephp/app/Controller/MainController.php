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
		$this->loadModel('TransactionHistory');
		App::uses('CakeEmail', 'Network/Email');
		$this->TransactionHistory->validator()->remove('login');
		if($this->Session->read('loggedIn'))
			$this->layout = 'loggedIn';
		else 
			$this->layout = 'default';
		Configure::write('Config.language', $this->Session->read('language'));
		$locale = $this->Session->read('language');
        if ($locale && file_exists(APP . 'View' . DS . $locale . DS . $this->viewPath . DS . $this->view . $this->ext)) {
            $this->viewPath = $locale . DS . $this->viewPath;
        }
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
		$this->loadModel('History');
		$wallet = $this->Wallet->find('first', array('conditions' => array('userUUID' => $this->Session->read('userUUID'))));
		$history = $this->History->find('all', array('conditions' => array('wallet_id' => $wallet['Wallet']['id'])));
		$this->set('history', $history);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.ratesapi.io/api/latest?base=".strtoupper($this->Session->read("baseCurrency")));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = json_decode(curl_exec($ch),true);
		curl_close($ch);

		$this->set('wallet', $wallet);
		$this->set('currencies', Configure::read('currencies'));
		$this->set('apiResult', $result);
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

			$cryptoCurrencies = ['bitcoin', 'ethereum', 'lumen', 'XRP', 'litecoin', 'eos', 'Yearn-finance'];
			$resources = ['oil', 'gold', 'copper', 'silver', 'palladium', 'platinum', 'nickel', 'aluminum'];

			$wallet = $this->Wallet->find('first', array('conditions' => array('userUUID' => $this->Session->read('userUUID'))));

			$this->set('wallet', $wallet);
			$this->set('currencies', Configure::read('currencies'));
			$this->set('cryptoCurrencies', $cryptoCurrencies);
			$this->set('resources', $resources);

		}

		App::uses('HttpSocket', 'Network/Http');
		$httpSocket = new HttpSocket();
		$response = $httpSocket->get('https://www.bankier.pl/surowce/notowania');
		$html = file_get_contents('https://stackoverflow.com/questions/ask');
		$this->set('response', str_replace('\'', '"', str_replace("\n", '', htmlentities($response))));
		
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
		$amount = $wallet['Wallet'][$data['currency']] + $data['amount'];
		$this->Wallet->updateAll(array($data['currency'] => $amount),array('userUUID' => $this->Session->read('userUUID')));
		$this->TransactionHistory->save(array(
			'id' => null,
			'type' => 'deposit',
			'currency_plus' => $data['currency'],
			'currency_minus' => '',
			'money_on_plus' => $data['amount'],
			'money_on_minus' => 0,
			'transaction_date' => date('Y-m-d H:i:s'),
			'wallet_id' => $wallet['Wallet']['id']
		));
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
		$amount = $wallet['Wallet'][$data['currency']] - $data['amount'];
		$this->Wallet->updateAll(array($data['currency'] => $amount),array('userUUID' => $this->Session->read('userUUID')));
		$this->TransactionHistory->save(array(
			'id' => null,
			'type' => 'withdraw',
			'currency_plus' => '',
			'currency_minus' => $data['currency'],
			'money_on_plus' => 0,
			'money_on_minus' => $data['amount'],
			'transaction_date' => date('Y-m-d H:i:s'),
			'wallet_id' => $wallet['Wallet']['id']
		));
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
		$this->TransactionHistory->save(array(
			'id' => null,
			'type' => 'exchange',
			'currency_plus' => $this->params['url']['currencyToBuy'],
			'currency_minus' => $this->params['url']['currencyToExchange'],
			'money_on_plus' => $this->params['url']['buyAmount'],
			'money_on_minus' => $this->params['url']['exchangeAmout'],
			'transaction_date' => date('Y-m-d H:i:s'),
			'wallet_id' => $wallet['Wallet']['id']
		));
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
		$usersList = $this->User->find('all', array('fields' => array('login', 'name', 'surname')));
		$this->set('usersList', $usersList);
		$this->set('currencies', Configure::read('currencies'));
	}

	public function transfer() {
		$data = $this->request->data['transferMoney'];

		if($data['recipientLogin'] == $this->Session->read('userName')) {
			$this->Session->write('transferError', true);
			$this->redirect('/transfer-form');
		}

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
		$this->TransactionHistory->save(array(
			'id' => null,
			'type' => 'transfer',
			'currency_plus' => '',
			'currency_minus' => $data['currencyToSend'],
			'money_on_plus' => 0,
			'money_on_minus' => $data['amountToSend'],
			'transaction_date' => date('Y-m-d H:i:s'),
			'wallet_id' => $sender['Wallet']['id']
		));
	}

	public function history () {
		$wallet = $this->Wallet->find('first', array('conditions' => array('userUUID' => $this->Session->read('userUUID'))));
		$history = $this->TransactionHistory->find('all', array('conditions' => array('wallet_id' => $wallet['Wallet']['id']), 'order' => array('transaction_date' => 'desc'), 'limit' => 8));
		$this->set('history', $history);
		$historyCount = $this->TransactionHistory->find('count', array('conditions' => array('wallet_id' => $wallet['Wallet']['id'])));
		$this->set('rowCount', $historyCount);
	}

	public function getHistoryRows () {
		$this->autoRender = false;
		$wallet = $this->Wallet->find('first', array('conditions' => array('userUUID' => $this->Session->read('userUUID'))));
		$history = $this->TransactionHistory->find('all', array('conditions' => array('wallet_id' => $wallet['Wallet']['id']), 'limit' => 8, 'offset' => (intval($this->params['limit']) - 1) * 8, 'order' => array('transaction_date' => 'desc')));
		return json_encode($history);
	}

	public function faq () {
		
	}

	public function changeLanguage() {
		$this->Session->write('language', $this->params['lang']);
	}

	public function sendEmail () {
		$response = $this->request['data'];
		$privatekey = "6Ld7zQMaAAAAACtEa7wfbJODYKNU09FxI8aazRLP";
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array('secret' => $privatekey, 'response' => $response['g-recaptcha-response']);

		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data),
			),
		);

		// We could also use curl to send the API request
		$context  = stream_context_create($options);
		$json_result = file_get_contents($url, false, $context);
		$result = json_decode($json_result);
		
		if(!$result->success) {
			$this->Session->write('captchaError', true);
			$this->redirect('/contact');
		} else {
			$email = new CakeEmail('default');
			$email->emailFormat('html')
				->to('kamil.wan05@gmail.com')                            
				->from($response['Contact']['emailFrom'])
				->viewVars(array('message' => $response['Contact']['message'], 'senderName' => $response['Contact']['senderName'], 'emailFrom' => $response['Contact']['emailFrom']))
				->template('contact_view', 'mytemplate')
				->attachments(array(
					array(         
						'file' => ROOT.'/app/webroot/img/bg-pattern.jpg',
						'mimetype' => 'image/jpg',
						'contentId' => 'background'
					)
				))
				->subject('Contact message from Wallency')
				->send();
			}
	}

	public function addToTransactionHistory() {
		$this->loadModel('History');
		$this->History->validator()->remove('login');
		$this->History->save(array('id' => null, 'wallet_id' => $this->Session->read('walletId'), 'sum' => floor($this->params['sum']), 'date' => date('Y-m-d')));
	}
}
