<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$party_list_id = add_escape_character($obj->party_list_id);
$college_program_id = add_escape_character($obj->college_program_id);
$party_list_name = add_escape_character($obj->party_list_name);
$party_list_description = add_escape_character($obj->party_list_description);

$sql = "UPDATE tbl_Party_List 
SET college_program_id = $college_program_id, 
party_list_name = '$party_list_name', 
party_list_description = '$party_list_description'
WHERE party_list_id = $party_list_id";
if(mysqli_query($connection, $sql)){
	// LOGS
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("UPDATE PARTY LIST INFORMATION",$party_list_id, "", "UPDATE","Party list information successfully changed<br>New Information<br>Party List Name: $party_list_name<br>Party List Description: $party_list_description",$signedin_person_id);
	// END OF LOGS

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}

?>