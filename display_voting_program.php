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
                                <h5>Display Voting Program</h5>
                                <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                            </div>
                        </div>
                    </div>

                    </div>  
                </div>

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
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <span id="itemFrom" style="display: none;"></span>
                        <span id="itemTo" style="display: none;"></span>

                        <div id="divListOfData"></div>
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
  
  var perItem=5; 
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
xmlhttp.open("GET", "tbl_Voting_Program/count_voting_program.php?data="+parameter, true);
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
      $("#divListOfData").text("");
      $("#divListOfData").append(this.responseText);
    }else{
   
    }
  };
  xmlhttp.open("GET", "tbl_Voting_Program/read_voting_program.php?data=" + parameter, true);
  xmlhttp.send();
}

function btnViewInformation(id){
  ToggleDIV("divViewData", "block");
  DisplayData_ToModal(id);
}

function btnChangeStatus(id){
  ToggleDIV("divUpdateStatus", "block");
  DisplayData_ToModal(id);

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var data = JSON.parse(this.responseText);
    for(var index = 0; index < data.length; index++){
      if(data[index].voting_program_id == id){
        status(data[index].voting_status, id);
        break;
      }
    }
  }else{
  }
  };
  xmlhttp.open("GET", "tbl_Voting_Program/json_voting_program.php", true);
  xmlhttp.send();
}

function status(status, id){
  $("#divButtonStatus").text("");
  var changeStatus_PastTense = ["Opened", "Closed"];
  var changeStatus_PresentTense = ["Open", "Close"];
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
  var  obj = {"voting_program_id":id,"voting_status":status};
  var parameter = JSON.stringify(obj);
  ToggleDIV("divUpdateStatus", "none");
  $.ajax({url:'tbl_Voting_Program/update_voting_program_status.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
            showToast("Success", "Voting status successfully updated !.", "success", "#f96868");
            Pagination();
        }
        else{
            showToast("Warning", "Updating voting status was failed, Please try again !."+data, "warning", "#57c7d4");
          Pagination();
        }
      },
      error:function(){
        showToast("Danger", "Updating college program status went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        Pagination();
      }
    });//end of ajax 
}

function DisplayData_ToModal(id){
if(id!=0){
  $(".information").text("");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    $(".information").text("");
      var data = JSON.parse(this.responseText);
      for(var index = 0; index < data.length; index++){
        if(data[index].voting_program_id == id){

$(".information").append("<div class='row'><div class='div1 col-lg-3'></div><div class='div2 col-lg-9'></div></div>");

$(".div1").append("<div class='row'><div class='col-lg-12' style='text-align:center;'>"+data[index].voting_program_code_image+"</div></div>");
// $(".div1").append("<div class='row'><div class='col-lg-12' style='text-align:center;'><b>"+data[index].voting_program_code+"</b></div></div>");

$(".div2").append("<div class='row'><div class='col-lg-12'><h5>"+ data[index].voting_program_name+"</h5></div></div>");

$(".div2").append("<div class='row'><div class='col-lg-12'>"+data[index].voting_program_description+"</div></div>");

$(".div2").append("<div class='row'><div class='col-lg-12'><br><b>Voting Starts:</b> "+data[index].voting_program_starting_date+" @ "+data[index].voting_program_starting_time+"</div></div>");
$(".div2").append("<div class='row'><div class='col-lg-12'><b>Voting Ends:</b> "+data[index].voting_program_ending_date+" @ "+data[index].voting_program_ending_time+"</div></div>");

$(".div2").append("<div class='row'><div class='col-lg-12'><br><b>Date & Time Encoded:</b> "+data[index].voting_program_created_at+"</div></div>");
$(".div2").append("<div class='row'><div class='col-lg-12'><b>Status:</b> "+data[index].voting_program_status+"</div></div>");
break;
        }
      }
    }else{
    $(".information").text("Loading...");
    }
  };
  xmlhttp.open("GET", "tbl_Voting_Program/json_voting_program.php", true);
  xmlhttp.send();
}
}

 document.getElementById("btn_convert1").addEventListener("click", function() {
  html2canvas(document.getElementById("html-content-holder")).then(function (canvas) {      var anchorTag = document.createElement("a");
      document.body.appendChild(anchorTag);
      document.getElementById("previewImg").appendChild(canvas);
      anchorTag.download = "filename.jpg";
      anchorTag.href = canvas.toDataURL();
      anchorTag.target = '_blank';
      anchorTag.click();
    });
 });


function ToggleDIV(id,status){
    document.getElementById(id).style.display=status;
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

<div id="divViewData" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:750px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Voting Program Details</h5>
                <button type="button" class="close" onclick="ToggleDIV('divViewData','none')"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <button class="btn alert-success" title='Print' onclick="printThis('save_program_as_poster')"><i class="fa fa-print"></i> Print</button>
                <div id="save_program_as_poster">
                  <img src="img/voting.jpg" style="width: 100%; height: 250px"><br><br>
                  <span class="information" style="font-size: 14px;"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ToggleDIV('divViewData','none')">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="divUpdateStatus" class="w3-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:750px">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel"> Change Voting Status</h5>
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

        <?php include("includes/main_footer.php"); ?>  
    </div>
</div>
<?php include("includes/quick_menu.php"); ?>
<?php include("includes/footer.php"); ?>