<?php
require '../templates/header.php';
require '../templates/sidebar.php';
include '../templates/nav.php';
?>
<div class="table-content p-4">    
<div class="container-fluid mt-4">




<div class="row" id="profile-content">
  <!-- Left Panel -->
  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        Profile
      </div>
      <div class="card-body">
        <p class="fw-semibold">Personal Information</p>

        <div class="row">
          <div class="col-md-6 profile-line"><span class="label">First Name:</span> <span class="value" id="first_name"></span></div>
          <div class="col-md-6 profile-line"><span class="label">Last Name:</span> <span class="value" id="last_name"></span></div>
          <div class="col-md-6 profile-line"><span class="label">Middle Name:</span> <span class="value" id="middle_name"></span></div>
          <div class="col-md-6 profile-line"><span class="label">Suffix:</span> <span class="value" id="suffix"></span></div>
          <div class="col-md-6 profile-line"><span class="label">Email:</span> <span class="value" id="email"></span></div>
          <div class="col-md-6 profile-line"><span class="label">Contact Number:</span> <span class="value" id="contact_number"></span></div>
          <div class="col-md-6 profile-line"><span class="label">Gender:</span> <span class="value" id="gender"></span></div>
          <div class="col-md-6 profile-line"><span class="label">Birthdate:</span> <span class="value" id="birthdate"></span></div>
          <div class="col-md-6 profile-line"><span class="label">Civil Status:</span> <span class="value" id="civil_status"></span></div>
          <div class="col-md-6 profile-line"><span class="label">Citizenship:</span> <span class="value" id="citizenship"></span></div>
          <div class="col-md-6 profile-line"><span class="label">Religion:</span> <span class="value" id="religion"></span></div>
          <div class="col-md-6 profile-line"><span class="label">Position:</span> <span class="value" id="position"></span></div>
          <div class="col-md-12 profile-line"><span class="label">Address:</span> <span class="value" id="address"></span></div>
          <div class="col-md-12 profile-line"><span class="label">Role:</span> <span class="value" id="role"></span></div>
        </div>

        <div class="mt-3">
          <a href="#" id="editProfileBtn" class="btn btn-primary btn-sm me-2">Edit Profile</a>
          <a href="{{ route('profile.change-password') }}" class="btn btn-secondary btn-sm">Change Password</a>
        </div>
      </div>
    </div>
  </div>


<!-- Right Panel: Photo + QR -->
<div class="col-md-4">
  <div class="card text-center shadow-sm">
    <div class="card-body">
      <img id="profilePhoto" class="rounded-circle mb-3" width="100" height="100" alt="Profile Photo">
      <img id="qrCode" class="img-fluid mb-2" width="180" alt="QR Code">
      <div class="text-muted">
        <small id="positionLabel"></small><br>
        <small id="roleLabel"></small>
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
   function loadUserProfile() {
    fetch("http://backend.test/api/user-profile", {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("token"), // Make sure token is correct
        },
    })
    .then(response => response.json())
    .then(data => {
        // Basic fields
        document.getElementById("first_name").textContent = data.name.split(" ")[0];
        document.getElementById("last_name").textContent = data.name.split(" ")[1];
        document.getElementById("email").textContent = data.email;
        document.getElementById("role").textContent = data.role;
        document.getElementById("profilePhoto").src = `http://backend.test/storage/${data.photo}`;

        // Conditional fields
        if (data.role === "resident") {
            document.getElementById("contact_number").textContent = data.contact_number;
            document.getElementById("address").textContent = data.address;
            document.getElementById("gender").textContent = data.gender;
            document.getElementById("birthdate").textContent = data.birthdate;
            document.getElementById("civil_status").textContent = data.civil_status;
            document.getElementById("citizenship").textContent = data.citizenship;
            document.getElementById("religion").textContent = data.religion;
        } else if (data.role === "admin" || data.role === "secretary") {
            document.getElementById("position").textContent = data.position;
            document.getElementById("contact_number").textContent = data.contact_number;
        }

        // Optional text labels
        document.getElementById("positionLabel").textContent = data.position ?? '';
        document.getElementById("roleLabel").textContent = data.role;

    })
    .catch(error => {
        console.error("Error fetching profile:", error);
    });
}

// Call this function when the page loads
loadUserProfile();


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
<?php
require '../templates/footer.php'
?>