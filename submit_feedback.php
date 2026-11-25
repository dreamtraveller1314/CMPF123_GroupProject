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
$feedback_type = $_POST["userFeedback_type"];
$feedback      = $_POST["userFeedback"];
$datetime      = $_POST["userFeedbackDatetime"];

// ---------- 4. Simple check: no field should be empty ----------
if ($user_name == "" || $user_gender == "" || $user_email == "" ||
    $feedback_type == "" || $feedback == "" || $datetime == "") {
    die("Error: Please fill in all the fields. <a href='feedback.html'>Go back</a>");
}

// ---------- 5. Save the data into the database ----------
// The ? are placeholders, which keep the database safe from SQL injection
$sql  = "INSERT INTO feedback_form
         (userEmail, userName, userGender, userFeedbackType, userFeedback, userFeedbackDateTime)
         VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssss",
    $user_name, $user_gender, $user_email, $feedback_type, $feedback, $datetime);

$saved = mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Feedback Received - Toysverse</title>
</head>
<body>

<?php if ($saved) { ?>

    <h1>Thank you! Your feedback has been received.</h1>
    <p>Here is a summary of what you submitted:</p>

    <!-- htmlspecialchars() makes the user's text safe to show on the page -->
    <ul>
        <li><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></li>
        <li><strong>Gender:</strong> <?php echo htmlspecialchars($user_gender); ?></li>
        <li><strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?></li>
        <li><strong>Feedback Type:</strong> <?php echo htmlspecialchars($feedback_type); ?></li>
        <li><strong>Feedback:</strong> <?php echo htmlspecialchars($feedback); ?></li>
        <li><strong>Date and Time:</strong> <?php echo htmlspecialchars($datetime); ?></li>
    </ul>

<?php } else { ?>

    <h1>Sorry, something went wrong. Your feedback was not saved.</h1>

<?php } ?>

<p><a href="feedback.html">Submit another feedback</a> |
   <a href="view_feedback.php">View all feedback</a> |
   <a href="index.html">Back to Home</a></p>

</body>
</html>
