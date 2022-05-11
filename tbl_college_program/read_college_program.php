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
	  <th style="width: 10%">Name</th>
	  <th style="width: 20%">Description</th>
	  <th style="width: 12%">Created At</th>
	  <th style="width: 5%">Status</th>
	  <th style="width: 5%">Action</th>
	</tr>
</thead>
<?php 
$obj = json_decode($_GET["data"], false);
$filter = $obj->filter;
$start = $obj->start;
$end = $obj->end;

if($signedin_user_type_id==1){
$filterCounter = 0;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_College_Program
ON tbl_Person.person_id = tbl_College_Program.college_program_added_by
WHERE tbl_Person.last_name LIKE \"%$filter%\" OR 
tbl_Person.first_name LIKE \"%$filter%\" OR 
tbl_Person.middle_name LIKE \"%$filter%\" OR 
tbl_Person.affiliation_name LIKE \"%$filter%\" OR 
tbl_Person.person_code LIKE \"%$filter%\" OR 
tbl_College_Program.college_program_code LIKE \"%$filter%\" OR 
tbl_College_Program.college_program_name LIKE \"%$filter%\" OR 
tbl_College_Program.college_program_description LIKE \"%$filter%\" OR 
tbl_College_Program.college_program_status LIKE \"%$filter%\"
ORDER BY tbl_College_Program.college_program_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$filterCounter++;
	if($filterCounter>=$start && $filterCounter<=$end){
	$statusColor = statusColor($User['college_program_status']);

echo "<tr>
	<td>{$filterCounter}</td>
	<td>{$User['college_program_name']}<br>
		<span style='color:gray'>{$User['college_program_code']}</span></td>
	<td>{$User['college_program_description']}</td>
	<td>{$User['college_program_created_at']}</td>
	<td>{$statusColor}</td>
	<td>						
		<button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action <i class='ik ik-chevron-down'></i></button>
	    <div class='dropdown-menu'>
	        <a class='dropdown-item' 
	        	onclick='btnViewInformation({$User['college_program_id']})' 
				data-toggle='tooltip' title='View User\"s Profile'
				id='{$User['college_program_id']}'>
				<i class='ik ik-eye'></i> View Details
	        </a>
	        <a class='dropdown-item' 
	        	onclick='btnUpdateInformation({$User['college_program_id']})' 
				data-toggle='tooltip' title='Update User\"s Profile'
				id='{$User['college_program_id']}'>
				<i class='ik ik-edit'></i> Edit Details
	        </a>
	        <a class='dropdown-item'
	        	onclick='btnChangeStatus({$User['college_program_id']})' 
				data-toggle='tooltip' title='Change Access Account Status'
				id='{$User['college_program_id']}'>
				<i class='ik ik-refresh-cw'></i> Change Status
	        </a>
	    </div>
	</td>
</tr>";
	        // <div role='separator' class='dropdown-divider'></div>
	}//end of pagination
}//end of while
}//end of if
else if($signedin_user_type_id==2){
$filterCounter = 0;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_College_Program
ON tbl_Person.person_id = tbl_College_Program.college_program_added_by
WHERE tbl_Person.last_name LIKE \"%$filter%\" OR 
tbl_Person.first_name LIKE \"%$filter%\" OR 
tbl_Person.middle_name LIKE \"%$filter%\" OR 
tbl_Person.affiliation_name LIKE \"%$filter%\" OR 
tbl_Person.person_code LIKE \"%$filter%\" OR 
tbl_College_Program.college_program_code LIKE \"%$filter%\" OR 
tbl_College_Program.college_program_name LIKE \"%$filter%\" OR 
tbl_College_Program.college_program_description LIKE \"%$filter%\" OR 
tbl_College_Program.college_program_status LIKE \"%$filter%\"
ORDER BY tbl_College_Program.college_program_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
if($User['college_program_added_by']==$signedin_person_id){
	$filterCounter++;
	if($filterCounter>=$start && $filterCounter<=$end){
		$statusColor = statusColor($User['college_program_status']);

echo "<tr>
	<td>{$filterCounter}</td>
	<td>{$User['college_program_name']}<br>
		<span style='color:gray'>{$User['college_program_code']}</span></td>
	<td>{$User['college_program_description']}</td>
	<td>{$User['college_program_created_at']}</td>
	<td>{$statusColor}</td>
	<td>						
		<button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action <i class='ik ik-chevron-down'></i></button>
	    <div class='dropdown-menu'>
	        <a class='dropdown-item' 
	        	onclick='btnViewInformation({$User['college_program_id']})' 
				data-toggle='tooltip' title='View User\"s Profile'
				id='{$User['college_program_id']}'>
				<i class='ik ik-eye'></i> View Details
	        </a>
	        <a class='dropdown-item' 
	        	onclick='btnUpdateInformation({$User['college_program_id']})' 
				data-toggle='tooltip' title='Update User\"s Profile'
				id='{$User['college_program_id']}'>
				<i class='ik ik-edit'></i> Edit Details
	        </a>
	        <a class='dropdown-item'
	        	onclick='btnChangeStatus({$User['college_program_id']})' 
				data-toggle='tooltip' title='Change Access Account Status'
				id='{$User['college_program_id']}'>
				<i class='ik ik-refresh-cw'></i> Change Status
	        </a>
	    </div>
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