<?php defined('SYSPATH') or die('No direct script access.');

class Model_V1_Users extends Model_V1_Api {

	private $collection = 'users';

	public static $user_id;

	private $rules = array(
		'email' => array(
			array('not_empty'),
			array('email'),
		),
		'username' => array(
			array('not_empty'),
			array('min_length', array(':value', 4)),
			array('max_length', array(':value', 15)),
			array('regex', array(':value', '/[a-z0-9]+/'))
		),
		'password' => array(
			array('not_empty'),
			array('min_length', array(':value', 6)),
			array('max_length', array(':value', 127))
		),
		'password_confirm' => array(
			array('matches', array(':validation', ':field', 'password'))
		)
	);

	protected function __construct() {
		parent::__construct();
		MDB::collection($this->collection);
	}

	public function valid_unique_email($data) {
		return Validation::factory($data)
			->rule('email', array($this, 'is_unique_email'), array(':value'));
	}
	
	public function valid_auth($data) {
		return Validation::factory($data)
			->rules('email', $this->rules['email'])
			->rules('password', $this->rules['password'])
			->rule('password', array($this, 'is_auth_data'), $data);
	}

	public function valid_add($data) {
		return Validation::factory($data)
			->rules('email', $this->rules['email'])
			->rules('password', $this->rules['password']);
	}

	private static function password($password) {
		$auth = Kohana::$config->load('auth')->auth;
		return hash($auth['algo'], $password . $auth['salt']);
	}

	public static function is_auth_data($email, $password) {

		$data['email']		= $email;
		$data['password']	= self::password($password);

		self::$user_id = MDB::findOne($data, array('_id' => 1));

		return (bool) self::$user_id;
	}

	public static function is_unique_email($email) {

		return !MDB::findOne(array('email' => $email), array('email' => 1));
	}

	public function auth() {

		$user = MDB::findOne(self::$user_id, array('password' => 0));

		return array(
			'name'	=> $user['email'],
			'token' => Model::factory('v1_tokens')->get($user)
		);
	}

	public function add($data) {

		$data['password'] = self::password($data['password']);

		$insert = MDB::insert($data);

		self::$user_id = MDB::objectId($data);

		return $this->auth();
	}

}
