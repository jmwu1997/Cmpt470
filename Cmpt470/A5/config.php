<?php
   //define the server configs
   define('server', '35.227.146.173');
   define('username', 'readonlyuser');
   define('password', 'readonly');
   define('database', 'cmpt470');
   //connect to the sql server
   $db = mysqli_connect(server,username,password,database);
?>