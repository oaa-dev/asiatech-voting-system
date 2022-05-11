<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$voting_program_id = $obj->voting_program_id;
$voting_status = $obj->voting_status;

$sql = "UPDATE tbl_Voting_Program 
SET voting_status = '$voting_status'
WHERE voting_program_id = $voting_program_id";
if(mysqli_query($connection, $sql)){
	// LOGS
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("UPDATE VOTING STATUS",$voting_program_id, "", "UPDATE","Voting status successfully changed<br>Status: $voting_status",$signedin_person_id);
	// END OF LOGS

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}
?>