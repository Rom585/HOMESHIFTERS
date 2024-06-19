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
    <title>About</title>
    <link rel="stylesheet" type="text/css" href="AboutDesign.css">
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

    <div class="Learn">
        <h2>Full Service Moving Company</h2>
        <p>When it comes to getting your belongings where they need to be – whether it’s a new residence, new office building, or even a new country – Allied Van Lines is committed to taking the hassle out of your full-service move with convenience and efficiency as a priority.<br><br>Our moving company's professional movers will help you plan and organize your move before the first item is packed to ensure things go smoothly and keep the disruption of your everyday life to a minimum. Once the moving plan is in place, you can count on our dedicated staff to handle everything from disassembling furniture and packing items to the more strenuous work of the actual moving process. Whatever your moving needs may be, Allied Van Lines is more than ready to meet them with excellence and professional service.</p>
    </div>

    <section class="mission">
        <div class="mission-img">
            <div class="mission-text">
                <h2>OUR MISSION</h2>
                <p>Delivering effortless moving experiences with reliable services and storage, prioritizing care, professionalism, and peace of mind for our clients.</p>
            </div>
        </div>
        <div class="vision-img">
            <div class="vision-text">
                <h2>OUR VISION</h2>
                <p>Leading household movers, committed to customer satisfaction, operational excellence, and innovation, empowering transitions with confidence.</p>
            </div>
        </div>
        <div class="objective-img">
            <div class="objective-text">
                <h2>OBJECTIVES</h2>
                <p>- To ensure timely and professional relocation and storage services.</p>
                <p>- To uphold high standards of safety, efficiency, and dependability in every aspect of our operations.</p>
                <p>- To integrate eco-conscious practices into our processes to minimize environmental impact.</p>
                <p>- To foster collaborative partnerships to enhance service quality and innovation.</p>
                <p>- To strive for excellence by consistently surpassing customer expectations and delivering unparalleled satisfaction.</p>
            </div>
        </div>
        <br>
        <div class="organization-img" >
            
        </div>
        <div class="why-text">
            <h2>Why HomeShifters?</h2>
            <p>We provide the most inclusive moving services to our customers, and there is nothing we won't do for your move. We pride ourselves as a moving company with the best customer service reputation, and each of our valued customers receives a personalized moving experience. There may be other moving companies, but none retain the outstanding customer appreciation we do.</p>
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