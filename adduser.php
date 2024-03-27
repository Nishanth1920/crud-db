<?php
// Start the session
session_start();

// Check if user is not logged in, redirect to index.php
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddUser</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body style="background-image: url(https://img.freepik.com/free-vector/gradient-blur-pink-blue-abstract-background_53876-117324.jpg?w=740&t=st=1710478849~exp=1710479449~hmac=c1b2c5635922a7aaf7cef296aa08fd60ee84c8f446efb780c0951b07b2b7289a);">


    <div class="container" style="margin-top: 20px; width: 40%; ">
        <div>
            <h3 style="margin-bottom: 20px; margin-top: 20px;" class="px-3">CRUD OPERATION-ADD USER</h3>
        </div>
        <div class="card shadow-lg p-3 mb-5 bg-body rounded">
            <div class="card-body">
                <form method="POST" action="adduserError.php" id="loginForm" > <!-- Change action to your PHP script -->
                <!-- <div id="alert" class="alert alert-danger d-none" role="alert"></div> -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <h6>Name</h6>
                        </label>
                        <input type="text" id="name" class="form-control" name="name" placeholder="Enter Your Name">
                        <div class="invalid-feedback">Name is required</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">
                            <h6>Email</h6>
                        </label>
                        <input type="email" id="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter Your Email">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                         <div class="invalid-feedback">Email is required</div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <h6>Country</h6>
                        </label>
                        <input type="text" id="country" class="form-control" name="country" placeholder="Enter Your Country">
                         <div class="invalid-feedback">Country is required</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">
                            <h6>Password</h6>
                        </label>
                        <input type="password" id="password" class="form-control" name="password" placeholder="Enter Your Password">
                         <div class="invalid-feedback">Password is required</div>
                    </div>
                    
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="read.php" class="btn btn-secondary btn-md active" role="button" aria-pressed="true">Cancel</a>
        
                </form>
            </div>
        </div>
    </div>


    <script>
    $(document).ready(function() {
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            var name = $('#name').val();
            var email = $('#email').val();
            var country = $('#country').val();
            var password = $('#password').val();
            
            // Validate inputs
            if (name.trim() === '') {
                $('#name').addClass('is-invalid');
                return;
            }
            $('#name').removeClass('is-invalid');

            if (email.trim() === '') {
                $('#email').addClass('is-invalid');
                return;
            }
            $('#email').removeClass('is-invalid');

            if (country.trim() === '') {
                $('#country').addClass('is-invalid');
                return;
            }
            $('#country').removeClass('is-invalid');
            
            if (password.trim() === '') {
                $('#password').addClass('is-invalid');
                return;
            }
            $('#password').removeClass('is-invalid');

            // Send AJAX request for login
            $.ajax({
                type: 'POST',
                url: 'adduserError.php',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    // exit;
                    if (response === 'success') {
                        window.location.href = 'read.php';
                    } else {
                        $('#alert').removeClass('d-none').text(response);
                        // window.location.href = 'read.php';
                    }
                }
            });
        });
    });
</script>
</body>

</html>