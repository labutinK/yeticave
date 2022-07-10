<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");

if ($link) {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $page_content = include_template("search-tmpl.php");
        $req = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        $q = $req['search'];
        $sql = "SELECT l.id, lot_description, title, img, start_price, date_finish, name_category, date_creation "
            . "FROM lots l "
            . "JOIN categories s ON l.category_id = s.id "
            . "where date_finish > now() and MATCH(title,lot_description) AGAINST('" . "$q" . "')";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $page_content = include_template("search-tmpl.php", [
                "lots" => $lots,
                'q' => $q
            ]);
        } else {
            $page_content = include_template("error.php", [
                "error" => mysqli_error($link),
            ]);
        }
    }
} else {
    $page_content = getErrorTemplate(mysqli_error($link));
}
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Регистрация",
]);
print($layout_content);