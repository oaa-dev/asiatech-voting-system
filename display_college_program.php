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
                                <h5>College Program</h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                    </div>
                    </div>  
                </div>
                <!-- <div class="row clearfix"></div> -->

                <div class="row">
                  <div class="col-lg-12">
                    <label>Search by: Generated Code, Name, Status <span class="validation-area"></span></label>
                    <div class="input-group input-group-success">
                      <input type="text" class="form-control" name="keyword"
                      id="keyword"  size="22" placeholder="Generated Code, Name, Status"
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
  DisplayInformation();
}

function GeneratePagination(){
$(".divPagination").text("");
var data = $("#keyword").val();
var obj = {"filter":data};
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
xmlhttp.open("GET", "tbl_college_program/count_college_program.php?data="+parameter, true);
xmlhttp.send();
}

function Next(start, end){
  $("#itemFrom").text(start);
  $("#itemTo").text(end);
  DisplayInformation();
}

function DisplayInformation(){
  var start = $("#itemFrom").text();
  var end = $("#itemTo").text();
  var data = $("#keyword").val()
  var obj = {"filter":data,"start":start,"end":end};
  var parameter = JSON.stringify(obj);
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#divListOfAccounts").text("");
      $("#divListOfAccounts").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_college_program/read_college_program.php?data=" + parameter, true);
  xmlhttp.send();
}

function btnViewInformation(id){
  ToggleDIV("divViewProfile", "block");
  Displayinformation_ToModal(id);
}

function btnUpdateInformation(id){
  ToggleDIV("divUpdateProfile", "block");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);
      for(var index = 0; index < data.length; index++){
        if(data[index].college_program_id == id){
          $("#update_profile").val(id);
          $("#program_name").val(data[index].college_program_name);
          $("#program_description").val(data[index].college_program_description);
        break;
        }
      }
    }else{
    }
  };
  xmlhttp.open("GET", "tbl_college_program/json_college_program.php", true);
  xmlhttp.send();
}

function Empty(){
  $("#program_name").val("");
  $("#program_description").val("");

  $(".error_program_name").text("*");
  $(".error_program_description").text("*");
}

function Update_College_Program(){
  if($("#program_name").val() == "" || $("#program_description").val() == ""){
      $(".error_program_name").text("* Field is required");
      $(".error_program_description").text("* Field is required");
  }else{
      $(".error_program_name").text("*");
      $(".error_program_description").text("*");

    var obj={"college_program_id":$("#update_profile").val(),
        "college_program_name":$("#program_name").val(), 
      "college_program_description":$("#program_description").val()};
      ToggleDIV("divUpdateProfile", "none");
      var parameter = JSON.stringify(obj); 
      $.ajax({url:'tbl_college_program/update_college_program_information.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          showToast("Success", "College program successfully updated !.", "success", "#f96868");
          Empty();
          DisplayInformation();
        }
        else{
          showToast("Warning", "Updating of college program was failed, Please try again !.", "warning", "#57c7d4");
          Empty();
          DisplayInformation();
        }
      },
      error:function(){
        showToast("Danger", "Registration went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        Empty();
        DisplayInformation();
      }
    });//end of ajax  
  }//END OF IF Form_Validation()
}//END OF Submit_Registration


function btnChangeStatus(id){
  ToggleDIV("divUpdateStatus", "block");
  Displayinformation_ToModal(id);

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var data = JSON.parse(this.responseText);
    for(var index = 0; index < data.length; index++){
      if(data[index].college_program_id == id){
        status(data[index].college_program_status, id);
        break;
      }
    }
  }else{
  }
  };
  xmlhttp.open("GET", "tbl_college_program/json_college_program.php", true);
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
  var  obj = {"college_program_id":id,"college_program_status":status};
  var parameter = JSON.stringify(obj);
  ToggleDIV("divUpdateStatus", "none");
  $.ajax({url:'tbl_college_program/update_college_program_status.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
            showToast("Success", "College program status successfully updated !.", "success", "#f96868");
            DisplayInformation();
        }
        else{
            showToast("Warning", "Updating college program status was failed, Please try again !."+data, "warning", "#57c7d4");
          DisplayInformation();
        }
      },
      error:function(){
        showToast("Danger", "Updating college program status went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        DisplayInformation();
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

function Displayinformation_ToModal(id){
if(id!=0){
  $(".information").text("");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    $(".information").text("");
      var data = JSON.parse(this.responseText);
      for(var index = 0; index < data.length; index++){
        if(data[index].college_program_id == id){

$(".information").append("<div class='row'><div class='col-lg-12' style='text-align:center;'>"+data[index].college_program_code_image+"</div></div>");
$(".information").append("<div class='row'><div class='col-lg-12' style='text-align:center;'><b>"+data[index].college_program_code+"</b></div></div>");

$(".information").append("<div class='row'><div class='col-lg-12'><b>Program Name:</b> "+ data[index].college_program_name+"</div></div>");

$(".information").append("<div class='row'><div class='col-lg-12'><b>Program Description:</b> "+data[index].college_program_description+"</div></div>");

$(".information").append("<div class='row'><div class='col-lg-12'><br><b>Date & Time Encoded:</b> "+data[index].college_program_created_at+"</div></div>");
$(".information").append("<div class='row'><div class='col-lg-12'><b>Status:</b> "+data[index].college_program_status+"</div></div>");
break;
        }
      }
    }else{
    $(".information").text("Loading...");
    }
  };
  xmlhttp.open("GET", "tbl_college_program/json_college_program.php", true);
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
                <h5 class="modal-title" id="demoModalLabel">College Program Details</h5>
                <button type="button" class="close" onclick="ToggleDIV('divViewProfile','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <span class="information" style="font-size: 14px;"></span>
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
                <h5 class="modal-title" id="demoModalLabel">Update College Program Details</h5>
                <button type="button" class="close" onclick="ToggleDIV('divUpdateProfile','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <label for="program_name">Program Name: <span class="required validation-area error_program_name">*</span></label>
                  <input type="text" id="program_name" class="form-control" name="program_name" required />
                </div>
              </div>

              <div class="row">
                <div class="col-lg-12">
                  <label for="program_description">Program Description: <span class="required validation-area error_program_description">*</span></label>
                  <input type="text" id="program_description" class="form-control" name="program_description" required />
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divUpdateProfile','none')">Close</button>
                <button class="btn btn-info" id="update_profile" onclick="Update_College_Program()"><i class="ik ik-save"></i> Update Details</button>
            </div>
        </div>
    </div>
</div>

<div id="divUpdateStatus" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:750px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel"> Change College Program Status</h5>
                <button type="button" class="close" onclick="ToggleDIV('divUpdateStatus','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                      <p class="information"></p>
                    </div>
                    <div class="col-lg-12">
                      <h4>Status</h4>
                      <div class="block clear" id="divButtonStatus"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divUpdateStatus','none')">Close</button>
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
                    <div class="col-8">
                      <h4>Profile</h4>
                      <p class="information"></p>
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