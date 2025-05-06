<?php
require 'templates/header.php';
require 'templates/sidebar.php';
include 'templates/nav.php';
?>

<div class="container mt-4">
    <h3>Create New Role</h3>
    <form id="createRoleForm">
        <div class="mb-3">
            <label for="roleName" class="form-label">Role Name</label>
            <input type="text" class="form-control" id="roleName" name="role_name" required>
        </div>

        <div class="row">
            <!-- CRUD Permissions -->
            <div class="col-md-6">
                <div class="card shadow mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">CRUD Permissions</h5>
                    </div>
                    <div class="card-body" id="crudPermissions">
                        <!-- Dynamic CRUD permissions will load here -->
                    </div>
                </div>
            </div>

            <!-- System Features -->
            <div class="col-md-6">
                <div class="card shadow mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">System Features</h5>
                    </div>
                    <div class="card-body" id="systemFeatures">
                        <!-- Dynamic system features will load here -->
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Role</button>
    </form>
</div>

<script>
const token = localStorage.getItem('token'); //kuha token kung naa

// Fetch the list of permissions and features
fetch('http://backend.test/api/permissions', {
    headers: {
        'Authorization': 'Bearer ' + token,
        'Accept': 'application/json'
    }
})
.then(response => response.json())
.then(data => {
    let crudPermissions = document.getElementById('crudPermissions');
    let systemFeatures = document.getElementById('systemFeatures');

    // Loop for CRUD
    data.crud.forEach(crud => {
        crudPermissions.innerHTML += `
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="crud[]" value="${crud}" id="crud-${crud}">
                <label class="form-check-label" for="crud-${crud}">${crud}</label>
            </div>
        `;
    });

    // Loop for Features
    data.features.forEach(feature => {
        systemFeatures.innerHTML += `
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="features[]" value="${feature}" id="feature-${feature}">
                <label class="form-check-label" for="feature-${feature}">${feature}</label>
            </div>
        `;
    });
})
.catch(error => console.error('Error fetching permissions:', error));

// Handle submit
document.getElementById('createRoleForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('http://backend.test/api/roles', {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        body: formData
    })
    .then(response => {
        if (response.ok) {
            alert('Role created successfully!');
            location.reload();
        } else {
            alert('Failed to create role.');
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>

<?php
require 'templates/footer.php';
?>
