<?php
class DB
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $charset;

    function __construct()
    {
        $this->host     = 'localhost';
        $this->database = 'peliculas';
        $this->username = 'root';
        $this->password = '';
        $this->charset  = 'utf8mb4';
    }

    function connect()
    {
        try {
            $connection = 'mysql:host=' . $this->host . ';dbname=' . $this->database . ';charset=' . $this->charset . ';';

            $options = [
                PDO::ATTR_ERRMODE           =>  PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES  =>  false,
            ];

            $pdo = new PDO($connection, $this->username, $this->password, $options);

            return $pdo;
        } catch (PDOException $e) {
            print_r('FAILED TO CONNECT DATABASE: ' . $e->getMessage());
        }
    }
}
