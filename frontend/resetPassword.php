<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- SweetAlert2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f0f2f5;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .reset-container {
      background: white;
      padding: 30px;
      border-radius: 1rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 400px;
    }

    .reset-container h4 {
      margin-bottom: 20px;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="reset-container">
    <h4>Reset Password</h4>
    <form id="resetForm">
      <input type="hidden" name="token" />
      <input type="hidden" name="email" />

      <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" name="password" class="form-control" placeholder="New password" required />
      </div>

      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required />
      </div>

      <button type="submit" class="btn btn-primary w-100">Reset Password</button>
    </form>
  </div>

  <script>
    // ✅ Your Toast alert setup
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true,
    });

    // Get token and email from URL
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');
    const email = urlParams.get('email');

    document.querySelector('[name="token"]').value = token;
    document.querySelector('[name="email"]').value = email;

    // Form submission
    document.getElementById('resetForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      const emailInput = formData.get('email');
      const tokenFromUrl = formData.get('token');
      const newPassword = formData.get('password');
      const confirmPassword = formData.get('password_confirmation');

      fetch("https://bmsbackend.christjoy.site/api/reset-password", {
        method: "POST",
        headers: {
          "Accept": "application/json",
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          email: emailInput,
          token: tokenFromUrl,
          password: newPassword,
          password_confirmation: confirmPassword
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          Toast.fire({
            icon: 'success',
            title: 'Password reset successful!'
          });

          setTimeout(() => {
            window.location.href = 'login.php'; // ✅ Redirect after 2 seconds
          }, 2200);
        } else {
          Toast.fire({
            icon: 'error',
            title: data.message || 'Reset failed.'
          });
        }
      })
      .catch(error => {
        console.error("Error:", error);
        Toast.fire({
          icon: 'error',
          title: 'Server error. Try again.'
        });
      });
    });
  </script>

</body>
</html>
