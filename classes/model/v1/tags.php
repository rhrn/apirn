<?php defined('SYSPATH') or die('No direct script access.');

class Model_V1_Tags extends Model_V1_Api {

	public $collection = 'tags';

	public $limit = 0;

	public static $user_id;

	private $rules = array(
		'tag' => array(
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
			->rules('tag', $this->rules['tag']);
	}

	public function add($user, $tag) {

		$data = array();

		$data['user_id']	= MDB::stringId($user);
		$data['name']		= $tag;
		$data['created']	= date('Y-m-d H:i:s');

		$insert = $this->collection->insert($data);

		if ($insert) {

			$id = MDB::stringId($data);

			unset($data["_id"]);
			unset($data["user_id"]);

			return array($id => $data);
		}

		return false;
	}

	public function update($user, $id, $tag) {

		$data = MDB::objectId($id);

		$data['user_id'] = MDB::stringId($user);

		$set = array('$set' => array(
			'name'		=> $tag,
			'updated'	=> date('Y-m-d H:i:s'),
		));

		$update = $this->collection->update($data, $set, array('upsert' => true));

		if ($update) {
			return array($id => $set['$set']);
		}
	}

	public function get($user) {

		$find = array();

		$find['user_id'] = MDB::stringId($user);

		$find = $this->collection->find($find, array('user_id' => 0))
				->limit($this->limit)
				->sort(array('created' => -1));

		$find = iterator_to_array($find);

		return $find;
	}

	public function remove($user, $id) {

		$remove			= MDB::objectId($id);
		$remove['user_id']	= MDB::stringId($user);

		$x = $this->collection->remove($remove, array('safe' => true));

		if ($x['n']) {
			return $id;
		}

	}

}
