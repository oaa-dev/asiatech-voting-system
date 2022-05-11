<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<div class="table-responsive">
<table class="table table-hover w3-responsive" style="color: black;">
<thead>
	<tr>
	  <th style="width: 2%">#</th>
	  <th style="width: 15%">Program</th>
	  <th style="width: 15%">Name</th>
	  <th style="width: 15%">Home Address</th>
	  <th style="width: 5%">Action</th>
	</tr>
</thead>
<?php 
$obj = json_decode($_GET["data"], false);
$filter = $obj->filter;
$userType = $obj->userType;
$start = $obj->start;
$end = $obj->end;

if($signedin_user_type_id==1){
$filterCounter = 0;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_Person_Program
ON tbl_Person.person_id = tbl_Person_Program.person_id
INNER JOIN tbl_College_Program
ON tbl_Person_Program.college_program_id = tbl_College_Program.college_program_id
WHERE tbl_Person.last_name LIKE \"%$filter%\" OR 
tbl_Person.first_name LIKE \"%$filter%\" OR 
tbl_Person.middle_name LIKE \"%$filter%\" OR 
tbl_Person.affiliation_name LIKE \"%$filter%\"
ORDER BY tbl_Person.last_name, tbl_Person.first_name, tbl_Person.middle_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
if($User['user_type_id'] == $userType && 
	$User['person_program_status'] == "Activated"){
	$filterCounter++;
	if($filterCounter>=$start && $filterCounter<=$end){
echo "<tr>
	<td>{$filterCounter}</td>
	<td><b>{$User['college_program_name']}</b> : {$User['college_program_description']}</td>
	<td>{$User['last_name']} {$User['affiliation_name']}, {$User['first_name']} 
		{$User['middle_name']}<br>
		<span style='color:gray'>{$User['person_code']}</span></td>
	<td>{$User['house_no']} {$User['street']} Brgy. {$User['barangay']}, {$User['city']}, {$User['province']}, {$User['region']}</td>
	<td>						
		<button type='button' class='btn btn-secondary' onclick='btnAddToPartyList({$User['person_program_id']}, {$User['person_id']})' data-toggle='tooltip' title='Add Student to this Party List'><i class='ik ik-plus'></i> Add</button>
	</td>
</tr>";
	        // <div role='separator' class='dropdown-divider'></div>
	}//end of pagination
}//end of if
}//end of while
}//end of if
else if($signedin_user_type_id==2){
$filterCounter = 0;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_Person_Program
ON tbl_Person.person_id = tbl_Person_Program.person_id
INNER JOIN tbl_College_Program
ON tbl_Person_Program.college_program_id = tbl_College_Program.college_program_id
WHERE tbl_Person.last_name LIKE \"%$filter%\" OR 
tbl_Person.first_name LIKE \"%$filter%\" OR 
tbl_Person.middle_name LIKE \"%$filter%\" OR 
tbl_Person.affiliation_name LIKE \"%$filter%\"
ORDER BY tbl_Person.last_name, tbl_Person.first_name, tbl_Person.middle_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
if($User['user_type_id'] == $userType && $User['added_by']==$signedin_person_id && 
	$User['person_program_status'] == "Activated"){
	$filterCounter++;
	if($filterCounter>=$start && $filterCounter<=$end){

echo "<tr>
	<td>{$filterCounter}</td>
	<td><b>{$User['college_program_name']}</b> : {$User['college_program_description']}</td>
	<td>{$User['last_name']} {$User['affiliation_name']}, {$User['first_name']} 
		{$User['middle_name']}<br>
		<span style='color:gray'>{$User['person_code']}</span></td>
	<td>{$User['house_no']} {$User['street']} Brgy. {$User['barangay']}, {$User['city']}, {$User['province']}, {$User['region']}</td>
	<td>						
		<button type='button' class='btn btn-secondary' onclick='btnAddToPartyList({$User['person_program_id']})' data-toggle='tooltip' title='Add Student to this Party List'><i class='ik ik-plus'></i> Add</button>
	</td>
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