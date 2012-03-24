<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Authentication and Authorization
 */
class Controller_V1_Auth extends Controller_V1_Api {


	public function before() {
		parent::before();
	}

	public function action_index() {
		$this->response->body('hello, users!');
	}

	public function action_login() {
		$this->response->body('login');
	}

	public function action_logout() {
		$this->response->body('logout');
	}

	public function action_join() {
	
		$data = $this->request->post();
		
		$users = Model::factory('v1_users');

		$valid = $users->valid_unique_email($data);

		if (!$valid->check()) {

			$valid = $users->valid_auth($data);

			if ($valid->check()) {
				$this->data['error'] = 0;
				$this->data['auth'] = $users->auth();
			}

		} else {

			$valid = $users->valid_add($data);

			if ($valid->check()) {
				$this->data['error'] = 0;
				$this->data['auth'] = $users->add($data);
			}
		}

		$this->data['errors'] = $valid->errors('join');

		echo $this->response();
	}

	public function action_signin() {
		$this->response->body('sign in');
	}

	public function action_signup() {
		$this->response->body('sign up');
	}

	public function action_signout() {
		$this->response->body('sign out');
	}

	public function after() {
		parent::after();
	}
}
