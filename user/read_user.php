<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты
include_once "../config/database.php";
include_once "../objects/user.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем пользователя
$user = new User($db);

// запрашиваем список пользоваетелей
$stmt = $user->read();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num > 0) {
    // массив товаров
    $users_arr = array();
    $users_arr["records"] = array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);
        $user_item = array(
            "userId " => $userId ,
            "username" => $username,
            "email" => $email,
            "address" => $address,
            "city" => $city,
            "postalCode" => $postalCode,
            "country" => $country
        );
        array_push($users_arr["records"], $user_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode($users_arr);
} else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что не найдено
    echo json_encode(array("message" => "Пользователи не найдены."), JSON_UNESCAPED_UNICODE);
}