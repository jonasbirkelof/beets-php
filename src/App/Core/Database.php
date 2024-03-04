<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

class Database
{
	public $connection;
	public static $lastInsertId;

	public static $order;

	public function __construct()
	{
		// Collect credentials from .env
		$dbConnection = $_ENV['DB_CONNECTION'];
		$dbUsername = $_ENV['DB_USERNAME'];
		$dbPassword = $_ENV['DB_PASSWORD'];
		$dbConfig = [
			'host' => $_ENV['DB_HOST'],
			'port' => $_ENV['DB_PORT'],
			'dbname' => $_ENV['DB_DATABASE'],
			'charset' => $_ENV['DB_CHARSET']
		];

		// Build PDO DSN string using the $config array
		$dsn = $dbConnection . ":" . http_build_query($dbConfig, '', ';');

		// Assign a new PDO instance to the $connection variable
		$this->connection = new PDO($dsn, $dbUsername, $dbPassword, [
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		]);
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
		$pdo = (new static)->connection;
		$stmt = $pdo->prepare($query);
		$stmt->execute($params);
		
		static::$lastInsertId = $pdo->lastInsertId();

		return $stmt;
	}

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