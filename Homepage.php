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
    <title>Home Shifters</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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

    <!-- Hero Section -->
    <section class="home">
        <div class="home-text">
            <h5>WHEN IT COMES TO MOVING,</h5>
            <h1>We can do it.</h1>
            <p>Moving into a new home sounds good in almost all aspects: it signifies a new chapter, a change of ways, and in some cases, it means the fulfillment of a dream. While all of these sound exciting, the actual process of packing or moving into a new space, isn’t much so. Admit it—just thinking about the boxes waiting to be filled, the papers to be signed, and transporting everything your past space contained can be stressful.</p>
            <a href="Quote.php" class="btn">Quote now</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="feature">
        <div class="feature-content">
            <div class="row">
                <div class="row-img">
                    <a href="Services.php"><img src="2.jpg"></a>
                </div>
                <a href="Services.php"><h4>Household Moving Service</h4></a>
                <h6>Every family's moving needs are unique. Our professional movers are here to help.</h6>
            </div>

            <div class="row">
                <div class="row-img">
                    <a href="StorageService.php"><img src="3.jpg"></a>
                </div>
                <a href="StorageService.php"><h4>Storage Service</h4></a>
                <h6>Your storage needs, our personalized solutions. Let us simplify your space.</h6>
            </div>
        </div>
    </section>

    <!-- Holiday Section -->
    <section class="holiday">
        <div class="holiday-img">
            <img src="4.jpg">
        </div>

        <div class="holiday-text">
            <h2>You’ll have one of the best moving company working for you.</h2>
            <p>With 24 hours customer service and an ability to offer quality moving services on the local and long distance level, HomeShifters offers unmatched resources to help you sail smoothly through your next move.</p>
            <a href="About.php" class="btn">Learn more</a>
        </div>
    </section>

    <!-- Analysis Section -->
    <section class="analysis">
        <div class="center-text">
            <h2>Numbers Don't Lie</h2>
        </div>

        <div class="analysis-content">
            <div class="box">
                <img src="icon-truck.png">
                <h4>350,000</h4>
                <h6>Total Moves in the Philippines</h6>
            </div>

            <div class="box">
                <img src="icon-ribbon.png">
                <h4>95</h4>
                <h6>Experience</h6>
            </div>

            <div class="box">
                <img src="icon-check.png">
                <h4>96%</h4>
                <h6>Satisfaction Rate</h6>
            </div>

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
            </div>

            <form action="">
                <h4>Moving From:</h4>
                <input type="MoveFrom" placeholder="Address/Zip Code" required>
                <h4>Moving To:</h4>
                <input type="MoveTo" placeholder="Address/Zip Code" required>
                <a href="Quote.html" class="btn" >Next</a>
            </form>
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