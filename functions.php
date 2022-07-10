<?php
require_once("helpers.php");
/*
* Функция форматирования цены
* @params number $price - изначальная цена
* @return string - отформатированная цена
*/
function format_price($price)
{
    $price = number_format(ceil($price), 0, "", " ");
    return ("$price ₽");
}

/*
 * Возвращеет количество целых часов и остатка минут от настоящего времени до даты
 * @param string $left_date Дата истечения времени
 * @return array
 */
function expiration_calc($left_date)
{
    date_default_timezone_set('Europe/Moscow');
    $cur_date = strtotime("now");
    $left_date = strtotime($left_date);
    $res_array = [];
    $diff = $left_date - $cur_date;
    if ($diff < 0) return ['hours' => '00', 'minutes' => '00', 'soon' => 'left'];
    $res_array['hours'] = str_pad(floor($diff / 3600), 2, "0", STR_PAD_LEFT);
    $res_array['minutes'] = str_pad(floor($diff % 3600 / 60), 2, "0", STR_PAD_LEFT);
    return $res_array;
}


/*
    Функции валидации значения полей
 */


function validateCategory($id, $allowed_list)
{
    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
    }
    return null;
}

function validateNotZero($value)
{
    if (!is_numeric($value)) {
        return 'Значение поля должно быть числом';
    } else {
        if (intval($value) <= 0) {
            return 'Значение поля должно быть больше нуля';
        }
        return null;
    }
}

function validateDate($value)
{
    $d = DateTime::createFromFormat('Y-m-d', $value);
    if (!$d || $d->format('Y-m-d') !== $value) {
        return 'Задайте дату в формате ГГГГ-ММ-ДД';
    }
    if (date_diff(new DateTime(), new DateTime($value))->days < 1 || (new DateTime() > new DateTime($value))) {
        return 'Дата окончания торгов должна быть больше текущей хотя бы на 1 день';
    }
    return null;
}

function getErrorTemplate($errorText)
{
    return include_template("error.php", [
        "error" => $errorText
    ]);
}

function preArray($array){
    echo '<pre>',print_r($array,1),'</pre>';
}

function isCorrectLength($name, $min, $max) {
    $len = strlen($name);

    if ($len < $min or $len > $max) {
        return "Значение должно быть от $min до $max символов";
    }
    return null;
}
