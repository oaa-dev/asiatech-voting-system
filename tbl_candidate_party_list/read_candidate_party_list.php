<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<div class="table-responsive">
<table class="table table-hover" style="color: black;">
<thead>
	<tr>
	  <th style="width: 2%">#</th>
	  <th style="width: 15%">Student Details</th>
	  <th style="width: 35%">Candidate Position</th>
	  <th style="width: 5%">Status</th>
	  <th style="width: 5%">Action</th>
	</tr>
</thead>
<?php 
$obj = json_decode($_GET["data"], false);
$party_list_id = $obj->party_list_id;
$filter = $obj->filter;
$start = $obj->start;
$end = $obj->end;

if($signedin_user_type_id==1){
$filterCounter = 0;
$query = "SELECT * FROM tbl_Candidate_Position INNER JOIN tbl_Person_Candidate_Party_List 
ON tbl_Candidate_Position.candidate_position_id = tbl_Person_Candidate_Party_List.candidate_position_id
INNER JOIN tbl_Person_Program
ON tbl_Person_Candidate_Party_List.person_program_id = tbl_Person_Program.person_program_id
INNER JOIN tbl_College_Program
ON tbl_Person_Program.college_program_id = tbl_College_Program.college_program_id
WHERE tbl_Candidate_Position.candidate_position_name LIKE \"%$filter%\" OR 
tbl_Candidate_Position.candidate_position_description LIKE \"%$filter%\"";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($User['party_list_id'] == $party_list_id){
	$filterCounter++;
	if($filterCounter>=$start && $filterCounter<=$end){
	$statusColor = statusColor($User['person_candidate_party_list_status']);

	$studName = UserPersonName($User['person_id']);
echo "<tr>
	<td>{$filterCounter}</td>
	<td><b>$studName</b><br><span style='color:gray;'>{$User['college_program_name']}: {$User['college_program_description']}</span>
	</td>
	<td><b>{$User['candidate_position_name']}</b><br><span style='color:gray;'>{$User['candidate_position_description']}</span>
	</td>
	<td>$statusColor</td>
	<td>	
		<button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action <i class='ik ik-chevron-down'></i></button>
		<div class='dropdown-menu'>
	        <a class='dropdown-item' 
	        	onclick='btnChangeStatus({$User['person_candidate_party_list_id']})' 
				data-toggle='tooltip' title='Add Student to this Party List'
				id='{$User['person_candidate_party_list_id']}'>
				<i class='ik ik-refresh-cw'></i> Change Status
	        </a>
	    </div>					
	</td>
</tr>";
	        // <div role='separator' class='dropdown-divider'></div>
	}//end of pagination
	}
}//end of while
}//end of if
else if($signedin_user_type_id==2){
$filterCounter = 0;
$query = "SELECT * FROM tbl_Candidate_Position INNER JOIN tbl_Person_Candidate_Party_List 
ON tbl_Candidate_Position.candidate_position_id = tbl_Person_Candidate_Party_List.candidate_position_id
INNER JOIN tbl_Person_Program
ON tbl_Person_Candidate_Party_List.person_program_id = tbl_Person_Program.person_program_id
INNER JOIN tbl_College_Program
ON tbl_Person_Program.college_program_id = tbl_College_Program.college_program_id
WHERE tbl_Candidate_Position.candidate_position_name LIKE \"%$filter%\" OR 
tbl_Candidate_Position.candidate_position_description LIKE \"%$filter%\"";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
if($User['party_list_platform_added_by']==$signedin_person_id){
	if($User['party_list_id'] == $party_list_id){
	$filterCounter++;
	if($filterCounter>=$start && $filterCounter<=$end){
	$statusColor = statusColor($User['person_candidate_party_list_status']);

	$studName = UserPersonName($User['person_id']);
echo "<tr>
	<td>{$filterCounter}</td>
	<td><b>$studName</b><br><span style='color:gray;'>{$User['college_program_name']}: {$User['college_program_description']}</span>
	</td>
	<td>{$User['candidate_position_name']}<br><span style='color:gray;'>{$User['candidate_position_description']}</span>
	</td>
	<td>$statusColor</td>
	<td>	
		<button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action <i class='ik ik-chevron-down'></i></button>
		<div class='dropdown-menu'>
	        <a class='dropdown-item' 
	        	onclick='btnChangeStatus({$User['person_candidate_party_list_id']})' 
				data-toggle='tooltip' title='Add Student to this Party List'
				id='{$User['person_candidate_party_list_id']}'>
				<i class='ik ik-refresh-cw'></i> Change Status
	        </a>
	    </div>					
	</td>
</tr>";
		}//end of pagination
	}
}//end of if
}//end of while
}
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