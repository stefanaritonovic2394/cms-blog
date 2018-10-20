<?php

$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "stefan95";
$db['db_name'] = "cms";

foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Change character set to utf8
mysqli_set_charset($connection, "utf8");

// if ($connection) {
//     echo "Povezani smo";
// }

?>
