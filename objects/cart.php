<?php

class Cart
{
    // соединение с БД и таблицей "carts"
    private $conn;
    private $table_name = "carts";

    // свойства объекта
    public $id;//
    public $userid;
    public $productid;
    public $quantity;
    public $item_price;//
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
            id=:id, userid=:userid, productid=:productid, quantity=:quantity, created=:created";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->userid = htmlspecialchars(strip_tags($this->userid));
        $this->productid = htmlspecialchars(strip_tags($this->productid));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->created = htmlspecialchars(strip_tags($this->created));

        // привязка значений
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":userid", $this->userid);
        $stmt->bindParam(":productid", $this->productid);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":created", $this->created);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

     // метод для получения списка корзин
    function read()
    {
         // выбираем все записи
         $query = "SELECT
            id, p.userid, quantity, p.productid, quantity, created
            FROM
                " . $this->table_name . " p
            ORDER BY
                id";
         // подготовка запроса
         $stmt = $this->conn->prepare($query);
 
         // выполняем запрос
         $stmt->execute();
         return $stmt;
    }

    // метод для обновления корзин
    function update()
    {
        // запрос для обновления записи (корзины)
        $query = "UPDATE
            " . $this->table_name . "
        SET
            userid = :userid,
            productid = :productid,
            quantity = :quantity
        WHERE
            id = :id";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->userid = htmlspecialchars(strip_tags($this->userid));
        $this->productid = htmlspecialchars(strip_tags($this->productid));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // привязка значений
        $stmt->bindParam(":userid", $this->userid);
        $stmt->bindParam(":productid", $this->productid);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":id", $this->id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод для удаления корзин
    function delete()
    {
        // запрос для удаления записи (пользователя)
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->id = htmlspecialchars(strip_tags($this->id));

        // привязываем id записи для удаления
        $stmt->bindParam(1, $this->id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

}