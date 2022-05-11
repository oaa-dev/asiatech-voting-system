<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$person_candidate_party_list_id = $obj->person_candidate_party_list_id;
$person_candidate_party_list_status = $obj->person_candidate_party_list_status;

$sql = "UPDATE tbl_Person_Candidate_Party_List 
SET person_candidate_party_list_status = '$person_candidate_party_list_status'
WHERE person_candidate_party_list_id = $person_candidate_party_list_id";
if(mysqli_query($connection, $sql)){
	// LOGS
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("UPDATE CANDIDATE POSITION PARTY LIST STATUS",$person_candidate_party_list_id, "", "UPDATE","Candidate position party list status successfully changed<br>Status: $person_candidate_party_list_status",$signedin_person_id);
	// END OF LOGS

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}
?>