<?php
// start session if not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// detect if user is on mobile
$isMobile = false;
if (preg_match('/(android|iphone|ipad|ipod|blackberry|opera mini|iemobile|mobile)/i', $_SERVER['HTTP_USER_AGENT'])) {
    $isMobile = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CDN where link is in head part and its script is in body part -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- boxicon CDN -->
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <!-- to connect css file -->
    <link rel="stylesheet" href="style.css"> 

</head>
<body>
<div class="wrapper">
    <!-- Sidebar -->
    <aside id="sidebar" class="<?php echo $isMobile ? '' : 'expand'; ?>">
        <div class="d-flex justify-content-between p-4">
            <div class="sidebar-logo">
                <a href="#">Suyog</a>
            </div>
            <button class="toggle-btn border-0" type="button">
                <i id="icon" class='bx bxs-chevrons-left'></i>
            </button>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-item"><a href="dashboard.php" class="sidebar-link"><i class='bxr bx-user'></i><span>Profile</span></a></li>
            <li class="sidebar-item"><a href="#" class="sidebar-link"><i class='bxr bx-list-ul'></i><span>Task</span></a></li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth">
                    <i class='bxr bx-bug'></i><span>Auth</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse">
                    <li class="sidebar-item"><a href="login.php" class="sidebar-link">Login</a></li>
                    <li class="sidebar-item"><a href="register.php" class="sidebar-link">Register</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#multi">
                    <i class='bx-bar-chart-big'></i><span>Multi</span>
                </a>
                <ul id="multi" class="sidebar-dropdown list-unstyled collapse">
                    <li class="sidebar-item"><a href="employee.php" class="sidebar-link">Employee</a></li>
                    <li class="sidebar-item"><a href="bill.php" class="sidebar-link">Bill</a></li>
                </ul>
            </li>
            <li class="sidebar-item"><a href="#" class="sidebar-link"><i class='bxr bx-bell-ring'></i><span>Notification</span></a></li>
            <li class="sidebar-item"><a href="#" class="sidebar-link"><i class='bxr bx-cog'></i><span>Setting</span></a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="logout.php" class="sidebar-link"><i class='bx bx-arrow-out-left-square-half'></i><span>Logout</span></a>
        </div>
    </aside>

    <div class="main">
        <nav class="navbar navbar-expand px-4 py-3">
            <form action="#" class="d-none d-sm-inline-block">
                <div class="input-group input-group-navbar">
                    <input type="text" class="form-control border-0 rounded-0 pe-0" placeholder="Search....." aria-label="Search">
                    <button class="btn border-0 rounded-0" type="button"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <div class="navbar-collapse collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                            <img src="account.png" class="avatar img-fluid" alt="">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow mt-3">
                            <a href="#" class="dropdown-item"><i class='bx bx-database-alt'></i><span>Analytics</span></a>
                            <a href="#" class="dropdown-item"><i class='bx bx-cog'></i><span>Setting</span></a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item"><i class='bx bx-help-circle'></i><span>Help Center</span></a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
