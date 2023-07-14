<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты
include_once "../config/database.php";
include_once "../objects/cart.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем корзину
$cart = new Cart($db);

// запрашиваем список корзин
$stmt = $cart->read();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num > 0) {
    // массив товаров
    $carts_arr = array();
    $carts_arr["cart"] = array();

    // получаем содержимое нашей корзины
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);
        $cart_item = array(
            "id" => $id,
            "userid" => $userid,
            "productid" => $productid,
            "quantity" => $quantity
        );
        array_push($carts_arr["cart"], $cart_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode($carts_arr);
} else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что не найдено
    echo json_encode(array("message" => "Корзины не найдены."), JSON_UNESCAPED_UNICODE);
}