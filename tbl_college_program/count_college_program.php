<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 

$obj = json_decode($_GET["data"], false);
$filter = $obj->filter;

$counter = 0;
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
	$counter++;
}
echo $counter;
?>