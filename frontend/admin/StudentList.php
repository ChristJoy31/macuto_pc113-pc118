<?php
require 'templates/header.php';
require 'templates/sidebar.php';
include 'templates/nav.php';
?>
<div class="hehe">
<!-- Main Content -->
<div class="col-md-9 col-lg-10 p-4 offset-md-3 offset-lg-2">
            <table class="table table-bordered table-striped" id="userTable">
                <thead class="table-light">
                    <tr>
                        <th>Id</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Action</th> <!-- New Action Column -->
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm">
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
                        <label for="editCourse" class="form-label">Course</label>
                        <input type="text" class="form-control" id="editCourse" required>
                    </div>
                    <input type="hidden" id="editStudentId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>
</div>
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
                    data: 'id', // Action column
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
            table.clear().rows.add(data).draw();
        })
        .catch(error => console.error("Error fetching data:", error));
    });

    // Edit Student Function
function editStudent(id) {
    // Show loading state
    const saveBtn = document.getElementById("saveChangesBtn");
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
 
     // Clear previous data to prevent displaying old information
        document.getElementById("editFirstName").value = "";
        document.getElementById("editLastName").value = "";
        document.getElementById("editEmail").value = "";
        document.getElementById("editCourse").value = "";
        document.getElementById("editStudentId").value = "";

    fetch(`http://backend.test/api/students/${id}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("token"),
        },
    })
    .then(async response => {
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || `HTTP status ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        // Handle different response structures
        const student = data.student || data.data || data[0] || data;
        
        if (!student) {
            throw new Error("Student data not found in response");
        }

        // Set default empty string if field is undefined
        document.getElementById("editFirstName").value = student.first_name || student.firstName || '';
        document.getElementById("editLastName").value = student.last_name || student.lastName || '';
        document.getElementById("editEmail").value = student.email || '';
        document.getElementById("editCourse").value = student.course || student.course_name || '';
        document.getElementById("editStudentId").value = student.id || '';

        // Show the modal
        const editModal = new bootstrap.Modal(document.getElementById('editStudentModal'));
        editModal.show();
    })
    .catch(error => {
        console.error("Error fetching student details:", error);
        alert("Error loading student: " + error.message);
    })
    .finally(() => {
        saveBtn.disabled = false;
        saveBtn.textContent = 'Save changes';
    });
}

    // Save changes in the modal
    document.getElementById("saveChangesBtn").addEventListener("click", function () {
    const studentId = document.getElementById("editStudentId").value;

    if (!studentId) {
        alert("Error: Missing student ID.");
        return;
    }

    const updatedData = {
        first_name: document.getElementById("editFirstName").value,
        last_name: document.getElementById("editLastName").value,
        email: document.getElementById("editEmail").value,
        course: document.getElementById("editCourse").value,
    };

    console.log("Sending data:", JSON.stringify(updatedData)); // Debugging

    fetch(`http://backend.test/api/students/${studentId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("token"),
        },
        body: JSON.stringify(updatedData),
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw new Error(JSON.stringify(err)); });
        }
        return response.json();
    })
    .then(data => {
        alert("Student updated successfully!");
        window.location.reload();
    })
    .catch(error => {
        console.error("Error updating student:", error);
        alert("Error updating student: " + error.message);
    });
});


    // Delete Student Function
    function deleteStudent(id) {
        if (confirm(`Are you sure you want to delete student with ID: ${id}?`)) {
            fetch(`http://backend.test/api/students/${id}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("HTTP status " + response.status);
                }
                return response.json();
            })
            .then(data => {
                alert("Student deleted successfully!");
                window.location.reload(); // Refresh the page to reflect changes
            })
            .catch(error => console.error("Error deleting student:", error));
        }
    }
</script>

<?php

require 'templates/footer.php';
?>


