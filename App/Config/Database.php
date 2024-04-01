<?php

declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;


    // Connect database

    /**
     * @param  string  $host
     * @param  string  $db_name
     * @param  string  $username
     * @param  string  $password
     */

    public function __construct(){
        $this->host = 'eu-cluster-west-01.k8s.cleardb.net';
        $this->db_name = 'heroku_387801b339c230a';
        $this->username = 'b96eac2c469a9e';
        $this->password = '72710f7b';
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getDBname(): string
    {
        return $this->db_name;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return PDO
     */

    public function connect(): PDO
    {
        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->getHost() . ';dbname='
                . $this->getDBname(),
                $this->getUsername(), $this->getPassword()
            );
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
