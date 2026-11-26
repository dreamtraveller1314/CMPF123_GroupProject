<?php
//connect this file to config.php to get the database connection details 
require "config.php";

//create connection to the database using the details from config.php
$conn = mysqli_connect($host, $username, $password, $database);

//check if the connection is successful
if (!$conn) {
    //if the connection is not successful, display an error message and terminate the script
    die("Connection failed: " . mysqli_connect_error());
}

//retrieve the data from the form submission using the POST method
$name = $_POST["userName"];
$gender = $_POST["userGender"];
$email = $_POST["userEmail"];
$feedbackType = $_POST["userFeedbackType"];
$feedback = $_POST["userFeedback"];

//set the timezone to Kuala Lumpur and get the current date and time
date_default_timezone_set('Asia/Kuala_Lumpur');
//get the current date and time in the format 'Y-m-d H:i:s'
$dateTime = date('Y-m-d H:i:s'); 

//insert the data into the feedback_data table in the database
$sql = "INSERT INTO feedback_data (userEmail, userName, userGender, userFeedbackType, userFeedback, userFeedbackDateTime)
VALUES ('$email', '$name', '$gender', '$feedbackType', '$feedback', '$dateTime')";

//check if submission is successful and display an alert message to the user, then redirect them back to the feedback form
if (mysqli_query($conn, $sql)) {
    echo "<script>
        alert('Feedback submitted successfully!');
        window.location.href = 'feedback.html';
        </script>";
} else {
    echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "');
    window.location.href = 'feedback.html';
    </script>";
}

mysqli_close($conn);