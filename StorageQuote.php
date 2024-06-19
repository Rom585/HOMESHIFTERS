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

if(isset($_POST['btnSave'])){
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $quote_date = date('Y-m-d', strtotime($_POST['quote_date']));
    $storage_date = date('Y-m-d', strtotime($_POST['storage_date']));
    $storage_location = mysqli_real_escape_string($conn, $_POST['storage_location']);
    $storage_package = mysqli_real_escape_string($conn, $_POST['storage_package']);

    $stmt = mysqli_prepare($conn, "INSERT INTO storage (fullname, email, phone_number, quote_date, storage_date, storage_location, storage_package) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssssss", $fullname, $email, $phone_number, $quote_date, $storage_date, $storage_location, $storage_package);
    mysqli_stmt_execute($stmt);

    if(mysqli_stmt_affected_rows($stmt) > 0){
        ?>
        <script>window.alert('Record Saved');</script>
        <script>window.location='StorageConfirmed.php';</script>
        <?php
    }else{
        echo mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Storage Quote</title>
    <!--Icons-->
    <link rel="stylesheet" type="text/css" href="QuoteStorage.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"/>
    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>

<!--Header design-->
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

<!--Fill up section design-->
<section class="fill-up">
    <div class="container">
        <h1>CONTINUE YOUR FREE STORAGE QUOTE HERE</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="input-box">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" placeholder="First M. Last" value="<?php echo htmlspecialchars($fullname); ?>" required>
            </div>
            <div class="input-box">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="input-box">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" id="phone_number" name="phone_number" placeholder="(123) 456-7890" required>
            </div>
            <div class="input-box">
                <label for="moving_date">Quote Date:</label>
                <input type="date" id="quote_date" name="quote_date" value="<?php echo date('Y-m-d');?>" readonly>
            </div>
            <div class="input-box">
                <label for="storage_date">Storage Date:</label>
                <input type="date" id="storage_date" name="storage_date" required>
            </div>
            <div class="input-box">
                <label for="storage_location">Preferred Location:</label>
                <select id="storage_location" name="storage_location" required>
                    <option value="">Select an option</option>
                    <option value="Tuguegarao City">Tuguegarao City</option>
                    <option value="Manila">Manila</option>
                </select>
            </div>
            <div class="input-box">
                <label for="storage_package">Storage Service Package:</label>
                <select id="storage_package" name="storage_package" required>
                    <option value="">Select an option</option>
                    <option value="Short-Term Package">Short-Term Package</option>
                    <option value="Medium-Term Package">Medium-Term Package</option>
                    <option value="Long-Term Package">Long-Term Package</option>
                </select>
            </div>
            <div class="input-box">
                <h4>By pressing the submit button below, I give HomeShifters consent to use automated telephone dialing technology to call and/or use SMS text messages at the phone number provided including a wireless number for telemarketing purposes. I understand consent is not a condition of purchase of HomeShifters services.</h4>
                <label>
                    <input type="checkbox" id="myCheckBox" required>
                    I agree to the terms and conditions
                </label>
            </div>
            <button type="submit" class="button" id="btnSave" name="btnSave" disabled>Submit</button>
        </form>
    </div>
</section>

<!--lower section design-->
<section class="lower">
    <div class="lower-content">
        <div class="lower-text">
            <h2>Get Your Quote Now!</h2>
            <p>HomeShifters is the leading moving company in the Philippines. We offer a wide range of moving services to help you sail smoothly through your next move.</p>
            <h3>Or Call:</h3>
            <h2>+63 997 360 3101</h2>
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

<!--Footer section design-->
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
<script>
    // Enable submit button only when checkbox is checked
    document.getElementById('myCheckBox').addEventListener('change', function() {
        document.getElementById('btnSave').disabled = !this.checked;
    });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>