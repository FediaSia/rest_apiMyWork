<?php

// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключим файл для соединения с базой и объектом Cart
include_once "../config/database.php";
include_once "../objects/cart.php";

// получаем соединение с БД
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$cart = new Cart($db);

// получаем id
$data = json_decode(file_get_contents("php://input"));

// установим id для удаления
$cart->id = $data->id;

// удаление юзера
if ($cart->delete()) {
    // код ответа - 200 ok
    http_response_code(200);

    // сообщение пользователю
    echo json_encode(array("message" => "Корзина была удалена"), JSON_UNESCAPED_UNICODE);
}
// если не удается удалить корзину
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщим об этом пользователю
    echo json_encode(array("message" => "Не удалось удалить корзину"));
}