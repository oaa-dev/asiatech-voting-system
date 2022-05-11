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
$party_list_platform_title = add_escape_character($obj->party_list_platform_title);
$party_list_platform_content = add_escape_character($obj->party_list_platform_content);

date_default_timezone_set("Asia/Manila");
$Date = date("Y-m-d");
$Time = date("h:i:sa");

$party_list_platform_id = 0;
$query = "SELECT * FROM tbl_Party_List_Platform
ORDER BY party_list_platform_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$party_list_platform_id = $User['party_list_platform_id'];
}
$party_list_platform_id++;

$generated_code = GenerateDisplayId("PARTY-LIST-PLATFORM", $party_list_platform_id);

$sql = "INSERT INTO tbl_Party_List_Platform 
VALUES ($party_list_platform_id,'$generated_code',$party_list_id,'$party_list_platform_title', '$party_list_platform_content', '$Date @ $Time', 'Activated', $signedin_person_id)";
if(mysqli_query($connection, $sql)){
	Create_Logs("CREATE PARTY LIST PLATFORM",$party_list_platform_id, $generated_code, "CREATE","New party list platform successfully saved<br>New Information<br>Platform Title: $party_list_platform_title<br>Platform Content: $party_list_platform_content<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}	

?>