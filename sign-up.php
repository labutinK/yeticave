<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");

if (isset($_SESSION['username'])) {
    http_response_code(403);
    $page_content = getErrorTemplate("Вы уже зарегистрированы");
} else {
    if ($link) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $_POST;
            $reqired = ['email', 'password', 'name', 'message'];
            $errors = [];
            $rules = [
                'email' => function ($value) use ($link) {
                    if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) return 'Некорректный email';
                    $sql = 'SELECT email from users';
                    $res = mysqli_query($link, $sql);
                    if (!$res) {
                        return 'Ошибка подключения к базе данных';
                    }
                    $emails = array_column(mysqli_fetch_all($res, MYSQLI_ASSOC), 'email');
                    if (in_array($value, $emails)) return 'Email зарегистрирован на сайте';
                    return null;
                },
                'password' => function ($value) {
                    return isCorrectLength($value, 6, 20);
                },
            ];
            foreach ($data as $name => $value) {
                if (isset($rules[$name])) {
                    $rule = ($rules[$name]);
                    $errors[$name] = $rule($value);
                }
                if (in_array($name, $reqired)) {
                    if (strlen($value) == 0) $errors[$name] = 'Поле обязательно для заполнения';
                }
            }
            $errors = array_filter($errors);
            if (!empty($errors)) {
                $page_content = include_template("registration.php", ['errors' => $errors]);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $sql = 'INSERT INTO users (email,user_password, user_name, contacts) VALUES (?,?,?,?)';
                $stmt = db_get_prepare_stmt($link, $sql, $data);
                $res = mysqli_stmt_execute($stmt);
                if ($res) {
                    $page_content = include_template("registration.php");
                    header("Location: /pages/login.html");
                } else {
                    $page_content = getErrorTemplate(mysqli_error($link));
                }
            }

        } else {
            $page_content = include_template("registration.php");
        }
    } else {
        $page_content = getErrorTemplate(mysqli_error($link));
    }
}
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Регистрация",
]);
print($layout_content);