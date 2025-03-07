
<?php
include('includes/dbconnection.php');
if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $contno = $_POST['contactno'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    try {
        // Check if email or contact number already exists
        $stmt = $conn->prepare("SELECT Email FROM tbluser WHERE Email = :email OR MobileNumber = :contno");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contno', $contno);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<script>alert('This email or Contact Number is already associated with another account');</script>";
        } else {
            // Insert new user
            $query = $conn->prepare("INSERT INTO tbluser (FirstName, LastName, MobileNumber, Email, Password) 
                                    VALUES (:fname, :lname, :contno, :email, :password)");
            $query->bindParam(':fname', $fname);
            $query->bindParam(':lname', $lname);
            $query->bindParam(':contno', $contno);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $password);

            if ($query->execute()) {
                echo "<script>alert('You have successfully registered');</script>";
                echo "<script>window.location.href ='signin.php'</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again');</script>";
            }
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Sign Up Page</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Registration Form</h2>
                    <form method="POST">
                        <div class="input-group">
                            <input class="input--style-1" type="text" placeholder="First name" name="fname" required="true">
                        </div>
                        <div class="input-group">
                            <input class="input--style-1" type="text" placeholder="Last name" name="lname" required="true">
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" type="text" placeholder="Mobile Number" name="contactno" required="true" maxlength="10" pattern="[0-9]+"> 
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <div class="rs-select2 js-select-simple select--no-search">
                               <input class="input--style-1" type="email" placeholder="Email Address" name="email" required="true"> 
                              
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input type="password" value="" class="input--style-1" name="password" required="true" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="p-t-20">
                            <button class="btn btn--radius btn--green" type="submit" name="submit">Submit</button>
                        </div>
                        <br>
                        <a href="signin.php" style="color: red">Already have an account? SIGN IN</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->

