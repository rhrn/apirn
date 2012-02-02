<?php defined('SYSPATH') or die('No direct script access.');

class Controller_V1_Auth extends Controller_V1_Abstract {

	public function action_index() {
		$this->response->body('hello, users!');
	}

	public function action_login() {
		$this->response->body('login');
	}

	public function action_logout() {
		$this->response->body('logout');
	}
}
