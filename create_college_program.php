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
                                <h5>New College Program</h5>
                                <span>The authorized user can add new college program.</span>
                            </div>
                        </div>
                    </div>
                    </div>  
                </div>
                <div class="row clearfix"></div>
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
                <div class="row">
                    <div class="col-lg-12"><br>
                         <button class="btn alert-success btn-medium" onclick="Submit_Registration()"><i class="ik ik-save"></i> Submit Registration</button>
                    </div>
                </div>

	        </div>
        </div>

<script type="text/javascript">
function Empty(){
  $("#program_name").val("");
  $("#program_description").val("");

  $(".error_program_name").text("*");
  $(".error_program_description").text("*");
}

function Submit_Registration(){
  if($("#program_name").val() == "" || $("#program_description").val() == ""){
      $(".error_program_name").text("* Field is required");
      $(".error_program_description").text("* Field is required");
  }else{
      $(".error_program_name").text("*");
      $(".error_program_description").text("*");

    var obj={"college_program_name":$("#program_name").val(), 
      "college_program_description":$("#program_description").val()};
      var parameter = JSON.stringify(obj); 
      $.ajax({url:'tbl_college_program/create_college_program.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          showToast("Success", "College program successfully saved !.", "success", "#f96868");
          Empty();
        }
        else{
          showToast("Warning", "Saving of college program was failed, Please try again !."+data, "warning", "#57c7d4");
          Empty();
        }
      },
      error:function(){
        showToast("Danger", "Registration went something wrong, Please contact the System Administrator !.", "error", "#f2a654");
        Empty();
      }
    });//end of ajax  
  }//END OF IF Form_Validation()
}//END OF Submit_Registration

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