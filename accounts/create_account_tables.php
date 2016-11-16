<?php
$tables = ['login', 'log_login', 'user'];
include '/home/yango/workspaces/php.d/update_movies.d/yango_mysql_functions.php';

# CONNECT TO MYSQL SERVER
$conn = yangosql_connect();


$sql_login = "CREATE TABLE login (
	id int NOT NULL AUTO_INCREMENT,
	hash_username char(255) COLLATE utf8_bin NOT NULL,
	hash_password char(255) COLLATE utf8_bin NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY hash_email (hash_username),
	KEY hash_password (hash_password)
	);";

$sql_log_login = "CREATE TABLE log_login (
  	id int NOT NULL AUTO_INCREMENT,
  	id_user int DEFAULT NULL,
  	last_login timestamp,
  	IP int,
  	success tinyint,
  	PRIMARY KEY (id)
        );";

$sql_user = "CREATE TABLE user (
        id_user int NOT NULL,
	role set( 'periodista', 'lector', 'admin', '') COLLATE utf8_bin NOT NULL,
	id_superior int(11) DEFAULT NULL,
	username varchar(80) COLLATE utf8_bin NOT NULL,
	active int NOT NULL,
	banned int NOT NULL,
	PRIMARY KEY ( id_user, role ),
	KEY username ( username )
        );";

# CREATE TABLES

foreach ($tables as $table) {
	if (mysqli_query($conn, ${'sql_'.$table})) {
		echo "Table $table created succesfully\n";
	}
	else {
		echo "Error creating table $table: " . mysqli_error($conn). "\n";
	}
}
mysqli_close($conn);
?>
