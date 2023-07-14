<?php

class Database
{
    // укажите свои учетные данные базы данных
    private $host = "server100.hosting.reg.ru";
    private $db_name = "u2123047_DB";
    private $username = "u2123047_default";
    private $password = "pG7qb3cw66myLlPG";
    public $conn;

    // получаем соединение с БД
    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Ошибка подключения: " . $exception->getMessage();
        }

        return $this->conn;
    }
}