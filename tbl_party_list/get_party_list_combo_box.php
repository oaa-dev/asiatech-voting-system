<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$status = $obj->status;

$filterCounter = 0;
if($status == "All"){
	$query = "SELECT * FROM tbl_Party_List";
	$datas = mysqli_query($connection, $query);
	while ($data = mysqli_fetch_array($datas)) {
		$filterCounter++;
		echo "<option value='{$data['party_list_id']}'>{$data['party_list_name']}: {$data['party_list_description']}</option>";
	}//end of while
}else if($status == "Activated"){
	$query = "SELECT * FROM tbl_Party_List";
	$datas = mysqli_query($connection, $query);
	while ($data = mysqli_fetch_array($datas)) {
		if($data['party_list_status'] == "Activated"){
			$filterCounter++;
			echo "<option value='{$data['party_list_id']}'>{$data['party_list_name']}: {$data['party_list_description']}</option>";
		}
	}//end of while
}
	
if($filterCounter == 0){
	echo "<option value=''>No part list available</option>";	
}
?>