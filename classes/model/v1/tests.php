<?php defined('SYSPATH') or die('No direct script access.');
class Model_V1_Tests extends Model_V1_Api {


	public function add() {

		MDB::$config = Kohana::$config->load('database')->mongo;

		MDB::collection('test');

		$find = MDB::find();

		var_dump ($find);
	}
}
