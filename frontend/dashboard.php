    <?php
    require 'templates/header.php';
    require 'templates/sidebar.php';
    include 'templates/nav.php';
    ?>
    <div class="table-content p-4">
    <div id="adminSection" style="display: none;">
        <h2 class="mb-4">Welcome back, Admin!</h2>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <h2>120</h2>
                        <p class="mb-0">Active and inactive users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Documents</h5>
                        <h2>342</h2>
                        <p class="mb-0">Pending and approved</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm bg-warning text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Complaints</h5>
                        <h2>15</h2>
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

        <!-- Notifications Panel (optional) -->
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
    </div>

    <div id="secretarySection" style="display: none;">
        <h2 class="mb-4">Welcome, Secretary!</h2>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-md-6">
                <a href="incoming-documents.php" class="btn btn-primary w-100 mb-2">
                    📥 View Incoming Documents
                </a>
            </div>
            <div class="col-md-6">
                <a href="create-announcement.php" class="btn btn-warning w-100 mb-2">
                    📢 Post Announcement
                </a>
            </div>
        </div>

        <!-- Document Requests Summary -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <strong>Pending Document Requests</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Resident</th>
                            <th>Document</th>
                            <th>Date Requested</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ana Reyes</td>
                            <td>Barangay Certificate</td>
                            <td>April 18, 2025</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>Mark Lopez</td>
                            <td>Indigency Certificate</td>
                            <td>April 17, 2025</td>
                            <td><span class="badge bg-success">Approved</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="residentSection" style="display: none;">
        <h2 class="mb-4">Welcome, Resident!</h2>

        <!-- Request Documents -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <strong>Request a Document</strong>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="documentType" class="form-label">Select Document</label>
                        <select class="form-select" id="documentType">
                            <option value="brgy_cert">Barangay Certificate</option>
                            <option value="indigency">Certificate of Indigency</option>
                            <option value="clearance">Barangay Clearance</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Submit Request</button>
                </form>
            </div>
        </div>

        <!-- My Requests Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <strong>My Document Requests</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Document</th>
                            <th>Status</th>
                            <th>Requested On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Barangay Certificate</td>
                            <td><span class="badge bg-info">Processing</span></td>
                            <td>April 18, 2025</td>
                        </tr>
                        <tr>
                            <td>Clearance</td>
                            <td><span class="badge bg-success">Approved</span></td>
                            <td>April 15, 2025</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

        </div>
    </div>



    <script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch('http://backend.test/api/user-info', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        })
        .then(res => res.json())
        .then(user => {
            // console.log(user);
            if (parseInt(user.role) === 1) {
                document.getElementById('adminSection').style.display = 'block';
            } else if (parseInt(user.role) === 2) {
                document.getElementById('secretarySection').style.display = 'block';
            } else if (parseInt(user.role) === 3) {
                document.getElementById('residentSection').style.display = 'block';
            }
        })
        .catch(err => {
            console.error("Error fetching user info", err);
        });
        
    });

    </script>
    <?php require 'templates/footer.php'; ?>

