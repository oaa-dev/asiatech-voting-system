<?php include("includes/header.php"); ?>
<?php 
  $desc = "";
  $id = "";
  if(isset($_SESSION['personId'])){
    if($_SESSION['userTypeId'] == 1){
        $id = 2;  
        if($id==1) $desc = "Administrator";
        if($id==2) $desc = "Staff";
        if($id==3) $desc = "Student";
    }
  }
?>

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
                                <h5>Display <?php echo $desc; ?></h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                    </div>
                    </div>  
                </div>
                <!-- <div class="row clearfix"></div> -->

                <div class="row">
                  <div class="col-lg-12">
                    <label>Search by: Generated Code, Name, Account Status <span class="validation-area"></span></label>
                    <div class="input-group input-group-success">
                      <input type="text" class="form-control" name="keyword"
                      id="keyword"  size="22" placeholder="Generated Code, Name, Account Status"
                      onkeyup="Pagination()">
                      <span class="input-group-append">
                        <label class="input-group-text" onclick="Pagination()"><i class="ik ik-search"></i></label>
                      </span>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <span id="itemFrom" style="display: none;"></span>
                    <span id="itemTo" style="display: none;"></span>

                    <div id="divListOfAccounts"></div>
                    <div class="divPagination w3-center"></div>
                  </div>
                </div>
            </div>
        </div>

<script type="text/javascript">
Pagination();
function Pagination(){
  GeneratePagination();
  DisplayPersonInformation();
}

function GeneratePagination(){
$(".divPagination").text("");
var data = $("#keyword").val();
var userTypeId = 2;
var obj = {"filter":data,"userType":userTypeId};
var parameter = JSON.stringify(obj);
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
  var transactionCount = JSON.parse(this.responseText);
  
  $(".divPagination").text("");
  var totalItems=transactionCount;
  
  var perItem=10; 
  var paginator = totalItems/perItem;
  var textCounter=0;
  var start=1;
  var end=perItem;
  Next(start, end);
  for(var index=0; index<paginator; index++){
    textCounter++;
    $(".divPagination").append("<button class='btn alert-success btnPagination' onclick=\"Next("+start+","+end+")\">"+(index+1)+"</button> ");
    start+=perItem;
    end+=perItem;
  }
}//end of if
};
xmlhttp.open("GET", "tbl_accounts/count_account.php?data="+parameter, true);
xmlhttp.send();
}

function Next(start, end){
  $("#itemFrom").text(start);
  $("#itemTo").text(end);
  DisplayPersonInformation();
}

function DisplayPersonInformation(){
  var start = $("#itemFrom").text();
  var end = $("#itemTo").text();
  var data = $("#keyword").val()
  var userTypeId = 2;
  var obj = {"filter":data, "userType":userTypeId,"start":start,"end":end};
  var parameter = JSON.stringify(obj);
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#divListOfAccounts").text("");
      $("#divListOfAccounts").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_accounts/read_account.php?data=" + parameter, true);
  xmlhttp.send();
}

function btnViewPersonInformation(id){
  ToggleDIV("divViewProfile", "block");
  DisplayPersonInformation_ToModal(id);
}

function btnUpdatePersonInformation(id){
  ToggleDIV("divUpdateProfile", "block");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);
      for(var index = 0; index < data.length; index++){
        if(data[index].person_id == id){
          $("#update_profile").val(id);
          $("#first_name").val(data[index].first_name);
          $("#middle_name").val(data[index].middle_name);
          $("#last_name").val(data[index].last_name);
          $("#affiliation_name").val(data[index].affiliation_name);
          $("#date_of_birth").val(data[index].date_of_birth);
          $("#select_sex").val(data[index].sex);
          $("#select_civil_status").val(data[index].civil_status);
          $("#house_number").val(data[index].house_no);
          $("#street_number").val(data[index].street);
          $("#select_barangay").val(data[index].barangay);
          $("#select_city").val(data[index].city);
          $("#select_province").val(data[index].province);
          $("#select_region").val(data[index].region);
          $("#email_user_name").val(data[index].email_address);
          $("#contact_number").val(data[index].contact_number);
          $("#telephone_number").val(data[index].telephone_number);
      break;
        }
      }
    }else{
    }
  };
  xmlhttp.open("GET", "tbl_accounts/json_account.php", true);
  xmlhttp.send();
}

