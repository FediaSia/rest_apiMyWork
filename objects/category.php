<?php

class Category
{
    // соединение с БД и таблицей "categories"
    private $conn;
    private $table_name = "categories";

    // свойства объекта
    public $id;
    public $name;
    public $description;
    public $created;

    public function __construct($db)
    {
        $this->conn = $db;
    }
        // метод для создания категории
        function create()
        {
            // запрос для вставки (создания) записей
            $query = "INSERT INTO
                " . $this->table_name . "
            SET
            id=:id, name=:name,  description=:description, created=:created";
    
            // подготовка запроса
            $stmt = $this->conn->prepare($query);
    
            // очистка
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->created = htmlspecialchars(strip_tags($this->created));
    
            // привязка значений
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":created", $this->created);
    
            // выполняем запрос
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

    // метод для получения всех категорий товаров
    public function readAll()
    {
        $query = "SELECT
                id, name, description
            FROM
                " . $this->table_name . "
            ORDER BY
                name";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}