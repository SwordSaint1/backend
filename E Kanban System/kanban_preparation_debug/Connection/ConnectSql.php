<?php 
	date_default_timezone_set('Asia/Manila');
	$conn_sql =new mysqli('localhost', 'root', 'SystemGroup2018', 'live_kanban_preparation');
	if ($conn_sql->connect_error){
		die("Connection failed: " . $conn_sql->connect_error);
	}
?>