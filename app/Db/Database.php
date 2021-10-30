<?php

namespace App\Db;

use PDO;
use PDOException;

class Database
{
    private static $dbhost;
    private static $dbname;
    private static $dbuser;
    private static $dbpass;
    private static $dbport;
    private $table;
    private $connection;

    public static function config($dbhost, $dbname, $dbuser, $dbpass, $dbport = 3306)
    {
        self::$dbhost = $dbhost;
        self::$dbname = $dbname;
        self::$dbuser = $dbuser;
        self::$dbpass = $dbpass;
        self::$dbport = $dbport;
    }

    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    private function setConnection()
    {
        try {
            $this->connection = new PDO('mysql:host=' . self::$dbhost . ';dbname=' . self::$dbname . ';port=' . self::$dbport, self::$dbuser, self::$dbpass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    private function execute($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('ERROR ' . $e->getMessage());
        }
    }

    public function select($where, $order, $limit, $fields = '*')
    {
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }

    public function insert($params)
    {
        $fields = array_keys($params);
        $binds = array_pad([], count($fields), '?');
        $query = 'INSERT INTO ' . $this->table . '(' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

        $this->execute($query, array_values($params));

        return $this->connection->lastInsertId();
    }

    public function update($where, $params)
    {
        $fields = array_keys($params);

        $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?', $fields) . ' =? WHERE ' . $where;

        $this->execute($query, array_values($params));

        return true;
    }

    public function delete($where)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;

        $this->execute($query);

        return true;
    }
}
