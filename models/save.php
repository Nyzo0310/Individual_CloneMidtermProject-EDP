<?php
// Include database connection
include('../config/database.php');

// Function to sanitize input data
function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $s_app_id = sanitize($conn, $_POST['inp_appid']);
    $s_tes_number = sanitize($conn, $_POST['inp_tesno']);
    $s_student_id = sanitize($conn, $_POST['inp_sid']);
    $s_first_name = sanitize($conn, $_POST['inp_fname']);
    $s_last_name = sanitize($conn, $_POST['inp_lname']);
    $s_ext_name = sanitize($conn, $_POST['inp_ename']);
    $s_middle_name = sanitize($conn, $_POST['inp_mname']);
    $s_gender = sanitize($conn, $_POST['inp_gender']);
    $s_phone = sanitize($conn, $_POST['inp_contact']);
    $s_award_batch = sanitize($conn, $_POST['inp_batch']);
    $s_status = sanitize($conn, $_POST['inp_status']);

    // SQL query to insert data into the database
    $query = "INSERT INTO t_students (s_student_id, s_app_id, s_tes_number, s_first_name, s_last_name, s_ext_name, s_middle_name, s_gender, s_phone, s_award_batch, s_status) VALUES ('$inp_sid', '$inp_appid', '$inp_tesno', '$inp_fname', '$inp_lname', '$inp_ename', '$inp_mname', '$inp_gender', '$inp_contact', '$inp_batch', '$inp_status')";

    // Execute query and handle success or failure
    if(mysqli_query($conn, $query)) {
        // Display success message directly on the registration page
        echo '<div class="alert alert-success" id="successDiv"><b>New Student Added.</b> Congrats. Thank you!</div>';
        echo '<hr>';
    } else {
        // Redirect with error message if query fails
        header('location: ../event-driven-programming/registration.php?invalid');
        exit();
    }
} else {
    // Redirect if form is not submitted
    header('location: ../event-driven-programming/registration.php');
    exit();
}
?>
