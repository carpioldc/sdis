<?php
# Title: uptdate_movie_tables.php 
# Center: Universidad Autonoma de Madrid
# Description: This script adds info contained in a CSV file to a database. 
# The first row contains a descriptive name of each column. 
# The rest of the rows have information to be added to the database
# specified in the parameters. Encoding: utf-8

include 'mysql_functions.php';

# SCRIPT PARAMETERS
$csv_filename = "/tmp/movie_data.csv";
$film_tbname = "film";
$director_tbname = "director";

# CREATE AND CHECK CONNECTION
$conn = sql_connect();
if(!$conn)
    die("CONNECTION FAILED: " . mysqli_connect_error());

# CHANGE CHARSET TO UTF-8
if (!mysqli_set_charset($conn, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($conn));
    exit();
}

# INSERT ROWS INTO DATABASE:
# 0- read first row, create associative array 
# 1- read next row from .csv, update values on the array
# 2- check director. If it exists, get id for its insertion on the film table.
# 3- if it doesn't, insert into 'director' 
# 4- query string for 'film'

if (($file = fopen($csv_filename,"r")) !== FALSE) { # Open file
        $fieldnames = fgetcsv($file);  # This is the first row
	foreach ($fieldnames as $k => $v) 
            $film[$v] = '';
        
	# Now read rows until the end
	while ($row = fgetcsv($file))
        {
		foreach ($row as $k => $v)
	        	$film[$fieldnames[$k]] = mysqli_real_escape_string($conn, $v);

		# Check director
		if(!$id = director_id($conn, $film['director'])) # If it does not exist already
			$id = add_director($conn, $film['director']);		
		
		$film['id_director'] = $id;
		unset($film['director']);
		add_film($conn, $film);		
		
	}	
	# Close file
	fclose($file);
}
# Close db connection
mysqli_close($conn);
?> 
