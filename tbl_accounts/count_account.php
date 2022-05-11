<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 

$obj = json_decode($_GET["data"], false);
$userType = $obj->userType;
$filter = $obj->filter;

$counter = 0;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_Account
ON tbl_Person.person_id=tbl_Account.person_id 
WHERE tbl_Person.last_name LIKE \"%$filter%\" OR tbl_Person.first_name LIKE \"%$filter%\" OR 
tbl_Person.middle_name LIKE \"%$filter%\" OR tbl_Person.affiliation_name LIKE \"%$filter%\" 
OR tbl_Person.person_code LIKE \"%$filter%\" OR 
tbl_Person.person_status LIKE \"%$filter%\"
ORDER BY tbl_Person.last_name, tbl_Person.first_name, tbl_Person.middle_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($User['user_type_id']==$userType)
		$counter++;
}
echo $counter;
?>