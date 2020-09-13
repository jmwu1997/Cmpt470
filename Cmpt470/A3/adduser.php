<?php 
$myObj = new stdClass();
$myObj->name = $_POST["name"];
$myObj->email = $_POST["email"];
$myObj->age = $_POST["age"];
$myObj->phone_number = $_POST["phone_number"];
$myObj->country = $_POST["country"];
//$myJSON = json_encode($myObj);

//echo $myJSON;

$user = 'root';
$password = ''; 
$database = 'cmpt470'; 
$mysqli = new mysqli('127.0.0.1', $user, $password, $database, $port);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

echo '<p>Connection OK '. $mysqli->host_info.'</p>';
echo '<p>Server '.$mysqli->server_info.'</p>';

$sql = "INSERT INTO users (name,email,age,phone_number,country)
VALUES ('$myObj->name','$myObj->email','$myObj->age','$myObj->phone_number','$myObj->country')";

if ($mysqli->query($sql) === TRUE) {
    echo "New user created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}


$mysqli->close();
?>