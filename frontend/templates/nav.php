<?php
include '../templates/header.php'
?>
        <div class="content">
        <div class="top-nav d-flex justify-content-between align-items-center px-3 py-2 border-bottom bg-light">
    <h3 class="m-0">Dashboard</h3>

    <div class="dropdown d-flex align-items-center" id="user-info">
        <!-- Placeholder while loading -->
        <img src="assets/img/default.png" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
        <a class="nav-link text-dark btn dropdown-toggle p-2" data-bs-toggle="dropdown" aria-expanded="false">
            Loading...
        </a>
        <ul class="dropdown-menu nav-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item text-light bg-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" id="logoutLink">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </ul>
    </div>
</div>


<script>
  fetch("http://backend.test/api/user-profile", {
    method: "GET",
    headers: {
      "Authorization": "Bearer " + localStorage.getItem("token")
    }
  })
  .then(response => response.json())
  .then(data => {
    const userInfo = document.getElementById("user-info");

    const photoUrl = data.photo 
      ? `http://backend.test/storage/${data.photo}` 
      : '/frontend/assets/img/default.png';

    userInfo.innerHTML = `
      <img src="${photoUrl}" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
      <a class="nav-link text-dark btn dropdown-toggle p-2" data-bs-toggle="dropdown" aria-expanded="false">
        Hi, ${data.name}
      </a>
      <ul class="dropdown-menu nav-menu dropdown-menu-end">
        <a class="dropdown-item text-light bg-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" id="logoutLink">
          <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
      </ul>
    `;
  })
  .catch(error => {
    console.error("Failed to load user info:", error);
  });

  function logout() {
    localStorage.removeItem("token");
    localStorage.removeItem("role");
    window.location.href = "http://frontend.test/login.php";
  }
</script>

