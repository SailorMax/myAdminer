<?php
$drivers["redis"] = "Redis (alpha)";

if (isset($_GET["redis"])) {
	define("DRIVER", "redis");

	if (class_exists('Redis')) {
		class Min_DB {
			var $extension = "Redis", $server_info, $error, $last_id, $_link, $_db;
			var $_result;
			var $info;

			function connect($uri, $options) {
				try {
					$this->_link = new Redis();
					$this->_link->pconnect($uri);
					if ($options) {
						$this->_link->auth($options);
					}

					$this->server_info = $this->_link->info()["redis_version"];
				} catch (Exception $e) {
					$this->error = $e->getMessage();
				}
			}

			function query($query) {
				return false;
			}

			function multi_query($query) {
				return $this->_result = $this->query($query);
			}

			function next_result() {
				return false;
			}

			function store_result() {
				return $this->_result;
			}

			function select_db($database) {
				try {
					$this->_db = $this->_link->select(intval(substr($database, 2)));
					return true;
				} catch (Exception $ex) {
					$this->error = $ex->getMessage();
					return false;
				}
			}

			function quote($string) {
				return $string;
			}
		}

		class Min_Result {
			var $num_rows, $_rows = array(), $_offset = 0, $_charset = array();

			function __construct($result) {
				foreach ($result as $item) {
					$row = array();
					foreach ($item as $key => $val) {
						if (is_a($val, 'MongoBinData')) {
							$this->_charset[$key] = 63;
						}
						$row[$key] =
							(is_a($val, 'MongoId') ? "ObjectId(\"$val\")" :
							(is_a($val, 'MongoDate') ? gmdate("Y-m-d H:i:s", $val->sec) . " GMT" :
							(is_a($val, 'MongoBinData') ? $val->bin : //! allow downloading
							(is_a($val, 'MongoRegex') ? "$val" :
							(is_object($val) ? get_class($val) : // MongoMinKey, MongoMaxKey
							$val
						)))));
					}
					$this->_rows[] = $row;
					foreach ($row as $key => $val) {
						if (!isset($this->_rows[0][$key])) {
							$this->_rows[0][$key] = null;
						}
					}
				}
				$this->num_rows = count($this->_rows);
			}

			function fetch_assoc() {
				$row = current($this->_rows);
				if (!$row) {
					return $row;
				}
				$return = array();
				foreach ($this->_rows[0] as $key => $val) {
					$return[$key] = $row[$key];
				}
				next($this->_rows);
				return $return;
			}

			function fetch_row() {
				$return = $this->fetch_assoc();
				if (!$return) {
					return $return;
				}
				return array_values($return);
			}

			function fetch_field() {
				$keys = array_keys($this->_rows[0]);
				$name = $keys[$this->_offset++];
				return (object) array(
					'name' => $name,
					'charsetnr' => $this->_charset[$name],
				);
			}

		}



		class Min_Driver extends Min_SQL {
			public $primary = "_id";

			function select($table, $select, $where, $group, $order = array(), $limit = 1, $page = 0, $print = false) {
				global $connection;
				$select = ($select == array("*")
					? array()
					: array_fill_keys($select, true)
				);
				$sort = array();
				foreach ($order as $val) {
					$val = preg_replace('~ DESC$~', '', $val, 1, $count);
					$sort[$val] = ($count ? -1 : 1);
				}

				$options = array();
				if ($where) {
					$options["by"] = $where;
				}
				if ($limit) {
					$options["limit"] = [$page * $limit, $limit];
				}
				if ($order) {
					$options["sort"] = $order;
				}

				$is_comples_values = false;
				$values_list = array();
				//$list = $connection->_link->keys("*");

				$retuns = null;
				$keys_list = $connection->_link->scan($retuns);	// get only part of records. to get other, require exec it more
				if ($keys_list !== false)
					foreach ($keys_list as $key)
					{
						$complex_value = array();
						$value_type = $this->_conn->_link->type($key);
						switch ($value_type) {
							case Redis::REDIS_STRING:
								$complex_value = $this->_conn->_link->get($key);
								break;

							case Redis::REDIS_LIST:
								$complex_value = $this->_conn->_link->lRange($table, $where[0], $limit);
								break;

							case Redis::REDIS_SET:
								$is_comples_values = true;
								$iterator = null;
								$counter = $limit;
								while ($item = $this->_conn->_link->sScan($table, $iterator, $where[0])) {
									$complex_value[] = array("id" => $item[0], "value" => $item[1]);
									if (!($counter--)) {
										break;
									}
								}
								break;

							case Redis::REDIS_ZSET:
								$is_comples_values = true;
								$iterator = null;
								$counter = $limit;
								while ($item = $this->_conn->_link->zScan($table, $iterator, $where[0])) {
									foreach ($item as $member => $score) {
										$complex_value[] = array("member" => $member, "score" => $score);
									}
									if (!($counter--))
										break;
								}
								break;

							case Redis::REDIS_HASH:
								$is_comples_values = true;
								$iterator = null;
								$counter = $limit;
								while ($item = $this->_conn->_link->hScan($table, $iterator, $where[0])) {
									foreach ($item as $k => $v) {
										$complex_value[] = array("key" => $k, "value" => $v);
									}
									if (!($counter--))
										break;
								}
								break;

							case Redis::REDIS_STREAM:
								$is_comples_values = true;
								$range_values = $this->_conn->_link->xRange($table, '-', '+', $limit);
								foreach ($range_values as $k => $v) {
									$complex_value[] = array("id" => $k, "value" => json_encode($v));
								}
								break;

							case Redis::REDIS_NOT_FOUND:
								break;

							default:
								break;
						}

						$values_list[] = array($key, $complex_value, $this->_conn->_link->ttl($key));
					}

				$result_rows = array();
				if ($is_comples_values) {
					foreach ($values_list as $value) {
						$result_rows[] = $value;
					}
				} else {
					foreach ($values_list as $values) {
						if (is_array($values[1]))
							$record = array("key" => $values[0], "value" => json_encode($values[1]), 'ttl' => $values[2]);
						else
							$record = array("key" => $values[0], "value" => $values[1], 'ttl' => $values[2]);

						if ($select)
							$record = array_filter($record, fn($k) => !empty($select[$k]), ARRAY_FILTER_USE_KEY);
						$result_rows[] = $record;
					}
				}

				return new Min_Result($result_rows);
			}

			function insert($table, $set) {
				try {
					$return = $this->_conn->_db->selectCollection($table)->insert($set);
					$this->_conn->errno = $return['code'];
					$this->_conn->error = $return['err'];
					$this->_conn->last_id = $set['_id'];
					return !$return['err'];
				} catch (Exception $ex) {
					$this->_conn->error = $ex->getMessage();
					return false;
				}
			}
		}

		function get_databases($flush) {
			global $connection;
			$return = array();
			$dbs_cnt = $connection->_link->config("GET", "databases")["databases"];
			if (!$dbs_cnt) {	// disabled access to CONFIG-command
				$dbs_cnt = 15;
			}
			for ($db_idx=0; $db_idx<=$dbs_cnt; $db_idx++) {
				$return[] = "DB".$db_idx;
			}
			return $return;
		}

		function count_tables($databases) {
			global $connection;
			$return = array();
			foreach ($databases as $db) {
				$return[$db] = count($connection->_link->select($db));
			}
			return $return;
		}

		function tables_list() {
			global $connection;
			//return array_fill_keys($connection->_link->keys("*"), 'table');
			return array('[records]' => 'table');
		}

		function drop_databases($databases) {
			global $connection;
			foreach ($databases as $db) {
				$response = $connection->_link->selectDB($db)->drop();
				if (!$response['ok']) {
					return false;
				}
			}
			return true;
		}

		function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning, $row_format, $options) {
			global $connection;
			if ($table == "") {
				$connection->_db->createCollection($name);
				return true;
			}
		}

		function drop_tables($tables) {
			global $connection;
			foreach ($tables as $table) {
				$response = $connection->_db->selectCollection($table)->drop();
				if (!$response['ok']) {
					return false;
				}
			}
			return true;
		}

		function truncate_tables($tables) {
			global $connection;
			foreach ($tables as $table) {
				$response = $connection->_db->selectCollection($table)->remove();
				if (!$response['ok']) {
					return false;
				}
			}
			return true;
		}

		function indexes($table, $connection2 = null) {
			global $connection;
			$return = array(
				[
					'type' => 'PRIMARY',
					'columns' => ['key']
				]
			);
			return $return;
		}

		function fields($table) {
			$fields = fields_from_edit();
			if (!$fields)
			{
				$fields = array(
					'key'	=> array(
								'field' => 'key',
								'type' => 'text',
								'privileges' => ['select' => 1]
								),
					'value'	=> array(
								'field' => 'value',
								'type' => 'text',
								'privileges' => ['select' => 1]
								),
					'ttl'	=> array(
								'field' => 'ttl',
								'type' => 'integer',
								'privileges' => ['select' => 1]
								)
				);
			}
			return $fields;
		}

		function found_rows($table_status, $where) {
			global $connection;
			//! don't call count_rows()
			return $connection->_db->selectCollection($_GET["select"])->count($where);
		}

		$operators = array("=");

	}

	function table($idf) {
		return $idf;
	}

	function idf_escape($idf) {
		return $idf;
	}

	function table_status($name = "", $fast = false) {
		$return = array();
		foreach (tables_list() as $table => $type) {
			$return[$table] = array("Name" => $table);
			if ($name == $table) {
				return $return[$table];
			}
		}
		return $return;
	}

	function create_database($db, $collation) {
		return true;
	}

	function last_id() {
		global $connection;
		return $connection->last_id;
	}

	function error() {
		global $connection;
		return h($connection->error);
	}

	function collations() {
		return array();
	}

	function row_formats() {
		return array();
	}

	function logged_user() {
		global $adminer;
		$credentials = $adminer->credentials();
		return $credentials[1];
	}

	function connect() {
		global $adminer;
		$connection = new Min_DB;
		list($server, $username, $password) = $adminer->credentials();
		$options = array();
		if ($username . $password != "") {
			$options["username"] = $username;
			$options["password"] = $password;
		}
		$db = $adminer->database();
		if ($db != "") {
			$options["db"] = $db;
		}
		if (($auth_source = getenv("REDIS_AUTH_SOURCE"))) {
			$options["authSource"] = $auth_source;
		}
		$connection->connect("$server", $options);
		if ($connection->error) {
			return $connection->error;
		}
		return $connection;
	}

	function alter_indexes($table, $alter) {
		global $connection;
		foreach ($alter as $val) {
			list($type, $name, $set) = $val;
			if ($set == "DROP") {
				$return = $connection->_db->command(array("deleteIndexes" => $table, "index" => $name));
			} else {
				$columns = array();
				foreach ($set as $column) {
					$column = preg_replace('~ DESC$~', '', $column, 1, $count);
					$columns[$column] = ($count ? -1 : 1);
				}
				$return = $connection->_db->selectCollection($table)->ensureIndex($columns, array(
					"unique" => ($type == "UNIQUE"),
					"name" => $name,
					//! "sparse"
				));
			}
			if ($return['errmsg']) {
				$connection->error = $return['errmsg'];
				return false;
			}
		}
		return true;
	}

	function support($feature) {
		return preg_match("~database|indexes|descidx~", $feature);
	}

	function db_collation($db, $collations) {
	}

	function information_schema() {
	}

	function is_view($table_status) {
	}

	function convert_field($field) {
	}

	function unconvert_field($field, $return) {
		return $return;
	}

	function foreign_keys($table) {
		return array();
	}

	function fk_support($table_status) {
	}

	function engines() {
		return array();
	}

	function driver_config() {
		global $operators;
		return array(
			'possible_drivers' => array("redis"),
			'jush' => "redis",
			'operators' => $operators,
			'functions' => array(),
			'grouping' => array(),
			'edit_functions' => array(array("json")),
		);
	}
}
