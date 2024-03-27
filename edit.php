<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD-Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-image: url(https://img.freepik.com/free-vector/gradient-blur-pink-blue-abstract-background_53876-117324.jpg?w=740&t=st=1710478849~exp=1710479449~hmac=c1b2c5635922a7aaf7cef296aa08fd60ee84c8f446efb780c0951b07b2b7289a);">

    <div class="container" style="margin-top: 50px; width: 50%;">
        <h3>CRUD-Edit user</h3><br>
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

            // Fetch data of the record to be edited
            $edit = "SELECT name, email, country, password FROM userdetails WHERE id = $id";
            $result = $conn->query($edit);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        ?>
                <div class="card shadow-lg p-3 mb-5 bg-body rounded">
                    <div class="card-body">
                        <form method="POST" action="update.php">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Country</label>
                                <input type="text" class="form-control" name="country" value="<?php echo $row['country']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Password</label>
                                <input type="text" class="form-control" name="password" value="<?php echo $row['password']; ?>">
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="read.php"><button type="submit" class="btn btn-danger">Cancel</button></a>
                        </form>
                    </div>
                </div>
                <?php
            } else {
                echo "No user found with ID: $id";
            }

            $conn->close();
        } else {
            echo "No ID provided.";
        }
                ?>
                    </div>

</body>

</html>