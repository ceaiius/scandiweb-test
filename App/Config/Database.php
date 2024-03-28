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
        $env = parse_ini_file('.env');
        $this->host = $env['DB_HOST'];
        $this->db_name = $env['DB_DATABASE'];
        $this->username = $env['DB_USERNAME'];
        $this->password = $env['DB_PASSWORD'];
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
