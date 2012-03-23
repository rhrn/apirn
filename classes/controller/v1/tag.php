<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Tags
 */
class Controller_V1_Tag extends Controller_V1_Api {


	public function before() {
		parent::before();
	}

	public function action_add() {

		$data = $this->request->post();

		if (!empty($data)  && $this->user) {
			
			$tags = Model::factory('v1_tags');

			if ($tag = $tags->add($this->user, $data['tags'])) {
				$this->data['error']	= 0;
				$this->data['list']	= $tag;
			}
		}

		echo $this->response();
	}

	public function action_list() {

		$data = $this->request->query();

		if (!empty($data)  && $this->user) {

			$tags = Model::factory('v1_tags');

			if ($list = $tags->get($this->user)) {
				$this->data['error']	= 0;
				$this->data['list']	= $list;
			}
		}

		echo $this->response();
	}

	public function after() {
		parent::after();
	}
}
