<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом
include_once "../config/database.php";
include_once "../objects/cart.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$cart = new Cart($db);

// установим свойство ID записи для чтения
$cart->userid = isset($_GET["userid"]) ? $_GET["userid"] : die();

// получим детали корзины
$cart->read_onecart();

if ($cart->userid != null) {

    // создание массива
    $cart_arr = array(
        "id" =>  $cart->id,
        "userid" => $cart->userid,
        "productid" => $cart->productid,
        "quantity" => $cart->quantity,
    );

    // код ответа - 200 OK
    http_response_code(200);

    // вывод в формате json
    echo json_encode($cart_arr);
} else {
    // код ответа - 404 Не найдено
    http_response_code(404);

    // сообщим пользователю, что такой корзины не существует
    echo json_encode(array("message" => "Корзина не существует"), JSON_UNESCAPED_UNICODE);
}