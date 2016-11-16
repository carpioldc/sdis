<?php
# Title: insert_new_entry.php
# Center: Universidad Autonoma de Madrid
# Description: Manually insert new entry into table.

include 'mysql_functions.php';

# Open connection
$link = sql_connect();

$name = 'Quenin Tarantino';
$id = director_id( $link, $name );

print $id;

# Close connection
mysqli_close( $link );
?>
