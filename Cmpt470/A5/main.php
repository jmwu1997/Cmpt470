<?php
   include('session.php');

?>


<html>
   
   <head>
  
   </head>
   
   <body align='center'>
      <h1>Hello,<?php echo $login_session; ?>. Please submit your grade file.</h1> 
      <form action="grade.php" method='POST' enctype='multipart/form-data'>
        <div align='center'>
            <p>Upload CSV files: <input class='input' type='file' name='file' /></p>
            <p><input type='submit' class='submit' name='submit' value='Submit' /></p>
        </div>
      <p align='center'><a href = "logout.php">Sign Out</a></p>
   </body>
   
</html>

<style>
.input {
  display: inline-block;
  padding: 10px 20px;
  border: 1px solid #b7b7b7;
  margin-left:15px;
  border-radius: 3px;
  font: normal 16px/normal "Times New Roman", Times, serif;
  color: black;
  background: rgba(252,252,252,1);
  box-shadow: 2px 2px 2px 0 rgba(0,0,0,0.2) inset;
  text-shadow: 1px 1px 0 rgba(255,255,255,0.66) ;
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