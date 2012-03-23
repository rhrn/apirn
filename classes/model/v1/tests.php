<?php defined('SYSPATH') or die('No direct script access.');
class Model_V1_Tests extends Model_V1_Api {

	public $collection = 'tests';

	function __construct() {
		parent::__construct();
	}

	public function add() {

		$find = $this->collection->find();

		var_dump ($find);
	}
}
