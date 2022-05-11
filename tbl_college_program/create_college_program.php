<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$college_program_name = add_escape_character($obj->college_program_name);
$college_program_description = add_escape_character($obj->college_program_description);

date_default_timezone_set("Asia/Manila");
$Date = date("Y-m-d");
$Time = date("h:i:sa");

$college_program_id = 0;
$query = "SELECT * FROM tbl_College_Program
ORDER BY college_program_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$college_program_id = $User['college_program_id'];
}
$college_program_id++;

$generated_code = GenerateDisplayId("PROGRAM", $college_program_id);

$sql = "INSERT INTO tbl_College_Program 
VALUES ($college_program_id,'$generated_code','$college_program_name', '$college_program_description', '$Date @ $Time', 'Activated', $signedin_person_id)";
if(mysqli_query($connection, $sql)){
	Create_Logs("CREATE COLLEGE PROGRAM",$college_program_id, $generated_code, "CREATE","New college program successfully saved<br>New Information<br>College Program Name: $college_program_name<br>College Program Description: $college_program_description<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}	

?>