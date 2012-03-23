<?php defined('SYSPATH') or die('No direct script access.');

class Controller_V1_Default extends Controller_V1_Api {

	public function before() {
		parent::before();
	}

	public function action_index() {
		$this->response->body('hello, default!');
	}

	public function after() {
		parent::after();
	}
}
