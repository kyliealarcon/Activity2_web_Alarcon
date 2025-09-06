<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "activity2_web_alarcon");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Find user by email
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            header("Location: homepage.php");
            exit();
        } else {
            $error = " Invalid password.";
        }
    } else {
        $error = " No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  
</head>
<body>
  <div class="login-box">
    <h2>WELCOME</h2>

    <?php if ($error != ""): ?>
      <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" placeholder="Enter your email" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Enter your password" required>

      <div class="agree">
        <input type="checkbox" id="agree" required>
        <label for="agree">I agree to the Terms & Conditions</label>
      </div>

      <button type="submit" class="btn-login">Log in</button>
    </form>
  </div>
</body>
</html>
