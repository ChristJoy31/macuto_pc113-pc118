<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #4E73DF; position: sticky; top: 0;">
    <div class="container-fluid">
        <a href="" class="logo d-flex justify-content-center">
            <img src="{{asset('images/logo.png')}}" width="140px" height="auto" class="py-2" alt="">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
            </ul>
        </div>
        <div class="dropdown mx-3 pt-2">
            <a class="nav-link text-light btn dropdown-toggle p-2" data-bs-toggle="dropdown" aria-expanded="false">
                Hi, Admin
            </a>
            <ul class="dropdown-menu nav-menu dropdown-menu-lg-end" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item text-dark" href="" data-bs-toggle="modal" data-bs-target="#logoutModal" id="logoutLink">
                    <i class="mdi mdi-logout me-2 text-primary"></i> Logout
                </a>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-3 position-fixed vh-100" style="background-color: #4E73DF;">
            <h3 class="text-center text-white mb-4">Dashboard Sheesh</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white active" href="#">Dashboard</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4 offset-md-3 offset-lg-2">
            <h1>Welcome to the Dashboard</h1>
            <table class="table table-bordered table-striped" id="userTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const token = localStorage.getItem("token");
        const role = localStorage.getItem("role");

        // Redirect to login if no token or role is found
        if (!token) {
            alert("Access Denied! Please log in first.");
            window.location.href = "index.php";
            return;
        }

        // Redirect if user is not an admin
        if (role != 1) {
            alert("Access Denied! Only admin can access this page.");
            window.location.href = "index.php";
            return;
        }

        // Logout function
        document.getElementById("logoutLink").addEventListener("click", function(e) {
            e.preventDefault();
            localStorage.removeItem("token");
            localStorage.removeItem("role");
            window.location.href = "index.php";
        });

        // Initialize DataTable
        const table = $('#userTable').DataTable({
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                { data: 'role' }
            ],
            columnDefs: [
                {
                    targets: 0, 
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    targets: 3, 
                    render: function(data, type, row) {
                        return data === 1 ? "Admin" : "User"; 
                    }
                }
            ]
        });

        // Fetch user data from the API
        fetch("http://backend.test/api/users-admin", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token,
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP status " + response.status);
            }
            return response.json();
        })
        .then(data => {
            // Clear existing rows and add new data
            table.clear();
            table.rows.add(data).draw();
        })
        .catch(error => console.error("Error fetching data:", error));
    });
</script>

<!-- Bootstrap JS (Optional, for dropdowns, modals, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>