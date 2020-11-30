<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/home', array('controller' => 'main', 'action' => 'home'));
	Router::connect('/profile', array('controller' => 'main', 'action' => 'profile'));
	Router::connect('/login', array('controller' => 'main', 'action' => 'login'));
	Router::connect('/register', array('controller' => 'main', 'action' => 'register'));
	Router::connect('/terms-of-service', array('controller' => 'main', 'action' => 'termsOfService'));
	Router::connect('/webroot', array('controller' => 'main', 'action' => 'privacyPolicy'));
	Router::connect('/about', array('controller' => 'main', 'action' => 'about'));
	Router::connect('/contact', array('controller' => 'main', 'action' => 'contact'));
	Router::connect('/career', array('controller' => 'main', 'action' => 'career'));
	Router::connect('/createRodoCookie', array('controller' => 'main', 'action' => 'createRodoCookie'));
	Router::connect('/wallet', array('controller' => 'main', 'action' => 'wallet'));
	Router::connect('/activate', array('controller' => 'main', 'action' => 'activate'));
	Router::connect('/deposit', array('controller' => 'main', 'action' => 'deposit'));
	Router::connect('/add-money', array('controller' => 'main', 'action' => 'addMoney'));
	Router::connect('/substract-money', array('controller' => 'main', 'action' => 'substractMoney'));
	Router::connect('/check-money', array('controller' => 'main', 'action' => 'checkMoney'));
	Router::connect('/withdraw', array('controller' => 'main', 'action' => 'withdraw'));
	Router::connect('/rules', array('controller' => 'main', 'action' => 'rules'));
	Router::connect('/change-password', array('controller' => 'main', 'action' => 'changePassword'));
	Router::connect('/change-password-form', array('controller' => 'main', 'action' => 'changePasswordForm'));
	Router::connect('/exchange-form', array('controller' => 'main', 'action' => 'exchangeForm'));
	Router::connect('/exchange', array('controller' => 'main', 'action' => 'exchange'));
	Router::connect('/get-wallet', array('controller' => 'main', 'action' => 'getWallet'));
	Router::connect('/change-base-currency', array('controller' => 'main', 'action' => 'changeBaseCurrency'));
	Router::connect('/transfer-form', array('controller' => 'main', 'action' => 'transferForm'));
	Router::connect('/transfer', array('controller' => 'main', 'action' => 'transfer'));
	Router::connect('/privacy-policy', array('controller' => 'main', 'action' => 'privacyPolicy'));
	Router::connect('/history', array('controller' => 'main', 'action' => 'history'));
	Router::connect('/get-history-rows/:limit', array('controller' => 'main', 'action' => 'getHistoryRows'));
	Router::connect('/faq', array('controller' => 'main', 'action' => 'faq'));
	Router::connect('/change-language/:lang', array('controller' => 'main', 'action' => 'changeLanguage'));

	Router::connect('/send_currency_change_notification/:currency/:percent/', array('controller' => 'notification', 'action' => 'sendCurrencyChangeNotification'));

	Router::connect('/register-user', array('controller' => 'user', 'action' => 'registerUser'));
	Router::connect('/login-user', array('controller' => 'user', 'action' => 'loginUser'));
	Router::connect('/logout', array('controller' => 'user', 'action' => 'logout'));
	Router::connect('/deposit', array('controller' => 'user', 'action' => 'deposit'));
	Router::connect('/transfer', array('controller' => 'user', 'action' => 'transfer'));
	Router::connect('/editProfile', array('controller' => 'user', 'action' => 'editProfile'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
