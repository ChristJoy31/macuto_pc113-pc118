<?php
require '../templates/header.php';
require '../templates/sidebar.php';
include '../templates/nav.php';
?>

<!-- Main Content -->
<div class="table-content p-4">    
    <div class="container-fluid mt-4">
        <!-- Title and Add Employee Button -->
        <div class="d-flex justify-content-start align-items-right mb-3">
            <button class="btn btn-primary shadow" id="addUserBtn">
                <i class="bi bi-person-plus"></i> Add User
            </button>
        </div>
        <!-- User DataTable -->
        <div class="table-responsive">
            <table class="table table-hover text-center shadow-sm" id="userTable">
                <thead class="table-primary text-dark">
                    <tr>
                        <th>ID</th>
                        <th>Action</th>
                        <th>Photo</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Role</th>
                        
                    </tr>
                </thead>
                <tbody id="userTableBody">
    <!-- New user rows will be added here via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
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
                        <select class="form-select" id="addRole" required>
                            <option value="1">Admin</option>
                            <option value="2">Secretary</option>
                            <option value="3">Resident</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="file" id="addPhoto" name="photo" class="dropify"
                            data-allowed-file-extensions="jpg jpeg png"
                            data-max-file-size="10M" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addUserBtnModal">Add User</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
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
                        <select class="form-select" id="editRole" required>
                            <option value="1">Admin</option>
                            <option value="2">Secretary</option>
                            <option value="3">Resident</option>
                        </select>
                    </div>
                     <div class="mb-3">
                        <input type="file" id="editPhoto" name="photo" class="dropify"
                            data-default-file="path/to/existing/photo.jpg"
                            data-allowed-file-extensions="jpg jpeg png"
                            data-max-file-size="10M" />
                    </div>
                    <input type="hidden" id="editUserId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>
    $('.dropify').dropify();
     const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    });

    // Fetch user data function
function fetchUsers() {
    const token = localStorage.getItem("token"); // Token is needed for the request
    fetch("https://bmsbackend.christjoy.site/api/users-admin", {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + token,
        },
    })
    .then(response => response.json())
    .then(data => {
        table.clear();
        table.rows.add(data).draw();  // Assuming `table` is your DataTable instance
    })
    .catch(error => console.error("Error fetching users:", error));
}
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
    table = $('#userTable').DataTable({
    columnDefs: [
        { targets: 0, visible: false }  // Hide the ID column
    ],
    columns: [
        { data: 'id' },  // Hidden ID column
        {
            data: 'id',
            render: function(data, type, row) {
                return `
                        <div class="d-flex align-items-center justify-content-start">
                            <a href="#" class="text-decoration-none d-flex align-items-center me-2 text-success" onclick="viewUser(${row.id})">
                            <i class="bi bi-eye me-1"></i> View
                            </a>
                            <span class="mx-1">|</span>
                         <a href="#" class="text-decoration-none d-flex align-items-center me-2 text-primary" onclick="editUser(${row.id})">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                        <span class="mx-1">|</span>
                        <a href="#" class="text-decoration-none d-flex align-items-center text-danger" onclick="deleteUser(${row.id})">
                            <i class="bi bi-trash me-1"></i> Delete
                        </a>
                        </div>
                `;
            }
        },  
        { 
            data: 'photo',
            render: function(data) {
                if (!data) return 'No Photo';
                return `<img src="https://bmsbackend.christjoy.site/storage/${data}" alt="Employee Photo" width="50" height="50" class="rounded-circle"/>`;
            }
        },
        { data: 'first_name' },
        { data: 'last_name' },
        { data: 'email' },
        { 
            data: 'role', 
            render: function(data) {
                if (data == 1) return `<span class="badge bg-primary">Admin</span>`;
                if (data == 2) return `<span class="badge bg-warning text-dark">Secretary</span>`;
                if (data == 3) return `<span class="badge bg-success">Resident</span>`;
                return `<span class="badge bg-secondary">Unknown</span>`;  // In case of unexpected values
            }
        },
        
    ]
});

    fetchUsers();

    // Open Add User Modal
    document.getElementById("addUserBtn").addEventListener("click", function() {
        const addModal = new bootstrap.Modal(document.getElementById('addUserModal'));
        addModal.show();
    });

    // Add User Function
    document.getElementById("addUserBtnModal").addEventListener("click", function () {
    const formData = new FormData();
    formData.append("first_name", document.getElementById("addFirstName").value);
    formData.append("last_name", document.getElementById("addLastName").value);
    formData.append("email", document.getElementById("addEmail").value);
    formData.append("role", document.getElementById("addRole").value);
    formData.append("photo", document.getElementById("addPhoto").files[0]);

    fetch("https://bmsbackend.christjoy.site/api/users-admin", {
        method: "POST",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token"),
            "Accept": "application/json",
        },
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // SweetAlert success notification
            Toast.fire({
                icon: 'success',
                title: 'User added successfully. Email Sent!'
            });

            // Close the modal
            const addModal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            addModal.hide(); // Close the modal

            // Clear the form inputs
            document.getElementById("addFirstName").value = "";
            document.getElementById("addLastName").value = "";
            document.getElementById("addEmail").value = "";
            document.getElementById("addRole").value = "";

            // Refresh the table data
            fetchUsers(); // Call fetchUsers to update the table

        } else {
            // Handle errors if the creation fails
            Toast.fire({
                icon: 'error',
                title: data.message || 'Failed to add user and email not sent'
            });
            console.error("Validation error:", data);
        }
    })
    .catch(error => {
        // Handle any network or other errors
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong!'
        });
        console.error("Error adding user:", error);
    });
});

});



