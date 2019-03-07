<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "exchange";
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db = new mysqli($servername, $username, $password, $dbname); // connect to the DB
    $query = $db->prepare("SELECT balance FROM services"); // prepate a query
     
    $query->execute(); // actually perform the query
    $result = $query->get_result(); // retrieve the result so it can be used inside PHP
    $r = $result->fetch_array(MYSQLI_ASSOC); // bind the data from the first result row to $r
    $info = $r['balance'];
    $query = $db->prepare("SELECT updatedAt FROM services"); // prepate a query
     
    $query->execute(); // actually perform the query
    $result = $query->get_result(); // retrieve the result so it can be used inside PHP
    $r = $result->fetch_array(MYSQLI_ASSOC); // bind the data from the first result row to $r
    $last = $r['updatedAt'];
?>