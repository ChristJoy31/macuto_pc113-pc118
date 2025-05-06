<!-- <?php
require 'templates/header.php';
require 'templates/sidebar.php';
include 'templates/nav.php';
?>

<div class="table-content p-4">
    <div id="adminSection" style="display: none;">
        <?php include 'admin/dashboard.php'; ?>
    </div>

    <div id="secretarySection" style="display: none;">
        <?php include 'secretary/dashboard.php'; ?>
    </div>

    <div id="residentSection" style="display: none;">
        <?php include 'resident/dashboard.php'; ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch('http://backend.test/api/user-info', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        })
        .then(res => res.json())
        .then(user => {
            if (parseInt(user.role) === 1) {
                document.getElementById('adminSection').style.display = 'block';
            } else if (parseInt(user.role) === 2) {
                document.getElementById('secretarySection').style.display = 'block';
            } else if (parseInt(user.role) === 3) {
                document.getElementById('residentSection').style.display = 'block';
            }
        })
        .catch(err => {
            console.error("Error fetching user info", err);
        });
    });
</script>

<?php require 'templates/footer.php'; ?> -->