// Edit Employee Function
function editUser(id) {
    fetch(`https://bmsbackend.christjoy.site/api/users-admin/search?find=${id}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("token"),
        },
    })
    
    .then(response => response.json())
    .then(data => {
        if (!data || data.length === 0 || data.message) {
            throw new Error("User data not found");
        }

        // Check if data is an array and get the first item
        const user = Array.isArray(data) ? data[0] : data;

        document.getElementById("editFirstName").value = user.first_name || '';
        document.getElementById("editLastName").value = user.last_name || '';
        document.getElementById("editEmail").value = user.email || '';
        document.getElementById("editRole").value = user.role || '';
        document.getElementById("editUserId").value = user.id || '';


        const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        editModal.show();
    })  
    .catch(error => {
        console.error("Error fetching user details:", error);
        alert("Error loading user: " + error.message);
    });
}

// Save Changes
document.getElementById("saveChangesBtn").addEventListener("click", function() {
    const userId = document.getElementById("editUserId").value;
    const updatedData = {
        first_name: document.getElementById("editFirstName").value,
        last_name: document.getElementById("editLastName").value,
        email: document.getElementById("editEmail").value,
        role: document.getElementById("editRole").value,
    };

    fetch(`https://bmsbackend.christjoy.site/api/users-admin/${userId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("token"),
        },
        body: JSON.stringify(updatedData),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // SweetAlert success notification
            Toast.fire({
                icon: 'success',
                title: data.message || 'User updated successfully!'
            });

            // Close the modal
            const editModal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            editModal.hide(); // Close the modal

            // Clear the form inputs
            document.getElementById("editFirstName").value = "";
            document.getElementById("editLastName").value = "";
            document.getElementById("editEmail").value = "";
            document.getElementById("editRole").value = "";

            // Refresh the table data by fetching the latest users
            fetchUsers(); // This will refresh the entire table
        } else {
            // Handle errors if the update fails
            Toast.fire({
                icon: 'error',
                title: data.message || 'Failed to edit user'
            });
            console.error("Validation error:", data);
        }
    })
    .catch(error => {
        // Handle any network or other errors
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong!'
        });
        console.error("Error editing user:", error);
    });
});



// Delete Employee Function

function deleteUser(id) {
    Swal.fire({
    title: 'Are you sure?',
    text: `You are about to delete user with ID: ${id}`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
}).then((result) => {
    if (result.isConfirmed) {
        fetch(`https://bmsbackend.christjoy.site/api/users-admin/${id}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("token"),
            },
        })
        .then(response => response.json())
        .then(data => {
            Toast.fire({
                icon: 'success',
                title: 'User deleted successfully!'
            });
            fetchUsers(); // Refresh user list
        })
        .catch(error => {
            Toast.fire({
                icon: 'error',
                title: 'Error deleting user!'
            });
            console.error("Error deleting user:", error);
        });
    }
});
}





</script>

</body>
</html>


<?php
require '../templates/footer.php'
?>