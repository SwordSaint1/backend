<?php 
	date_default_timezone_set('Asia/Manila');
	$conn_sql =new mysqli('localhost', 'root', 'SystemGroup2018', 'tubecutting_kanban_live');
	if ($conn_sql->connect_error){
		die("Connection failed: " . $conn_sql->connect_error);
	}
?>