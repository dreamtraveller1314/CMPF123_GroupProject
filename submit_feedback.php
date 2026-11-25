<!DOCTYPE html>
<html>
    <?php
    //check if the form was submitted via POST  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //collect and sanitize input data  
        $userName = $_POST["user-name"];
        $userEmail = $_POST["user-email"];
        $feedbackType = $_POST["feedback-type"];
        $feedbackMessage = $_POST["feedback-message"];
        $feedbackDateTime = $_POST["feedback-datetime"];

         //change date format to DD-MM-YYYY
         $feedbackDate = new DateTime();

        //store data into database
        require "config.php";

        //create connection with database
        $link = mysqli_connect($host, $username, $password, $dbname);

        //to check if connection is NOT OK
        if (!$link) {
            die("Connection problem".mysqli_connect_error($link));//display MySQLI error
        } else {
            //connection OK - insert record into a database table
            $queryInsert = "INSERT INTO feedback_form (user_name, user_email, feedback_type, feedback_message, feedback_datetime) VALUES ('$userName', '$userEmail', '$feedbackType', '$feedbackMessage', '$feedbackDateTime')";
            $resultInsert = mysqli_query($link, $queryInsert);
            if (!$resultInsert) { //to check if query result is NOT OK 
                die("Invalid Query - insert feedback".mysqli_error($link));
            } else {
                //query result is OK
                echo "<script>alert('Your feedback has been successfully submitted.');</script>";
            }
        }
    } else {
        //form not submitted via POST, redirect to feedback form
        header("Location: feedback.html");
        exit(); 
    }
    ?>
</html>