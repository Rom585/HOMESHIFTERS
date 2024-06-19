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
    <title>Moving Service</title>
    <link rel="stylesheet" type="text/css" href="ServiceMoving.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <a class="logo">Home<span>Shifters</span></a>
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

    <section class="home"></section>

    <!--Household section design-->
    <div class="household">
        <h2>Household Moving Service</h2>
    </div>
    <div class="household">
        <p>Packing up and moving your life (and oftentimes the lives of others) from one home to another can be stressful and tiring, but the HomeShifters team is prepared to work with you and your family to make sure everything gets where it needs to be when it needs to be there. From our basic to additional household services, including unpacking services, we have everything you need and more to get the job done right the first time, ensuring a stress-free move.</p>
    </div>
    <section class="holiday">
        <div class="holiday-img">
            <img src="small.avif">
        </div>

        <div class="holiday-text">
            <h2>Basic Package</h2></a>
            <p>✔ Distance: Within the city limits. 
                <br> ✔ Services include packing materials, transportation,  loading and unloading.<br> 
                ✔ Price Range: ₱4,000 - ₱6,000
            </p>
            
        </div>

        <div class="holiday-text">
            <h2>Premium Package</h2></a>
            <p> ✔ Distance: Across city limits or neighboring cities. <br>
                ✔ Services include packing materials, transportation, loading and unloading, assembly of furniture.<br> 
                ✔ Price Range: ₱6,000 - ₱8,500
            </p>
            
        </div>

        <div class="holiday-img">
            <img src="medium.avif">
        </div>

        <div class="holiday-img">
            <img src="executive.jpg">
        </div>

        <div class="holiday-text">
            <h2>Executive Package</h2></a>
            <p> ✔ Tailored for large households with extensive belongings or long-distance moves.<br>
                ✔ Distance: Across Luzon Region. <br>
                ✔ Services include premium packing materials, transportation, loading and unloading, furniture assembly, specialized handling of fragile items.<br> 
                ✔ Price Range: ₱12,000 - NEGOTIABLE
            </p>
            
        </div>
    </section>

    <!-- Lower Section -->
    <section class="lower">
        <div class="lower-content">
            <div class="lower-text">
                <h2>Get Your Quote Now!</h2>
                <p>HomeShifters is the leading moving company in the Philippines. We offer a wide range of moving services to help you sail smoothly through your next move.</p>
                <h3>Or Call:</h3>
                <h2>+63 997 360 3101</h2>
                <a href="Quote.php" class="btn" >Quote</a>
            </div>

            
        </div>
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

    <!-- Footer -->
    <section class="footer">
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
    </section>

    <!-- Scripts -->
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>