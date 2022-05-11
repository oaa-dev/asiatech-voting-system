<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 

$obj = json_decode($_GET["data"], false);
$userType = $obj->userType;
$filter = $obj->filter;

$counter = 0;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_Person_Program
ON tbl_Person.person_id = tbl_Person_Program.person_id
INNER JOIN tbl_College_Program
ON tbl_Person_Program.college_program_id = tbl_College_Program.college_program_id
WHERE tbl_Person.last_name LIKE \"%$filter%\" OR 
tbl_Person.first_name LIKE \"%$filter%\" OR 
tbl_Person.middle_name LIKE \"%$filter%\" OR 
tbl_Person.affiliation_name LIKE \"%$filter%\"";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($User['user_type_id']==$userType && 
	$User['person_program_status'] == "Activated")
		$counter++;
}
echo $counter;
?>