<!DOCTYPE html>
<html>
<head>
    <title>Set Password</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap + SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f0f2f5;
        }
        .card-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: block;
        }
        .form-control[readonly] {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<div class="card-container">
      <img src="" alt="User Photo" id="profilePhoto" class="profile-img" />

    <!-- Hidden Inputs -->
    <input type="hidden" id="email" />
    <input type="hidden" id="token" />

    <!-- Readonly User Info -->
    <div class="mb-3">
        <label class="form-label">First Name</label>
        <input type="text" id="first_name" class="form-control" readonly />
    </div>
    <div class="mb-3">
        <label class="form-label">Last Name</label>
        <input type="text" id="last_name" class="form-control" readonly />
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" id="email_readonly" class="form-control" readonly />
    </div>

    <form id="setPasswordForm">
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" id="password" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" class="form-control" required />
        </div>

        <button type="submit" class="btn btn-primary w-100">Set Password</button>
    </form>
</div>

<script>
    const params = new URLSearchParams(window.location.search);
    const email = params.get('email');
    const token = params.get('token');

    // Set hidden inputs
    document.getElementById('email').value = email;
    document.getElementById('token').value = token;

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    });

    // Fetch user info from API and display on the page
fetch(`https://bmsbackend.christjoy.site/api/user-infos`, {
  method: "GET",
  headers: {
    "Authorization": "Bearer " + token, // Make sure `token` is defined correctly
    "Accept": "application/json"
  }
})
.then(response => {
    if (!response.ok) throw new Error('Failed to fetch user info');
    return response.json();
})
.then(data => {
    console.log(data);
    document.getElementById('first_name').value = data.first_name;
    document.getElementById('last_name').value = data.last_name;
    document.getElementById('email_readonly').value = data.email;

    if (data.photo) {
        document.getElementById('profilePhoto').src = `https://bmsbackend.christjoy.site/storage/${data.photo}`;
    }
})
.catch(() => {
    Toast.fire({
        icon: 'error',
        title: 'Failed to load user info.'
    });
});



    // Submit new password to backend
    document.getElementById('setPasswordForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const password = document.getElementById('password').value;
        const password_confirmation = document.getElementById('password_confirmation').value;

        try {
            const response = await fetch('https://bmsbackend.christjoy.site/api/set-password', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, token, password, password_confirmation })
            });

            const result = await response.json();

            if (response.ok) {
                Toast.fire({
                    icon: 'success',
                    title: result.message || 'Password set successfully!'
                });
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000);
            } else {
                Toast.fire({
                    icon: 'error',
                    title: result.message || 'Something went wrong!'
                });
            }
        } catch (error) {
            Toast.fire({
                icon: 'error',
                title: 'Network error. Please try again.'
            });
        }
    
    });
</script>

</body>
</html>
