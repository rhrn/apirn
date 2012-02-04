<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Authentication and Authorization
 */
class Controller_V1_Auth extends Controller_V1_Abstract {


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

	public function action_signin() {
		$this->response->body('signin');
	}

	public function action_signup() {
		$this->response->body('signup');
	}

	public function action_test() {
		//d::v ($this->request->generate_etag());
		d::v ($this->request->method());
		d::v ($this->request->headers('Authentication'));
		d::v ($this->request->uri());
		d::v ($this->request->param('params'));
		d::cl ($this->response);
		d::cl ($this->request);
	}

	public function after() {
		parent::after();
	}
}
