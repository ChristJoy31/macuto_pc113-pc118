<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 300px;
            height: 100vh;
            background: #3b63cf;
            color: white;
            position: fixed;
            padding-top: 20px;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
        }
        .sidebar h3 {
            text-align: left;
            margin-left: 20px;
            margin-bottom: 40px;
            padding: 20px;
            border-bottom: 1px solid white;
        }
        .sidebar a, .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px 20px;
            color: white;
            font-size: 23px;
            text-decoration: none;
        }
        .sidebar a.active, .sidebar a:hover {
            background: white;
            color: #3b63cf;
            border-left: 5px solid #3458a4;
        }
        .dropdown .dropdown-toggle {
            width: 100%;
            justify-content: space-between;
            background: none;
            border: none;
            font-size: 18px;
        }
        .dropdown-menu {
            background: #3458a4;
            border: none;
            width: 100%;
        }
        .dropdown-menu .dropdown-item {
            color: white;
            font-size: 16px;
            padding: 10px 20px;
        }
        .dropdown-menu .dropdown-item:hover {
            background: white;
            color: #3b63cf;
        }
        .content {
            margin-left: 300px;
            background: #f4f4f4;
            min-height: 100vh;
        }
        .top-nav {
            background: white;
            height: 100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #ddd;
        }
        .top-nav h3 {
            margin: 0;
        }
        .top-nav div {
            display: flex;
            align-items: center;
        }
        .top-nav i {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>BMS PORTAL</h3>
        <a href="#" class="active">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 3a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2zm0 12a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-2a2 2 0 0 1 2 -2zm10 -4a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2zm0 -8a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-2a2 2 0 0 1 2 -2z" /></svg>
            Dashboard
        </a>
        <div class="dropdown">
            <button class="dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <span style="display: flex; align-items: center; gap: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor" style="color: #ffffff;"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                    Users
                </span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="#">Users List</a></li>
                <li><a class="dropdown-item" href="#">Employee List</a></li>
                <li><a class="dropdown-item" href="#">Student List</a></li>
            </ul>
        </div>
    </div>
    <div class="content">
        <div class="top-nav">
            <h3>Dashboard</h3>
            <div>
                <i class="fas fa-bell"></i> | <span>Christ Joy Recto Macuto</span>
                <img src="profile.jpg" alt="Profile" width="30" class="rounded-circle">
            </div>
        </div>
        <div class="table-content">
        <div class="container-fluid mt-5">
    
    <!-- Add Employee Button -->
    <button class="btn btn-primary mb-3" id="addEmployeeBtn">Add Employee</button>

    <table class="table table-bordered table-striped" id="userTable">
        <thead class="table-dark">
            <tr>
                <th>Id</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Position</th>
                <th>Action</th> <!-- New Action Column -->
            </tr>
        </thead>
        <tbody></tbody>
    </table>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEmployeeForm">
                    <div class="mb-3">
                        <label for="editFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPosition" class="form-label">Position</label>
                        <input type="text" class="form-control" id="editPosition" required>
                    </div>
                    <input type="hidden" id="editEmployeeId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEmployeeForm">
                    <div class="mb-3">
                        <label for="addFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="addFirstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="addLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="addLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="addEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="addEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="addPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="addPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="addPosition" class="form-label">Position</label>
                        <input type="text" class="form-control" id="addPosition" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addEmployeeBtnModal">Add Employee</button>
            </div>
        </div>
    </div>
</div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const token = localStorage.getItem("token");
    const role = localStorage.getItem("role");

    if (!token) {
        alert("Access Denied! Please log in first.");
        window.location.href = "index.php";
        return;
    }

    if (role != 1) {
        alert("Access Denied! Only admin can access this page.");
        window.location.href = "index.php";
        return;
    }

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
            { data: 'position' }, 
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-warning" onclick="editEmployee(${row.id})">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteEmployee(${row.id})">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    `;
                }
            }
        ]
    });

    fetch("http://backend.test/api/employees", {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + token,
        },
    })
    .then(response => response.json())
    .then(data => {
        table.clear();
        table.rows.add(data).draw();
    })
    .catch(error => console.error("Error fetching employees:", error));

    // Add Employee Modal
    document.getElementById("addEmployeeBtn").addEventListener("click", function() {
        const addModal = new bootstrap.Modal(document.getElementById('addEmployeeModal'));
        addModal.show();
    });

    // Add Employee Function
    document.getElementById("addEmployeeBtnModal").addEventListener("click", function() {
        const newEmployeeData = {
            first_name: document.getElementById("addFirstName").value,
            last_name: document.getElementById("addLastName").value,
            email: document.getElementById("addEmail").value,
            password: document.getElementById("addPassword").value,
            position: document.getElementById("addPosition").value,
        };

        fetch("http://backend.test/api/employees", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("token"),
            },
            body: JSON.stringify(newEmployeeData),
        })
        .then(response => response.json())
        .then(data => {
            alert("Employee added successfully!");
            window.location.reload(); // Reload the page to show the new employee in the table
        })
        .catch(error => console.error("Error adding employee:", error));
    });
});

// Edit Employee Function
function editEmployee(id) {
    fetch(`http://backend.test/api/employees/search?find=${id}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("token"),
        },
    })
    .then(response => response.json())
    .then(data => {
        if (!data || data.length === 0 || data.message) {
            throw new Error("Employee data not found");
        }

        // Check if data is an array and get the first item
        const employee = Array.isArray(data) ? data[0] : data;

        document.getElementById("editFirstName").value = employee.first_name || '';
        document.getElementById("editLastName").value = employee.last_name || '';
        document.getElementById("editEmail").value = employee.email || '';
        document.getElementById("editPosition").value = employee.position || '';
        document.getElementById("editEmployeeId").value = employee.id || '';

        const editModal = new bootstrap.Modal(document.getElementById('editEmployeeModal'));
        editModal.show();
    })
    .catch(error => {
        console.error("Error fetching employee details:", error);
        alert("Error loading employee: " + error.message);
    });
}

