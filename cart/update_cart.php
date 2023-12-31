<?php

// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом Сart
include_once "../config/database.php";
include_once "../objects/cart.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$cart = new Cart($db);

// получаем id для редактирования
$data = json_decode(file_get_contents("php://input"));

// установим значения свойств корзины
$cart->id = $data->id;
$cart->userid = $data->userid;
$cart->productid = $data->productid;
$cart->quantity = $data->quantity;
$cart->created = date("Y-m-d H:i:s");

// обновление корзины
if ($cart->update()) {
    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array("message" => "Корзина была обновлена"), JSON_UNESCAPED_UNICODE);
}
// если не удается обновить корзину, сообщим пользователю
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщение пользователю
    echo json_encode(array("message" => "Невозможно обновить корзину"), JSON_UNESCAPED_UNICODE);
}