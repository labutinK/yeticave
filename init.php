<?php
$db = require_once("./config/db.php");
error_reporting(0);
$link = mysqli_connect($db['host'], $db['username'], $db['password'], $db['dbname']);
mysqli_set_charset($link, "utf8");
if (!$link) {
    return $page_content = include_template("error.php", [
        "error" => mysqli_connect_error()
    ]);
}