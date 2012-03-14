<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller_Html {

	public function action_index() {

		$this->response->body('hello, auth index!');
	}

	public function action_login() {
		$this->template->content = (string) View::factory('auth/login');
	}

	public function action_logout() {
		$this->template->content = (string) View::factory('auth/logout');
	}

	public function action_join() {
		$data = array(
			'version'	=> 'v1',
			'submit'	=> 'join',
			'action'	=> 'auth/join'
		);

		$this->template->content = (string) View::factory('auth/join', $data);
	}


}
