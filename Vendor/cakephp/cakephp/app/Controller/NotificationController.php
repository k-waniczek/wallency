<?php
App::uses('AppController', 'Controller');

class NotificationController extends AppController {

	public $uses = array();

	public function beforeFilter() {
		parent::beforeFilter();
		App::uses('CakeEmail', 'Network/Email');
	}

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

	public function sendCurrencyChangeNotification () {
		echo "Działa";
		// $this->loadModel('User');
		// $users = $this->User->find('all', array('fields' => 'email'));
		// for($i = 0; $i < count($users); $i++) {
		// 	$email = new CakeEmail('default');
		// 	$email->emailFormat('html')
		// 		->to($users[$i]['User']['email'])                            
		// 		->from(array('frezi12345cr@gmail.com' => 'wallency'))
		// 		->viewVars(array('currency' => $this->params['currency'], 'percent' => $this->params['percent']))
		// 		->attachments(array(
		// 			array(         
		// 				'file' => ROOT.'/app/webroot/img/bg-pattern.jpg',
		// 				'mimetype' => 'image/jpg',
		// 				'contentId' => 'background'
		// 			),
		// 			array(         
		// 				'file' => ROOT.'/app/webroot/img/wallet.png',
		// 				'mimetype' => 'image/png',
		// 				'contentId' => 'logo'
		// 			)
		// 		))
		// 		->template('notificationView', 'mytemplate')
		// 		->subject('Currency Change Notification')
		// 		->send();
		// }
		//$this->autoRender = false;
	}
}
