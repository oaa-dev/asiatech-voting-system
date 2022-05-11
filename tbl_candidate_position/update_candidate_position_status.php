<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$candidate_position_id = $obj->candidate_position_id;
$candidate_position_status = $obj->candidate_position_status;

$sql = "UPDATE tbl_Candidate_Position 
SET candidate_position_status = '$candidate_position_status'
WHERE candidate_position_id = $candidate_position_id";
if(mysqli_query($connection, $sql)){
	// LOGS
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("UPDATE CANDIDATE POSITION STATUS",$candidate_position_id, "", "UPDATE","Candidate position status successfully changed<br>Status: $candidate_position_status",$signedin_person_id);
	// END OF LOGS

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}
?>