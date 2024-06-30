<?php
// Database credentials
$servername = "mesproddb3.waltonbd.com"; // Change this to your database server name
$username = "test_intern"; // Change this to your database username
$password = "test_intern"; // Change this to your database password
$dbname = "test_intern"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query
$sql = "SELECT t1.parent_id parentId, t1.* FROM global_org_chart_details t1";
$result = $conn->query($sql);

$arr = [];
if ($result->num_rows > 0) {
    // Fetch associative array
    while ($row = $result->fetch_assoc()) {
        // print_r($row);
        // echo "<br>";
        // Append each row to the $arr array
        $arr[] = $row;
    }
    // Print the accumulated array
    // print_r($arr); // Optional: for debugging
}

// Close connection
$conn->close();

// print_r($arr);
// echo "<br>";
// echo json_encode($arr);
// print_r(json_encode($arr));
