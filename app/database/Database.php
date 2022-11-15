<?php

namespace App\Helpers;

use PDO;

class Database
{
	public $connection;

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
	 * Execute a prepared statement.
	 * The method recieves the query as a string and the params as an array.
	 *
	 * @param string $query
	 * @param array $params
	 * 
	 * @return [type]
	 * 
	 */
	public function query(string $query, array $params = [])
	{
		$stmt = $this->connection->prepare($query);
		$stmt->execute($params);

		return $stmt;
	}
}