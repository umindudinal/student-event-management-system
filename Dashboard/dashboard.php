<?php
session_start();

if (!isset($_SESSION["registration_no"])) {
    header("Location: ../API/login.php");
    exit();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");


$authenticated = false;

if (isset($_SESSION["registration_no"])) {
   $authenticated = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../CSS/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
   <link rel="icon" type="image/png" href="https://online.uom.lk/pluginfile.php/1/theme_moove/logo/1761377935/University_of_Moratuwa_logo.png">
   <title>ITUM EM (Dashboard)</title>
   
</head>
<body>

   <div class="dashboard_container">

      <!-- Navigation Bar -->
      <nav>
         <div class="imbs_logo">
            <a href="index.php"><img src="https://itum.mrt.ac.lk/sites/default/files/MicrosoftTeams-image.png"></a>
         </div>
         <input type="checkbox" id="click">
         <label for="click" class="menu_btn">
         <i class="fas fa-bars"></i>
         </label>
         <div class="menu_bar">
            <ul>
               <li><a href="../index.php">Home</a></li>
               <li><a href="../about.php">About Us</a></li>
               <li><a href="../event.php">Event</a></li>
               <li><a href="../contact.php">Contact Us</a></li>
            </ul>

            <?php 
            if ($authenticated) { 
            ?>
            <ul>
               <li><a href="../API/profile.php"><i class="fa-regular fa-user"></i> <?= $_SESSION["registration_no"] ?></a></li>
               <li><a href="../API/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
            <?php
            } else {
            ?>   
            <ul style="margin-left: 0;">
               <li><a href="../API/login.php" class="login">LogIn</a></li>
            </ul>
            <?php 
            } 
            ?>
         </div>
      </nav>

      <!-- Side Navigation -->
      <div class="side_nav">
         <ul>
            <li><a href="dashboard.php" class="active"><i class="fa-solid fa-table-columns"></i> Dashboard</a></li>
            <li><a href="event_management.php"><i class="fa-solid fa-calendar"></i> Event Management</a></li>
            <li><a href="user_management.php"><i class="fa-solid fa-users"></i> User Management</a></li>
            <li><a href="registration.php"><i class="fa-solid fa-user-plus"></i> Registration</a></li>
            <li style="margin-top: 200px;"><a href="../API/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a></li>
         </ul>
      </div>

      <div class="dashboard_content">
         <div class="dashboard">
            <h1>Welcome to the <?= $_SESSION["role"] ?> Dashboard !</h1>
            <div class="quick_buttons">
               <a href="event_management.php" class="button"><i class="fa-solid fa-calendar-plus"></i> Manage Events</a>
               <a href="user_management.php" class="button"><i class="fa-solid fa-users-cog"></i> Manage Users</a>
               <a href="registration.php" class="button"><i class="fa-solid fa-user-plus"></i> Register User</a>
            </div>
         </div>
      </div>


   </div>
   
</body>
</html>
