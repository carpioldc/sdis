<?php
# Title: check_charset.php
# Center: Universidad Autonoma de Madrid
# Description: Check the charset of the database

include 'mysql_functions.php';

# CONNECT TO MYSQL SERVER
$link = sql_connect();

printf("Initial character set: %s\n", mysqli_character_set_name($link));

/* change character set to utf8 */
if (!mysqli_set_charset($link, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($link));
    exit();
} else {
    printf("Current character set: %s\n", mysqli_character_set_name($link));
}

mysqli_close($link);
?>
