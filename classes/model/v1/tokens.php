<?php defined('SYSPATH') or die('No direct script access.');

class Model_V1_Tokens extends Model_V1_Api {

	public $collection = 'tokens';

	const DELIMETER = '.';

	public static $token;
	public static $user_id;

	protected function __construct() {
		parent::__construct();
	}

	public function get(array $user) {
		return $this->gen($user);
	}

	public function gen(array $user) {

		$id = MDB::stringId($user);

		$tail = base64_encode(hash('sha256', date('Y-m-d').$id.$user["_id"]->getTimestamp().$user["_id"]->getInc().microtime()));

		self::$user_id = MDB::stringId($user);

		self::$token = $id . Model_V1_Tokens::DELIMETER . $tail;

		if ($this->add()) {
			return self::$token;
		}

	}

	public function user($token, $field = 'user_id') {

		$one =  $this->collection->findOne(array('token' => $token), array('_id' => 0, $field => 1));

		if (isset($one[$field])) {
			return $one[$field];
		}

		return false;
	} 

	private function add() {

		$add = array(
			'user_id'	=> self::$user_id,
			'token'		=> self::$token,
			'ip'		=> $_SERVER['REMOTE_ADDR'],
			'agent'		=> $_SERVER['HTTP_USER_AGENT'],
			'expire'	=> time() + Date::YEAR,
		);

		return $this->collection->insert($add);
	}


}
