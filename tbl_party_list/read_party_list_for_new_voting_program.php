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
	  <th style="width: 2%">Action</th>
	  <th style="width: 30%">Party List Details</th>
	  <th style="width: 65%">Candidates</th>
	</tr>
</thead>
<?php 

if($signedin_user_type_id==1){
$filterCounter = 0;
$query = "SELECT * FROM tbl_Party_List INNER JOIN tbl_College_Program
ON tbl_Party_List.college_program_id = tbl_College_Program.college_program_id
ORDER BY party_list_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$filterCounter++;
	$statusColor = statusColor($User['party_list_status']);

echo "<tr>
	<td style='text-align:center;'>
		<div class=\"checkbox-fade fade-in-success\">
            <label>
                <input type=\"checkbox\" value=\"{$User['party_list_id']}\"
                id='{$User['party_list_id']}' name='chkPartyList' id='chkPartyList{$User['party_list_id']}' class='chkPartyList'>
                <span class=\"cr\">
                    <i class=\"cr-icon ik ik-check txt-success\"></i>
                </span>
            </label>
        </div>
	</td>
	<td><b>{$User['party_list_name']}</b><br>
		{$User['party_list_description']}<br>
		<span style='color:gray'>{$User['college_program_description']}</span>
	</td>";

	echo "<td>";
	$queryCandidates = "SELECT * FROM tbl_Person_Candidate_Party_List
	INNER JOIN tbl_Person_Program
	ON tbl_Person_Candidate_Party_List.person_program_id = tbl_Person_Program.person_program_id 
	INNER JOIN tbl_College_Program
	ON tbl_Person_Program.college_program_id = tbl_College_Program.college_program_id";
	$Candidates = mysqli_query($connection, $queryCandidates);
	while ($Candidate = mysqli_fetch_array($Candidates)) {
		if($Candidate['party_list_id']==$User['party_list_id'] && 
			$Candidate['person_program_status'] == "Activated"){
			$studName = UserPersonName($Candidate['person_id']);
			$candidatePosition = CandidatePosition($Candidate['candidate_position_id']);

			echo "<b>$candidatePosition: $studName</b> <br>
				<span style='color:gray;'>{$Candidate['college_program_name']}: {$Candidate['college_program_description']}</span>
			<br>";
		}
	}

	echo "</td>
</tr>";
	        // <div role='separator' class='dropdown-divider'></div>
}//end of while
}//end of if
else if($signedin_user_type_id==2){
$filterCounter = 0;
$query = "SELECT * FROM tbl_Party_List INNER JOIN tbl_College_Program
ON tbl_Party_List.college_program_id = tbl_College_Program.college_program_id
ORDER BY party_list_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
if($User['party_list_added_by']==$signedin_person_id){
	$filterCounter++;
	$statusColor = statusColor($User['party_list_status']);

echo "<tr>
	<td><b>{$User['party_list_name']}</b><br>
		{$User['party_list_description']}<br>
		<span style='color:gray'>{$User['party_list_code']}</span></td>
	<td>						

	</td>
</tr>";
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