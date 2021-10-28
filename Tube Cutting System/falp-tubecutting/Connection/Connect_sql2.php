<?php 
	$conn_sql2 =new mysqli('localhost', 'root', '', 'sem_db');
	if ($conn_sql2->connect_error) {
		die("Connection failed: " . $conn_sql->connect_error);
	}
?>