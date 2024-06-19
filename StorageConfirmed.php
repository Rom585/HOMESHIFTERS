<?php

session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Get the logged-in user's ID from the session
$user_id = $_SESSION['customer_id'];

// Fetch user data from the database
$sql = "SELECT fullname, email FROM customers WHERE id = $user_id";
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Storage Confirmed</title>
    <!--Icons-->
    <link rel="stylesheet" type="text/css" href="Confirmed.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"/>
    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <a href="Homepage.php" class="logo">Home<span>Shifters</span></a>

    <ul class="navbar">
        <li><a href="Homepage.php">Home</a></li>
        <li><a href="BrochurePage.php">Brochure</a></li>
        <li><a href="About.php">About</a></li>
        <li class="dropdown">
            <a href="#" class="dropbtn">Services</a>
            <div class="dropdown-content">
                <a href="Services.php">Moving Services</a>
                <a href="StorageService.php">Storage Services</a>
            </div>
        </li>
        <li><a href="Contact.php">Contact</a></li>
        <li><a href="#" data-toggle="modal" data-target="#profileModal">Profile</a></li>
    </ul>
</header>

<section class="booking-confirmed">
    <div class="Confirm">
        <h1>Your Storage Quote is Confirmed!</h1>
        <p>Thank you for choosing HomeShifters for your household move. Your quote details are as follows:</p>
    </div>

    <?php
    include('config.php');

    $query = "SELECT fullname, email, phone_number, quote_date, storage_date, storage_location, storage_package FROM storage ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $storage_package = htmlspecialchars($row['storage_package']);
        ?>

        <table class="summary-table">
            <tr>
                <td>Moving Details:</td>
                <td>
                    <ul>
                        <li><strong>Name:</strong> <?php echo htmlspecialchars($row['fullname']); ?></li>
                        <li><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></li>
                        <li><strong>Phone Number:</strong> <?php echo htmlspecialchars($row['phone_number']); ?></li>
                        <li><strong>Quote Date:</strong> <?php echo htmlspecialchars($row['quote_date']); ?></li>
                        <li><strong>Storage Date:</strong> <?php echo htmlspecialchars($row['storage_date']); ?></li>
                        <li><strong>Preffered Location:</strong> <?php echo htmlspecialchars($row['storage_location']); ?></li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>Service:</td>
                <td>
                    <ul>
                        <li><strong>Storage Package:</strong> <?php echo htmlspecialchars($row['storage_package']); ?></li>
                    </ul>
                </td>
            </tr>
            <tr>
            <td>Amount:</td>
            <td>
                <ul>
                    <li><strong>Price Range:</strong> <span id="priceRange"></span></li>
                </ul>
            </td>
            </tr>
        </table>
        <div class="button-container">
            <form action="StorageQuote.php">
                <button type="confirm" class="button">Confirm</button>
            </form>
        </div>
        <script>
            const selectedPackage = '<?php echo $storage_package; ?>';

            function updatePrice() {
                const priceRangeElement = document.getElementById('priceRange');

                let price = '-------------------------------------';
                if (selectedPackage === 'Short-Term Package') {
                    price = '3000';
                } else if (selectedPackage === 'Medium-Term Package') {
                    price = '6000';
                } else {
                    price = '10000';
                }

                priceRangeElement.textContent = price;
            }

            // Initialize the price on page load
            window.onload = updatePrice;
        </script>
        <?php
    } else {
        echo "<p>No booking details found.</p>";
    }
    
    // Close the connection
    mysqli_close($conn);
    
    ?>
    

    <p>If you have any questions or need to make changes to your Quote, please contact us at (+63) 997 360 3101 
        / (+63) 961 207 3502 / homeshifters@gmail.com.</p>
    <p>We're here to help!</p>
</section>

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
                </div>
            </div>
        </div>
    </div>

<footer class="footer">
    <div class="footer-box">
        <h3>About</h3>
        <a href="#">Our story</a>
        <a href="#">Benefits</a>
        <a href="#">Team</a>
        <a href="#">Careers</a>
    </div>

    <div class="footer-box">
        <h3>Help</h3>
        <a href="#">FAQs</a>
        <a href="#">Contact Us</a>
    </div>

    <div class="footer-box">
        <h3>Social Media</h3>
        <div class="social">
            <a href="#"><i class="ri-instagram-line"></i></a>
            <a href="#"><i class="ri-twitter-x-line"></i></a>
            <a href="#"><i class="ri-facebook-fill"></i></a>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>