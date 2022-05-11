<?php include("includes/header.php"); ?>
<?php 
date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");
$errorMessage = "";
if(isset($_POST['btnLogin'])){
    $accountNumber = $_POST['txtEnterUserName'];
    $accountPassword = $_POST['txtEnterPassword'];
   
    if(!VerifyBarCode($accountNumber, $accountPassword)){
        $errorMessage = "<p class=\"alert alert-danger\"><b>Invalid Account!.</b></p>";
    }else{
      global $connection;
      $isValid = false; 
      $query = "SELECT * FROM tbl_Account
      INNER JOIN  tbl_Person ON tbl_Account.person_id=tbl_Person.person_id";
      $Users = mysqli_query($connection, $query);
      while ($User = mysqli_fetch_array($Users)) {
        if($User['person_code'] == $accountNumber
            && $User['mpin'] == $accountPassword
            && $User['account_status'] == "Activated"){
        
            $_SESSION['personId'] = $User['person_id'];
            $_SESSION['referenceNumber'] = $User['person_code'];
            $_SESSION['userTypeId'] = $User['user_type_id'];
  
       $ip = isset($_SERVER['HTTP_CLIENT_IP']) 
                ? $_SERVER['HTTP_CLIENT_IP'] 
                : (isset($_SERVER['HTTP_X_FORWARDED_FOR'])
                ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
        // LOGS
        // $category,$id(primary_key),$code,$status,$description,$added_by(person_id)
        Create_Logs("ACCOUNT LOGIN",$User['person_id'], $User['person_code'], "LOGIN","Date and Time of Login: $dateEncoded @ $timeEncoded<br>IP ADDRESS: $ip<br>Sign in through Barcode",$User['person_id']);
        // END OF LOGS
        
        if($User['user_type_id'] != 3)
          header('Location:homepage.php');
        else
          header('Location:new_vote.php');
                        
        }else if($User['person_code'] == $accountNumber
            && $User['mpin'] == $accountPassword
            && $User['account_status'] == "Blocked"){
          $errorMessage = "<p class=\"alert alert-danger\"><b>Your account has been blocked!.</b></p>";
        }else if($User['person_code'] == $accountNumber
            && $User['mpin'] == $accountPassword
            && $User['account_status'] == "Deactivated"){
          $errorMessage = "<p class=\"alert alert-warning\"><b>Your account has been Deactivated!.</b></p>";
        }else if($User['person_code'] == $accountNumber
            && $User['mpin'] == $accountPassword
            && $User['account_status'] == "Registration"){
          $errorMessage = "<p class=\"alert alert-warning\"><b>Please proceed to your respective office to activate your account !.</b></p>";
        }
      }
    }//end of ELSE
}// end of IF
?>

        <div class="auth-wrapper">
            <div class="container-fluid h-100">
                <div class="row flex-row h-100 bg-white">
                    <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">
                        <div class="lavalite-bg" style="background-image: url('img/auth/login-bg.jpg')">
                            <div class="lavalite-overlay"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                        <div class="authentication-form mx-auto">
                           <!--  <div class="logo-centered">
                                <a href="index.html"><img src="src/img/brand.svg" alt=""></a>
                            </div> -->
                            <h3>Scan your Barcode</h3>
                            <p>Happy to see you again!</p>
                            <?php 
                                if($errorMessage != "") echo $errorMessage; 
                              ?>
                            <form method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="BARCODE" name="txtEnterUserName" id="txtEnterUserName" value="<?php if(isset($_POST['txtEnterUserName'])) { echo $_POST['txtEnterUserName']; }?>" required>
                                    <i class="ik ik-user"></i>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="MPIN" name="txtEnterPassword" id="txtEnterPassword" value="<?php if(isset($_POST['txtEnterPassword'])) { echo $_POST['txtEnterPassword']; }?>" required>
                                    <i class="ik ik-lock"></i>
                                </div>
                                <div class="sign-btn text-center">
                                    <a href="sign_in.php" class="btn btn-theme"><i class="fa fa-arrow-left"></i> Back</a>

                                    <button class="btn btn-theme" id="btnLogin" name="btnLogin">Sign In</button>
                                </div>
                            </form>
                            <div class="register">
                                <p>Don't have an account? <a href="sign_up.php"><u>Create an account</u></a></p>
                            </div>                
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
<script type="text/javascript">
    $("#txtEnterUserName").focus();
</script>
 <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
        <script>window.jQuery || document.write('<script src="src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
        <script src="plugins/popper.js/dist/umd/popper.min.js"></script>
        <script src="plugins/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
        <script src="plugins/screenfull/dist/screenfull.js"></script>
        <script src="plugins/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <!-- <script src="plugins/jvectormap/jquery-jvectormap.min.js"></script> -->
        <!-- <script src="plugins/jvectormap/tests/assets/jquery-jvectormap-world-mill-en.js"></script> -->
        <script src="plugins/moment/moment.js"></script>
        <script src="plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="plugins/d3/dist/d3.min.js"></script>
        <script src="plugins/c3/c3.min.js"></script>
        <script src="js/tables.js"></script>
        <script src="js/widgets.js"></script>
        <script src="js/charts.js"></script>
        <script src="dist/js/theme.min.js"></script>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <!-- <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script> -->
    </body>
</html>