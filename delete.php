
<?php
// Check if ID is provided in URL parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];

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

    // Delete the record from the database
    $delete = "DELETE FROM userdetails WHERE id = $id";

    if ($conn->query($delete) === TRUE) {
        // Redirect to read.php page after successful delete
        header("Location: read.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No ID provided.";
}
?>
