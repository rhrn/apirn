<?php defined('SYSPATH') or die('No direct script access.');
abstract class Model_V1_Api extends Model_Api {
	
	protected function __construct() {
		MDB::$config = Kohana::$config->load('database')->mongo;
	}

}
