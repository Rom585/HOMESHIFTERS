<?php
    session_start();
    include('config.php');
    
    // Check if the user is logged in
    if (!isset($_SESSION['admin_id'])) {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit;
    }
    
    // Get the logged-in user's ID from the session
    $admin_id = $_SESSION['admin_id'];
    
    // Fetch user data from the database
    $sql = "SELECT fullname, email FROM admin WHERE id = $admin_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fullname = $row['fullname'];
        $email = $row['email'];
    } else {
        // Handle case where no user data is found
        $fullname = "";
        $email = "";
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['process_moving'])) {
        $moving_to = $_POST['moving_to'];
        $moving_from = $_POST['moving_from'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $quote_date = date('Y-m-d', strtotime($_POST['quote_date']));
        $moving_date = date('Y-m-d', strtotime($_POST['moving_date']));
        $moving_package = $_POST['moving_package'];

        // Insert moving data into new database
        $sql = mysqli_query($conn, "INSERT INTO processed_moving (moving_to, moving_from, fullname, email, phone_number, quote_date, moving_date, moving_package) 
        VALUES ('$moving_to', '$moving_from', '$fullname', '$email', '$phone_number', '$quote_date', '$moving_date', '$moving_package')");
        
        // Delete the processed row from the original table
        $id = intval($_POST['id']);
        $sql = mysqli_query($conn, "DELETE FROM moving WHERE id = '$id'");
        if ($sql) {
            echo "<script>window.alert('Moving data processed and deleted successfully!'); window.location.href='AdminUi.php';</script>";
        } else {
            echo "<script>window.alert('Error deleting moving data: ); window.location.href='AdminUi.php.php';</script>";
        }
        $process->close();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['process_storage'])) {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $quote_date = date('Y-m-d', strtotime($_POST['quote_date']));
        $storage_date = date('Y-m-d', strtotime($_POST['storage_date']));
        $storage_location = $_POST['storage_location'];
        $storage_package = $_POST['storage_package'];

        // Insert moving data into new database
        $sql = mysqli_query($conn, "INSERT INTO processed_storage (fullname, email, phone_number, quote_date, storage_date, storage_location, storage_package) 
        VALUES ('$fullname', '$email', '$phone_number', '$quote_date', '$storage_date', '$storage_location', '$storage_package')");

        // Delete the processed row from the original table
        $id = intval($_POST['id']);
        $sql = mysqli_query($conn, "DELETE FROM storage WHERE id = '$id'");
        if ($sql) {
            echo "<script>window.alert('Moving data processed and deleted successfully!'); window.location.href='AdminUi.php';</script>";
        } else {
            echo "<script>window.alert('Error deleting moving data: ); window.location.href='AdminUi.php.php';</script>";
        }
        $process->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotes Section</title>
    <!--Icons-->
    <link rel="stylesheet" type="text/css" href="AdminUi.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"/>
    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
<div class="sidebar">
    <div class="logo">
        <a>Home<span>Shifters</span></a>
    </div>
    <ul class="nav">
        <li><a href="AdminUi.php" >Dashboard</a></li>
        <li><a href="Quote_Section.php" class="active">Quotes</a></li>
        <li><a href="Process_Section.php">Processing</a></li>
        <li><a href="Customer_Section.php">Customers</a></li>
        <li><a href="Recent_Section.php">Recent Transactions</a></li>
        <li><a href="#" data-toggle="modal" data-target="#profileModal">Profile</a></li>
    </ul>
</div>
<div class="main-content">
    <div class="header">
        <div class="search-box">
            <input type="search" placeholder="Search...">
            <button type="submit"><i class="ri-search-line"></i></button>
        </div>
    </div>
            <div class="data-grid-container">
                <h3>Household Moving Services</h3>
                <table class="data-grid">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Move To</th>
                        <th>Move From</th>
                        <th>Name</th>
                        
                        <th>Phone Number</th>
                        <th>Quote Date</th>
                        <th>Moving Date</th>
                        <th>Moving Package</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM moving");
                        while ($row = mysqli_fetch_array($sql)) {  
                        ?>
                    <tr>
                        <td><?php echo $row[0]; ?></td>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo $row[2]; ?></td>
                        <td><?php echo $row[3]; ?></td>
                       
                        <td><?php echo $row[5]; ?></td>
                        <td><?php echo $row[6]; ?></td>
                        <td><?php echo $row[7]; ?></td>
                        <td><?php echo $row[8]; ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                <input type="hidden" name="moving_to" value="<?php echo $row[1]; ?>">
                                <input type="hidden" name="moving_from" value="<?php echo $row[2]; ?>">
                                <input type="hidden" name="fullname" value="<?php echo $row[3]; ?>">
                                <input type="hidden" name="email" value="<?php echo $row[4]; ?>">
                                <input type="hidden" name="phone_number" value="<?php echo $row[5]; ?>">
                                <input type="hidden" name="quote_date" value="<?php echo $row[6]; ?>">
                                <input type="hidden" name="moving_date" value="<?php echo $row[7]; ?>">
                                <input type="hidden" name="moving_package" value="<?php echo $row[8]; ?>">
                                <button type="submit" class="process-btn" name="process_moving">Process</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>

                <h3>Storage Services</h3>
                <table class="data-grid">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        
                        <th>Phone Number</th>
                        <th>Quote Date</th>
                        <th>Storage Date</th>
                        <th>Preferred Location</th>
                        <th>Storage Package</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM storage");
                        while ($row = mysqli_fetch_array($sql)) {  
                        ?>
                    <tr>
                        <td><?php echo $row[0]; ?></td>
                        <td><?php echo $row[1]; ?></td>
                        
                        <td><?php echo $row[3]; ?></td>
                        <td><?php echo $row[4]; ?></td>
                        <td><?php echo $row[5]; ?></td>
                        <td><?php echo $row[6]; ?></td>
                        <td><?php echo $row[7]; ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                <input type="hidden" name="fullname" value="<?php echo $row[1]; ?>">
                                <input type="hidden" name="ema # #  il" value="<?php echo $row[1]; ?>">
                                <input type="hidden" name="phone_number" value="<?php echo $row[3]; ?>">
                                <input type="hidden" name="quote_date" value="<?php echo $row[4]; ?>">
                                <input type="hidden" name="storage_date" value="<?php echo $row[5]; ?>">
                                <input type="hidden" name="storage_location" value="<?php echo $row[6]; ?>">
                                <input type="hidden" name="storage_package" value="<?php echo $row[7]; ?>">
                                <button type="submit" class="process-btn" name="process_storage">Process</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Profile Modal -->
        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul>
                                <li>Name :  <?php echo htmlspecialchars($fullname); ?></li>
                                <li>Email :  <?php echo htmlspecialchars($email); ?></li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="logoutButton" ><a href="Logout.php">Log Out</a></button>
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scripts  -->
            <script src="script.js"></script>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</body>
</html>