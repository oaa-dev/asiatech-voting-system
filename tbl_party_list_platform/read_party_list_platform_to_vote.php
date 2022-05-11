<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>
<div class="table-responsive">
<table class="table table-hover" style="color: black;">
<!-- <thead>
	<tr>
	  <th style="width:100%" colspan="2">Platform</th>
	</tr>
</thead> -->
<?php 
$obj = json_decode($_GET["data"], false);
$party_list_id = $obj->party_list_id;

$filterCounter = 0;
$query = "SELECT * FROM tbl_Party_List_Platform
ORDER BY party_list_platform_title ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($User['party_list_id'] == $party_list_id){
	$filterCounter++;
	$statusColor = statusColor($User['party_list_platform_status']);

echo "<tr>
	<td><b>{$User['party_list_platform_title']}</b></td>
	<td>{$User['party_list_platform_content']}</td>
</tr>";
	        // <div role='separator' class='dropdown-divider'></div>
	}
}//end of while

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