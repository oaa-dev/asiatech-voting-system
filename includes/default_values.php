<?php 
date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

	global $connection;
	$newID = 0; $noData = 0;
	$query = "SELECT * FROM tbl_User_Type";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$noData++;
	}
	if($noData == 0){
		$dataArray = array("Administrator", "Staff", "Student");
		for($index = 0; $index < COUNT($dataArray); $index++){
			
			$newID++;
			global $connection;
			$sql = "INSERT INTO tbl_User_Type 
			VALUES ($newID,'{$dataArray[$index]}', 'Activated')";
			if(mysqli_query($connection, $sql)){
			}else{
			}	
		}
	}
	else{
	}
?>

<?php 
	
	global $connection;
	$newID = 0; $noData = 0;
	$query2 = "SELECT * FROM tbl_Person";
	$Users2 = mysqli_query($connection, $query2);
	while ($User2 = mysqli_fetch_array($Users2)) {
		$noData++;
	}
	if($noData == 0){
		date_default_timezone_set("Asia/Manila");
		$Date = date("Y-m-d");
		$Time = date("h:i:sa");
		global $connection;
		$generated_code = GenerateDisplayId("CODE", 1);

		$sql1 = "INSERT INTO tbl_Person 
		VALUES (1,'$generated_code','Daine','','Silva','','0000-00-00','','','','','','','','', 'daine_silva@gmail.com','','','$Date @ $Time', 'Saved',1,1)";
		if(mysqli_query($connection, $sql1)){
		}else{
		}
	}
	else{
	}
?>

<?php 
	
	global $connection;
	$newID = 0; $noData = 0;
	$query2 = "SELECT * FROM tbl_Account";
	$Users2 = mysqli_query($connection, $query2);
	while ($User2 = mysqli_fetch_array($Users2)) {
		$noData++;
	}
	if($noData == 0){
		date_default_timezone_set("Asia/Manila");
		$Date = date("Y-m-d");
		$Time = date("h:i:sa");
		$password=password_hash(add_escape_character("admin123"), PASSWORD_DEFAULT);
		global $connection;
		$sql1 = "INSERT INTO tbl_Account 
		VALUES (1,1,'daine_silva@gmail.com','$password','0000','Activated')";
		if(mysqli_query($connection, $sql1)){
		}else{
		}
	}
	else{
	}
?>

<?php 
	
	global $connection;
	$newID = 0; $noData = 0;
	$query2 = "SELECT * FROM tbl_College_Program";
	$Users2 = mysqli_query($connection, $query2);
	while ($User2 = mysqli_fetch_array($Users2)) {
		$noData++;
	}
	if($noData == 0){
		$dataArray = array("CBHTM", "CEITE", "CEAS", "COA");
		$dataArrayDescription = array("College of Business Hospitality abd Tourism Management", "College of Engineering and Information Technology Education", "College of Education, Arts and Science", "College of Accountancy");
		for($index = 0; $index < COUNT($dataArray); $index++){
			
			$newID++;
			date_default_timezone_set("Asia/Manila");
			$Date = date("Y-m-d");
			$Time = date("h:i:sa");
			$generated_code = GenerateDisplayId("PROGRAM", $newID);

			global $connection;
			$sql = "INSERT INTO tbl_College_Program 
			VALUES ($newID,'$generated_code','{$dataArray[$index]}', '{$dataArrayDescription[$index]}', '$Date @ $Time', 'Activated', 1)";
			if(mysqli_query($connection, $sql)){
			}else{
			}	
		

		}
	}
	else{
	}
?>