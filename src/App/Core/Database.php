<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

class Database
{
	public $create;
	public static $lastInsertId;
	public static $connection;

	public static $order;

	public function __construct()
	{
		// Get default host from .env
		$connection = self::$connection ?? $_ENV['DEFAULT_DB'] ?? 'DB';

		// Collect credentials from .env
		$dbConnection = $_ENV[$connection . '_CONNECTION'];
		$dbUsername = $_ENV[$connection . '_USERNAME'];
		$dbPassword = $_ENV[$connection . '_PASSWORD'];
		$dbConfig = [
			'host' => $_ENV[$connection . '_HOST'],
			'port' => $_ENV[$connection . '_PORT'],
			'dbname' => $_ENV[$connection . '_DATABASE'],
			'charset' => $_ENV[$connection . '_CHARSET']
		];

		// Build PDO DSN string using the $config array
		$dsn = $dbConnection . ":" . http_build_query($dbConfig, '', ';');

		// Assign a new PDO instance to the $create variable
		$this->create = new PDO($dsn, $dbUsername, $dbPassword, [
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		]);
	}

	/**
	 * Set the selected database connection
	 * 
	 * @param string $connectionName
	 * 
	 * @return object
	 */
	public static function connection(string $connectionName) : object
	{
		self::$connection = $connectionName;

		return new self;
	}

	/**
	 * Execute a prepared statement. The method recieves the query as a string and the params as an array.
	 *
	 * @param string $query
	 * @param array $params
	 * 
	 * @return object
	 * 
	 */
	public static function query(string $query, array $params = []) : object
	{
		$pdo = (new static)->create;
		$stmt = $pdo->prepare($query);
		$stmt->execute($params);
		
		static::$lastInsertId = $pdo->lastInsertId();

		return $stmt;
	}

	/**
	 * @param mixed $args
	 * @param mixed $defaultClause
	 * 
	 * @return string
	 */
	public static function orderBy($args, $defaultClause = "ORDER BY id ASC") : string
	{
		if (empty($args)) {
			return $defaultClause;
		}

		$clause = "ORDER BY";

		foreach ($args as $key => $column) {
			$clause .= ' ' . htmlentities($column);
			$clause .= $key !== array_key_last($args) ? ',' : '';
		}

		return $clause;
	}

	/**
	 * @param mixed $args
	 * @param mixed $defaultClause
	 * 
	 * @return string
	 */
	public static function where($args, $defaultClause = "WHERE id IS NOT NULL") : string
	{
		if (empty($args)) {
			return $defaultClause;
		}

		$clause = "WHERE";

		foreach ($args as $key => $column) {
			$clause .= ' ' . htmlentities($column);
		}

		return $clause;		
	}
}