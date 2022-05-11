<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$party_list_id = $obj->party_list_id;
$party_list_status = $obj->party_list_status;

$sql = "UPDATE tbl_Party_List 
SET party_list_status = '$party_list_status'
WHERE party_list_id = $party_list_id";
if(mysqli_query($connection, $sql)){
	// LOGS
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("UPDATE PARTY LIST STATUS",$party_list_id, "", "UPDATE","Party list status successfully changed<br>Status: $party_list_status",$signedin_person_id);
	// END OF LOGS

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}
?>