<?php
    // Start the session
    session_start();

    // Include your database configuration file
    include('config.php');

    // Initialize variables for error messages
    $loginError = '';

    // Handle login form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
      // Retrieve user input
      $email = $_POST['email'];
      $password = $_POST['password'];
  
      // Query to retrieve customer information based on email
      $customerSql = "SELECT * FROM customers WHERE email = '$email' AND password = '$password'";
      $customerResult = mysqli_query($conn, $customerSql);
  
      // Query to retrieve admin information based on email
      $adminSql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
      $adminResult = mysqli_query($conn, $adminSql);
  
      if(mysqli_num_rows($customerResult) == 1) {
          $row = mysqli_fetch_assoc($customerResult);
          // Set session for customer
          $_SESSION['customer_id'] = $row['id']; // Assuming 'id' is the column name for customer ID
          header("Location: Homepage.php");
          exit();
      } elseif(mysqli_num_rows($adminResult) == 1) {
          $row = mysqli_fetch_assoc($adminResult);
          // Set session for admin
          $_SESSION['admin_id'] = $row['id']; // Assuming 'id' is the column name for admin ID
          header("Location: AdminUi.php");
          exit();
      } else {
          // User with the given email and password does not exist
          $loginError = 'Invalid email or password';
      }
  }  

// Handle signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signupFullName']) && isset($_POST['signupEmail']) && isset($_POST['signupPassword'])) {
  // Retrieve user input
  $fullName = $_POST['signupFullName'];
  $email = $_POST['signupEmail'];
  $password = $_POST['signupPassword']; // Plain text password

  // Check if the email already exists in the database for customers
  $checkCustomerEmailQuery = "SELECT * FROM customers WHERE email = '$email'";
  $checkCustomerEmailResult = mysqli_query($conn, $checkCustomerEmailQuery);

  // Check if the email already exists in the database for admins
  $checkAdminEmailQuery = "SELECT * FROM admin WHERE email = '$email'";
  $checkAdminEmailResult = mysqli_query($conn, $checkAdminEmailQuery);

  if (mysqli_num_rows($checkCustomerEmailResult) > 0 || mysqli_num_rows($checkAdminEmailResult) > 0) {
      // Email already exists, handle the error (e.g., display a message to the user)
      // You can redirect back to the signup page with an error message
      echo "Email already exists!";
      exit(); // or redirect
  }

  // Insert user into the appropriate table (customers or admin)
  if ($fullName == "cicsesmer") {
      // If the full name is "admin", insert into the admin table
      $adminSql = "INSERT INTO admin (fullname, email, password) VALUES ('$fullName', '$email', '$password')";
      if(mysqli_query($conn, $adminSql)) {
          header("Location: login.php");
          exit();
      } else {
          // Signup failed
          // Handle error (e.g., display error message)
          echo "Admin signup failed: " . mysqli_error($conn);
          exit();
      }
  } else {
      // For regular customers, insert into the customers table
      $customerSql = "INSERT INTO customers (fullname, email, password) VALUES ('$fullName', '$email', '$password')";
      if(mysqli_query($conn, $customerSql)) {
          header("Location: login.php");
          exit();
      } else {
          // Signup failed
          // Handle error (e.g., display error message)
          echo "Customer signup failed: " . mysqli_error($conn);
          exit();
      }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons-1.11.2/font/bootstrap-icons.min.css"/>
</head>
<body>

<section class="landing">
    <div class="logo">
        <img src="hs_logo.png" alt="Your Logo">
    </div>
    <div class="landing-content">
        <p style="color: #000000;">Welcome to <b style="color: #FFFFFF;">Home<span><span style="color: #FF8D1F;">Shifters</span></b></span>
            Login or Sign Up to Explore our Services. 
        </p>
        <div class="cta-buttons">
            <a href="#loginModal" class="btn" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
            <a href="#signupModal" class="btn" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</a>
        </div>
    </div>
</section>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Login form goes here -->
        <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <div class="mb-3">
            <label for="loginEmail" class="form-label">Email address</label>
            <input type="email" class="form-control" id="loginEmail" name="email" aria-describedby="emailHelp" required>
          </div>
          <div class="mb-3">
            <label for="loginPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="loginPassword" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Signup Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Signup form goes here -->
        <form id="signupForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return signup(event)">
          <div class="mb-3 row">
            <div class="col">
              <label for="signupFullName" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="signupFullName" name="signupFullName" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="signupEmail" class="form-label">Email address</label>
            <input type="email" class="form-control" id="signupEmail" name="signupEmail" aria-describedby="emailHelp" required>
          </div>
          <div class="mb-3">
            <label for="signupPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="signupPassword" name="signupPassword" required>
          </div>
          <div class="mb-3">
            <label for="signupRetypePassword" class="form-label">Retype Password</label>
            <input type="password" class="form-control" id="signupRetypePassword" required>
            <div id="passwordError" class="text-danger"></div>
          </div>
          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="termsCheckbox" required>
            <label class="form-check-label" for="termsCheckbox">I agree to the <a href="#" target="_blank">Terms and Conditions</a> and <a href="#" target="_blank">Privacy Policy</a></label>
          </div>
          <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
  function signup(event) {
    var password = document.getElementById("signupPassword").value;
    var retypePassword = document.getElementById("signupRetypePassword").value;

    if (password !== retypePassword) {
      document.getElementById("passwordError").innerText = "Passwords do not match";
      return false; // Prevent form submission
    } else {
      document.getElementById("passwordError").innerText = "";
      return true; // Allow form submission
    }
  }
</script>
</body>
</html>
