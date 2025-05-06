<?php
require 'templates/header.php';
require 'templates/sidebar.php';
include 'templates/nav.php';
?>
<div class="table-content p-4">    
<div class="container-fluid mt-4">

<div class="container mt-4">
  <div class="card shadow p-4">
    <div class="row">
      <div class="col-md-3 text-center">
        <img id="profilePhoto" src="" class="rounded-circle mb-3" width="150" height="150" alt="User Photo">
      </div>
      <div class="col-md-9">
        <h4 class="mb-3">Personal Information</h4>
        <div class="row mb-2">
          <div class="col-sm-3 fw-bold">Firstname:</div>
          <div class="col-sm-9" id="firstName"></div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-3 fw-bold">Lastname:</div>
          <div class="col-sm-9" id="lastName"></div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-3 fw-bold">Email:</div>
          <div class="col-sm-9" id="email"></div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-3 fw-bold">Role:</div>
          <div class="col-sm-9" id="Role"></div>
        </div>
        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit Information</button>
      </div>
    </div>
  </div>
</div>
</div>
</div>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit Profile</h5>
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
                        <label for="editRole" class="form-label">Role</label>
                        <input type="text" class="form-control" id="editRole" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhoto" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="addPhoto" accept="image/*">
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
    console.log("User ID:", localStorage.getItem("user_id"));
    console.log("Token:", localStorage.getItem("token"));
document.addEventListener("DOMContentLoaded", function () {
    const userId = localStorage.getItem("user_id");
    if (userId) {
        fetch(`http://backend.test/api/users-admin/search?find=${userId}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("token"),
            },
        })
        .then(response => response.json())
        .then(data => {
            const user = Array.isArray(data) ? data[0] : data;

            document.getElementById("firstName").textContent = user.first_name || '';
            document.getElementById("lastName").textContent = user.last_name || '';
            document.getElementById("email").textContent = user.email || '';
            document.getElementById("Role").textContent = user.role || '';
            document.getElementById("profilePhoto").src = user.photo 
                ? `http://backend.test/storage/${data}` 
                : "https://via.placeholder.com/150";

            document.getElementById("editUserId").value = user.id;
            document.getElementById("editFirstName").value = user.first_name || '';
            document.getElementById("editLastName").value = user.last_name || '';
            document.getElementById("editEmail").value = user.email || '';
            document.getElementById("editRole").value = user.role || '';
        })
        .catch(error => {
            console.error("Failed to fetch user:", error);
        });
    }
});

// Edit Employee Function (optional - not used directly in this version)
function editUser(id) {
    fetch(`http://backend.test/api/users-admin/search?find=${id}`, {
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

    fetch(`http://backend.test/api/users-admin/${userId}`, {
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
            Toast.fire({
                icon: 'success',
                title: data.message || 'User updated successfully!'
            });

            const editModal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            editModal.hide();

            // Update personal info UI
            document.getElementById("firstName").textContent = updatedData.first_name;
            document.getElementById("lastName").textContent = updatedData.last_name;
            document.getElementById("email").textContent = updatedData.email;
            document.getElementById("Role").textContent = updatedData.role;

            // Clear form
            document.getElementById("editFirstName").value = "";
            document.getElementById("editLastName").value = "";
            document.getElementById("editEmail").value = "";
            document.getElementById("editRole").value = "";

        } else {
            Toast.fire({
                icon: 'error',
                title: data.message || 'Failed to edit user'
            });
        }
    })
    .catch(error => {
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong!'
        });
        console.error("Error editing user:", error);
    });
});
</script>
