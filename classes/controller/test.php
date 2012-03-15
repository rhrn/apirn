<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Test extends Controller_Html {

	public function before() {
		parent::before();
	}

	public function action_index() {

		$view = View::factory('test/index');

		$apirn = json_decode(Cookie::get('apirn_1'));

		$view->name = $apirn->name;

		$this->template->content = (string) $view;
	}

	public function action_api() {

		$data = array(
			'email' => 'nester@bqk.ru',
			'password' => 'qweqwe'
		);

		$data = $this->api->action('v1/auth/join')
			->params($data)
			->post();

		d::v($data);

	}


	public function after() {
		parent::after();
	}

}
