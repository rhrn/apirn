<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Api extends Controller {

	public $info = array();

	public $token	= null;
	public $user	= null;

	public $data = array(
		'error'	=> 1,
	);

	public function before() {

		$key = 'token';

		if ($this->request->query($key)) {
			$this->token = $this->request->query($key);
		} elseif ($this->request->post($key)) {
			$this->token = $this->request->post($key);
		}

		$this->user = $this->auth();
	}

	public function auth() {

		if ($this->token) {
			return Model::factory('v1_users')->token($this->token);
		}
	}

	public function response() {

		return json_encode($this->data);
	}

	public function after() {

	}

}
