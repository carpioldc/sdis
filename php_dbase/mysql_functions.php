<?php
/**
* Open MySQL connection through mysqli (procedural style) with fixed 
* parameters: -h localhost, -u root, -p qwe321. Then use database 'est018'. 
*
* @return connection object returned by mysqli_connect()
**/
function sql_connect()
{	
	$db_servername = "localhost";
	$db_username = "root";
	$db_password = "qwe321";
	$db_name = "est018";

	# CREATE CONNECTION
	$link = mysqli_connect($db_servername, $db_username, $db_password);

	if (!$link) {
	    echo "Error: Unable to connect to MySQL." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	}
	else {
	    echo "Successful connection!" . PHP_EOL;
	    echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;
	    # Select mydb
 	    mysqli_select_db($link, $db_name);
	}
	
	return $link;
}	# End of sql_connect()

/**
* Open MySQL connection through mysqli (object oriented style) with fixed 
* parameters: -h localhost, -u root, -p qwe321. Then use database 'est018'. 
*
* @return connection object returned by mysqli_connect()
**/
function sql_connect_obj()
{	
	$db_servername = "localhost";
	$db_username = "root";
	$db_password = "qwe321";
	$db_name = "est018";

	# CREATE CONNECTION
	$link = new mysqli($db_servername, $db_username, $db_password, $db_name);

	if ($link->connect_error) {
	    die('Connect Error (' . $link->connect_errno . ') '
		    . $link->connect_error);
	}

	echo "Successful connection!" . PHP_EOL;
	echo 'Host information:  ' . $link->host_info . "\n";

        return $link;
}       # End of sql_connect_obj()


/**
* Return the id of a director. Can be used to determine if it exists.
*
* @param mysqli $link Database connection object
* @param string $name Name of the director
* @return id of the director or 0 if not found
**/
function director_id($link, $name)
{
	$stmt = mysqli_stmt_init ( $link );
	$stmt->prepare("SELECT id FROM director WHERE name=?");
	$stmt->bind_param("s", $name);
	if (!$stmt->execute())
	    die("Error on the execution of the query");
	$stmt->bind_result($id);
	$stmt->fetch();
	#printf("%s's id: %s\n", $name, $id);
	$stmt->close();
	return (int)$id;
}


/**
* Add new entry to 'director'
*
* @param mysqli $link Database connection object
* @param string $name Name of the director
* @return id of the director
**/
function add_director($link, $name)
{
	$stmt = mysqli_stmt_init ( $link );
        $stmt->prepare("INSERT INTO director (name) VALUES ('$name');");
        if (!$stmt->execute())
            die("Error on the execution of the query 1");
        
	$stmt->prepare("SELECT MAX(id) FROM director;");
        if (!$stmt->execute())
            die("Error on the execution of the query 2");
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
	echo $name . " added to 'directors'\n";
        return (int)$id;
}

/**
* Return the id of a director. Can be used to determine if it exists.
*
* @param mysqli $link Database connection object
* @param array $film Associative array containing the field values
**/
function add_film($link, $film)
{
	# First part of the query string: INSERT INTO table (<column_name(s)>)
        $fields = "INSERT INTO film (";
        $values = "VALUES ('";
	
	# Save and remove last entry from array (to easen iteration)
	end($film);
        $lastfield = key($film);
	$lastvalue = current($film);
	reset($film);
	unset($film[$lastfield]);
	
	foreach ($film as $k => $v)
	{
		$fields = $fields . $k . ", ";
		$values = $values . $v . "', '";
	}
        $fields = $fields . $lastfield . ") ";
	$values = $values . $lastvalue ."');";
	
	# Prepare INSERT INTO query statement for 
        $sql = mysqli_stmt_init ( $link );
        $sql->prepare($fields . $values);
	if (!$sql->execute())
            die("Error on the execution of the query");
	echo $film['title'] . " added to 'film'\n";
	$sql->close();
}

?>