function Empty(){
  $("#first_name").val("");
  $("#last_name").val("");
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
    var obj={"person_id":$("#update_profile").val(),
        "first_name":$("#first_name").val(), 
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
      "telephone_number":$("#telephone_number").val()};
      ToggleDIV("divUpdateProfile", "none");
      var parameter = JSON.stringify(obj); 
      $.ajax({url:'tbl_accounts/update_account_information.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          showToast("Success", "Account successfully updated !.", "success", "#f96868");
          Empty();
          DisplayPersonInformation();
        }
        else{
          showToast("Warning", "Updating of account was failed, Please try again !.", "warning", "#57c7d4");
          Empty();
          DisplayPersonInformation();
        }
      },
      error:function(){
        showToast("Danger", "Registration went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        Empty();
        DisplayPersonInformation();
      }
    });//end of ajax  
  }//END OF IF Form_Validation()
}//END OF Submit_Registration

function Check_Email_Exist(){
  var isExist = 0;
  var obj = {"email":$("#email_user_name").val(),"status":"editing", "id":$("#update_profile").val()};
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

function btnChangeAccessStatus(id){
  ToggleDIV("divUpdateAccountAccess", "block");
  DisplayPersonInformation_ToModal(id);

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var data = JSON.parse(this.responseText);
    for(var index = 0; index < data.length; index++){
      if(data[index].person_id == id){
        status(data[index].accountStatus, id);
        break;
      }
    }
  }else{
  }
  };
  xmlhttp.open("GET", "tbl_accounts/json_account.php", true);
  xmlhttp.send();
}

function status(status, id){
  $("#divButtonStatus").text("");
  var changeStatus_PastTense = ["Activated", "Deactivated"];
  var changeStatus_PresentTense = ["Activate", "Deactivate"];
  var statusColor = ["btn btn-medium alert-success", "btn btn-medium alert-danger"];
  var statusIcon = ["ik ik-save", "ik ik-x"];

  for(var index = 0; index < changeStatus_PresentTense.length; index++){
    var w3disabled = disabled = "";
    if(status == changeStatus_PastTense[index]){
      w3disabled = "w3-disabled";
      disabled = "disabled";
    }
    $("#divButtonStatus").append("<button class='"+ w3disabled +" "+statusColor[index] + " btnIndex " + "' "+disabled+" onclick='UpdateAccessStatus("+id+",\""+changeStatus_PastTense[index]+"\")'>" +"<i class='"+statusIcon[index]+"'></i> " + changeStatus_PresentTense[index] +"</button>");
  }
}

function UpdateAccessStatus(id, status){
  var  obj = {"personId":id,"status":status};
  var parameter = JSON.stringify(obj);
  ToggleDIV("divUpdateAccountAccess", "none");
  $.ajax({url:'tbl_accounts/update_account_status.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
            showToast("Success", "Account status successfully updated !.", "success", "#f96868");
            DisplayPersonInformation();
        }
        else{
            showToast("Warning", "Updating account status was failed, Please try again !.", "warning", "#57c7d4");
          DisplayPersonInformation();
        }
      },
      error:function(){
        showToast("Danger", "Updating account status went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        DisplayPersonInformation();
      }
    });//end of ajax 
}

function btnResetPassword(id){
  ToggleDIV("divResetPassword", "block");
  $("#btnResetPassword").val(id);
  DisplayPersonInformation_ToModal(id);
}

function ResetPassword(){
  var personId=$("#btnResetPassword").val();
  var  obj = {"personId":personId};
  var parameter = JSON.stringify(obj);
  ToggleDIV("divResetPassword", "none");
  $.ajax({url:'tbl_accounts/reset_account_password.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        showToast("Success", "Account password successfully reset !.", "success", "#f96868");
        DisplayPersonInformation();
      }
      else{
        showToast("Warning", "Resetting account password was failed, Please try again !.", "warning", "#57c7d4");
        DisplayPersonInformation();
      }
    },
    error:function(){
        showToast("Danger", "Resetting account password went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
      DisplayPersonInformation();
    }
  });//end of ajax
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

