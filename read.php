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
    <title>CRUD-Users</title>
    <!-- cdn for pagination and sort implementation in way better -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- cdn for a bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        div {
            margin-bottom: 5px;
        }

        .container {
            margin-top: 20px;
            width: 85%;
        }
    </style>
</head>

<body style="background-image: url(https://img.freepik.com/free-vector/gradient-blur-pink-blue-abstract-background_53876-117324.jpg?w=740&t=st=1710478849~exp=1710479449~hmac=c1b2c5635922a7aaf7cef296aa08fd60ee84c8f446efb780c0951b07b2b7289a);">

    <body>

        <div class="container p-4">
            <div>
                <h3>Existing Users</h3>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal" style="margin-bottom: 10px;"> <i class="bi bi-person-fill-add"></i> Add User</a>
                <a href="logout.php" class="btn btn-danger" style="margin-bottom: 10px;"><i class="bi bi-box-arrow-left"></i> Log Out</a>
            </div>

            <table class="table table-hover shadow-lg p-3 mb-5 bg-body rounded" id="userTable" style="cursor: pointer;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php


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


                    // Fetch data from the database
                    $fetch = "SELECT id, name, email, country ,password FROM userdetails";
                    $result = $conn->query($fetch);

                    // Display data in table rows
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["country"] . "</td>";
                            echo "<td>" . $row["password"] . "</td>";
                            echo "<td>
                                    <a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'><i class='bi bi-pencil'></i> Edit</a>
                                    <button class='btn btn-danger btn-sm delete-btn' data-id='" . $row["id"] . "' data-bs-toggle='modal' data-bs-target='#deleteModal'><i class='bi bi-trash'></i> Delete</button>

                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No data found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- ......................................addUser Modal......................................... -->

        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">CRUD-New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addUserForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                                <div class="invalid-feedback">Name is required</div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <div class="invalid-feedback">Email is required</div>
                            </div>
                            <div class="mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country">
                                <div class="invalid-feedback">Country is required</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <div class="invalid-feedback">Password is required</div>
                            </div>
                            <div id="addError" class="alert alert-danger d-none" role="alert"></div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-plus"></i> Add</button>
                            <a href="read.php" class="btn btn-secondary btn-md active" class="btn-close" data-bs-dismiss="modal" aria-label="Close" role="button" aria-pressed="true">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- .......................................Delete Modal......................................... -->

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Record</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this record?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#userTable').DataTable({
                    "lengthMenu": [
                        [-1, 20, 15, 10],
                        ["All", 20, 15, 10]
                    ], // Custom entries for number of records per page
                    "searching": true, // Enable search functionality
                    "paging": true // Enable pagination
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                // Handle delete button click
                $('.delete-btn').click(function() {
                    var id = $(this).data('id');
                    $('#confirmDeleteBtn').attr('href', 'delete.php?id=' + id);
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#addUserForm').submit(function(e) {
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

                    $.ajax({
                        type: 'POST',
                        url: 'adduserError.php',
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response === 'success') {
                                // Reload the page to reflect the new user
                                location.reload();
                            } else {
                                $('#addError').removeClass('d-none').text(response);
                            }
                        }
                    });
                });
            });
        </script>






    </body>

</html>