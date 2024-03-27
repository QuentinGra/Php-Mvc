<?php

namespace App\Core;

use PDO;
use Exception;
use PDOException;


class Db extends PDO
{
    private const DB_HOST = "mvcdebutexo-db-1";
    private const DB_NAME = "demo_mvc";
    private const DB_USER = "root";
    private const DB_PASSWORD = "root";
    private static ?self $instance = null;

    public function __construct()
    {
        try {
            $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=utf8mb4";

            parent::__construct($dsn, self::DB_USER, self::DB_PASSWORD);

            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8mb4');
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
