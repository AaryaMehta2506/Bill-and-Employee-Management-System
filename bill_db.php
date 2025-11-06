<?php
$updated_by = $_SESSION['user'] ?? null;
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php?message=Please login first");
    exit;
}

$editMode = isset($_POST['edit']);
//step 1: Get form data
$purchase_from_party = $_POST['purchase_from_party'];
$bill_date = $_POST['bill_date'];
$bill_no = $_POST['bill_no'];
$total_amount = $_POST['total_amount'];
$quantity = $_POST['quantity'];
$file_upload = $_FILES['file_upload']['name'];

//handle file upload (optional)
if (!empty($file_upload)) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file_upload"]["name"]);
    move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file);
}else {
    //if editing and no new file uploaded, keep the old one
    if ($editMode) {
        $file_upload = $_POST['existing_file'] ?? '';
    }
}

//collect details arrays
$make = $_POST['make'];
$model = $_POST['model'];
$ram = $_POST['ram'];
$storage = $_POST['storage'];
$color = $_POST['color'];
$imei = $_POST['imei'];
$warranty = $_POST['warranty'];
$basic_rate = $_POST['basic_rate'];
$invoice_rate = $_POST['invoice_rate'];
if ($editMode) {
    $bill_id = $_POST['bill_id'];

    //update head table
    $sql_update_head = "UPDATE [student].[dbo].[head]
    SET purchase_from_party = ?, bill_date = ?, bill_no = ?, total_amount = ?, quantity = ?, file_upload = ?, updated_at = GETDATE(), updated_by = ?
    WHERE bill_id = ?";
    $params_head = [$purchase_from_party, $bill_date, $bill_no, $total_amount, $quantity, $file_upload, $updated_by, $bill_id];
    $res = sqlsrv_query($con, $sql_update_head, $params_head);
    if ($res === false) { die(print_r(sqlsrv_errors(), true)); }

    //  Soft Delete Logic 
    if (!empty($_POST['deleted_detail_id'])) {
        foreach ($_POST['deleted_detail_id'] as $deletedId) {
            // Soft delete + track update time (and user if available)
            $sql_soft_delete = "UPDATE [student].[dbo].[details]
                                SET is_delete = 1, updated_at = GETDATE(), updated_by = ?
                                WHERE id = ?";
            $updated_by = $_SESSION['user'] ?? null; // current logged-in user
            $res = sqlsrv_query($con, $sql_soft_delete, [$updated_by, $deletedId]);
            if ($res === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        }

        //  Recalculate active (non-deleted) rows 
        $sql_count_active = "SELECT COUNT(*) AS active_count
                            FROM [student].[dbo].[details]
                            WHERE bill_id = ? AND (is_delete IS NULL OR is_delete = 0)";
        $stmt_count = sqlsrv_query($con, $sql_count_active, [$bill_id]);
        $row_count = sqlsrv_fetch_array($stmt_count, SQLSRV_FETCH_ASSOC);
        $active_count = $row_count['active_count'] ?? 0;

        //  Update head table with new quantity and update timestamp 
        $sql_update_qty = "UPDATE [student].[dbo].[head]
                            SET quantity = ?, updated_at = GETDATE(), updated_by = ?
                            WHERE bill_id = ?";
        sqlsrv_query($con, $sql_update_qty, [$active_count, $updated_by, $bill_id]);
    }

    //update or insert detail rows
    $detail_ids = $_POST['detail_id'] ?? [];
    for ($i = 0; $i < count($make); $i++) {
        $current_id = isset($detail_ids[$i]) && !empty($detail_ids[$i]) ? $detail_ids[$i] : null;

        if ($current_id) {
            //update existing row
            $sql_update_detail = "UPDATE [student].[dbo].[details]
                SET make = ?, model = ?, ram = ?, storage = ?, color = ?, imei_no = ?, warranty = ?, basic_rate = ?, invoice_rate = ?, is_delete = 0, updated_at = GETDATE(), updated_by = ?
                WHERE id = ?";
            $params_update = [
                $make[$i], $model[$i], $ram[$i], $storage[$i], $color[$i], $imei[$i], $warranty[$i], $basic_rate[$i], $invoice_rate[$i], $updated_by, $current_id
            ];
            sqlsrv_query($con, $sql_update_detail, $params_update);

        } else {
            //insert new row
            $sqlid = "SELECT ISNULL(MAX(id),0) + 1 AS id FROM [student].[dbo].[details]";
            $runid = sqlsrv_query($con, $sqlid);
            $rowid = sqlsrv_fetch_array($runid, SQLSRV_FETCH_ASSOC);
            $new_Id = $rowid['id'];

            $sql_insert_detail = "INSERT INTO [student].[dbo].[details]
                (id, bill_id, make, model, ram, storage, color, imei_no, warranty, basic_rate, invoice_rate, is_delete, created_at, created_by)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, GETDATE(), ?)";
            $params_insert = [
                $new_Id, $bill_id, $make[$i], $model[$i], $ram[$i], $storage[$i], $color[$i],
                $imei[$i], $warranty[$i], $basic_rate[$i], $invoice_rate[$i], $updated_by
            ];
            sqlsrv_query($con, $sql_insert_detail, $params_insert);
        }
    }

    header("Location: bill.php?message=Bill updated successfully");
    exit;

} else {
    //add new record
    $sql_getid = "SELECT ISNULL(MAX(bill_id), 0) + 1 AS new_id FROM [student].[dbo].[head]";
    $stmt = sqlsrv_query($con, $sql_getid);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $new_bill_id = $row['new_id'];

    $sql_head = "INSERT INTO [student].[dbo].[head]
    (bill_id, purchase_from_party, bill_date, bill_no, total_amount, quantity, file_upload, created_at, created_by)
    VALUES (?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
    $params_head = [$new_bill_id, $purchase_from_party, $bill_date, $bill_no, $total_amount, $quantity, $file_upload, $updated_by];
    sqlsrv_query($con, $sql_head, $params_head);

    for ($i = 0; $i < count($make); $i++) {
        $sqlid = "SELECT ISNULL(MAX(id),0) + 1 AS id FROM [student].[dbo].[details]";
        $runid = sqlsrv_query($con, $sqlid);
        $rowid = sqlsrv_fetch_array($runid, SQLSRV_FETCH_ASSOC);
        $new_Id = $rowid['id'];

        $sql_detail = "INSERT INTO [student].[dbo].[details]
            (id, bill_id, make, model, ram, storage, color, imei_no, warranty, basic_rate, invoice_rate)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params_detail = [$new_Id, $new_bill_id, $make[$i], $model[$i], $ram[$i], $storage[$i], $color[$i], $imei[$i], $warranty[$i], $basic_rate[$i], $invoice_rate[$i]];
        sqlsrv_query($con, $sql_detail, $params_detail);
    }

    header("Location: bill.php?message=Bill added successfully");
    exit;
}
?>

