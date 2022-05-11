<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php include('../QR/libs/phpqrcode/qrlib.php');  ?>
<?php 
	$signedin_user_type_id = $_SESSION['userTypeId'];
	$signedin_person_id = $_SESSION['personId'];
?>

<?php 
$filterCounter = 0;
$query = "SELECT * FROM tbl_Person INNER JOIN tbl_Account
ON tbl_Person.person_id=tbl_Account.person_id 
WHERE tbl_Person.person_id = $signedin_person_id";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$statusColor = statusColor($User['account_status']);
	$program_description=Get_Person_Program_Description($User['person_id'], "Activated");

	$code=$User['person_code'];
	QRcode::png($code, "../temp/account_code/".''.$code.'.png', QR_ECLEVEL_L, 5);
	$qrCodeImage = '<img src="temp/account_code/'. @$code.'.png" style="width:200px; height:200px;">';


    echo "<div class='card'>
            <div class='card-body'>
              <div class='text-center'> 
                <h4 class='card-title mt-10'>{$User['last_name']} {$User['affiliation_name']}, {$User['first_name']} {$User['middle_name']}</h4>
                <p class='card-subtitle'>COLLEGE</p>
              </div>
            </div>
            <hr class='mb-0'> 
            <div class='card-body'> 
                <small class='text-muted d-block'>Email Address</small>
                <h6>{$User['email_address']}</h6> 
                <small class='text-muted d-block pt-10'>Phone</small>
                <h6>{$User['contact_number']} / {$User['telephone_number']}</h6> 
                <small class='text-muted d-block pt-10'>Address</small>
                <h6>{$User['house_no']} {$User['street']} Brgy. {$User['barangay']}, {$User['city']}, {$User['province']}, {$User['region']}</h6>
                <div class='map-box'>
                    <iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3866.3855912257795!2d121.10694451455045!3d14.2890147900015!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d8443bd38d5f%3A0x5b5112555ddaf9e9!2sAsia%20Technological%20School%20of%20Science%20and%20Arts!5e0!3m2!1sen!2sph!4v1647932185484!5m2!1sen!2sph' width='100%' height='300' style='border:0;' allowfullscreen=' loading='lazy'></iframe>
                </div> 
                <small class='text-muted d-block pt-30'>Social Profile</small>
                <br>
                <button class='btn btn-icon btn-facebook'><i class='fab fa-facebook-f'></i></button>
                <button class='btn btn-icon btn-twitter'><i class='fab fa-twitter'></i></button>
                <button class='btn btn-icon btn-instagram'><i class='fab fa-instagram'></i></button>
            </div>
        </div>";
}//end of while
?>
