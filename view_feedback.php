<?php
// ---------- 1. Connect to the database ----------
require "config.php";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ---------- 2. Get all feedback, newest first ----------
$sql    = "SELECT * FROM feedback_form ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Feedback - Toysverse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Feedback Submitted by Users</h1>

<?php if (mysqli_num_rows($result) > 0) { ?>

    <table>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Type</th>
            <th>Feedback</th>
            <th>Date and Time</th>
        </tr>

        <?php
        // ---------- 3. Loop through each row and show it ----------
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . htmlspecialchars($row["user_name"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["user_gender"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["user_email"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["feedback_type"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["feedback"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["datetime"]) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

<?php } else { ?>

    <p>No feedback has been submitted yet.</p>

<?php } ?>

<p><a href="feedback.html">Give feedback</a> | <a href="index.html">Back to Home</a></p>

</body>
</html>
<?php mysqli_close($conn); ?>
