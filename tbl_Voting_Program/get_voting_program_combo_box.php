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
	$query = "SELECT * FROM tbl_Voting_Program";
	$datas = mysqli_query($connection, $query);
	while ($data = mysqli_fetch_array($datas)) {
		$filterCounter++;
		echo "<option value='{$data['voting_program_id']}'>{$data['voting_program_name']}: {$data['voting_program_description']}</option>";
	}//end of while
}else if($status == "Activated"){
	$query = "SELECT * FROM tbl_Voting_Program";
	$datas = mysqli_query($connection, $query);
	while ($data = mysqli_fetch_array($datas)) {
		if($data['voting_program_status'] == "Activated"){
			$filterCounter++;
			echo "<option value='{$data['voting_program_id']}'>{$data['voting_program_name']}: {$data['voting_program_description']}</option>";
		}
	}//end of while
}
	
if($filterCounter == 0){
	echo "<option value=''>No voting program available</option>";	
}
?>