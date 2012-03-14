<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Api extends Controller {

	public $info = array();
	public $data = array(
		'error'	=> 1,
	);

	public function before() {
	}

	public function response() {

		return json_encode($this->data);
	}

	public function after() {

	}

}