function DisplayPersonInformation_ToModal(id){
if(id!=0){
  $(".personInformation").text("");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    $(".personInformation").text("");
      var data = JSON.parse(this.responseText);
      for(var index = 0; index < data.length; index++){
        if(data[index].person_id == id){

$(".personInformation").append("<div class='row'><div class='col-lg-12' style='text-align:center;'>"+data[index].person_code_image+"</div></div>");
$(".personInformation").append("<div class='row'><div class='col-lg-12' style='text-align:center;'><b>"+data[index].person_code+"</b></div></div>");

$(".personInformation").append("<div class='row'><div class='col-lg-12'><b>Name:</b> "+data[index].last_name + ", " + data[index].first_name + " " + data[index].middle_name + " " + data[index].affiliation_name+"</div></div>");

$(".personInformation").append("<div class='row'><div class='col-lg-12'><b>Date of Birth:</b> "+data[index].date_of_birth+"</div><div class='col-lg-12'><b>Sex:</b> "+data[index].sex+"</div><div class='col-lg-12'><b>Civil Status:</b> "+data[index].civil_status+"</div></div>");

$(".personInformation").append("<div class='row'><div class='col-lg-12'><b>Address:</b> "+data[index].house_no+" "+data[index].street+","+data[index].barangay+", "+data[index].city+", "+data[index].province+", "+data[index].region);

$(".personInformation").append("<div class='row'><br><div class='col-lg-12'><b>Email / Username:</b> "+data[index].email_address+"</div><div class='col-lg-12'><b>Contact Number:</b> "+data[index].contact_number+"</div><div class='col-lg-12'><b>Telephone Number:</b> "+data[index].telephone_number+"</div></div>");

$(".personInformation").append("<div class='row'><div class='col-lg-12'><br><b>Date & Time Encoded:</b> "+data[index].person_created_at+"</div></div>");
$(".personInformation").append("<div class='row'><div class='col-lg-12'><b>Account Status:</b> "+data[index].accountStatus+"</div></div>");
break;
        }
      }
    }else{
    $(".personInformation").text("Loading...");
    }
  };
  xmlhttp.open("GET", "tbl_accounts/json_account.php", true);
  xmlhttp.send();
}
}

function ToggleDIV(id,status){
    document.getElementById(id).style.display=status;
}

</script>

<div id="divViewProfile" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Account Profile</h5>
                <button type="button" class="close" onclick="ToggleDIV('divViewProfile','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <span class="personInformation" style="font-size: 14px;"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divViewProfile','none')">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="divUpdateProfile" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:750px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Update Account Profile</h5>
                <button type="button" class="close" onclick="ToggleDIV('divUpdateProfile','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <?php include("includes/account_form.php"); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divUpdateProfile','none')">Close</button>
                <button class="btn btn-info" id="update_profile" onclick="Check_Email_Exist()"><i class="ik ik-save"></i> Update Profile</button>
            </div>
        </div>
    </div>
</div>

<div id="divUpdateAccountAccess" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:750px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel"> Change Access Status</h5>
                <button type="button" class="close" onclick="ToggleDIV('divUpdateAccountAccess','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                      <h4>Profile</h4>
                      <p class="personInformation"></p>
                    </div>
                    <div class="col-lg-12">
                      <h4>Status</h4>
                      <div class="block clear" id="divButtonStatus"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divUpdateAccountAccess','none')">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="divResetPassword" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:750px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel"> Reset Password</h5>
                <button type="button" class="close" onclick="ToggleDIV('divResetPassword','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                      <p style="font-size: 20px;">Are you sure you want to reset the password?</p>
                      <button class="btn btn-medium alert-success" type="submit" name="submit"
                      id="btnResetPassword" 
                      onclick="ResetPassword()" 
                      style="width: 100%;"><i class="fa fa-check"> Yes</i></button>
                    </div>
                    <div class="col-lg-8">
                      <h4>Profile</h4>
                      <p class="personInformation"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divResetPassword','none')">Close</button>
            </div>
        </div>
    </div>
</div>

    <?php include("includes/main_footer.php"); ?>  
    </div>
</div>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>
<!-- FIXED -->