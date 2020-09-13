<?php
   include('config.php');
   session_start();
   //current session set up
   $session = $_SESSION['current_session'];
   $sql = mysqli_query($db,"select username from users where username = '$session'");
   $row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
   $login_session = $row['username'];
   //if not in session redirect
   if(!isset($_SESSION['current_session'])){
      header("location:login.php");
      die();
   }
?>