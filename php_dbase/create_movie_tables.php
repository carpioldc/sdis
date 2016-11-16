<?php
# Title: create_movie_tables.php
# Center: Universidad Autonoma de Madrid
# Description: Create film table. Working, but written with descriptive purposes. Therefore, further tables may be added to this script.
#	
$tables = ['director', 'film'];
#

include 'mysql_functions.php';

# CONNECT TO MYSQL SERVER
$conn = sql_connect();


$sql_film = 'CREATE table film (
	id int AUTO_INCREMENT UNIQUE,
	title varchar(64),
	year varchar(4),
	duration varchar(16),
	country varchar(32),
	id_director int,
	genre varchar(32),
	img varchar(128),
	description varchar(1024),
	PRIMARY KEY(id),
	CONSTRAINT fk_dir FOREIGN KEY(id_director) REFERENCES director(id)
	);';

$sql_director = 'CREATE table director (
        id int AUTO_INCREMENT UNIQUE,
        name varchar(64),
        year varchar(4),
        country varchar(32),
        PRIMARY KEY(id)
        );';

# CREATE TABLE film

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
