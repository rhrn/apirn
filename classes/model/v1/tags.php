<?php defined('SYSPATH') or die('No direct script access.');

class Model_V1_Tags extends Model_V1_Api {

	public $collection = 'tags';

	public static $user_id;

	private $rules = array(

	);

	protected function __construct() {
		parent::__construct();
	}

	public function valid_tags($data) {
		return Validation::factory($data)
			->rule('tags', array($this, 'tags'), array(':value'));
	}

	public function add($user, $tag) {

		$data = array(
			'user_id'	=> MDB::stringId($user),
			'name'		=> $tag,
			'created'	=> date('Y-m-d H:i:s')
		);

		$insert = $this->collection->insert($data);

		if ($insert) {

			$id = MDB::stringId($data);

			unset($data["_id"]);
			unset($data["user_id"]);

			return array($id => $data);
		}
		return false;
	}

	public function get($user) {

		$find = array();

		$find['user_id'] = MDB::stringId($user);

		$find = $this->collection->find($find, array('user_id' => 0));

		return iterator_to_array($find);
	}

}
