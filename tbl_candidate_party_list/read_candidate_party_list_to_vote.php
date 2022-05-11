<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<div class="table-responsive">
<table class="table table-hover" style="color: black;">
<!-- <thead>
	<tr>
	  <th style="width: 15%">Student Details</th>
	  <th style="width: 35%">Candidate Position</th>
	</tr>
</thead> -->
<?php 
$obj = json_decode($_GET["data"], false);
$party_list_id = $obj->party_list_id;

$filterCounter = 0;
$query = "SELECT * FROM tbl_Candidate_Position INNER JOIN tbl_Person_Candidate_Party_List 
ON tbl_Candidate_Position.candidate_position_id = tbl_Person_Candidate_Party_List.candidate_position_id
INNER JOIN tbl_Person_Program
ON tbl_Person_Candidate_Party_List.person_program_id = tbl_Person_Program.person_program_id
INNER JOIN tbl_College_Program
ON tbl_Person_Program.college_program_id = tbl_College_Program.college_program_id";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($User['party_list_id'] == $party_list_id){
	$filterCounter++;
	$statusColor = statusColor($User['person_candidate_party_list_status']);

	$studName = UserPersonName($User['person_id']);
echo "<tr>
	<td><b>{$User['candidate_position_name']}</b></span></td>
	<td><b>$studName</b><br><span style='color:gray;'>{$User['college_program_name']}: {$User['college_program_description']}</span>
	</td>
</tr>";
	}
}//end of while

	if($filterCounter == 0){
		echo "<tr>
			<td colspan='1000' class='alert alert-success'>
				<i class='ik ik-warning'></i> No Records Found !.
			</td>
		</tr>";
	}
?>
</table>
</div>