// Save Changes
document.getElementById("saveChangesBtn").addEventListener("click", function() {
    const employeeId = document.getElementById("editEmployeeId").value;
    const updatedData = {
        first_name: document.getElementById("editFirstName").value,
        last_name: document.getElementById("editLastName").value,
        email: document.getElementById("editEmail").value,
        position: document.getElementById("editPosition").value,
    };

    fetch(`http://backend.test/api/employees/${employeeId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("token"),
        },
        body: JSON.stringify(updatedData),
    })
    .then(response => response.json())
    .then(data => {
        alert("Employee updated successfully!");
        window.location.reload();
    })
    .catch(error => console.error("Error updating employee:", error));
});

// Delete Employee Function
function deleteEmployee(id) {
    if (confirm(`Are you sure you want to delete employee with ID: ${id}?`)) {
        fetch(`http://backend.test/api/employees/${id}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("token"),
            },
        })
        .then(response => response.json())
        .then(data => {
            alert("Employee deleted successfully!");
            window.location.reload();
        })
        .catch(error => console.error("Error deleting employee:", error));
    }
}


</script>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>







<?php
require 'templates/header.php';
require 'templates/sidebar.php';
// require 'templates/nav.php';
?>
<!-- Main Content -->
<div class="table-content">

<?php include 'templates/nav.php'; ?>

        <div class="container-fluid mt-5">
    
    <!-- Add Employee Button -->
    <button class="btn btn-primary mb-3" id="addEmployeeBtn">Add Employee</button>

    <table class="table table-bordered table-striped" id="userTable">
        <thead class="table-dark">
            <tr>
                <th>Id</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Position</th>
                <th>Action</th> <!-- New Action Column -->
            </tr>
        </thead>
        <tbody></tbody>
    </table>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEmployeeForm">
                    <div class="mb-3">
                        <label for="editFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPosition" class="form-label">Position</label>
                        <input type="text" class="form-control" id="editPosition" required>
                    </div>
                    <input type="hidden" id="editEmployeeId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEmployeeForm">
                    <div class="mb-3">
                        <label for="addFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="addFirstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="addLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="addLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="addEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="addEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="addPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="addPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="addPosition" class="form-label">Position</label>
                        <input type="text" class="form-control" id="addPosition" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addEmployeeBtnModal">Add Employee</button>
            </div>
        </div>
    </div>
