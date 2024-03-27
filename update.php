<?php
// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $cpassword = $_POST['password'];

    // Connect to your database
    $servername = "localhost";
    $username = "root";
    $password = "nichu100";
    $dbname = "cruddb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the record in the database
    $update = "UPDATE userdetails SET name='$name', email='$email', country='$country' ,password='$cpassword' WHERE id=$id";

    if ($conn->query($update) === TRUE) {
        // Redirect to read.php page after successful update
        header("Location: read.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No data submitted.";
}
?>
