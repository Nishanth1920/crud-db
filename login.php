<?php
// Start session
session_start();

// Check if name, password, and country are set
if(isset($_POST['name']) && isset($_POST['password']) && isset($_POST['country'])) {
    // Get input data
    $name = $_POST['name'];
    $cpassword = md5($_POST['password']);
    $country = $_POST['country'];

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "nichu100"; // Your database password
    $dbname = "cruddb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize failed attempts counter
    if (!isset($_SESSION['failed_attempts'])) {
        $_SESSION['failed_attempts'] = 0;
    }

    // Check if failed attempts exceed threshold
    if ($_SESSION['failed_attempts'] >= 3) {
        // Validate country after 3 failed attempts
        // Prepare and execute SQL query to check user credentials along with country
        $sql = "SELECT * FROM userdetails WHERE name='$name' AND password='$cpassword' AND country='$country'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Login successful after country validation
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $name;
            // Reset failed attempts counter
            $_SESSION['failed_attempts'] = 0;
            echo "success";
        } else {
            // Login failed after country validation
            $_SESSION['failed_attempts']++;
            echo "Invalid name, password, or country";
        }
    } else {
        // Prepare and execute SQL query to check user credentials
        $sql = "SELECT * FROM userdetails WHERE name='$name' AND password='$cpassword'";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            // Login successful
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $name;
            // Reset failed attempts counter
            $_SESSION['failed_attempts'] = 0;
            echo "success";
        } else {
            // Login failed
            $_SESSION['failed_attempts']++;
            echo "Invalid name or password";
        }
    }

    // Close connection
    $conn->close();
} else {
    // Handle case if name, password, or country are not set
    echo "Please enter both name, password, and country";
}
?>
