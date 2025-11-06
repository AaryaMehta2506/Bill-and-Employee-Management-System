<?php
include 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $emp_id = $_POST['emp_id'];
    $mail = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    // echo $password; die;

    $sql = "INSERT INTO register (Name, Emp_ID, Email, Mobile, Password)
            VALUES ('$name', '$emp_id', '$mail', '$mobile', '$password')";
    $stmt = sqlsrv_query($con, $sql);
    // echo $sql; die;
    if ($stmt) {
        echo "Registration complete";
    } else {
        echo "Registration failed";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
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
      width: 420px;
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
      background-color: #171573ff;
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
    <h2 class="text-center mb-4">Register</h2>
    
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php">
      <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="Name" required />
      </div>
      <div class="mb-3">
        <input type="text" name="emp_id" class="form-control" placeholder="Employee ID" required />
      </div>
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" required />
      </div>
      <div class="mb-3">
        <input type="tel" name="mobile" class="form-control" placeholder="Mobile" required />
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required />
      </div>
      <button type="submit" class="btn btn-success w-100">Register</button>
    </form>

    <!-- Login link -->
    <div class="text-center mt-3">
      <a href="index.php">Back to Login</a>
    </div>
  </div>
</body>
</html>
