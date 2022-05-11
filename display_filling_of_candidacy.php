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
                                <h5>Student Filling of Candidacy</h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                    </div>
                    </div>  
                </div>
                <!-- <div class="row clearfix"></div> -->

                <div class="row">
                  <div class="col-lg-12">
                    <label>Search by: Candidate Position, Student Name, Status <span class="validation-area"></span></label>
                    <div class="input-group input-group-success">
                      <input type="text" class="form-control" name="keyword"
                      id="keyword"  size="22" placeholder="Candidate Position, Student Name, Status"
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
xmlhttp.open("GET", "tbl_filling_of_candidacy/count_filling_of_candidacy.php?data="+parameter, true);
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
  xmlhttp.open("GET", "tbl_filling_of_candidacy/read_filling_of_candidacy.php?data=" + parameter, true);
  xmlhttp.send();
}

function btnViewInformation(id){
  ToggleDIV("divViewProfile", "block");
  Displayinformation_ToModal(id);
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
  xmlhttp.open("GET", "tbl_filling_of_candidacy/json_college_program.php", true);
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

    <?php include("includes/main_footer.php"); ?>  
    </div>
</div>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>
<!-- FIXED -->