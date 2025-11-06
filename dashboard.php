<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'header_sidebar.php';
?>

<main class="content px-3 py-4">
    <div class="container-fluid">
        <h3 class="fw-bold fs-4 mb-3">Admin Dashboard</h3>

        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card shadow">
                    <div class="card-body py-4">
                        <h6 class="mb-2 fw-bold">Member Progress</h6>
                        <p class="fw-bold mb-2">$89,1891</p>
                        <span class="badge text-success me-2">+9.0%</span>
                        <span class="fw-bold">Since Last Month</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow">
                    <div class="card-body py-4">
                        <h6 class="mb-2 fw-bold">Member Progress</h6>
                        <p class="fw-bold mb-2">$89,1891</p>
                        <span class="badge text-success me-2">+9.0%</span>
                        <span class="fw-bold">Since Last Month</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow">
                    <div class="card-body py-4">
                        <h6 class="mb-2 fw-bold">Member Progress</h6>
                        <p class="fw-bold mb-2">$89,1891</p>
                        <span class="badge text-success me-2">+9.0%</span>
                        <span class="fw-bold">Since Last Month</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-7">
                <h3 class="fw-bold fs-4 my-3">Users</h3>
                <table class="table table-striped">
                    <thead>
                        <tr class="highlight">
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td>Larry the Bird</td>
                        <td>Thornton</td>
                        <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12 col-md-5">
                <h3 class="fw-bold fs-4 my-3">
                    Reports Overview
                </h3>
                <canvas id="bar-chart-grouped" width="800" height="450"></canvas>
            </div>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container-fluid">
        <div class="row text-body-secondary">
            <div class="col-6 text-start">
                <a href="#" class="text-body-secondary"><strong>Suyog</strong></a>
            </div>
            <div class="col-6 text-end text-body-secondary d-none d-md-block">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="#" class="text-body-secondary">Contact</a></li>
                    <li class="list-inline-item"><a href="#" class="text-body-secondary">About</a></li>
                    <li class="list-inline-item"><a href="#" class="text-body-secondary">Terms & Conditions</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
</div>
</div>

<!-- Chart CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Bootstrap CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<!-- to connect js file -->
<script src="script.js"></script>

</body>
</html>
