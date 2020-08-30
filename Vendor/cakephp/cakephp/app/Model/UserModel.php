<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class UserModel extends Model {

    public function beforeFilter() {
		parent::beforeFilter();
    }
    
    public $validate = array(
        // 'login' => array(
        //     'between' => array(
        //         'rule' => array('lengthBetween', 4, 20),
        //         'message' => 'Login needs to be between 4 to 20 characters.'
        //     ),
        //     'isUnique' => array(
        //         'rule' => 'isUnique',
        //         'message' => 'This username has already been taken.'
        //     ),
        //     'custom' => array(
        //         'rule' => array('custom', '/[^\w-().#*]{1,}/'),
        //         'message' => 'Your login can contain all letters and these special characters: - ( ) . # *.'
        //     )
        // ),
        // 'password' => array(
        //     'minLength' => array(
        //         'rule' => array('minLength', '8'),
        //         'message' => 'Your password needs to be minimum 8 characters long.'
        //     ),
        //     'custom' => array(
        //         'rule' => array('custom', '/[A-Z\W_]{1,}/'),
        //         'message' => 'Your password needs to have at least one big letter and one special character.'
        //     )
        // ),
        // 'email' => 'email',
        // 'birth_date' => array(
        //     'rule' => 'date',
        //     'message' => 'Enter a valid date.',
        //     'allowEmpty' => true
        // ),
        // 'name' => array(
        //     'rule' => array('minLength', 3),
        //     'message' => 'Your name needs to be at least 3 letter long.'
        // ),
        'surname' => array(
            'rule' => array('minLength', 3),
            'message' => 'Your surname needs to be at least 3 letter long.'
        )
    );
}
