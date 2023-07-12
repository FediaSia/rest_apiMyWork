<?php

// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом User
include_once "../config/database.php";
include_once "../objects/user.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$user = new User($db);

// получаем userId для редактирования
$data = json_decode(file_get_contents("php://input"));

// установим значения свойств юзера
$user->userId = $data->userId;
$user->username = $data->username;
$user->email = $data->email;
$user->address = $data->address;
$user->city = $data->city;
$user->postalCode = $data->postalCode;
$user->country = $data->country;
$user->created = date("Y-m-d H:i:s");

// обновление юзера
if ($user->update()) {
    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array("message" => "Пользователь был обновлён"), JSON_UNESCAPED_UNICODE);
}
// если не удается обновить юзера, сообщим пользователю
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщение пользователю
    echo json_encode(array("message" => "Невозможно обновить пользователя"), JSON_UNESCAPED_UNICODE);
}