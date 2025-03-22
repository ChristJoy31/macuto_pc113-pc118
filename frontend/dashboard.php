<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-3 position-fixed vh-100" style="background-color:rgb(196, 210, 247);">
            <h3 class="text-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="50" height="50" stroke-width="3"> <path d="M17 16c.74 -2.286 2.778 -3.762 5 -3c-.173 -2.595 .13 -5.314 -2 -7.5c-1.708 2.648 -3.358 2.557 -5 2.5v-4l-3 2l-3 -2v4c-1.642 .057 -3.292 .148 -5 -2.5c-2.13 2.186 -1.827 4.905 -2 7.5c2.222 -.762 4.26 .714 5 3c2.593 0 3.889 .952 5 4c1.111 -3.048 2.407 -4 5 -4z"></path> <path d="M9 8a3 3 0 0 0 6 0"></path> </svg>
            </h3>
            <ul class="nav flex-column">
                <!-- Dashboard Link -->
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark d-flex align-items-center" href="#">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>

                <!-- User Dropdown -->
                <li class="nav-item dropdown mb-2">
                    <a class="nav-link text-dark d-flex align-items-center dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-people me-2"></i> User
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="UserList.php"><i class="bi bi-person me-2"></i> Users List</a></li>
                        <li><a class="dropdown-item" href="EmployeeList.php"><i class="bi bi-briefcase me-2"></i> Employees List</a></li>
                        <li><a class="dropdown-item" href="StudentList.php"><i class="bi bi-mortarboard me-2"></i> Students List</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4 offset-md-3 offset-lg-2">
            <h1>Welcome to the Dashboard</h1>
            <table class="table table-bordered table-striped" id="userTable">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Action</th> 
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
                { data: 'first_name' }, 
                { data: 'last_name' }, 
                { data: 'email' }, 
                { data: 'course' }, 
                {
                    data: null, // Action column
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-warning" onclick="editStudent(${row.id})">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteStudent(${row.id})">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            columnDefs: [
                {
                    targets: 0, 
                    render: function(data, type, row, meta) {
                        return meta.row + 1; 
                    }
                }
            ]
        });

        // Fetch student data from the API
        fetch("http://backend.test/api/students", {
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

    // Edit Student Function
    function editStudent(id) {
        alert(`Edit student with ID: ${id}`);
        
    }

    // Delete Student Function
    function deleteStudent(id) {
        if (confirm(`Are you sure you want to delete student with ID: ${id}?`)) {
            alert(`Delete student with ID: ${id}`);
           
        }
    }
</script>

<!-- Bootstrap JS (Required for dropdown functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>