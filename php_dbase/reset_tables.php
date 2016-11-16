<?php
# Title: reset_tables.php
# Center: Universidad Autonoma de Madrid
# Description: Drop FK and reset director and film tables

include 'mysql_functions.php';

# CREATE CONNECTION
$link = sql_connect_obj();
if(!$link)
{
	die("CONNECTION FAILED: " . mysqli_connect_error());
}

# SEND QUERY
$table = "film";
$stmt = $link->stmt_init();
$queries = ['ALTER TABLE film DROP FOREIGN KEY fk_dir',
	'TRUNCATE TABLE film', 'TRUNCATE TABLE director',
	'ALTER TABLE film ADD CONSTRAINT fk_dir FOREIGN KEY(id_director) REFERENCES director(id)'];
foreach ($queries as $query) {

	if (!$stmt->prepare( $query ))
		die("Error on the preparation of the query: ".$link->error."\n");
	if (!$stmt->execute())
		die("Error on the execution of the query: ".$link->error."\n");
}
$stmt->close();

# CLOSE CONNECTION
$link->close();
?>

