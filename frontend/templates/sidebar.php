<div class="sidebar">
    <h3>BMS PORTAL</h3>
    
    <!-- Dashboard link (Visible for all roles) -->
    <a href="dashboard.php" class="active">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M9 3a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2zm0 12a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-2a2 2 0 0 1 2 -2zm10 -4a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2zm0 -8a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-2a2 2 0 0 1 2 -2z"/>
        </svg>
        Dashboard
    </a>

    <!-- Admin Only Links -->
    <div id="adminLinks" class="d-none">
        <a href="UserList.php">
            <i class="bi bi-people-fill"></i> Users
        </a>
        
        <a href="UserProfile.php">
            <i class="bi bi-person-fill"></i> User Profile
        </a>

        <a href="FileUpload.php">
            <i class="bi bi-cloud-upload-fill"></i> File Upload
        </a>
    </div>

    <!-- Secretary Only Links -->
    <div id="secretaryLinks" class="d-none">
        <a href="documentRequest.php">
            <i class="bi bi-file-earmark-text"></i> Document Requests
        </a>

        <a href="announcements.php">
            <i class="bi bi-megaphone"></i> Announcements
        </a>
    </div>

    <!-- Resident Only Links -->
    <div id="residentLinks" class="d-none">
        <a href="requestDocument.php">
            <i class="bi bi-journal-plus"></i> Request Document
        </a>

        <a href="my-requests.php">
            <i class="bi bi-folder2-open"></i> My Requests
        </a>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch('https://bmsbackend.christjoy.site/api/user-info', {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
    })
    .then(res => res.json())
    .then(user => {
        
        // Hide all sections first
        document.getElementById('adminLinks').classList.add('d-none');
        document.getElementById('secretaryLinks').classList.add('d-none');
        document.getElementById('residentLinks').classList.add('d-none');

        const role = parseInt(user.role);
        // Show links based on user role
        if (role === 1) {
            document.getElementById('adminLinks').classList.remove('d-none');
        } else if (role === 2) {
            document.getElementById('secretaryLinks').classList.remove('d-none');
        } else if (role === 3) {
            document.getElementById('residentLinks').classList.remove('d-none');
        }

    })
    .catch(err => {
        console.error("Error fetching user info", err);
    });
});
</script>
