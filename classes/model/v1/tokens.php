<?php defined('SYSPATH') or die('No direct script access.');

class Model_V1_Tokens extends Model_V1_Api {

	private $collection = 'tokens';

	const DELIMETER = '.';

	public static $token;
	public static $user_id;

	protected function __construct() {
		parent::__construct();
		MDB::collection($this->collection);
	}

	public function get(array $user) {
		return $this->gen_token($user);
		//return self::$token;
	}

	public function gen_token(array $user) {

		$id = MDB::stringId($user);

		$tail = base64_encode(hash('sha256', date('Y-m-d').$id.$user["_id"]->getTimestamp().$user["_id"]->getInc().microtime()));

		self::$user_id = MDB::objectId($user);

		self::$token = $id . Model_V1_Tokens::DELIMETER . $tail;

		if ($this->add_token()) {
			return self::$token;
		}

	}


	private function add_token() {
		//d::v (self::$user_id);
		//d::v (self::$token);
		return MDB::update(self::$user_id, array('$inc' => array('token' => self::$token)), array('upsert' => true));
	}


}
