<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Html extends Controller_Template {

	public $template	= 'html/default';
	public $token		= null;
	public $api		= null;

	public function before() {

		/**
		 * Set Cookie Config
		 */

		$config = array('token' => Cookie::get('token'));

		$this->api 		= new Api('http://devapirn.loc/');

		//setcookie('cook_token', 'fadsfaw3rfafakbvnkansvdabvk43bkjlgbjh3', 11111);
		//setcookie('cook_token', 'fadsfaw3rfafakbvnkansvdabvk43bkjlgb01', 0);

		//Cookie::set('dwedwd', 'vvvvvv');

		parent::before();

	}

	public function after() {

		parent::after();

	}

}
