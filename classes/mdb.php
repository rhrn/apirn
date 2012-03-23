<?php
/**
 * MongoDB Helper
 */
class MDB
{

	public static $config		= null;

	private static $mongo		= null;
	private static $db		= null;
	private static $collection	= null;
	private static $gridFS		= null;

	public static function config($config = array()) {
		if (self::$config === null) {
			self::$config = $config;
		}
		return self::$config;
	}

	public static function mongo($hostname = 'localhost') {
		if (self::$mongo === null) {
			

			self::$mongo = new Mongo('mongodb://'. $hostname);

			// catch (MongoConnectionException $e) 

		}
		return self::$mongo;
	}

	public static function db() {
		if (self::$db === null) {
			$config = self::config();
			self::$db = self::mongo($config['hostname'])->selectDB($config['database']);
			self::$db->authenticate($config['username'], $config['password']);

			// catch (MongoCursorException $e)
		}
		return self::$db;
	}

	public static function collection($collection = null) {
		if ($collection !== null) {
			self::$collection = self::db()->$collection;
		}
		return self::$collection;
	}

	public static function gridFS() {
		if (self::$gridFS === null) {
			self::$gridFS = self::db()->getGridFS();
		}
		return self::$gridFS;
	}

	public static function stringId(array $array) {
		return $array["_id"]->{'$id'};
	}

	public static function objectId($id) {
		if (is_array($id)) {
			return array("_id" => $id["_id"]);
		} elseif (is_string($id)) {
			return array("_id" => new MongoId($id));
		}
	}

	public static function count(array $query = array(), $limit = 0, $skip = 0) {
		return self::collection()->count($query, $limit, $skip);
	}

	public static function find(array $query = array(), array $fields = array()) {
		return self::collection()->find($query, $fields);
	}

	public static function findOne(array $query = array(), array $fields = array()) {
		return self::collection()->findOne($query, $fields);
	}
	
	public static function insert(array $a, array $options = array()) {
		return self::collection()->insert($a, $options);
	}
	
	public static function save(array $a, array $options = array()) {
		return self::collection()->save($a, $options);
	}

	public static function update(array $criteria, array $new_object, array $options = array()) {
		return self::collection()->update($criteria, $new_object, $options);
	}
	
	public static function remove(array $criteria = array(), array $options = array()) {
		return self::collection()->remove($criteria, $options);
	}

}
