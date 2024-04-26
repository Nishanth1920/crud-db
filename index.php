<?php
require_once './Facebook/Facebook/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '1139736640360187',
    'app_secret' => 'f0e870b2a16111b3dcf75d0ff11fc624',
    'default_graph_version' => 'v19.0',
]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://logopond.com/logos/70a5a28358a0f80718ac4f6737f018ae.png" type="image/x-icon">
    <title>CRUD-Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

    <style>
        body {
            background-image: url(https://img.freepik.com/free-vector/gradient-blur-pink-blue-abstract-background_53876-117324.jpg?w=740&t=st=1710478849~exp=1710479449~hmac=c1b2c5635922a7aaf7cef296aa08fd60ee84c8f446efb780c0951b07b2b7289a);
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            text-align: center;
            color: #333;
        }

        .form-label {
            font-weight: 600;
        }

        .invalid-feedback {
            display: none;
            color: #dc3545;
            margin-top: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            border-color: #0056b3;
            background-color: #0056b3;
        }

        .btn-outline-secondary {
            color: #007bff;
            border-color: #007bff;
        }

        .btn-outline-secondary:hover {
            color: #0056b3;
            border-color: #0056b3;
        }

        .alert {
            margin-top: 15px;
            text-align: center;
        }

        .spinner-border {
            width: 1.5rem;
            height: 1.5rem;
            vertical-align: text-bottom;
            display: inline-block;
        }

        #facebookLoginBtn {
            background-color: #3b5998;
            /* Facebook blue */
            color: #fff;
            /* White text */
            border: none;
            /* Remove default button border */
            padding: 10px 20px;
            /* Add padding */
            border-radius: 5px;
            /* Add border radius */
            font-size: 16px;
            /* Increase font size */
            cursor: pointer;
            /* Change cursor to pointer on hover */
        }

        #facebookLoginBtn:hover {
            background-color: #2d4373;
            /* Darker shade of Facebook blue on hover */
        }

        /* Center the icon vertically */
        #facebookLoginBtn i {
            vertical-align: middle;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 d-flex justify-content-center">
                <div class="card shadow-lg p-3  bg-white rounded " style="width: 70%;">
                    <div class="card-body">
                        <h3 class="card-title">CRUD-Login</h3>
                        <div id="countdownTimer" class="text-center mb-3" style="font-size: 18px;"></div> <!-- Countdown timer placeholder -->
                        <!-- Rest of your card body content here -->
                        <!-- Modal -->
                        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-top">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="errorModalLabel"><i class="bi bi-exclamation-circle-fill"></i> Error</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="errorContent"></div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <!-- Additional buttons can be added here if needed -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Welcome message -->
                        <!-- <div id="welcomeMessage" class="alert alert-success d-none" role="alert">
                            Welcome! You have successfully logged in.
                        </div> -->
                        <form id="loginForm" method="post">
                            <div class="mb-2">
                                <label for="name" class="form-label">Username</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="@ Username">
                                <div class="invalid-feedback">Name is required</div>
                            </div>
                            <div class="mb-2">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </button>
                                </div>
                                <div id="password-strength-meter" class="form-text">
                                    Password Strength : <span id="strength-icon"></span> <span id="strength-text" class="strength-text"></span>
                                </div>
                                <div class="invalid-feedback">Password is required</div>
                            </div>
                            <!-- CountryInput -->
                            <div id="countryContainer" class="mb-3 d-none">
                                <label for="captcha" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country" placeholder="What is your country?">
                                <div class="invalid-feedback">Country is required</div>
                            </div>

                            <!-- Remember Me Checkbox -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember Me</label>
                            </div>
                           
                            <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff; transition: background-color 0.3s ease; width: 100%; padding: 10px; border-radius: 5px; font-size: 16px; font-weight: bold;">
                                Login
                            </button>
                        </form>
                        <!-- Facebook Login Button -->
                        
                        <div class="mb-1 mt-3 ">
                            <button id="facebookLoginBtn" class="btn btn-primary btn-block" style=" border-color: #007bff; transition: background-color 0.3s ease; width: 100%; padding: 10px; border-radius: 5px; font-size: 16px; font-weight: bold;">
                                <i class="bi bi-facebook"></i> Login with Facebook
                            </button>
                        </div>
                        <!-- Forgot Password Link -->
                        <div class="mt-3 d-flex justify-content-center">
                            <a href="forgotpassword.php">Forgot Password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var failedAttempts = 0;
            var maxAttempts = 2; // Maximum number of allowed failed attempts
            var lockoutDuration = 60; // Lockout duration in seconds
            var countdownInterval;
            var countdownRunning = false; // Flag to track if countdown is running

            // Function to start the countdown timer
            function startCountdownTimer() {
                var remainingTime = lockoutDuration;
                var countdownTimer = $('#countdownTimer');

                // Show initial countdown value
                countdownTimer.text("Your account is locked. Please try again after " + remainingTime + " seconds.");

                $('#errorModal').modal({
                    backdrop: 'static', // Disable closing modal by clicking outside
                    keyboard: false // Disable closing modal with keyboard
                });
                $('#errorModal').modal('show');

                // Update the modal content every second
                countdownInterval = setInterval(function() {
                    remainingTime--;
                    countdownTimer.text("Your account is locked. Please try again after " + remainingTime + " seconds.");

                    // If the countdown reaches 0, clear the interval
                    if (remainingTime <= 0) {
                        clearInterval(countdownInterval);
                        $('#errorModal').modal('hide');
                        failedAttempts = 0; // Reset failed attempts counter
                        countdownRunning = false; // Set countdown flag to false
                    }
                }, 1000);
            }

            // Check if Remember Me checkbox is checked and fill in the form if necessary
            if (localStorage.getItem('rememberMe') === 'true') {
                $('#name').val(localStorage.getItem('username'));
                $('#password').val(localStorage.getItem('password'));
                $('#rememberMe').prop('checked', true);
            }

            $('#loginForm').submit(function(e) {
                e.preventDefault();

                // Check if the countdown timer is running
                if (countdownRunning) {
                    return; // Do nothing if the countdown timer is already running
                }

                var name = $('#name').val();
                var password = $('#password').val();
                var country = $('#country').val();

                // Validate inputs
                if (name.trim() === '') {
                    $('#name').addClass('is-invalid');
                    return;
                }
                $('#name').removeClass('is-invalid');

                if (password.trim() === '') {
                    $('#password').addClass('is-invalid');
                    return;
                }
                $('#password').removeClass('is-invalid');

                // Check if CAPTCHA is required
                if (failedAttempts >= maxAttempts) {
                    if (country.trim() === '') {
                        $('#country').addClass('is-invalid');
                        return;
                    }
                    $('#country').removeClass('is-invalid');
                }

                // Save login credentials if Remember Me is checked
                if ($('#rememberMe').is(':checked')) {
                    localStorage.setItem('rememberMe', 'true');
                    localStorage.setItem('username', name);
                    localStorage.setItem('password', password);
                } else {
                    localStorage.removeItem('rememberMe');
                    localStorage.removeItem('username');
                    localStorage.removeItem('password');
                }

                // Send AJAX request for login
                $.ajax({
                    type: 'POST',
                    url: 'login.php',
                    data: $(this).serialize(),
                    beforeSend: function() {
                        // Disable form elements while submission is in progress
                        $('#loginForm :input').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response === 'success') {
                            window.location.href = 'read.php';
                        } else {
                            failedAttempts++;
                            if (failedAttempts >= 3) {
                                // Display CAPTCHA if max attempts reached
                                // $('#countryContainer').removeClass('d-none');
                                countdownRunning = true; // Set countdown flag to true
                                startCountdownTimer(); // Start countdown timer and lock account
                            }
                            if (failedAttempts >= maxAttempts) {
                                // Display CAPTCHA if max attempts reached
                                $('#countryContainer').removeClass('d-none');
                                // countdownRunning = true; // Set countdown flag to true
                                // startCountdownTimer(); // Start countdown timer and lock account
                            }
                            else {
                                // Show error modal
                                $('#errorContent').text(response); // Set error message in modal
                                $('#errorModal').modal('show'); // Show the modal
                            }
                        }
                    },
                    complete: function() {
                        // Re-enable form elements after submission is complete
                        $('#loginForm :input').prop('disabled', false);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#togglePassword').click(function() {
                var passwordInput = $('#password');
                var icon = $(this).find('i');

                // Toggle password visibility
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#password').on('input', function() {
                var password = $(this).val();
                var strengthIcon = $('#strength-icon');
                var strengthText = $('#strength-text');

                // Calculate password strength
                var strength = 0;
                if (password.length >= 8) {
                    strength += 1;
                }
                if (password.match(/[a-z]/)) {
                    strength += 1;
                }
                if (password.match(/[A-Z]/)) {
                    strength += 1;
                }
                if (password.match(/[0-9]/)) {
                    strength += 1;
                }
                if (password.match(/[^a-zA-Z0-9]/)) {
                    strength += 1;
                }

                // Update strength meter text and icon based on strength level
                switch (strength) {
                    case 0:
                        strengthIcon.html('<i class="bi bi-exclamation-triangle-fill text-danger"></i>');
                        strengthText.text("Very Weak");
                        break;
                    case 1:
                        strengthIcon.html('<i class="bi bi-exclamation-circle-fill text-warning"></i>');
                        strengthText.text("Weak");
                        break;
                    case 2:
                        strengthIcon.html('<i class="bi bi-info-circle-fill text-info"></i>');
                        strengthText.text("Medium");
                        break;
                    case 3:
                        strengthIcon.html('<i class="bi bi-shield-fill-exclamation text-success"></i>');
                        strengthText.text("Strong");
                        break;
                    case 4:
                        strengthIcon.html('<i class="bi bi-shield-fill-check text-success"></i>');
                        strengthText.text("Very Strong");
                        break;
                    default:
                        strengthIcon.html('');
                        strengthText.text("");
                }
            });
        });
    </script>

    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '1139736640360187',
                cookie: true,
                xfbml: true,
                version: 'v19.0'
            });

            FB.getLoginStatus(function(response) {
                // Check login status
                statusChangeCallback(response);
            });
        };

        function statusChangeCallback(response) {
            if (response.status === 'connected') {
                // User is logged in via Facebook, handle accordingly
                console.log('Logged in via Facebook');
                // You can redirect the user or perform any other action here
            }
        }

        function facebookLogin() {
            FB.login(function(response) {
                statusChangeCallback(response);
            }, {
                scope: 'email'
            });
        }

        document.getElementById('facebookLoginBtn').addEventListener('click', facebookLogin);
    </script>
</body>

</html>