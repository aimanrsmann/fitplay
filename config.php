<?php
	session_start();
	$host="localhost";
	$user="root";
	$password="";
	$dbName="fitplay_db";
	
	// connection 
	$conn = mysqli_connect($host,$user,$password,$dbName);
	if (!$conn) 
	{
		die("Connection failed: " . mysqli_connect_error());
	}
?>