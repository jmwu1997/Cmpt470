<?php

try {
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

    $sql = "SELECT id, name, email, age, phone_number, country FROM users";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - Name: " . $row["name"]. " - Email: " . $row["email"]. " - Age: " . $row["age"]. " - Phone number: " . $row["phone_number"]. " - Country: " . $row["country"]."<br>";
        }
    } else {
        echo "Results not found.";
    }

}
catch(PDOException $e){
  die($e->getMessage());
}
 ?>