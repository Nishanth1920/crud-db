<?php
// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "nichu100";
$dbname = "cruddb";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Select the database
    $conn->select_db($dbname);

    // ...............................CREATE DATABASE......................................

    // Create database
    $createdb = "CREATE DATABASE IF NOT EXISTS cruddb";
    if ($conn->query($createdb) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    // ...............................DROP DATABASE.........................................

    // Database name to drop
    // $databaseName = "cruddb";

    // // Drop database
    // $dropdb = "DROP DATABASE IF EXISTS $databaseName";

    // if ($conn->query($dropdb) === TRUE) {
    //     echo "<br>Database dropped successfully";
    // } else {
    //     throw new Exception("Error dropping database: " . $conn->error);
    // }

    // ...............................CREATE A TABLE........................................

    // SQL query to create or alter a table
    $create = "CREATE TABLE IF NOT EXISTS userdetails (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        country VARCHAR(30) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(50)
    )";

    // Execute query
    if ($conn->query($create) === TRUE) {
        echo "<br>Table created successfully";
    } else {
        throw new Exception("Error creating table: " . $conn->error);
    }

    // ...............................ALTER A TABLE.......................................

    // $alt = "ALTER TABLE userdetails CHANGE username name  VARCHAR(255) NOT NULL";

    // // Execute query
    // if ($conn->query($alt) === TRUE) {
    //     echo "<br>Table altered successfully";
    // } else {
    //     throw new Exception("Error altering table: " . $conn->error);
    // }

    // ...............................DROP A TABLE.........................................

    // Table to drop
    // $tableName = "userdetails";

    // // SQL query to drop the table
    // $drop = "DROP TABLE IF EXISTS $tableName";

    // // Execute query
    // if ($conn->query($drop) === TRUE) {
    //     echo "<br>Table dropped successfully";
    // } else {
    //     throw new Exception("Error dropping table: " . $conn->error);
    // }

    // ...............................INSERT TO A TABLE....................................

    // Data to insert
    // $firstname = "nichu";
    // $lastname = "M";
    // $email = "nicknishanth100@gmail.com";
    // $country = "India";
    // $mobile_no="7092444728";

    // // SQL query to insert data
    // $insert = "INSERT INTO userdetails (firstname, lastname, email,country,mobile_no) VALUES ('$firstname', '$lastname', '$email','$country','$mobile_no')";

    // // Execute the query
    // if ($conn->query($insert) === TRUE) {
    //     echo "<br>Data inserted successfully";
    // } else {
    //     throw new Exception("Error inserting data: " . $conn->error);
    // }

    // ...............................DELETE TABLE QUERIES....................................

    // SQL query to delete first two rows
    // $deleteQuery = "DELETE FROM userdetails ORDER BY id LIMIT 5";

    // // Execute query
    // if ($conn->query($deleteQuery) === TRUE) {
    //     echo "<br>First two rows deleted successfully";
    // } else {
    //     throw new Exception("Error deleting rows: " . $conn->error);
    // }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    // Close connection
    if (isset($conn)) {
        $conn->close();
    }
}
