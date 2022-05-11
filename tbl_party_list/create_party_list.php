<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$college_program_id = add_escape_character($obj->college_program_id);
$party_list_name = add_escape_character($obj->party_list_name);
$party_list_description = add_escape_character($obj->party_list_description);

date_default_timezone_set("Asia/Manila");
$Date = date("Y-m-d");
$Time = date("h:i:sa");

$party_list_id = 0;
$query = "SELECT * FROM tbl_Party_List
ORDER BY party_list_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$party_list_id = $User['party_list_id'];
}
$party_list_id++;

$generated_code = GenerateDisplayId("PARTY-LIST", $party_list_id);

$sql = "INSERT INTO tbl_Party_List 
VALUES ($party_list_id,'$generated_code',$college_program_id,'$party_list_name', '$party_list_description', '$Date @ $Time', 'Activated', $signedin_person_id)";
if(mysqli_query($connection, $sql)){
	Create_Logs("CREATE PARTY LIST",$party_list_id, $generated_code, "CREATE","New party list successfully saved<br>New Information<br>Party list Name: $party_list_name<br>Party list Description: $party_list_description<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Error: ".$connection->error." || ".$sql;
}	

?>