<?php
/**
 *	Usage:
 */
class Api {

	private $api_url	= '';
	private $url		= '';
	private $method		= '';
	private $action		= '';
	private $query		= '';
	private $data		= '';
	private $result		= '';
	private $info		= '';

	private $config		= array();
	private $params		= array();
	private $headers	= array(
		//'Content-type' => 'application/x-www-form-urlencoded',
	);

	private $json		= true;
	private $json_assoc	= false;
	private $use_curl	= true;

	private $named_methods = array(
		self::METHOD_GET	=> 'GET',
		self::METHOD_POST	=> 'POST',
		self::METHOD_PUT	=> 'PUT',
		self::METHOD_DELETE	=> 'DELETE'
	);

	const METHOD_GET	= 1;
	const METHOD_POST	= 2;
	const METHOD_PUT	= 3;
	const METHOD_DELETE	= 4;

	function __construct($api_url = '', $config = array()) {
		$this->api_url	= $api_url;
		$this->config	= $config;
	}

	public function action($action) {
		$this->action = $action;
		return $this;
	}

	public function params($params = array()) {
		$this->params = $params;
		return $this;
	}

	public function curl($use_curl = true) {
		$this->use_curl = $use_curl;
		return $this;
	}

	public function raw() {
		$this->json = false;
		return $this;
	}

	public function json($json = true, $assoc = false) {
		$this->json		= $json;
		$this->json_assoc	= $assoc;
		return $this;
	}

	public function get() {
		$this->method = self::METHOD_GET;
		return $this->execute();
	}

	public function post() {
		$this->method = self::METHOD_POST;
		return $this->execute();
	}

	public function getURL() {
		$this->prepare();
		return $this->url . '?' . $this->query;
	}

	public function upload() {
		$this->header('Content-type', 'multipart/form-data');
		$this->post();
	}

	public function result() {
		if ($this->json) {
			$this->result = json_decode($this->result, $this->json_assoc);
		}
		return $this->result;
	}

	public function execute() {
		if ($this->use_curl) {
			return $this->execute_curl();
		} else {
			return $this->execute_contents();
		}
	}

	public function header($name, $value) {
		$this->headers($name, $value);
		return $this;
	}

	public function debug($info = false) {

		$debug[] = '';

		$debug[] = 'DEBUG';

		$debug[] = "url: " . $this->url;

		$debug[] = "query: " . $this->query;

		$debug[] = "data: " . print_r($this->data, true);

		if ($info) {
			$debug[] = "info: " . print_r($this->info, true);
		}

		$debug[] = "headers: " . print_r($this->headers(), true);

		$debug[] = "result: " . var_export($this->result, true);

		$debug[] = "\n";

		echo implode("\n", $debug);
		return $this;
	}

	private function prepare() {
		$this->url	= $this->buildURL();
		$this->data	= $this->buildData();
		$this->query	= $this->buildQuery();
	}

	
	private function buildURL() {
		return $this->api_url . $this->action;
	}

	private function buildData() {
		return array_merge($this->params, $this->config);
	}

	private function buildQuery() {
		return http_build_query($this->data);
	}

	private function headers($name = null, $value = null) {

		if ($name === null && $value === null) {

			$headers = array();
			foreach ($this->headers as $name => $value) {
				$headers[] = $name . ': ' . $value;
			}
			return $headers;

		} elseif ($name !== null && $value === null) {

			return $name . ': ' . $this->headers[$name];

		} elseif ($name !== null && $value !== null) {
	
			$this->headers[$name] = $value;
			return $name . ': ' . $value;
		}
	}

	private function execute_curl() {

		$this->prepare();

		$ch = curl_init(); 

		if ($this->method === self::METHOD_GET) {

			$this->url .= '?' . $this->query;
			curl_setopt($ch, CURLOPT_URL, $this->url);

			$this->query = '';
			curl_setopt($ch, CURLOPT_HTTPGET, true);

		} elseif ($this->method === self::METHOD_POST) {

			curl_setopt($ch, CURLOPT_URL, $this->url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
		}

		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers());
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$this->result	= curl_exec($ch);
		$this->info	= curl_getinfo($ch);

		curl_close($ch);

		return $this->result();
	}

	/** not supported upload, need update */
	private function execute_contents() {

		$this->prepare();

		$options['http'] = array(
			'method'	=> $this->named_methods[$this->method],
			'header'	=> $this->headers('Content-type'),
			'content'	=> $this->query
		);

		$context = stream_context_create($options);

		$this->result = file_get_contents($this->url, false, $context);

		return $this->result();
	}

}
