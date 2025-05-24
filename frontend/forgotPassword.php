<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f0f2f5;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .forgot-container {
      background: white;
      padding: 30px;
      border-radius: 1rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 400px;
    }

    .forgot-container h4 {
      margin-bottom: 20px;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="forgot-container">
    <h4>Forgot Password</h4>
    <form id="forgotForm">
      <div class="mb-3">
        <label class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" placeholder="Enter your email" required />
      </div>
      <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
    </form>
  </div>

  <script>
    // ✅ Toast config from you
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true,
    });

    document.getElementById('forgotForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      const userEmail = formData.get('email');

      fetch("https://bmsbackend.christjoy.site/forgot-password", {
        method: "POST",
        headers: {
          "Accept": "application/json",
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          email: userEmail
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          Toast.fire({
            icon: 'success',
            title: 'Reset link sent to your email.'
          });
            setTimeout(() => {
        window.location.href = '/login.php'; // or 'login.html' depende sa setup nimo
            }, 2000);
        } else {
          Toast.fire({
            icon: 'error',
            title: data.message || 'Something went wrong.'
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
