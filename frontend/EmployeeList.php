<?php
require 'templates/header.php';
require 'templates/sidebar.php';
// require 'templates/nav.php';
?>
<!-- Main Content -->
<div class="table-content p-4">
<div class="table-content p-4">
    <?php include 'templates/nav.php'; ?>
    
    <div class="container-fluid mt-4">
        <!-- Title and Add Employee Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary shadow" id="addEmployeeBtn">
                <i class="bi bi-person-plus"></i> Add Employee
            </button>
        </div>

        <!-- User DataTable -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center shadow-sm" id="userTable">
                <thead class="table-primary text-light">
                    <tr>
                        <th>ID</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="align-middle"></tbody>
            </table>
        </div>
    </div>
</div>


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
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteEmployee(${row.id})">
                               <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
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
require 'templates/footer.php'
?>