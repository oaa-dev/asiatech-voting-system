<?php include("includes/header.php"); ?>
<div class="wrapper">
    <?php include("includes/top.php"); ?>
    <div class="page-wrap">
        <div class="app-sidebar colored">
            <?php include("includes/sidebar.php"); ?>
        </div>
        <div class="main-content">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-users bg-green"></i>
                            <div class="d-inline">
                                <h5>New Account</h5>
                                <span>The authorized user can add new account.</span>
                            </div>
                        </div>
                    </div>
                    </div>  
                </div>
                <div class="row clearfix"></div>
                <div class="row">
                    <div class="col-lg-5">
                      <label for="select_position">Position: <span class="required validation-area error_select_position">*</span></label>
                      <div class="input-group input-group-success">
                        <select class="selectField form-control" id="select_position" name="select_position">
                            <option value="1">Administrator</option>
                            <option value="2">Staff</option>
                            <option value="3">Student</option>
                        </select>
                      </div>
                    </div>   
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

  $(".error_select_position").text("*");
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

  if($("#select_position").val() == "" || 
    $("#first_name").val() == "" || $("#last_name").val() == "" || 
    $("#date_of_birth").val() == "" || $("#select_sex").val() == "" ||
    $("#select_civil_status").val() == "" || $("#select_region").val() == "" ||
    $("#select_province").val() == "" || $("#select_city").val() == "" ||
    $("#select_barangay").val() == "" || $("#house_number").val() == "" ||
    $("#street_number").val() == "" || $("#email_user_name").val() == "" ||
    $("#contact_number").val() == ""){
      $(".error_select_position").text("* Field is required");
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
    var userTypeId = $("#select_position").val();
    var personAddedBy = "<?php echo $_SESSION['personId']; ?>";
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
      "access_status":"Deactivated",
      "password":"admin123",
      "personAddedBy":personAddedBy,
      "college_program_id":$("#select_college_program").val()};
      
      var parameter = JSON.stringify(obj); 
      $.ajax({url:'tbl_accounts/create_account.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          showToast("Success", "Registration successfully saved !.", "success", "#f96868");
          Empty();
        }
        else{
          showToast("Warning", "Registration failed, Please try again !.", "warning", "#57c7d4");
          Empty();
        }
      },
      error:function(){
        showToast("Danger", "Registration went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        Empty();
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

<!-- FIXED -->
      <?php include("includes/main_footer.php"); ?>  
    </div>
</div>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>
<!-- FIXED -->