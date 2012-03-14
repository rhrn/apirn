<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cookie extends Controller_Api {

	public function before() {
		parent::before();
	}

	public function action_get() {
		echo Cookie::get($this->request->query('name'));
	}

	public function action_set() {

		$answer = array();
		$query	= $this->request->query();
		if (!empty($query)) {
			foreach ($this->request->query() as $name => $value) {
				if (Cookie::set($name, $value)) {
					$answer[$name] = 1;
				}
			}
		}
		echo json_encode($answer);
	}


	public function action_delete() {
		$name = $this->request->query('name');
		if (Cookie::delete($name)) {
			echo json_decode(array($name => 1));
		}
	}

	public function after() {
		parent::after();
	}

}
