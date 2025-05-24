<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background-color: #f8f9fa;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
    }

    .login-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      padding: 40px 30px;
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .login-card img {
      max-width: 80px;
      margin-bottom: 20px;
    }

    .login-title {
      font-weight: 600;
      margin-bottom: 1.5rem;
    }

    .form-label {
      font-weight: 500;
      text-align: left;
      display: block;
    }

    .form-control:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .toggle-password {
      cursor: pointer;
    }

    button[type="submit"] {
      width: 100%;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <!-- Logo -->
    <img src="https://th.bing.com/th/id/OIP.cC7xmIQhbUg2gnK3HA8SSgAAAA?rs=1&pid=ImgDetMain" alt="Logo" id="loginLogo">

    <h3 class="login-title">Login</h3>
    <form id="loginForm">
      <div class="mb-3 text-start">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" required>
      </div>
      <div class="mb-3 text-start">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" required>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
      <div class="mb-3">
        <a href="forgotPassword.php">Forgot Password</a>
      </div>
    </form>
  </div>

  <script>
    document.getElementById("loginForm").addEventListener("submit", function(event) {
      event.preventDefault();

      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;

      fetch("https://bmsbackend.christjoy.site/api/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ email, password }),
      })
      .then(response => {
        if (!response.ok) {
          return response.json().then(err => { throw err; });
        }
        return response.json();
      })
      .then(data => {
          localStorage.setItem("token", data.token);
          localStorage.setItem("role", data.user.role);

          const role = parseInt(data.user.role);
          if (role === 1) {
              window.location.href = "admin/dashboard.php";
          } else if (role === 2) {
              window.location.href = "secretary/dashboard.php";
          } else if (role === 3) {
              window.location.href = "resident/dashboard.php";
          } else {
              Swal.fire("Unknown Role", "Invalid role detected", "error");
          }
      })

      .catch(error => {
        console.error("Login error:", error);
        Swal.fire({
          title: "Login Failed",
          text: error?.message || "Please check your email and password.",
          icon: "error",
          confirmButtonText: "Try Again"
        });
      });
    });


  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
