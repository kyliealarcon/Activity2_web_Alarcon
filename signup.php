<?php
// Database connection 
$conn = new mysqli("localhost", "root", "", "activity2_web_alarcon");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Run  submitted
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname  = $conn->real_escape_string($_POST['lastname']);
    $email     = $conn->real_escape_string($_POST['email']);
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $password);

    if ($stmt->execute()) {
        // Redirect to login.php after successful registration
        header("Location: login.php");
        exit();
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .register-box {
      width: 400px;
      max-width: 90%;
      padding: 25px;
      border: 1px solid #ccc;
      background: #fff;
      box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
      border-radius: 6px;
    }
    .register-box h2 {
      text-align: left;
      margin-bottom: 20px;
      font-size: 22px;
      color: #090909;
    }
    .register-box label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      font-size: 14px;
      color: #333;
    }
    .register-box input[type="text"],
    .register-box input[type="email"],
    .register-box input[type="password"] {
      width: 100%;
      padding: 8px;
      margin-bottom: 14px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
      outline: none;
      box-sizing: border-box;
    }
    .register-box input:focus {
      border-color: #f21885;
      box-shadow: 0 0 3px rgba(231, 24, 242, 0.3);
    }
    .name-row {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }
    .name-row div {
      flex: 1;
    }
    .btn-register {
      display: block;
      width: 100%;
      padding: 10px;
      background: #c618f2;
      color: white;
      text-align: center;
      text-decoration: none;
      border: none;
      cursor: pointer;
      border-radius: 5px;
      font-size: 15px;
      font-weight: bold;
      transition: background 0.2s ease;
      margin-top: 10px;
    }
    .btn-register:hover {
      background: #bf1478;
    }
    .message {
      margin-top: 15px;
      font-size: 14px;
      color: green;
    }
    .login-link {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }
    .login-link a {
      color: #c618f2;
      font-weight: bold;
      text-decoration: none;
    }
    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="register-box">
    <h2>Register now</h2>

    <?php if ($message != ""): ?>
      <p class="message"><?= $message ?></p>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="name-row">
        <div>
          <label for="firstname">First Name</label>
          <input type="text" id="firstname" name="firstname" placeholder="First name" required>
        </div>
        <div>
          <label for="lastname">Last Name</label>
          <input type="text" id="lastname" name="lastname" placeholder="Last name" required>
        </div>
      </div>

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="Enter your email address" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter your password" required>

      <button type="submit" class="btn-register">Sign Up</button>
    </form>

    <!-- Login link -->
    <p class="login-link">
      Already have an account? <a href="login.php">Login here</a>
    </p>
  </div>
</body>
</html>
