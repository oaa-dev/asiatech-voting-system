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
	  <th style="width: 15%">Candidacy Details</th>
	  <th style="width: 10%">Created At</th>
	  <th style="width: 5%">Status</th>
	</tr>
</thead>
<?php 
$obj = json_decode($_GET["data"], false);
$filter = $obj->filter;
$start = $obj->start;
$end = $obj->end;

if($signedin_user_type_id==1){
$filterCounter = 0;
$query = "SELECT * FROM tbl_Candidate_Position INNER JOIN tbl_Filling_Of_Candidacy 
ON tbl_Candidate_Position.candidate_position_id = tbl_Filling_Of_Candidacy.candidate_position_id
INNER JOIN tbl_Person
ON tbl_Filling_Of_Candidacy.person_id = tbl_Person.person_id
WHERE tbl_Person.first_name LIKE \"%$filter%\" OR 
tbl_Person.middle_name LIKE \"%$filter%\" OR 
tbl_Person.last_name LIKE \"%$filter%\" OR 
tbl_Candidate_Position.candidate_position_name LIKE \"%$filter%\"
ORDER BY tbl_Person.last_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$filterCounter++;
	if($filterCounter>=$start && $filterCounter<=$end){
	$statusColor = statusColor($User['candidacy_status']);

echo "<tr>
	<td>{$filterCounter}</td>
	<td>{$User['last_name']} {$User['affiliation_name']}, {$User['first_name']} 
		{$User['middle_name']}<br>
		<span style='color:gray'>{$User['person_code']}</span></td>
	<td><b>{$User['candidate_position_name']}</b><br>
		<span style='color:gray'>Platforms: {$User['candidacy_platforms']}</span></td>
	<td>{$User['candidacy_created_at']}</td>
	<td>{$statusColor}</td>
</tr>";
	        // <div role='separator' class='dropdown-divider'></div>
	}//end of pagination
}//end of while
}//end of if
else if($signedin_user_type_id==2){
$filterCounter = 0;
$query = "SELECT * FROM tbl_Candidate_Position INNER JOIN tbl_Filling_Of_Candidacy 
ON tbl_Candidate_Position.candidate_position_id = tbl_Filling_Of_Candidacy.candidate_position_id
INNER JOIN tbl_Person
ON tbl_Filling_Of_Candidacy.person_id = tbl_Person.person_id
WHERE tbl_Person.first_name LIKE \"%$filter%\" OR 
tbl_Person.middle_name LIKE \"%$filter%\" OR 
tbl_Person.last_name LIKE \"%$filter%\" OR 
tbl_Candidate_Position.candidate_position_name LIKE \"%$filter%\"
ORDER BY tbl_Person.last_name ASC";
while ($User = mysqli_fetch_array($Users)) {
if($User['party_list_added_by']==$signedin_person_id){
	$filterCounter++;
	if($filterCounter>=$start && $filterCounter<=$end){
	$statusColor = statusColor($User['candidacy_status']);

echo "<tr>
	<td>{$filterCounter}</td>
	<td>{$User['last_name']} {$User['affiliation_name']}, {$User['first_name']} 
		{$User['middle_name']}<br>
		<span style='color:gray'>{$User['person_code']}</span></td>
	<td><b>{$User['candidate_position_name']}</b><br>
		<span style='color:gray'>Platforms: {$User['candidacy_platforms']}</span></td>
	<td>{$User['candidacy_created_at']}</td>
	<td>{$statusColor}</td>
</tr>";
	}//end of pagination
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