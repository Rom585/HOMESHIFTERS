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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Transaction</title>
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
            <li><a href="Quote_Section.php" >Quotes</a></li>
            <li><a href="Process_Section.php" >Processing</a></li>
            <li><a href="Customer_Section.php" >Customers</a></li>
            <li><a href="Recent_Section.php" class="active">Recent Transactions</a></li>
            <li><a href="#" data-toggle="modal" data-target="#profileModal">Profile</a></li>
        </ul>
    </div>
    <!--Main Content-->
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
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM approved_moving");
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
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM approved_storage");
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
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
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
</html>