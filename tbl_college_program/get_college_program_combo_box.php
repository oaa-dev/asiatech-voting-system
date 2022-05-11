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
	$query = "SELECT * FROM tbl_College_Program";
	$datas = mysqli_query($connection, $query);
	while ($data = mysqli_fetch_array($datas)) {
		$filterCounter++;
		echo "<option value='{$data['college_program_id']}'>{$data['college_program_name']}: {$data['college_program_description']}</option>";
	}//end of while
}else if($status == "Activated"){
	$query = "SELECT * FROM tbl_College_Program";
	$datas = mysqli_query($connection, $query);
	while ($data = mysqli_fetch_array($datas)) {
		if($data['college_program_status'] == "Activated"){
			$filterCounter++;
			echo "<option value='{$data['college_program_id']}'>{$data['college_program_name']}: {$data['college_program_description']}</option>";
		}
	}//end of while
}
	
if($filterCounter == 0){
	echo "<option value=''>No college program available</option>";	
}
?>