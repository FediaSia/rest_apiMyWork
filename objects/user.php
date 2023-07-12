<?php

class User
{
    // соединение с БД и таблицей "users"
    private $conn;
    private $table_name = "users";

    // свойства объекта
    public $userId;
    public $username;
    public $email;
    public $address;
    public $city;
    public $postalCode;
    public $country;
    public $created;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // метод для создания пользователя
    function create()
    {
        // запрос для вставки (создания) записей
        $query = "INSERT INTO
            " . $this->table_name . "
        SET
        userId=:userId, username=:username, email=:email, address=:address, city=:city, postalCode=:postalCode, country=:country, created=:created";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->postalCode = htmlspecialchars(strip_tags($this->postalCode));
        $this->country = htmlspecialchars(strip_tags($this->country));
        $this->created = htmlspecialchars(strip_tags($this->created));

        // привязка значений
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":postalCode", $this->postalCode);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":created", $this->created);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

     // метод для получения списка пользователей
     function read()
    {
         // выбираем все записи
         $query = "SELECT
         userId, username, email, address, city, postalCode, country
            FROM
                " . $this->table_name . "
            ORDER BY
                userId";
         // подготовка запроса
         $stmt = $this->conn->prepare($query);
 
         // выполняем запрос
         $stmt->execute();
         return $stmt;
    }

    // метод для обновления  юзера
    function update()
    {
        // запрос для обновления записи (юзера)
        $query = "UPDATE
            " . $this->table_name . "
        SET
        username = :username,
        email = :email,
        address = :address,
        city = :city,
        postalCode = :postalCode,
        country = :country
        WHERE
            userId = :userId";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->postalCode = htmlspecialchars(strip_tags($this->postalCode));
        $this->country = htmlspecialchars(strip_tags($this->country));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // привязка значений
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":postalCode", $this->postalCode);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":userId", $this->userId);


        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод для удаления пользователя
    function delete()
    {
        // запрос для удаления записи (пользователя)
        $query = "DELETE FROM " . $this->table_name . " WHERE userId = ?";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // привязываем id записи для удаления
        $stmt->bindParam(1, $this->userId);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

}