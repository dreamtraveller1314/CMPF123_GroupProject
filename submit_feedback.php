<?php 
require "config.php";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$name = $_POST["userName"];
$gender = $_POST["userGender"];
$email = $_POST["userEmail"];
$feedbackType = $_POST["userFeedbackType"];
$feedback = $_POST["userFeedback"];

date_default_timezone_set('Asia/Kuala_Lumpur');
$dateTime = date('Y-m-d H:i:s'); 

$sql = "INSERT INTO feedback_form (userEmail, userName, userGender, userFeedbackType, userFeedback, userFeedbackDateTime)
VALUES ('$email', '$name', '$gender', '$feedbackType', '$feedback', '$dateTime')";

if (mysqli_query($conn, $sql)) {
    echo "Feedback submitted successfully!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);