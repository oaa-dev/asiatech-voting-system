<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$userType = $obj->userType;

$description = 0;
$query = "SELECT * FROM tbl_User_Type";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($User['user_type_id']==$userType){
		$description = $User['type_description'];
		break;
	}
}

?>                
<?php 
$activated = 0;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_Account
ON tbl_Person.person_id=tbl_Account.person_id";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($User['user_type_id']==$userType && 
	$User['account_status'] == "Activated")
		$activated++;
}

$deactivated = 0;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_Account
ON tbl_Person.person_id=tbl_Account.person_id";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($User['user_type_id']==$userType && 
	$User['account_status'] == "Deactivated")
		$deactivated++;
}

$total = $activated + $deactivated;
?>
<div class="col-12">
    <div class="card proj-t-card">
        <div class="card-body">
            <div class="row align-items-center mb-30">
                <div class="col-auto">
                    <i class="fas fa-users text-green f-30"></i>
                </div>
                <div class="col pl-0">
                    <h6 class="mb-5">
                    	Registered <?php echo $description; ?>
                    </h6>
                </div>
            </div>
            <div class="row align-items-center text-center">
                <div class="col">
                	<h6 class="mb-0"><b><?php echo $activated; ?></b> 
                		<br>Activated</h6>
                </div>
				<div class="col">
					<i class="fas fa-exchange-alt text-green f-18"></i>
				</div>
    			<div class="col">
    				<h6 class="mb-0"><b><?php echo $deactivated; ?></b></b> 
    				<br>Deactivated</h6>
    			</div>
    		</div>
    		<h6 class="pt-badge bg-green"><?php echo $total; ?></h6>
		</div>
	</div>
</div>