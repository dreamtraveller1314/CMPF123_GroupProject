<?php 
require "config.php";

//create connection with database
$conn = new mysqli($host, $username, $password, $database);

//check if connectiion is not ok
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM feedback_form";

//execute the SQL query
$result = mysqli_query($conn, $sql);

//process the result set
if (mysqli_num_rows($result) > 0) {
    //output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "ID: " . $row["userFeedbackID"]. " - Name: " . $row["userName"]. " - Gender: " . $row["userGender"]. " - Email: " . $row["userEmail"]. " - Feedback Type: " . $row["userFeedbackType"]. " - Feedback: " . $row["userFeedback"]. " - Date and Time: " . $row["userFeedbackDateTime"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn = mysqli_close($conn);
?>