<?php
// Start session to store email address
session_start();

// Database connection parameters
$host = 'localhost'; // or your database host
$dbname = 'cruddb';
$username = 'root';
$password = 'nichu100';

// Attempt database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display error message if connection fails
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Check if email is submitted through the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    $email = $_POST["email"];

    // Query to check if the email exists in your database
    $sql = "SELECT * FROM userdetails WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Email exists, store it in session and redirect to setpassword.php
        $_SESSION['reset_email'] = $email;
        header("Location: setpassword.php");
        exit();
    } else {
        // Email does not exist, display error message
        $error = "Email not found. Please enter a valid email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://logopond.com/logos/70a5a28358a0f80718ac4f6737f018ae.png" type="image/x-icon">
    <title>CRUD-Reset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-image: url(https://img.freepik.com/free-vector/gradient-blur-pink-blue-abstract-background_53876-117324.jpg?w=740&t=st=1710478849~exp=1710479449~hmac=c1b2c5635922a7aaf7cef296aa08fd60ee84c8f446efb780c0951b07b2b7289a);">

    <div class="container" style="width: 60%;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg p-4 mb-5 bg-white rounded mx-auto" style="width: 100%; margin-top: 100px;">
                    <div class="card-body">
                        <h3 class="card-title">Reset Password</h3>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-warning" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <form id="forgotPasswordForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>