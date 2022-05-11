<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 

$obj = json_decode($_GET["data"], false);
$party_list_id = $obj->party_list_id;
$filter = $obj->filter;

$counter = 0;
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
	if($User['party_list_id']==$party_list_id)
		$counter++;
}
echo $counter;
?>