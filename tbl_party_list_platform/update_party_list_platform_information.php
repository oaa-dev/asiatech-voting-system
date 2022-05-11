<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$party_list_platform_id = add_escape_character($obj->party_list_platform_id);
$party_list_platform_title = add_escape_character($obj->party_list_platform_title);
$party_list_platform_content = add_escape_character($obj->party_list_platform_content);

$sql = "UPDATE tbl_Party_List_Platform 
SET party_list_platform_title = '$party_list_platform_title', 
party_list_platform_content = '$party_list_platform_content'
WHERE party_list_platform_id = $party_list_platform_id";
if(mysqli_query($connection, $sql)){
	// LOGS
	// $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
	Create_Logs("UPDATE PLATFORM INFORMATION",$party_list_platform_id, "", "UPDATE","Platform information successfully changed<br>New Information<br>Platform Title: $party_list_platform_title<br>Platform Content: $party_list_platform_content",$signedin_person_id);
	// END OF LOGS

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}

?>