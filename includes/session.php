<?php
   session_start();
   function logged_in() {
      return isset($_SESSION['personId']);
   }

   function confirm_logged_in() {
      if(!logged_in()) {
      	header("Location: index.php");
      }else{
      }
   }

   function VerifyAccount(){
      if(isset($_SESSION['personId'])){
      }
      else{
         header("Location: index.php");
         log_out();
      }
   }
   
   function log_out(){
	   // Four steps to closing a session

	   // 1. Find the session
	   session_start();
	   // 2. Unset all session variables
	   $_SESSION = array();
	   // 3. Destroy the session cookie
	   if(isset($_COOKIE[session_name])){
	      setcookie(session_name(),'',time(-42000), '/');
	   }
	   // 4. Destroy the session
	   session_destroy();
	   header("index.php");
   }
?>
