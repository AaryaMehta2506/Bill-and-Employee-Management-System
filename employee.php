<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php?message=Please login first");
    exit;
}
include 'header_sidebar.php';
include 'dbcon.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Employee Management</title>
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

    .content-wrapper {
      padding: 2rem;
    }

    h2.page-title {
      color: #293b5f;
      font-weight: 700;
      margin-bottom: 1.5rem;
    }

    .card {
      border: none;
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
      border-radius: 10px;
      background-color: #fff;
    }

    .btn-primary {
      background-color: #293b5f;
      border: none;
      border-radius: 6px;
      font-weight: 600;
    }

    .btn-primary:hover {
      background-color: #293b5f;
    }

    .btn-success {
      background-color: #293b5f;
      border: none;
      font-weight: 600;
      border-radius: 6px;
    }

    .btn-success:hover {
      background-color: #293b5f;
    }

    .btn-secondary {
      background-color: #6c757d;
      border: none;
      border-radius: 6px;
      font-weight: 600;
    }

    /* Table styling */
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
  <div class="container-fluid mt-4 px-3">
    <div class="row mb-3 align-items-center">
      <div class="col">
        <h2 class="mb-0">Employee Management</h2>
      </div>
      <div class="col-auto">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add Employee</button>
      </div>
    </div>

    <?php if (isset($_GET['message'])): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($_GET['message']) ?>
      </div>
    <?php elseif (isset($error)): ?>
      <div class="alert alert-danger">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <!-- Add employee dialog box -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form method="POST" action="emp_db.php" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="addEmployeeModalLabel">Add New Employee</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="emp_id" class="form-label">Employee ID</label>
                  <input type="text" name="emp_id" class="form-control" placeholder="Employee ID" required />
                </div>
                <div class="col-md-6">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" name="name" class="form-control" placeholder="Name" required />
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="department" class="form-label">Department</label>
                  <input type="text" name="department" class="form-control" placeholder="Department" required />
                </div>
                <div class="col-md-6">
                  <label for="designation" class="form-label">Designation</label>
                  <input type="text" name="designation" class="form-control" placeholder="Designation" required />
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" placeholder="Email" required />
                </div>                
                <div class="col-md-6">
                  <label for="mobile_no" class="form-label">Phone Number</label>
                  <input type="text" name="mobile_no" class="form-control" placeholder="Phone Number" required />
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="image" class="form-label">Upload Image</label>
                  <input type="file" name="image" class="form-control" accept=".jpg, .jpeg, .png" />
                </div>                
                <!-- <div class="col-md-6">
                  <label for="mobile_no" class="form-label">Phone Number</label>
                  <input type="text" name="mobile_no" class="form-control" placeholder="Phone Number" required />
                </div> -->
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" name="save" class="btn btn-success">Save Employee</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Edit Employee dialog box -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form method="POST" action="emp_db.php" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light">
              <input type="hidden" name="id" id="edit_id">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="emp_id" class="form-label">Employee ID</label>
                  <input type="text" name="emp_id" id="edit_emp_id" class="form-control" placeholder="Employee ID" required />
                </div>
                <div class="col-md-6">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" name="name" id="edit_name" class="form-control" placeholder="Name" required />
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="department" class="form-label">Department</label>
                  <input type="text" name="department" id="edit_department" class="form-control" placeholder="Department" required />
                </div>
                <div class="col-md-6">
                  <label for="designation" class="form-label">Designation</label>
                  <input type="text" name="designation" id="edit_designation" class="form-control" placeholder="Designation" required />
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" name="email" id="edit_email" class="form-control" placeholder="Email" required />
                </div>
                <div class="col-md-6">
                  <label for="mobile_no" class="form-label">Phone Number</label>
                  <input type="text" name="mobile_no" id="edit_mobile_no" class="form-control" placeholder="Phone Number" required />
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="image" class="form-label">Upload Image</label>
                  <input type="file" name="image" id="edit_image" class="form-control" accept=".jpg, .jpeg, .png" />
                </div>
                <!-- <div class="col-md-6">
                  <label for="mobile_no" class="form-label">Phone Number</label>
                  <input type="text" name="mobile_no" id="edit_mobile_no" class="form-control" placeholder="Phone Number" required />
                </div> -->
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" name="update" class="btn btn-success">Update Employee</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  <!-- Datatable -->
  <div class="container-fluid px-3">
  <table id="emp_table" class="table table-striped">
    <thead>
      <tr>
        <th>emp_id</th>
        <th>image</th>
        <th>name</th>
        <th>department</th>
        <th>designation</th>
        <th>email</th>
        <th>mobile_no</th>                
        <th>created_at</th>
        <th>Action</th>
      </tr>
    </thead>
    <?php       
    $query = "SELECT * FROM employee Where is_delete=0";
    $result = sqlsrv_query($con, $query);

    if ($result === false) {
      die(print_r(sqlsrv_errors(), true));
    }
    
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?= htmlspecialchars($row['emp_id']) ?></td>
        <td>
        <?php if (!empty($row['image'])): ?>
          <img src="uploads/<?= htmlspecialchars($row['image']) ?>" width="50" height="50" class="rounded-circle" />
        <?php else: ?>
          <img src="uploads/" width="50" height="50" class="rounded-circle" />
        <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['department']) ?></td>
        <td><?= htmlspecialchars($row['designation']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['mobile_no']) ?></td>                  
        <td><?= $row['created_at']->format('d-m-Y') ?></td>
        <td>
          <!-- Edit icon -->
          <div class="d-flex justify-content-center align-items-center gap-3">
          <a href="javascript:void(0);" class="text-primary  editBtn" title="Edit Employee"
            data-id="<?= $row['id'] ?>"
            data-emp_id="<?= $row['emp_id'] ?>"
            data-name="<?= $row['name'] ?>"
            data-department="<?= $row['department'] ?>"
            data-designation="<?= $row['designation'] ?>"
            data-email="<?= $row['email'] ?>"
            data-mobile_no="<?= $row['mobile_no'] ?>"
            data-image="<?= $row['image'] ?>">
            <i class="fa-solid fa-pen"></i>
          </a>
          <!-- Delete icon -->
          <a href="emp_db.php?id=<?= $row['id'] ?>" class="text-danger deleteBtn" title="Delete Employee"
            onclick="return confirm('Are you sure you want to delete this employee?');">
            <i class="fa-solid fa-trash"></i>
          </a>
        </td>
      </tr>
      <?php
      }
      ?>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Jquery CDN (for ui in the datatable)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>
  function toggleForm() {
    const form = document.getElementById('employee-form');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
  }

    $(document).ready(function() {
      $('#emp_table').DataTable();

      $(document).on('click', '.editBtn', function () {
        const btn = $(this);
        $('#edit_id').val(btn.data('id'));
        $('#edit_emp_id').val(btn.data('emp_id'));
        $('#edit_name').val(btn.data('name'));
        $('#edit_department').val(btn.data('department'));
        $('#edit_designation').val(btn.data('designation'));
        $('#edit_email').val(btn.data('email'));
        $('#edit_mobile_no').val(btn.data('mobile_no'));
        $('#previewImage').attr('src', 'uploads/' + btn.data('image'));
        // Show the edit modal
        $('#editEmployeeModal').modal('show');
      });
    });
  </script>
</body>
</html>
