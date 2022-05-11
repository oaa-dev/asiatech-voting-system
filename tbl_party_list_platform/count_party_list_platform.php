<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 

$obj = json_decode($_GET["data"], false);
$party_list_id = $obj->party_list_id;
$filter = $obj->filter;

$counter = 0;
$query = "SELECT * FROM tbl_Party_List_Platform
WHERE party_list_platform_title LIKE \"%$filter%\" OR 
party_list_platform_content LIKE \"%$filter%\"
ORDER BY party_list_platform_title ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($User['party_list_id'] == $party_list_id){
		$counter++;
	}
}
echo $counter;
?>