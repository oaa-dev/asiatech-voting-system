<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$candidate_position_id = add_escape_character($obj->candidate_position_id);
$candidate_position_name = add_escape_character($obj->candidate_position_name);
$candidate_position_description = add_escape_character($obj->candidate_position_description);

$sql = "UPDATE tbl_Candidate_Position 
SET candidate_position_name = '$candidate_position_name', 
candidate_position_description = '$candidate_position_description'
WHERE candidate_position_id = $candidate_position_id";
if(mysqli_query($connection, $sql)){
	// LOGS
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("UPDATE CANDIDATE POSITION INFORMATION",$candidate_position_id, "", "UPDATE","Candidate position information successfully changed<br>New Information<br>College Position Name: $candidate_position_name<br>Position Description: $candidate_position_description",$signedin_person_id);
	// END OF LOGS

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}

?>