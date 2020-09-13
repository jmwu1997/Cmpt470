<?php
   include("config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      //md5 password hash
      $mypassword = md5($_POST['password']);
      $mypassword = mysqli_real_escape_string($db,$mypassword); 

      //sql statement to check username and password match
      $sql = "SELECT username FROM users WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
    
		//if there is user exist direct to main page
      if($result->num_rows == 1) {
         
         $_SESSION['current_session'] = $myusername;
         header("location: main.php");
      //error message for invalid login
      }else {
         $message = "Incorrect login, please try again.";
         echo "<script type='text/javascript'>alert('$message');</script>";
      }
   }
?>
<html>
   <head>
      <title>Login Page</title>
   </head>
   <body>
         <fieldset>
         <legend>User login:</legend>
         <form action = "" method = "post">
            <label>UserName  :</label><input class="input" type = "text" name = "username" /><br /><br />
            <label>Password  :</label><input class="input" name = "password" /><br/><br />
            <input class="submit" type = "submit" value = " Submit "/><br />
         </form>
         </fieldset>   
   </body>
   
</html>

<style>
.input {
  display: inline-block;
  padding: 10px 20px;
  border: 1px solid #b7b7b7;
  border-radius: 3px;
  font: normal 16px/normal "Times New Roman", Times, serif;
  color: black;
  background: rgba(252,252,252,1);
  box-shadow: 2px 2px 2px 0 rgba(0,0,0,0.2) inset;
  text-shadow: 1px 1px 0 rgba(255,255,255,0.66) ;
}
fieldset
{
  border:2px grey;
  background-color:#CCC;
  max-width:500px;
  padding:16px;	
}
.legend
{
  margin-bottom:0px;
  margin-left:16px;
}

.submit {
  display: inline-block;
  cursor: pointer;
  padding: 10px 20px;
  border: 1px solid #018dc4;
  border-radius: 3px;
  font: normal 16px/normal "Times New Roman", Times, serif;
  color: rgba(0,0,0,1);
  background: rgba(255,255,255,1);
  -webkit-box-shadow: 2px 2px 2px 0 rgba(0,0,0,0.2) ;
}
</style>