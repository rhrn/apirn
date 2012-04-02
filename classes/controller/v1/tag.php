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

		$tags = Model::factory('v1_tags');

		$valid = $tags->valid_tags($data);

		if ($valid->check()) {


			if (empty($data['id'])) {
				$tag = $tags->add($this->user, $data['tag']);
				$this->data['insert'] = 1;
			} else {
				$tag = $tags->update($this->user, $data['id'], $data['tag']);
				$this->data['insert'] = 0;
			}

			if ($tag) {
				$this->data['error']	= 0;
				$this->data['list']	= $tag;
			}
			
		} else {
			$this->data['errors'] = $valid->errors('tags');
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

	public function action_remove() {

		$data = $this->request->query();

		if (!empty($data)  && $this->user) {

			$tags = Model::factory('v1_tags');

			if ($id = $tags->remove($this->user, $data['id'])) {
				$this->data['error']	= 0;
				$this->data['id']	= $id;
			}
		}

		echo $this->response();
	}

	public function after() {
		parent::after();
	}
}
