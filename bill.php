<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php?message=Please login first");
    exit;
}
include 'dbcon.php';
include 'header_sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Bill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTable CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css" rel="stylesheet">
    <script defer src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script defer src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script defer src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>

    <!-- Edit icon, Delete icon CDN-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <!-- Sweet Alert -->

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f5f7fb;
        }

        h2.page-title {
            color: #293b5f;
            /* font-weight: 700; */
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #293b5f;
            border: none;
            border-radius: 6px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #1f2b47;
        }

        .btn-danger {
            border-radius: 6px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            background-color: #fff;
        }

        table.dataTable thead th {
            background-color: #293b5f !important;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
        }

        table.dataTable tbody td {
            vertical-align: middle;
            color: #000;
            font-size: 0.9rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 5px 10px;
        }

        footer {
            background-color: #f5f5f5;
            padding: 1rem .875rem;
            text-align: center;
            color: #293b5f;
            font-weight: 500;
            border-top: 1px solid #e1e1e1;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4 px-3">
        <div class="row mb-3 align-items-center">
            <div class="col">
                <h2 class="mb-0">Bill</h2>
            </div>
            <div class="col-auto">
                <a href="bill_form.php" class="btn btn-primary">Add Bill</a>
            </div>
            </div>

            <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['message']) ?></div>
            <?php endif; ?>

            <table id="bill_table" class="table table-striped">
            <thead>
                <tr>
                <th>Bill ID</th>
                <th>Purchase From Party</th>
                <th>Bill Date</th>
                <th>Bill No</th>
                <th>Total Amount</th>
                <th>Quantity</th>
                <th>File Upload</th>
                <th>Edit</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $query = "SELECT * FROM [student].[dbo].[head] ORDER BY bill_id ASC";
            $result = sqlsrv_query($con, $query);
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            ?>
                <tr>
                <td><?= htmlspecialchars($row['bill_id']) ?></td>
                <td><?= htmlspecialchars($row['purchase_from_party']) ?></td>
                <td><?= $row['bill_date'] ? $row['bill_date']->format('d-m-Y') : '' ?></td>
                <td><?= htmlspecialchars($row['bill_no']) ?></td>
                <td><?= htmlspecialchars($row['total_amount']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td><?= htmlspecialchars($row['file_upload']) ?></td>
                <td>
                    <a href="bill_form.php?id=<?= $row['bill_id'] ?>" class="btn btn-primary btn-sm" title="Edit Bill">EDIT</a>
                    <!-- <a href="bill_form.php?id=<?= $row['bill_id'] ?>" class="text-primary" title="Edit Bill"><i class="fa-solid fa-pen"></i></a> -->
                    <!-- <a href="bill_delete.php?id=<?= $row['bill_id'] ?>" class="text-danger" onclick="return confirm('Delete this bill?');" title="Delete Bill"><i class="fa-solid fa-trash"></i></a> -->
                </td>
                </tr>
            <?php } ?>
            </tbody>
            </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Jquery CDN (for ui in the datatable)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
    $(document).ready(function() {
        $('#bill_table').DataTable();
    });
    </script>
</body>
</html>

