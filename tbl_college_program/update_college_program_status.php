<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$college_program_id = $obj->college_program_id;
$college_program_status = $obj->college_program_status;

$sql = "UPDATE tbl_College_Program 
SET college_program_status = '$college_program_status'
WHERE college_program_id = $college_program_id";
if(mysqli_query($connection, $sql)){
	// LOGS
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("UPDATE COlLEGE PROGRAM STATUS",$college_program_id, "", "UPDATE","College program status successfully changed<br>Status: $college_program_status",$signedin_person_id);
	// END OF LOGS

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}
?>