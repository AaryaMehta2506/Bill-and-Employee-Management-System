<?php
session_start();
include 'dbcon.php';

$user = $_SESSION['user'];

if (isset($_POST['save'])) {
    //add new employee
    $emp_id     = $_POST['emp_id'];
    $name       = $_POST['name'];
    $department = $_POST['department'];
    $designation   = $_POST['designation'];
    $email      = $_POST['email'];
    $mobile_no      = $_POST['mobile_no'];
    $created_by = $user['Name'];

    //handle image upload
    $imageName = "";
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $imageName = time() . '_' . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
    }

    //which takes id when we add data
    $sqlid = "SELECT ISNULL(MAX(id),0) + 1 AS id from [employee]";
    $runid = sqlsrv_query($con, $sqlid);
    $rowid = sqlsrv_fetch_array($runid, SQLSRV_FETCH_ASSOC);
    $headId = $rowid['id'];

    $sql = "INSERT INTO employee (id, emp_id, name, department, designation, email, mobile_no, image, created_by) VALUES ('$headId', '$emp_id', '$name', '$department', '$designation', '$email', '$mobile_no', '$imageName', '$created_by')";
    $stmt = sqlsrv_query($con, $sql);
    

    if ($stmt) {
        echo "Insert Successfully!";
        header("Location: employee.php?message=Employee added successfully");
        exit;
    } else {
        echo "insert unsuccessfull";
        $error = "Error adding employee.";
    }
}

//update existing employee details
if (isset($_POST['update'])) {
    $id         = $_POST['id'];
    $emp_id     = $_POST['emp_id'];
    $name       = $_POST['name'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $email      = $_POST['email'];
    $mobile_no  = $_POST['mobile_no'];
    $updated_by = $user['Name'];

    //handle image
    $image_sql = "";
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $imageName = time() . '_' . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

        $image_sql = ", image = '$imageName'";
    }

    $sql = "UPDATE employee SET 
                emp_id = ?, 
                name = ?, 
                department = ?, 
                designation = ?, 
                email = ?, 
                mobile_no = ?,
                updated_by = ?,
                updated_at = GETDATE()
                $image_sql
            WHERE id = ?";

    $params = [$emp_id, $name, $department, $designation, $email, $mobile_no, $updated_by, $id];
    $stmt = sqlsrv_query($con, $sql, $params);

    if ($stmt) {
        header("Location: employee.php?message=Employee updated successfully");
        exit;
    } else {
        echo "Update failed.";
        print_r(sqlsrv_errors());
    }
}

//delete employee
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);  
    $query = "UPDATE employee set is_delete=1 WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($con, $query, $params);
    if ($stmt) {
        header("Location: employee.php?message=Employee deleted successfully");
        exit();
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}
?>