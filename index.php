<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");

$error_flag = 0;
if ($link) {
    $sql = 'SELECT * FROM categories';
    $result = mysqli_query($link, $sql);
    if($result){
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else{
        $page_content = include_template("error.php", [
            "error" => mysqli_error($link),
        ]);
        $error_flag = 1;
    }
    $sql = 'SELECT l.id, title, img, start_price, date_finish, name_category, date_creation '
            . 'FROM lots l '
            . 'JOIN categories s ON l.category_id = s.id '
            . 'where date_finish > now()'
            . 'order by date_creation asc limit 6';

    $result = mysqli_query($link, $sql);
    if($error_flag != 1){
        if($result){
            $goods = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $page_content = include_template("main.php", [
                "categories" => $categories,
                "goods" => $goods
            ]);
        }
        else {
            $page_content = include_template("error.php", [
                "error" => mysqli_error($link),
            ]);
        }
    }
}
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Главная",
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);
print($layout_content);