</div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const token = localStorage.getItem("token");
    const role = localStorage.getItem("role");

    if (!token) {
        alert("Access Denied! Please log in first.");
        window.location.href = "index.php";
        return;
    }

    if (role != 1) {
        alert("Access Denied! Only admin can access this page.");
        window.location.href = "index.php";
        return;
    }

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
            { data: 'position' }, 
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-warning" onclick="editEmployee(${row.id})">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteEmployee(${row.id})">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    `;
                }
            }
        ]
    });

    fetch("http://backend.test/api/employees", {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + token,
        },
    })
    .then(response => response.json())
    .then(data => {
        table.clear();
        table.rows.add(data).draw();
    })
    .catch(error => console.error("Error fetching employees:", error));

    // Add Employee Modal
    document.getElementById("addEmployeeBtn").addEventListener("click", function() {
        const addModal = new bootstrap.Modal(document.getElementById('addEmployeeModal'));
        addModal.show();
    });

    // Add Employee Function
    document.getElementById("addEmployeeBtnModal").addEventListener("click", function() {
        const newEmployeeData = {
            first_name: document.getElementById("addFirstName").value,
            last_name: document.getElementById("addLastName").value,
            email: document.getElementById("addEmail").value,
            password: document.getElementById("addPassword").value,
            position: document.getElementById("addPosition").value,
        };

        fetch("http://backend.test/api/employees", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("token"),
            },
            body: JSON.stringify(newEmployeeData),
        })
        .then(response => response.json())
        .then(data => {
            alert("Employee added successfully!");
            window.location.reload(); // Reload the page to show the new employee in the table
        })
        .catch(error => console.error("Error adding employee:", error));
    });
});

// Edit Employee Function
function editEmployee(id) {
    fetch(`http://backend.test/api/employees/search?find=${id}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("token"),
        },
    })
    .then(response => response.json())
    .then(data => {
        if (!data || data.length === 0 || data.message) {
            throw new Error("Employee data not found");
        }

        // Check if data is an array and get the first item
        const employee = Array.isArray(data) ? data[0] : data;

        document.getElementById("editFirstName").value = employee.first_name || '';
        document.getElementById("editLastName").value = employee.last_name || '';
        document.getElementById("editEmail").value = employee.email || '';
        document.getElementById("editPosition").value = employee.position || '';
        document.getElementById("editEmployeeId").value = employee.id || '';

        const editModal = new bootstrap.Modal(document.getElementById('editEmployeeModal'));
        editModal.show();
    })
    .catch(error => {
        console.error("Error fetching employee details:", error);
        alert("Error loading employee: " + error.message);
    });
}

// Save Changes
document.getElementById("saveChangesBtn").addEventListener("click", function() {
    const employeeId = document.getElementById("editEmployeeId").value;
    const updatedData = {
        first_name: document.getElementById("editFirstName").value,
        last_name: document.getElementById("editLastName").value,
        email: document.getElementById("editEmail").value,
        position: document.getElementById("editPosition").value,
    };

    fetch(`http://backend.test/api/employees/${employeeId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("token"),
        },
        body: JSON.stringify(updatedData),
    })
    .then(response => response.json())
    .then(data => {
        alert("Employee updated successfully!");
        window.location.reload();
    })
    .catch(error => console.error("Error updating employee:", error));
});

// Delete Employee Function
function deleteEmployee(id) {
    if (confirm(`Are you sure you want to delete employee with ID: ${id}?`)) {
        fetch(`http://backend.test/api/employees/${id}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("token"),
            },
        })
        .then(response => response.json())
        .then(data => {
            alert("Employee deleted successfully!");
            window.location.reload();
        })
        .catch(error => console.error("Error deleting employee:", error));
    }
}


</script>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php
require 'templates/footer.php';
?>
