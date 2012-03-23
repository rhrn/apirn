<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Tests
 */
class Controller_V1_Test extends Controller_V1_Api {

	public function before() {
		parent::before();
	}

	public function action_index() {

	}

	public function action_find() {

		MDB::$config = Kohana::$config->load('database')->mongo;

		$id = '4f645e4f6e3d1c284e000001';

		$id = MDB::objectId($id);

		MDB::collection('users');
		
		$find = MDB::find($id);

		d::v (iterator_to_array($find));

	}

	public function action_token() {

		$users = Model::factory('v1_users');

		if ($users->is_auth_data('maylog@gmail.com', 'qwertyhn')) {
			$x = $users->auth(); d::v($x);
		}

		$find = MDB::collection('tokens')->find();

		foreach ($find as $f) {
			d::v ($f);
		}

		$find = MDB::collection('tokens')->findOne();

			d::v ($find);

	}

	public function action_model() {

		$model = Model::factory('v1_tests');

		$model->add();

	}

	public function action_mongo() {

		MDB::$config = Kohana::$config->load('database')->mongo;

		$config = MDB::config();		#d::v($config);
		$mongo  = MDB::mongo();			d::v($mongo);
		$db	= MDB::db();			d::cl($db);
		$colle	= MDB::collection('test');	d::cl($colle);

		$data = array('data' => 'test');
		$insert = MDB::insert($data);		d::v($insert);

		$find	= MDB::find();			d::cl($find);
		d::v(iterator_to_array($find));

		$gridFS	= MDB::gridFS();		d::cl($gridFS);

		$remove	= MDB::remove();		d::v($remove);

	}

	public function action_validate() {

		$post = array(
			'email'		=> 'nester@bk.ru',
			'password'	=> 'qwn',
			'username'	=> 'rhr'
		);

		$users = Model::factory('v1_users');

		$valid = $users->validate($post);

		if ($valid->check()) {
			$user = $users->add($post);
		} else {
			d::v($valid->errors('register'));
		}

	}

	public function after() {
		parent::after();
	}

}
