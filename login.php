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
            header("Location: homepage.html");
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
    .login-box {
      width: 400px;
      max-width: 90%;
      padding: 25px;
      border: 1px solid #ccc;
      background: #fff;
      box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
      border-radius: 6px;
    }
    .login-box h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 22px;
    }
    .login-box label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      font-size: 14px;
      color: #333;
    }
    .login-box input[type="email"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 14px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
      outline: none;
      box-sizing: border-box;
    }
    .login-box input:focus {
      border-color: #f21885;
      box-shadow: 0 0 3px rgba(231, 24, 242, 0.3);
    }
    .login-box .agree {
      display: flex;
      align-items: center;
      font-size: 13px;
      margin-bottom: 16px;
      color: #444;
    }
    .login-box .agree input {
      margin-right: 8px;
    }
    .btn-login {
      display: block;
      width: 50%;
      margin: 0 auto;
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
    }
    .btn-login:hover {
      background: #bf1478;
    }
    .error {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
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
