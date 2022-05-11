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
                                <h5>Party List Management</h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                    </div>

                    </div>  
                </div>

                <div class="row">
                  <div class="col-lg-10">
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
                  <div class="col-lg-2"><br>
                        <button class="btn alert-info" id="btn_add_evaluation_information" onclick="Add_Data()"><i class="ik ik-plus"></i> New Data</button>
                    </div>
                </div>
                <div class="row">
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

function Add_Data(){
    Empty();
    ToggleDIV("div_party_list_management", "block");
    document.getElementById("saveData").style.display="block";
    document.getElementById("updateData").style.display="none";
}

function Empty(){
    $("#party_list_name").val("");
    $("#party_list_description").val("");

    $(".error_party_list_name").text("*");
    $(".error_party_list_description").text("*");
}

function Save_Records(){
if($("#party_list_name").val() == "" || $("#party_list_description").val() == ""){
  $(".error_party_list_name").text("* Field is required");
  $(".error_party_list_description").text("* Field is required");
}else{
  $(".error_party_list_name").text("*");
  $(".error_party_list_description").text("*");

  var obj={"college_program_id":$("#select_college_program").val(),
      "party_list_name":$("#party_list_name").val(), 
      "party_list_description":$("#party_list_description").val()};
      var parameter = JSON.stringify(obj); 
      ToggleDIV("div_party_list_management", "none");
      $.ajax({url:'tbl_party_list/create_party_list.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          showToast("Success", "Party list successfully saved !.", "success", "#f96868");
          Empty();
          DisplayInformation();
        }
        else{
          showToast("Warning", "Saving of party list was failed, Please try again !."+data, "warning", "#57c7d4");
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
}
}

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
xmlhttp.open("GET", "tbl_party_list/count_party_list.php?data="+parameter, true);
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
  xmlhttp.open("GET", "tbl_party_list/read_party_list.php?data=" + parameter, true);
  xmlhttp.send();
}

function btnViewInformation(id){
  ToggleDIV("divViewProfile", "block");
  Displayinformation_ToModal(id);
}

function btnUpdateInformation(id){
Empty();
$("#btnUpdateRecord").val(id);
ToggleDIV("div_party_list_management", "block");
document.getElementById("saveData").style.display="none";
document.getElementById("updateData").style.display="block";

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);
      for(var index = 0; index < data.length; index++){
        if(data[index].party_list_id == id){
          $("#party_list_name").val(data[index].party_list_name);
          $("#party_list_description").val(data[index].party_list_description);
        break;
        }
      }
    }else{
    }
  };
  xmlhttp.open("GET", "tbl_party_list/json_party_list.php", true);
  xmlhttp.send();
}

function Update_Records(){
 if($("#party_list_name").val() == "" || $("#party_list_description").val() == ""){
  $(".error_party_list_name").text("* Field is required");
  $(".error_party_list_description").text("* Field is required");
}else{
  $(".error_party_list_name").text("*");
  $(".error_party_list_description").text("*");

    var obj={"party_list_id":$("#btnUpdateRecord").val(),
      "college_program_id":$("#select_college_program").val(),
      "party_list_name":$("#party_list_name").val(), 
      "party_list_description":$("#party_list_description").val()};
      ToggleDIV("div_party_list_management", "none");
      var parameter = JSON.stringify(obj); 
      $.ajax({url:'tbl_party_list/update_party_list_information.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          showToast("Success", "Party list successfully updated !.", "success", "#f96868");
          Empty();
          DisplayInformation();
        }
        else{
          showToast("Warning", "Updating of party list was failed, Please try again !.", "warning", "#57c7d4");
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
      if(data[index].party_list_id == id){
        status(data[index].party_list_status, id);
        break;
      }
    }
  }else{
  }
  };
  xmlhttp.open("GET", "tbl_party_list/json_party_list.php", true);
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
  var  obj = {"party_list_id":id,"party_list_status":status};
  var parameter = JSON.stringify(obj);
  ToggleDIV("divUpdateStatus", "none");
  $.ajax({url:'tbl_party_list/update_party_list_status.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
            showToast("Success", "Party list status successfully updated !.", "success", "#f96868");
            DisplayInformation();
        }
        else{
            showToast("Warning", "Updating party list status was failed, Please try again !."+data, "warning", "#57c7d4");
          DisplayInformation();
        }
      },
      error:function(){
        showToast("Danger", "Updating college program status went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        DisplayInformation();
      }
    });//end of ajax 
}

function Displayinformation_ToModal(id){
if(id!=0){
  $(".information").text("");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    $(".information").text("");
      var data = JSON.parse(this.responseText);
      for(var index = 0; index < data.length; index++){
        if(data[index].party_list_id == id){

$(".information").append("<div class='row'><div class='col-12' style='text-align:center;'>"+data[index].party_list_code_image+"</div></div>");
$(".information").append("<div class='row'><div class='col-12' style='text-align:center;'><b>"+data[index].party_list_code+"</b></div></div>");

$(".information").append("<div class='row'><div class='col-12'><b>Party List Name:</b> "+ data[index].party_list_name+"</div></div>");

$(".information").append("<div class='row'><div class='col-12'><b>Party List Description:</b> "+data[index].party_list_description+"</div></div>");

$(".information").append("<div class='row'><div class='col-12'><br><b>Date & Time Encoded:</b> "+data[index].party_list_created_at+"</div></div>");
$(".information").append("<div class='row'><div class='col-12'><b>Status:</b> "+data[index].party_list_status+"</div></div>");
break;
        }
      }
    }else{
    $(".information").text("Loading...");
    }
  };
  xmlhttp.open("GET", "tbl_party_list/json_party_list.php", true);
  xmlhttp.send();
}
}

function ToggleDIV(id,status){
    document.getElementById(id).style.display=status;
}
</script>

<script type="text/javascript">
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

<div id="divViewProfile" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Party List Details</h5>
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

<div id="divUpdateStatus" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:750px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel"> Change Party List Status</h5>
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

<div id="div_party_list_management" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:750px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Party List Management</h5>
                <button type="button" class="close" onclick="ToggleDIV('div_party_list_management','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="select_college_program">Select College Program: <span class="required validation-area error_select_college_program">*</span></label>
                        <div class="input-group input-group-success">
                            <select id='select_college_program' class="form-control selectField"></select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label for="party_list_name">Party List Name: <span class="required validation-area error_party_list_name">*</span></label>
                        <input type="text" id="party_list_name" class="form-control" name="party_list_name" required />
                    </div>
                    <div class="col-lg-12">
                        <label for="party_list_description">Party List Description: <span class="required validation-area error_party_list_description">*</span></label>
                        <input type="text" id="party_list_description" class="form-control" description="party_list_description" required />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('div_party_list_management','none')">Close</button>
                <div id="saveData">
                    <button class="btn alert-info" id="btnSave" onclick="Save_Records()"><i class="ik ik-save"></i> Save</button>
                </div>
                <div id="updateData" style="display: none;">
                    <button class="btn alert-warning" id="btnUpdateRecord" onclick="Update_Records()"><i class="ik ik-save"></i> Update</button>
                </div>
            </div>
        </div>
    </div>
</div>


        <?php include("includes/main_footer.php"); ?>  
    </div>
</div>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>