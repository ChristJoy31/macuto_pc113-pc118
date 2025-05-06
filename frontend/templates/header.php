<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">




    <!-- Bootstrap CSS & JS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 300px;
            height: 100vh;
            background: #3b63cf;
            color: white;
            position: fixed;
            padding-top: 20px;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
        }
        .sidebar h3 {
            text-align: left;
            margin-left: 20px;
            margin-bottom: 40px;
            padding: 20px;
            border-bottom: 1px solid white;
        }
        .sidebar a, .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px 20px;
            color: white;
            font-size: 23px;
            text-decoration: none;
        }
        .sidebar a.active, .sidebar a:hover {
            background: white;
            color: #3b63cf;
            border-left: 5px solid #3458a4;
        }
        .dropdown .dropdown-toggle {
            width: 100%;
            justify-content: space-between;
            background: none;
            border: none;
            font-size: 18px;
        }
        .dropdown-menu {
            background: #3458a4;
            border: none;
            width: 100%;
        }
        .dropdown-menu .dropdown-item {
            color: white;
            font-size: 16px;
            padding: 10px 20px;
        }
        .dropdown-menu .dropdown-item:hover {
            background: white;
            color: #3b63cf;
        }
        .content {
            margin-left: 300px;
            background: #f4f4f4;
            min-height: 100vh;
        }
        .top-nav {
            background: white;
            height: 100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #ddd;
        }
        .top-nav h3 {
            margin: 0;
        }
        .top-nav div {
            display: flex;
            align-items: center;
        }
        .top-nav i {
            margin-right: 10px;
        }
        .custom-margin {
        margin-left: 50px; 
        }
    </style>
</head>
<body>