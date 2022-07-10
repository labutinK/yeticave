<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");

if ($link) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = $_POST;
        $required = ['email', 'password'];
        $errors = [];
        foreach ($data as $name => $value) {
            if (in_array($name, $required)) {
                if (strlen($value) == 0) $errors[$name] = 'Поле обязательно для заполнения';
            }
        }
        $errors = array_filter($errors);
        if (!empty($errors)) {
            $page_content = include_template("login-template.php", ['errors' => $errors]);
        } else {
            $sql = "SELECT user_password, user_name, id " .
                "FROM users " .
                "WHERE email ='" . $data['email'] . "'";
            $res = mysqli_query($link, $sql);
            if (!$res) {
                $page_content = getErrorTemplate(mysqli_error($link));
            } else {
                $user_data = mysqli_fetch_assoc($res);
                $pass_hash = $user_data['user_password'];

                if (password_verify($data['password'], $pass_hash)) {
                    session_start();
                    $_SESSION['username'] = $user_data['user_name'];
                    $_SESSION['id'] = $user_data['id'];
                    header("Location: /");
                } else {
                    $errors['password'] = "Вы ввели неверный пароль";
                    $page_content = include_template("login-template.php", ["errors" => $errors]);
                }
            }
        }

    } else {
        $page_content = include_template("login-template.php", []);
    }
} else {
    $page_content = getErrorTemplate(mysqli_error($link));
}
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Главная",
]);
print($layout_content);
