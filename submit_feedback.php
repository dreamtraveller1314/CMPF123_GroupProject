<?php
// ---------- 1. Connect to the database (WampServer defaults) ----------
require "config.php";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ---------- 2. Make sure the form was submitted ----------
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Please submit the feedback form first.");
}

// ---------- 3. Get the data from the form ----------
// The names in brackets must match the name="" attributes in feedback.html
$user_name     = $_POST["userName"];
$user_gender   = $_POST["userGender"];
$user_email    = $_POST["userEmail"];
$feedback_type = $_POST["userFeedbackType"];
$feedback      = $_POST["userFeedback"];

// 1. Set the timezone to Kuala Lumpur (Malaysia)
date_default_timezone_set('Asia/Kuala_Lumpur');

// 2. Get the current date and time
$dateTime = date('Y-m-d H:i:s');


// ---------- 4. Simple check: no field should be empty ----------
if ($user_name == "" || $user_gender == "" || $user_email == "" ||
    $feedback_type == "" || $feedback == "" || $dateTime == "") {
    die("Error: Please fill in all the fields. <a href='feedback.html'>Go back</a>");
}

// ---------- 5. Save the data into the database ----------
// The ? are placeholders, which keep the database safe from SQL injection
$sql  = "INSERT INTO feedback_form
         ($user_name, $user_gender, $user_email, $feedback_type, $feedback, $dateTime)";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Feedback Received - Toysverse</title>
</head>
<body>
    <h1>Thank you! Your feedback has been received.</h1>
    <p>Here is a summary of what you submitted:</p>

    <!-- htmlspecialchars() makes the user's text safe to show on the page -->
    <ul>
        <li><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></li>
        <li><strong>Gender:</strong> <?php echo htmlspecialchars($user_gender); ?></li>
        <li><strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?></li>
        <li><strong>Feedback Type:</strong> <?php echo htmlspecialchars($feedback_type); ?></li>
        <li><strong>Feedback:</strong> <?php echo htmlspecialchars($feedback); ?></li>
        <li><strong>Date and Time:</strong> <?php echo htmlspecialchars($dateTime); ?></li>
    </ul>

<p><a href="feedback.html">Submit another feedback</a> |
   <a href="view_feedback.php">View all feedback</a> |
   <a href="index.html">Back to Home</a></p>

</body>
</html>
