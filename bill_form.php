<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php?message=Please login first");
    exit;
}
include 'header_sidebar.php';
include 'dbcon.php';

$editMode = isset($_GET['id']);
$head = [];
$details = [];

if ($editMode) {
    $bill_id = $_GET['id'];

    $sql_head = "SELECT * FROM [student].[dbo].[head] WHERE bill_id=?";
    $stmt = sqlsrv_query($con, $sql_head, [$bill_id]);
    $head = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    $sql_details = "SELECT * FROM [student].[dbo].[details] WHERE bill_id=? AND (is_delete IS NULL OR is_delete=0) ORDER BY id ASC";
    $details_result = sqlsrv_query($con, $sql_details, [$bill_id]);
    while ($row = sqlsrv_fetch_array($details_result, SQLSRV_FETCH_ASSOC)) {
        $details[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title><?= $editMode ? 'Edit Bill' : 'Add Bill' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
        font-family: 'Outfit', sans-serif;
        background-color: #f5f7fb;
        }

        .card {
        border: none;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        background-color: #fff;
        padding: 20px;
        }

        .btn-success {
        background-color: #293b5f;
        border: none;
        font-weight: 600;
        border-radius: 6px;
        }

        .btn-success:hover {
        background-color: #293b5f !important;
        }

        .btn-secondary {
        background-color: #293b5f;
        border: none;
        font-weight: 600;
        border-radius: 6px;
        color: #fff;
        }

        .btn-secondary:hover {
        background-color: #1f2b47 !important;
        color: #fff;
        }

        /* Table styling */
        .table th {
        background-color: #293b5f !important;
        color: #fff;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        }

        .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
        }

        .modal-title {
        color: #293b5f;
        font-weight: 700;
        }

        .form-label {
        font-weight: 600;
        color: #293b5f;
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
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3><?= $editMode ? 'Edit Bill' : 'Add Bill' ?></h3>
  </div>

  <form action="bill_db.php" method="POST" enctype="multipart/form-data">
    <?php if ($editMode): ?>
      <input type="hidden" name="bill_id" value="<?= $head['bill_id'] ?>">
      <input type="hidden" name="edit" value="1">
    <?php endif; ?>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Purchase From Party</label>
        <select name="purchase_from_party" class="form-select" required>
          <option value="">Select Party</option>
          <?php
          $parties = ["Target Enterprises","UNI Enterprises","Sunce Info Tech","Mobile World","Union Enterprises"];
          foreach ($parties as $p) {
            $selected = ($editMode && $head['purchase_from_party'] == $p) ? 'selected' : '';
            echo "<option value='$p' $selected>$p</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Bill Date</label>
        <input type="date" name="bill_date" class="form-control"
               value="<?= $editMode && $head['bill_date'] ? $head['bill_date']->format('Y-m-d') : '' ?>">
      </div>
      <div class="col-md-4">
        <label class="form-label">Bill Number</label>
        <input type="text" name="bill_no" class="form-control"
               value="<?= $editMode ? $head['bill_no'] : '' ?>">
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Total Amount</label>
        <input type="number" name="total_amount" class="form-control"
               value="<?= $editMode ? $head['total_amount'] : '' ?>">
      </div>
      <!-- <div class="col-md-4">
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control"
               value="<?= $editMode ? $head['quantity'] : '' ?>">
      </div> -->

      <div class="col-md-4">
        <label class="form-label">Quantity</label>
        <div class="d-flex align-items-center">
          <input type="number" name="quantity" id="quantity" class="form-control"
                value="<?= $editMode ? $head['quantity'] : '' ?>">
          <?php if ($editMode): ?>
            <button type="button" id="addRowBtn" class="btn btn-success ms-2" title="Add new row">
              <i class="fa-solid fa-plus"></i>
            </button>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-md-4">
        <label class="form-label">File Upload</label>
        <input type="file" name="file_upload" class="form-control">

        <?php if ($editMode): ?>
          <!-- Hidden field to retain existing file name if no new upload -->
          <input type="hidden" name="existing_file" value="<?= htmlspecialchars($head['file_upload']) ?>">
        <?php endif; ?>

        <?php if ($editMode && $head['file_upload']): ?>
          <small>Current: <?= htmlspecialchars($head['file_upload']) ?></small>
        <?php endif; ?>
      </div>
    </div>
    <table class="table table-bordered" id="detailsTable">
      <thead class="table-dark">
        <tr>
          <th>Sr No.</th>
          <th>Make</th>
          <th>Model</th>
          <th>RAM</th>
          <th>Storage</th>                                                     
          <th>Color</th>
          <th>IMEI No</th>
          <th>Warranty</th>
          <th>Basic Rate</th>
          <th>Invoice Rate</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($editMode): ?>
          <?php foreach ($details as $index => $d): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <input type="hidden" name="detail_id[]" value="<?= $d['id'] ?>">
              <td><input type="text" name="make[]" class="form-control" value="<?= $d['make'] ?>"></td>
              <td><input type="text" name="model[]" class="form-control" value="<?= $d['model'] ?>"></td>
              <td><input type="text" name="ram[]" class="form-control" value="<?= $d['ram'] ?>"></td>
              <td><input type="text" name="storage[]" class="form-control" value="<?= $d['storage'] ?>"></td>
              <td><input type="text" name="color[]" class="form-control" value="<?= $d['color'] ?>"></td>
              <td><input type="text" name="imei[]" class="form-control" value="<?= $d['imei_no'] ?>"></td>
              <td><input type="text" name="warranty[]" class="form-control" value="<?= $d['warranty'] ?>"></td>
              <td><input type="number" name="basic_rate[]" class="form-control" value="<?= $d['basic_rate'] ?>"></td>
              <td><input type="number" name="invoice_rate[]" class="form-control" value="<?= $d['invoice_rate'] ?>"></td>
              <td class="text-center"> <button type="button" class="btn btn-sm btn-danger delete-row"><i class="fa-solid fa-trash"></i></button></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="mt-3 d-flex gap-2">
      <button type="submit" class="btn btn-success"><?= $editMode ? 'Update' : 'Save' ?></button>
      <a href="bill.php" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>

<script>
$(document).ready(function() {
  //  Delete row logic 
  <?php if ($editMode): ?>
  //Edit Mode → Soft Delete
  $('#detailsTable').on('click', '.delete-row', function() {
    const row = $(this).closest('tr');
    const detailIdInput = row.find('input[name="detail_id[]"]');

    // If this row exists in DB → mark for soft delete
    if (detailIdInput.length) {
      const deletedId = detailIdInput.val();

      // Add hidden field to mark deletion
      $('<input>').attr({
        type: 'hidden',
        name: 'deleted_detail_id[]',
        value: deletedId
      }).appendTo('form');
    }

    // Just hide the row (don’t remove it)
    row.hide();

    updateSerialNumbers();
  });
  <?php else: ?>
  //Add Mode → hard delete (just remove)
  $('#detailsTable').on('click', '.delete-row', function() {
    $(this).closest('tr').remove();
    updateSerialNumbers();
  });
  <?php endif; ?>

  //  Function to renumber visible rows 
  function updateSerialNumbers() {
    $('#detailsTable tbody tr:visible').each(function(index) {
      $(this).find('td:first').text(index + 1);
    });
  }

  //  Add mode dynamic rows 
  <?php if (!$editMode): ?>
  let tbody = $('#detailsTable tbody');
  tbody.empty();

  $('#quantity').on('input', function() {
    let count = parseInt($(this).val()) || 0;
    tbody.empty();

    if (count > 0) {
      for (let i = 1; i <= count; i++) {
        tbody.append(`
          <tr>
            <td>${i}</td>
            <td><input type="text" name="make[]" class="form-control"></td>
            <td><input type="text" name="model[]" class="form-control"></td>
            <td><input type="text" name="ram[]" class="form-control"></td>
            <td><input type="text" name="storage[]" class="form-control"></td>
            <td><input type="text" name="color[]" class="form-control"></td>
            <td><input type="text" name="imei[]" class="form-control"></td>
            <td><input type="text" name="warranty[]" class="form-control"></td>
            <td><input type="number" name="basic_rate[]" class="form-control"></td>
            <td><input type="number" name="invoice_rate[]" class="form-control"></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger delete-row"><i class="fa-solid fa-trash"></i></button></td>
          </tr>`);
      }
    }
  });
  <?php endif; ?>
});

//Edit Mode: Add new row when + clicked
<?php if ($editMode): ?>
  $("#addRowBtn").on("click", function () {
    let tbody = $("#detailsTable tbody");
    let lastRow = tbody.find("tr:last");
    let newRow = lastRow.clone();
    //clear all input values in the cloned row
    newRow.find("input").val("");
    //remove hidden detail_id (so new row is treated as new record)
    newRow.find('input[name="detail_id[]"]').remove();
    //update the Sr No
    let newSrNo = tbody.find("tr").length + 1;
    newRow.find("td:first").text(newSrNo);
    //append the row
    tbody.append(newRow);
    //update the Quantity field dynamically
    $("#quantity").val(newSrNo);
  });
<?php endif; ?>
</script>
</body>
</html>
