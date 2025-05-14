<!-- Admin Dashboard Content -->
<?php
require __DIR__ . '/../templates/header.php';
require __DIR__ . '/../templates/sidebar.php';
include __DIR__ . '/../templates/nav.php';
?>


<h2 class="mb-4">Welcome back, Admin!</h2>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <h2>--</h2>
                <p class="mb-0">Active and inactive users</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Documents</h5>
                <h2>--</h2>
                <p class="mb-0">Pending and approved</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm bg-warning text-dark">
            <div class="card-body">
                <h5 class="card-title">Complaints</h5>
                <h2>--</h2>
                <p class="mb-0">New complaints this week</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Table -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
        <strong>Recent Activities</strong>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>April 19, 2025</td>
                    <td>Juan Dela Cruz</td>
                    <td>Submitted document for approval</td>
                </tr>
                <tr>
                    <td>April 18, 2025</td>
                    <td>Maria Santos</td>
                    <td>Created a new complaint</td>
                </tr>
                <tr>
                    <td>April 18, 2025</td>
                    <td>Admin</td>
                    <td>Approved a document</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Notifications -->
<div class="card shadow-sm">
    <div class="card-header bg-light">
        <strong>System Notifications</strong>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item">🔔 3 new documents awaiting approval</li>
            <li class="list-group-item">⚠️ Complaint #203 needs response</li>
            <li class="list-group-item">✅ Backup completed successfully</li>
        </ul>
    </div>
</div>

<?php
include __DIR__ . '/../templates/footer.php';
?>