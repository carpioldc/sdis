<?php
	include 'update_database-php/mysql_functions.php';

	# CONNECT TO MYSQL SERVER
	$link = sql_connect_obj();

	if ($stmt = $link->prepare("SELECT title, img FROM film")) {
        
		if (!$stmt->execute())
			die("Error on the execution of the query 1");

		$result = $stmt->get_result();
		#void var_dump (mixed $expression[, mixed $expression[,  $...]] )
		while ($row = $result->fetch_array(MYSQLI_NUM))
		{
			foreach ($row as $r)
			{
				print "$r ";
			}
		print "\n";
		}
	
		/* close statement */
		$stmt->close();
	}
?>
