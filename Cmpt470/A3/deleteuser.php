<?php 
$myObj = new stdClass();
$myObj->name = $_POST["name"];
$myObj->id = $_POST["uid"];
//$myJSON = json_encode($myObj);

//echo $myJSON;

$user = 'root';
$password = ''; 
$database = 'cmpt470'; 
$port = 3308; 
$mysqli = new mysqli('127.0.0.1', $user, $password, $database, $port);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

echo '<p>Connection OK '. $mysqli->host_info.'</p>';
echo '<p>Server '.$mysqli->server_info.'</p>';

$sql = "DELETE FROM users WHERE id = '$myObj->id' and name = '$myObj->name'";

if ($mysqli->query($sql) === TRUE) {
    echo "User deleted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}


$mysqli->close();
?>