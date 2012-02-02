<?php defined('SYSPATH') or die('No direct script access.');

class Controller_V1_Defaults extends Controller_V1_Abstract {

	public function action_index() {
		$this->response->body('hello, defaults!');
	}
}
