<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Hello {{ $user->first_name }},</p>
<p>You have been added to the system. Please set your password by clicking the button below:</p>
<p>
    <a href="{{ $setPasswordUrl }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Set Your Password
    </a>
</p>
<p>If you did not request this, please ignore this email.</p>
<p>Thank you,<br>Barangay Management System</p>

</body>
</html>