<?php
// Include database connection
include("./config/database.php");

// Initialize variables to store form field values
$inp_sid = $inp_appid = $inp_tesno = $inp_fname = $inp_lname = $inp_ename = $inp_mname = $inp_gender = $inp_contact = $inp_batch = $inp_status = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and escape input fields to prevent SQL injection
    $inp_sid = mysqli_real_escape_string($conn, $_POST['inp_sid']);
    $inp_appid = mysqli_real_escape_string($conn, $_POST['inp_appid']);
    $inp_tesno = mysqli_real_escape_string($conn, $_POST['inp_tesno']);
    $inp_fname = mysqli_real_escape_string($conn, $_POST['inp_fname']);
    $inp_lname = mysqli_real_escape_string($conn, $_POST['inp_lname']);
    $inp_ename = mysqli_real_escape_string($conn, $_POST['inp_ename']);
    $inp_mname = mysqli_real_escape_string($conn, $_POST['inp_mname']);
    $inp_gender = mysqli_real_escape_string($conn, $_POST['inp_gender']);
    $inp_contact = mysqli_real_escape_string($conn, $_POST['inp_contact']);
    $inp_batch = mysqli_real_escape_string($conn, $_POST['inp_batch']);
    $inp_status = mysqli_real_escape_string($conn, $_POST['inp_status']);

    // SQL query to check if the application ID already exists
    $check_query = "SELECT * FROM t_students WHERE s_app_id = '$inp_appid'";
    $result = mysqli_query($conn, $check_query);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        // Redirect to registration page with error message for duplicate application ID
        header('location: ./registration.php?duplicate=true');
        exit();
    }

    // SQL query to insert data into the database
    $query = "INSERT INTO t_students (s_student_id, s_app_id, s_tes_number, s_first_name, s_last_name, s_ext_name, s_middle_name, s_gender, s_phone, s_award_batch, s_status) VALUES ('$inp_sid', '$inp_appid', '$inp_tesno', '$inp_fname', '$inp_lname', '$inp_ename', '$inp_mname', '$inp_gender', '$inp_contact', '$inp_batch', '$inp_status')";

    if (mysqli_query($conn, $query)) {
        // Set a session variable to display success message
        $_SESSION['success_message'] = true;
    } else {
        // Redirect to registration page with error message
        header('location: ./registration.php?error=' . urlencode(mysqli_error($conn)));
        exit();
    }
}

