<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once "../config/database.php";

// создание объекта корзины
include_once "../objects/cart.php";
$database = new Database();
$db = $database->getConnection();
$cart = new Cart($db);

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты
if (
    !empty($data->userid) &&
    !empty($data->productid) &&
    !empty($data->quantity)
    // !empty($data->item_price) 

    // устанавливаем значения свойств корзины
) {
    $cart->userid = $data->userid;
    $cart->productid = $data->productid;
    $cart->quantity = $data->quantity;
    // $cart->item_price = $data->item_price;
    $cart->created = date("Y-m-d H:i:s");

    // создание корзины
    if ($cart->create()) {
        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Корзина была создана."), JSON_UNESCAPED_UNICODE);
    }
    // если не удается создать корзину, сообщим пользователю
    else {
        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("message" => "Невозможно создать корзину."), JSON_UNESCAPED_UNICODE);
    }
}
// сообщим пользователю что данные неполные
else {
    // установим код ответа - 400 неверный запрос
    http_response_code(400);

    // сообщим пользователю
    echo json_encode(array("message" => "Невозможно создать корзину. Данные неполные."), JSON_UNESCAPED_UNICODE);
}