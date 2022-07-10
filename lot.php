<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");

if($link){
    $id = filter_input(INPUT_GET, 'ID');
    if(!$id){
        http_response_code(404);
        $page_content = include_template('error.php', ['error' => '404<br>Лот не найден']);
        $layout_content = include_template('layout.php', ['content' => $page_content]);
    }
    else{
        $sql = "SELECT l.id, title, lot_description, img, start_price, date_finish, step, category_id, name_category, c.id " .
        "FROM lots l JOIN categories c ON category_id = c.id " .
        "WHERE l.id = $id";
        $result = mysqli_query($link, $sql);
        if($result){
            $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $lot = $lots[0];
            $page_content = include_template('lot.php', ['lot' => $lot]);
            $layout_content = include_template('layout.php', ['content' => $page_content]);
        }

    }

}
else{
    http_response_code(404);
    $page_content = include_template('error.php', ['error' => http_response_code()]);
    $layout_content = include_template('layout.php', ['content' => $page_content]);
}

print($layout_content);