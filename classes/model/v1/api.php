<?php defined('SYSPATH') or die('No direct script access.');
abstract class Model_V1_Api extends Model_Api {

	public $collection = null;
	
	protected function __construct() {
		MDB::$config = Kohana::$config->load('database')->mongo;
		$this->collection = MDB::collection($this->collection);
	}

}