// Check if success message session variable is set
if (isset($_SESSION['success_message']) && $_SESSION['success_message'] === true) {
    $success_message = true;
    // Unset the session variable
    unset($_SESSION['success_message']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/img/Tcc_logo.png">
    <title>TCC - Registration</title>
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #ecf0f1;
        }
        .card-footer {
            padding-top: 20px;
            justify-content: flex-end; /* Align button to the right */
        }
        #successDiv {
            width: 100%; /* Make success message occupy full width */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="javascript:void(0)">
                <img src="./assets/img/logo.png" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="./index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./registration.php">Registration</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="postalCode.php">Postal</a>
                    </li> 
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
            <div class="card-body">
            <?php if (isset($success_message) && $success_message === true) : ?>
                <div class="alert alert-success" id="successDiv">
                    <b>New Student Added.</b> Congrats. Thank you!
                </div>
                <hr>
            <?php elseif (isset($_GET['duplicate']) && $_GET['duplicate'] == 'true') : ?>
                <div class="alert alert-danger" id="errorDiv">
                    <b>Error:</b> Application ID already exists.
                </div>
                <hr>
            <?php elseif (isset($_GET['error'])) : ?>
                <div class="alert alert-danger" id="errorDiv">
                    <b>Error:</b> <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
                <hr>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col">
            <div class="container" id="registrationCardBody">
                    <p class="h2 mt-3">Registration</p>
                    <p>You can add a record for a student here.</p>
                    <div class="card mt-3">
                        <form id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="card-header">Registration Form</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> Student ID : <b class="text-danger">*</b></label>
                                        <input name="inp_sid" required type="text" placeholder="Enter student ID here.." class="form-control mt-2" value="<?php echo $inp_sid; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label> Application ID : <b class="text-danger">*</b></label>
                                        <input name="inp_appid" required type="text" placeholder="Enter Application ID here.." class="form-control mt-2" value="<?php echo $inp_appid; ?>">
                                    </div>
                                    <div class="col -md-5">
                                        <label> TES Award Number : <b class="text-danger">*</b></label>
                                        <input name="inp_tesno" required type="text" placeholder="Enter TES Award Number here.." class="form-control mt-2" value="<?php echo $inp_tesno; ?>">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label>First Name : <b class="text-danger">*</b></label>
                                        <input name="inp_fname" required type="text" placeholder="Enter first name here.." class="form-control mt-2" value="<?php echo $inp_fname; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Last Name : <b class="text-danger">*</b></label>
                                        <input name="inp_lname" required type="text" placeholder="Enter last name here.." class="form-control mt-2" value="<?php echo $inp_lname; ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Ext. Name : <small>(Optional)</small></label>
                                        <input name="inp_ename" type="text" placeholder="Ext. name here.." class="form-control mt-2" value="<?php echo $inp_ename; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Middle Name : <small>(Optional)</small></label>
                                        <input name="inp_mname" type="text" placeholder="Enter middle name here.." class="form-control mt-2" value="<?php echo $inp_mname; ?>">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label>Gender : <b class="text-danger">*</b></label>
                                        <select name="inp_gender" required class="form-control mt-2">
                                            <option value="" disabled selected>-- SELECT GENDER --</option>
                                            <option value="Female" <?php if ($inp_gender == 'Female') echo 'selected'; ?>>Female</option>
                                            <option value="Male" <?php if ($inp_gender == 'Male') echo 'selected'; ?>>Male</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Contact Number : <b class="text-danger">*</b></label>
                                        <input name="inp_contact" required type="text" placeholder="09 XXXX XXXX" class="form-control mt-2" value="<?php echo $inp_contact; ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Award Batch : <b class="text-danger">*</b></label>
                                        <input name="inp_batch" required type="text" placeholder="Batch X" class="form-control mt-2" value="<?php echo $inp_batch; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Status : <small>(Optional)</small></label>
                                        <input name="inp_status" type="text"  placeholder="Enter the student status here.." class="form-control mt-2" value="<?php echo $inp_status; ?>">
                                    </div>
                                </div>
                                
                                <!--Address-->
                                <?php
                                    include './config/database.php';

                                    
                                ?>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                    <label>Region : <b class="text-danger">*</b></label>
                                        <select name="inp_region" id="inp_region" onchange="display_province(this.value)" required class="form-control mt-2">
                                            <option value="" disabled selected>-- SELECT REGION --</option>

                                            <?php
                                              $sql = "SELECT * FROM ph_region";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                ?>
                                                 <option value="<?= $row['regCode'] ?>"><?= $row['regDesc']?></option> 
                                                <?php
                                            }
                                            } else {
                                            echo "0 results";
                                            }
                                            $conn->close();  
                                            ?>
                                        </select>   
                                    </div>
                                    <!--Provice-->
                                    <div class="col-md-12 mt-3">
                                    <label>Province : <b class="text-danger">*</b></label>
                                        <select name="inp_province" id="inp_province" onchange="display_citymun(this.value)" required class="form-control mt-2">
                                            <option value="" disabled selected>-- SELECT PROVINCE --</option>
                                        </select>
                                    </div>
                                    <!--City / Municipality-->
                                    <div class="col-md-12 mt-3">
                                    <label>City / Municipality : <b class="text-danger">*</b></label>
                                        <select name="inp_citymun" id="inp_citymun" onchange="display_brgy(this.value)" required class="form-control mt-2">
                                            <option value="" disabled selected>-- SELECT CITY / MUNICIPALITY --</option>
                                        </select>
                                    </div>
                                    <!--Barangay-->
                                    <div class="col-md-12 mt-3">
                                    <label>Barangay : <b class="text-danger">*</b></label>
                                        <select name="inp_brgy" id="inp_brgy" required class="form-control mt-2">
                                            <option value="" disabled selected>-- SELECT BARANGAY --</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Add New Student</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function display_province(regCode) {
            $.ajax({
            url: './models/ph_address.php',
            type: 'POST',
            data: {
                'type': 'region',
                'post_code': regCode
            },
            success: function(response) {
                $('#inp_province').html(response);
            }
        });
    
        }

        function display_citymun(provCode) {
            $.ajax({
            url: './models/ph_address.php',
            type: 'POST',
            data: {
                'type': 'province',
                'post_code': provCode
            },
            success: function(response) {
                $('#inp_citymun').html(response);
            }
        });
    
        }

        function display_brgy(citymunCode) {
            $.ajax({
            url: './models/ph_address.php',
            type: 'POST',
            data: {
                'type': 'citymun',
                'post_code': citymunCode
            },
            success: function(response) {
                $('#inp_brgy').html(response);
            }
        });
    
        }

    </script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./assets/js/registration.js"> </script>    

</body>
</html>

