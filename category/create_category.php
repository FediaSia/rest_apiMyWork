<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once "../config/database.php";

// создание объекта категории
include_once "../objects/category.php";
$database = new Database();
$db = $database->getConnection();
$category = new Category($db);

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты
if (
    !empty($data->id) &&
    !empty($data->name) &&
    !empty($data->description)
) {
    // устанавливаем значения свойств категории
    $category->id = $data->id;
    $category->name = $data->name;
    $category->description = $data->description;
    $category->created = date("Y-m-d H:i:s");

    // создание категории
    if ($category->create()) {
        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Категория была создана."), JSON_UNESCAPED_UNICODE);
    }
    // если не удается создать категорию, сообщим пользователю
    else {
        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("message" => "Невозможно создать категорию."), JSON_UNESCAPED_UNICODE);
    }
}
// сообщим пользователю что данные неполные
else {
    // установим код ответа - 400 неверный запрос
    http_response_code(400);

    // сообщим пользователю
    echo json_encode(array("message" => "Невозможно создать категорию. Данные неполные."), JSON_UNESCAPED_UNICODE);
}