<?php
   session_start();
   //when session destory redirect back to login page
   if(session_destroy()) {
      header("Location: login.php");
   }
?>