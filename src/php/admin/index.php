<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WMR Admin Dashboard</title>
  <link rel="stylesheet" href="../../css/header.css">
  <link rel="stylesheet" href="../../css/admincss/dashboard.css">
  <link rel="stylesheet" href="../../css/admincss/clients.css"/>
  <link rel="stylesheet" href="../../css/admincss/inquiries.css">
  <link rel="stylesheet" href="../../css/admincss/requestsadmin.css"/>
</head>
<body class="dashboard-page">
  <?php include('header.php'); ?>
  

<div class="dashboard-wrapper">
  <div class="dashboard">
    <?php include('menu.php'); ?>
    <div class="dashboard-content-panel" id="requests"></div>
    <div class="dashboard-content-panel" id="inquiries"></div>
    <div class="dashboard-content-panel" id="clients"></div>
    <div class="dashboard-content-panel" id="editstatus"></div>
  </div>
</div>
  <script src="script.js"></script>
</body>
</html>