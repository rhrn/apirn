<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Html {

	public function before() {
		parent::before();
	}

	public function action_index() {

		$view = View::factory('welcome');

		$view->name = '';
		$view->token = '';

		$apirn = json_decode(Cookie::get('apirn_1'));

		if ($apirn) {
			$view->name	= $apirn->name;
			$view->token	= $apirn->token;
			$view->action	= '/tag/add';
		} else {
			$this->request->redirect('/join');
		}

		$this->template->content = (string) $view;
	}


	public function after() {
		parent::after();
	}

}
