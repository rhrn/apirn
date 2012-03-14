<?php defined('SYSPATH') or die('No direct script access.');

class Controller_V1_Defaults extends Controller_V1_Api {

	public function before() {
		parent::before();
	}

	public function action_index() {
		$this->response->body('hello, defaults!');
	}

	public function after() {
		parent::after();
	}
}
