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
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name</label>
                    <div class="form-control"  id="first_name" ></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <div class="form-control" id="last_name" ></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Middle Name</label>
                    <div class="form-control"  id="middle_name" ></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Suffix</label>
                    <div class="form-control"  id="suffix" ></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <div class="form-control"  id="email" ></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Number</label>
                    <div class="form-control"  id="contact_number" ></div>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Address</label>
                    <div class="form-control"  id="address" ></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Gender</label>
                    <div class="form-control"  id="gender" ></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Birthdate</label>
                    <div class="form-control"  id="birthdate" ></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Civil Status</label>
                    <div class="form-control" id="civil_status" ></div>

                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Citizenship</label>
                    <div class="form-control"  id="citizenship"  ></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Religion</label>
                    <div class="form-control"  id="religion"  ></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Position</label>
                    <div class="form-control"  id="position"  ></div>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Role</label>
                    <div class="form-control"  id="role"  ></div>
                </div>
                </div>

                <div class="mt-3">
                <a href="#" onclick="editUserProfile()" class="btn btn-primary btn-sm me-2">Edit Profile</a>
                <a href="/change-password.php" class="btn btn-secondary btn-sm">Change Password</a>

                </div>
            </div>
            </div>
        </div>




        <!-- Right Panel: Photo + QR -->
        <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
            <img id="profilePhoto" class="rounded-circle mb-3" width="100" height="100" alt="Profile Photo">
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
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="editUserForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="editFirstName" name="first_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editLastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="editLastName" name="last_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editMiddleName" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="editMiddleName" name="middle_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editSuffix" class="form-label">Suffix</label>
                                <input type="text" class="form-control" id="editSuffix" name="suffix">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editContactNumber" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="editContactNumber" name="contact_number">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="editAddress" class="form-label">Address</label>
                                <textarea class="form-control" id="editAddress" name="address"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editGender" class="form-label">Gender</label>
                                <select class="form-select" id="editGender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editBirthdate" class="form-label">Birthdate</label>
                                <input type="date" class="form-control" id="editBirthdate" name="birthdate">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editCivilStatus" class="form-label">Civil Status</label>
                                <select class="form-select" id="editCivilStatus" name="civil_status">
                                    <option value="">Select</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editCitizenship" class="form-label">Citizenship</label>
                                <input type="text" class="form-control" id="editCitizenship" name="citizenship">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editReligion" class="form-label">Religion</label>
                                <input type="text" class="form-control" id="editReligion" name="religion">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editPosition" class="form-label">Position</label>
                                <input type="text" class="form-control" id="editPosition" name="position">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editRole" class="form-label">Role</label>
                                <select class="form-select" id="editRole" name="role">
                                    <option value="1">Admin</option>
                                    <option value="2">Secretary</option>
                                    <option value="3">Resident</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                        <form id="uploadForm" action="#" method="POST" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="mb-3">
                            <label for="document" class="form-label">Upload Profile Picture</label>
                            <input type="file" id="document" name="document" class="dropify"
                              data-allowed-file-extensions="pdf doc docx"
                             data-max-file-size="10M" />
                              </div>
                             </form>
                            </div>
                        </div>
                        <input type="hidden" id="editUserId" name="user_id">
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
        // Load user profile data and populate the page
        function loadUserProfile() {
        fetch("http://backend.test/api/user-profile", {
            method: "GET",
            headers: {
            "Authorization": "Bearer " + localStorage.getItem("token"),
            "Content-Type": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data) {
                console.log(data);
            // Fill display fields directly
            document.getElementById("first_name").textContent = data.first_name || "";
            document.getElementById("last_name").textContent = data.last_name || "";
            document.getElementById("middle_name").textContent = data.middle_name || "";
            document.getElementById("suffix").textContent = data.suffix || "";
            document.getElementById("email").textContent = data.email || "";
            document.getElementById("contact_number").textContent = data.contact_number || "";
            document.getElementById("address").textContent = data.address || "";
            document.getElementById("gender").textContent = data.gender || "";
            document.getElementById("birthdate").textContent = data.birthdate || "";
            document.getElementById("civil_status").textContent = data.civil_status || "";
            document.getElementById("citizenship").textContent = data.citizenship || "";
            document.getElementById("religion").textContent = data.religion || "";
            document.getElementById("position").textContent = data.position || "";

            // Handle role text
            const roleText = convertRole(data.role); 
            document.getElementById("role").textContent = roleText;
            document.getElementById("roleLabel").textContent = roleText;
            document.getElementById("positionLabel").textContent = data.position || "";

            // Handle photo
            if (data.photo) {
                document.getElementById("profilePhoto").src = `http://backend.test/storage/${data.photo}`;
            } else {
                document.getElementById("profilePhoto").src = "default-profile.png";
            }
            }
        })
        .catch(err => {
            console.error("Error loading profile:", err);
        });
        }

        // Convert role value (1,2,3) to text
        function convertRole(role) {
        switch (parseInt(role)) {
            case 1: return "Admin";
            case 2: return "Secretary";
            case 3: return "Resident";
            default: return "Unknown";
        }
        }


        // Capitalize first letter helper
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        // Open edit modal and pre-fill the form with current profile data
        function editUserProfile() {
    fetch("http://backend.test/api/user-profile", {
        method: "GET",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token"),
            "Content-Type": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data) {
            document.getElementById("editFirstName").value = data.first_name || "";
            document.getElementById("editLastName").value = data.last_name || "";
            document.getElementById("editMiddleName").value = data.middle_name || "";
            document.getElementById("editSuffix").value = data.suffix || "";
            document.getElementById("editEmail").value = data.email || "";
            document.getElementById("editContactNumber").value = data.contact_number || "";
            document.getElementById("editAddress").value = data.address || "";
            document.getElementById("editGender").value = data.gender || "";
            document.getElementById("editBirthdate").value = data.birthdate || "";
            document.getElementById("editCivilStatus").value = data.civil_status || "";
            document.getElementById("editCitizenship").value = data.citizenship || "";
            document.getElementById("editReligion").value = data.religion || "";
            document.getElementById("editPosition").value = data.position || "";
            document.getElementById("editRole").value = data.role || "";
            document.getElementById("editUserId").value = data.id || "";

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById("editUserModal"));
            modal.show();
        }
    });
}


