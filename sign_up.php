<?php include("includes/header.php"); ?>

<div class="wrapper">
    <div class="page-wrap">
        <div class="main-content" style="background-color: white;">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-users bg-green"></i>
                            <div class="d-inline">
                                <h2>Online Registration</h2>
                                <!-- <span>The authorized user can add new account.</span> -->
                            </div>
                        </div>
                    </div>
                    </div>  
                </div>

                <div class="row">
                  <div class="col-lg-7">
                        <label for="select_college_program">Select College Program: <span class="required validation-area error_select_college_program">*</span></label>
                        <div class="input-group input-group-success">
                            <select id='select_college_program' class="form-control selectField"></select>
                        </div>
                    </div>
                </div>
                <?php include("includes/account_form.php"); ?>
                <div class="row">
                    <div class="col-lg-12"><br>
                         <button class="btn alert-success btn-medium" onclick="Check_Email_Exist()"><i class="ik ik-save"></i> Submit Registration</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="register"><br>
                            <p>Already have an account? <a href="sign_in.php">Sig In Here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
ComboBox_College_Program();
function ComboBox_College_Program(){
  var obj={"status":"Activated"};
  var parameter = JSON.stringify(obj); 
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#select_college_program").text("");
      $("#select_college_program").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_college_program/get_college_program_combo_box.php?data="+parameter, true);
  xmlhttp.send();
}

function Empty(){
  $("#first_name").val("");
  $("#middle_name").val("");
  $("#last_name").val("");
  $("#affiliation_name").val("");
  $("#date_of_birth").val("");
  $("#select_sex").val("");
  $("#select_civil_status").val("");
  $("#select_region").val("");
  $("#select_province").val("");
  $("#select_city").val("");
  $("#select_barangay").val("");
  $("#house_number").val("");
  $("#street_number").val("");
  $("#email_user_name").val("");
  $("#contact_number").val("");
  $("#telephone_number").val("");

  $(".error_first_name").text("*");
  $(".error_last_name").text("*");
  $(".error_date_of_birth").text("*");
  $(".error_select_sex").text("*");
  $(".error_select_civil_status").text("*");
  $(".error_select_region").text("*");
  $(".error_select_province").text("*");
  $(".error_select_city").text("*");
  $(".error_select_barangay").text("*");
  $(".error_house_number").text("*");
  $(".error_street_number").text("*");
  $(".error_email_user_name").text("*");
  $(".error_contact_number").text("*");
}

function Submit_Registration(){
if($("#select_college_program").val() == ""){
  $(".error_select_college_program").text("* Field is required");
}else{
  $(".error_select_college_program").text("*");

  if($("#first_name").val() == "" || $("#last_name").val() == "" || 
    $("#date_of_birth").val() == "" || $("#select_sex").val() == "" ||
    $("#select_civil_status").val() == "" || $("#select_region").val() == "" ||
    $("#select_province").val() == "" || $("#select_city").val() == "" ||
    $("#select_barangay").val() == "" || $("#house_number").val() == "" ||
    $("#street_number").val() == "" || $("#email_user_name").val() == "" ||
    $("#contact_number").val() == ""){
      $(".error_first_name").text("* Field is required");
      $(".error_last_name").text("* Field is required");
      $(".error_date_of_birth").text("* Field is required");
      $(".error_select_sex").text("* Field is required");
      $(".error_select_civil_status").text("* Field is required");
      $(".error_select_region").text("* Field is required");
      $(".error_select_province").text("* Field is required");
      $(".error_select_city").text("* Field is required");
      $(".error_select_barangay").text("* Field is required");
      $(".error_house_number").text("* Field is required");
      $(".error_street_number").text("* Field is required");
      $(".error_email_user_name").text("* Field is required");
      $(".error_contact_number").text("* Field is required");
  }else{
    var userTypeId = 3;
    var obj={"first_name":$("#first_name").val(), 
      "middle_name":$("#middle_name").val(), 
      "last_name":$("#last_name").val(), 
      "affiliation_name":$("#affiliation_name").val(),
      "date_of_birth":$("#date_of_birth").val(),
      "sex":$("#select_sex").val(), 
      "civil_status":$("#select_civil_status").val(), 
      "region_option":$("#select_region").val(), 
      "province_option":$("#select_province").val(), 
      "city_option":$("#select_city").val(), 
      "barangay_option":$("#select_barangay").val(), 
      "house_number":$("#house_number").val(), 
      "street":$("#street_number").val(), 
      "email_address":$("#email_user_name").val(), 
      "contact_number":$("#contact_number").val(), 
      "telephone_number":$("#telephone_number").val(), 
      "user_type_id":userTypeId, 
      "status":"Saved",
      "access_status":"Registration",
      "password":"admin123",
      "personAddedBy":1,
      "college_program_id":$("#select_college_program").val()};
      var parameter = JSON.stringify(obj); 
      $.ajax({url:'tbl_accounts/register_account.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          showToast("Success", "Registration successfully saved !.", "success", "#f96868");
          Empty();
        }
        else{
          showToast("Warning", "Registration failed, Please try again !."+data, "warning", "#57c7d4");
          // Empty();
        }
      },
      error:function(){
        showToast("Danger", "Registration went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        // Empty();
      }
    });//end of ajax  
  }//END OF IF Form_Validation()
}
}//END OF Submit_Registration

function Check_Email_Exist(){
  var isExist = 0;
  var obj = {"email":$("#email_user_name").val(),"status":"adding", "id":"0"};
  var parameter = JSON.stringify(obj);
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      isExist = this.responseText;
        if(isExist == 1){
          $(".error_email_user_name").text("* Email is already exist");
        }else{
          $(".error_email_user_name").text("*");
          Submit_Registration();
        }
    }
  };
  xmlhttp.open("GET", "tbl_accounts/check_email_exist.php?data=" + parameter, true);
  xmlhttp.send();
}


(function($) {
  showToast = function(heading, text, icon, loaderBg) {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: heading,
      text: text,
      showHideTransition: 'slide',
      icon: icon,
      loaderBg: loaderBg,
      position: 'top-right'
    })
  };

  resetToastPosition = function() {
    $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center'); // to remove previous position class
    $(".jq-toast-wrap").css({
      "top": "",
      "left": "",
      "bottom": "",
      "right": ""
    }); //to remove previous position style
  }
})(jQuery);
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
        <script src="plugins/jvectormap/jquery-jvectormap.min.js"></script>
        <script src="plugins/jvectormap/tests/assets/jquery-jvectormap-world-mill-en.js"></script>
        <script src="plugins/moment/moment.js"></script>
        <script src="plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="plugins/d3/dist/d3.min.js"></script>
        <script src="plugins/c3/c3.min.js"></script>
        <script src="js/tables.js"></script>
        <script src="js/widgets.js"></script>
        <script src="js/charts.js"></script>
        <script src="dist/js/theme.min.js"></script>
        <script src="plugins/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
        <script src="plugins/mohithg-switchery/dist/switchery.min.js"></script>
        <script src="plugins/select2/dist/js/select2.min.js"></script>
        <script src="plugins/summernote/dist/summernote-bs4.min.js"></script>
        <script src="plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <script src="plugins/owl.carousel/dist/owl.carousel.min.js"></script>
        <script src="plugins/chartist/dist/chartist.min.js"></script>
        <script src="js/widget-statistic.js"></script>
        
        
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
</html>