<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/img/Tcc_logo.png">
    <title>TCC - Postal</title>
    <script src="./assets/js/search.js"></script>

    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #ecf0f1;
        }
    </style>
</head>

<body>
    <header>
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
    </header>
    <main>
        <div class="container">
            <br>
            <p>You can add Postal Code here.</p>
            <div class="card mt-3">

                <form action="./models/save-postal-code.php" method="POST" id="registrationForm"> <!-- Added id="registrationForm" -->
                    <div class="card-header h3">Postal Code Registration</div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['success'])) {
                            ?>
                            <div class="alert alert-success" id="successDiv"> <!-- Added id="successDiv" -->
                                <b>Postal Code Added:</b> Congratulations! New Postal Code added.
                            </div>
                            <?php
                        } elseif (isset($_GET['invalid'])) {
                            ?>
                            <div class="alert alert-danger" id="errorDiv"> <!-- Added id="errorDiv" -->
                                <b>Existed Postal Code:</b> Details below are already EXISTED, Please try another.
                            </div>
                            <?php
                        }
                        ?>

                        <?php
                        include './config/database.php';
                        ?>
                        <div class="col-md-12">

                        </div>
                        <div class="col-md-12">
                            <label>Region : <b class="text-danger">*</b></label>
                            <select name="inp_region" id="inp_region" onchange="display_province(this.value)" required
                                class="form-control mt-2">
                                <option value="" disabled selected>-- SELECT REGION --</option>

                                <?php
                                $sql = "SELECT * FROM ph_region";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['regCode'] ?>"><?= $row['regDesc'] ?></option>
                                        <?php
                                    }
                                } else {
                                    echo "0 results";
                                }

                                $conn->close();
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Province : <b class="text-danger">*</b></label>
                            <select name="inp_province" id="inp_province" onchange="display_citymun(this.value)"
                                required class="form-control mt-2">
                                <option value="" disabled selected>-- SELECT PROVINCE --</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>City / Municipality : <b class="text-danger">*</b></label>
                            <select name="inp_citymun" id="inp_citymun"
                                class="form-control mt-2">
                                <option value="" disabled selected>-- SELECT CITY / MUNICIPALITY --</option>
                            </select>
                            <div class="col-md-12">
                            </div>
                            <div class="col-md-12">
                                <label>POSTAL CODE : <b class="text-danger">*</b></label>
                                <input type="text" name="PostalCode" id="PostalCode" required class="form-control mt-2" placeholder="Enter Postal Code">
                            </div>
                            <div class="card-footer">
                                <div class="row mt-12">
                                    <div>
                                        <span style="float: right">
                                            <button class="btn btn-success">
                                                Add Postal CODE
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
    </main>
    <footer>
        <div>
            <p>
                <center>TCC-2024&#174;</center>
            </p>
        </div>
    </footer>
</body>

<script>
    function display_province(regCode) {
        $.ajax({
            url: './models/ph_address.php',
            type: 'POST',
            data: {
                'type': 'region',
                'post_code': regCode
            },
            success: function (response) {
                $('#inp_province').html(response);
                hideMessages(); // Hide success and error messages when province changes
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
            success: function (response) {
                $('#inp_citymun').html(response);
                hideMessages(); // Hide success and error messages when city/municipality changes
            }
        });

    }

    // Function to hide success and error messages
    function hideMessages() {
        const successDiv = document.getElementById('successDiv');
        const errorDiv = document.getElementById('errorDiv');
        if (successDiv) successDiv.style.display = 'none';
        if (errorDiv) errorDiv.style.display = 'none';
    }
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="./assets/js/registration.js"> </script>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

</html>