document.getElementById("saveChangesBtn").addEventListener("click", function () {
    const userId = document.getElementById("editUserId").value;
    const formData = new FormData();
    formData.append("first_name", document.getElementById("editFirstName").value);
    formData.append("last_name", document.getElementById("editLastName").value);
    formData.append("middle_name", document.getElementById("editMiddleName").value);
    formData.append("suffix", document.getElementById("editSuffix").value);
    formData.append("email", document.getElementById("editEmail").value);
    formData.append("contact_number", document.getElementById("editContactNumber").value);
    formData.append("address", document.getElementById("editAddress").value);
    formData.append("gender", document.getElementById("editGender").value);
    formData.append("birthdate", document.getElementById("editBirthdate").value);
    formData.append("civil_status", document.getElementById("editCivilStatus").value);
    formData.append("citizenship", document.getElementById("editCitizenship").value);
    formData.append("religion", document.getElementById("editReligion").value);
    formData.append("position", document.getElementById("editPosition").value);
    formData.append("role", document.getElementById("editRole").value);
    formData.append("photo", document.getElementById("editPhoto").files[0]);
    formData.append("id", userId);

        console.log("FormData values:");
    for (let [key, value] of formData.entries()) {
        console.log(`${key}:`, value);
    }

    fetch(`http://backend.test/api/users-admin/${userId}`, {
        method: "POST",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token")
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        console.log("Response data:", data);
        Swal.fire("Success", "Profile updated successfully!", "success");
        const modal = bootstrap.Modal.getInstance(document.getElementById("editUserModal"));
        modal.hide();
        loadUserProfile();
    })
    .catch(error => {
        Swal.fire("Error", "Failed to update profile.", "error");
        console.error(error);
    });
});



        // Load profile on page load
        document.addEventListener("DOMContentLoaded", () => {
            loadUserProfile();
        });
        </script>

        <?php
        require '../templates/footer.php'
        ?>