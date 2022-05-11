<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 

$obj = json_decode($_GET["data"], false);
$filter = $obj->filter;

$counter = 0;
$query = "SELECT * FROM tbl_Party_List INNER JOIN tbl_College_Program
ON tbl_Party_List.college_program_id = tbl_College_Program.college_program_id
WHERE tbl_Party_List.party_list_name LIKE \"%$filter%\" OR 
tbl_Party_List.party_list_description LIKE \"%$filter%\" OR 
tbl_Party_List.party_list_code LIKE \"%$filter%\"
ORDER BY tbl_Party_List.party_list_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$counter++;
}
echo $counter;
?>