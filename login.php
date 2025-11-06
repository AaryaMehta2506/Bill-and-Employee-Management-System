<?php
session_start();
include 'dbcon.php';

//if already logged in → go directly to dashboard
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

//login when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($mail) || empty($password)) {
        $_SESSION['message'] = "Please enter both email and password.";
    } else {
        $sql = "SELECT * FROM register WHERE Email = ? AND Password = ?";
        $params = [$mail, $password];
        $stmt = sqlsrv_query($con, $sql, $params);

        if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $_SESSION['user'] = $row;
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['message'] = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Outfit', sans-serif;
      background-color: #f5f7fb;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-box {
      background: #ffffff;
      width: 380px;
      padding: 40px 35px;
      border-radius: 10px;
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
      text-align: center;
    }
    .form-box h2 {
      margin-bottom: 25px;
      font-weight: 700;
      color: #293b5f;
    }
    .form-control {
      border-radius: 8px;
      height: 45px;
    }
    .btn-success {
      background-color: #293b5f;
      border: none;
      font-weight: 600;
      border-radius: 8px;
      height: 45px;
    }
    .btn-success:hover {
      background-color: #153673ff;
    }
    a {
      color: #293b5f;
      text-decoration: none;
      font-weight: 600;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h2 class="text-center mb-4">Login</h2>

    <?php if (isset($_SESSION['message'])): ?>
      <div class="alert alert-info text-center">
        <?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
      </div>
    <?php endif; ?>

    <!-- Login form -->
    <form method="POST" action="login.php">
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" required />
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required />
      </div>
      <button type="submit" class="btn btn-success w-100">Login</button>
    </form>

    <div class="text-center mt-3">
      <a href="register.php">Register</a>
    </div>
  </div>
</body>
</html>
