<?php
	$server="localhost";
	$user="root";
	$pass="";
	$name="voting_system_db";
	$connection = mysqli_connect($server,$user,$pass,$name);
	if(!$connection){
		die("");
	}
?>