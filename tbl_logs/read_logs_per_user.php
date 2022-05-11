<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>

<?php 

$obj = json_decode($_GET["data"], false);
$start = $obj->start;
$end = $obj->end;

$filterCounter = 0;
$query = "SELECT * FROM tbl_Logs
WHERE logs_added_by=$signedin_person_id
ORDER BY logs_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
$filterCounter++;
	if($filterCounter>=$start && $filterCounter<=$end){
	$name = UserPersonName($User['logs_added_by']);
	echo "<div class='profiletimeline mt-0'>
	        <div class='sl-item'>
	            <div class='sl-left'> <img src='img/user.jpg' alt='user' class='rounded-circle'> </div>
	            <div class='sl-right'>
	                <div>
	                    <a href='javascript:void(0)' class='link'>$name</a> <span class='sl-date'><br>{$User['created_at']}</span>
	                    <p class='mt-10'> {$User['status']}: {$User['description']} </p>
	                </div>
	            </div>
	        </div>
	        <hr>
	    </div>";
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
