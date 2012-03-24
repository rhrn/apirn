<?php defined('SYSPATH') or die('No direct script access.');

class Model_V1_Tags extends Model_V1_Api {

	public $collection = 'tags';

	public static $user_id;

	private $rules = array(
		'tags' => array(
                        array('not_empty'),
                        array('min_length', array(':value', 1)),
                        array('max_length', array(':value', 4444))
                )
	);

	protected function __construct() {
		parent::__construct();
	}

	public function valid_tags($data) {
		return Validation::factory($data)
			->rules('tags', $this->rules['tags']);
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

		$find = $this->collection->find($find, array('user_id' => 0))
				->sort(array('$natural' => -1))
				->limit(5);

		$find = iterator_to_array($find);

		sort($find);

		return $find;
	}

}
