<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");

if ($link) {
    $sql = 'SELECT name_category, id FROM categories';
    $res = mysqli_query($link, $sql);
    if ($res) {
        $cats = mysqli_fetch_all($res, MYSQLI_ASSOC);
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $errors = [];
            $cats_ids = array_column($cats, 'id');
            $rules = [
                'category_id' => function ($value) use ($cats_ids) {
                    return validateCategory($value, $cats_ids);
                },
                'start_price' => function ($value) {
                    return validateNotZero($value);
                },
                'step' => function ($value) {
                    return validateNotZero($value);
                },
                'date_finish' => function ($value) {
                    return validateDate($value);
                }
            ];

            $lot = filter_input_array(INPUT_POST, ['lot-title' => FILTER_DEFAULT, 'lot_description' => FILTER_DEFAULT, 'category_id' => FILTER_DEFAULT,
                'start_price' => FILTER_DEFAULT, 'step' => FILTER_DEFAULT, 'date_finish' => FILTER_DEFAULT], true);

            foreach ($lot as $key => $value) {
                if (isset($rules[$key])) {
                    $rule = $rules[$key];
                    $errors[$key] = $rule($value);
                }
                if (empty($value) && $value != '0') {
                    $errors[$key] = 'Поле обязательно для заполнения';
                }
            }
            if (!empty($_FILES['lot-picture']['name'])) {
                $tmp_name = $_FILES['lot-picture']['tmp_name'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $file_type = finfo_file($finfo, $tmp_name);
                if ($file_type !== "image/png" && $file_type !== "image/jpeg") {
                    $errors['lot-picture'] = 'Загрузите картинку в формате png или jpeg';
                } else {
                    $pic_name = uniqid() . '.' . mb_substr($_FILES['lot-picture']['type'], 6);
                    $pic_path = __DIR__ . '/uploads/';
                    move_uploaded_file($tmp_name, $pic_path . $pic_name);
                    $lot['lot-picture'] = 'uploads/' . $pic_name;
                }
            } else {
                $errors['lot-picture'] = 'Загрузите картинку лота';
            }
            $errors = array_filter($errors);
            if (count($errors)) {
                $page_content = include_template("add-lot.php", [
                    'categories' => $cats,
                    'errors' => $errors,
                ]);
            } else {
                $sql = 'INSERT INTO lots (title, lot_description, category_id, start_price, step, date_finish,  user_id, img) VALUES (?, ?, ?, ?, ?, ?, 1, ?)';
                $stmt = db_get_prepare_stmt($link, $sql, $lot);
                $res = mysqli_stmt_execute($stmt);
                if ($res) {
                    $id_added = mysqli_insert_id($link);
                    header("Location: /lot.php?ID=$id_added");
                } else {
                    $page_content = getErrorTemplate(mysqli_error($link));
                }
            }
        } else {
            $page_content = include_template("add-lot.php", [
                'categories' => $cats,
            ]);
        }
    } else {
        $page_content = getErrorTemplate(mysqli_error($link));
    }
} else {
    $page_content = getErrorTemplate(mysqli_error($link));
}
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Добавить лот",
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);
print($layout_content);
