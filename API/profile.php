<?php

session_start();

if(!isset($_SESSION["registration_no"])) {
   header("Location: login.php");
   exit();
}

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
   <title>ITUM EM (Profile)</title>
</head>
<body>

   <div class="container">

   <!-- Navigation Bar -->
      <nav>
         <div class="imbs_logo">
            <a href="../index.php"><img src="https://itum.mrt.ac.lk/sites/default/files/MicrosoftTeams-image.png"></a>
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
               <li><a href="profile.php" class="active"><i class="fa-regular fa-user"></i> <?= $_SESSION["registration_no"] ?></a></li>
               <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
            <?php
            } else {
            ?>   
            <ul style="margin-left: 0;">
               <li><a href="login.php" class="login">LogIn</a></li>
            </ul>
            <?php 
            } 
            ?>
         </div>
      </nav>
   </div>

   <div class="profile_container">
      <div class="profile_box">
         <h1>User Profile</h1>
         <p><i class="fa-solid fa-user-tie"></i></p>

         <div class="profile_row top">
            <span class="label">Full Name :</span>
            <span class="value"><?= $_SESSION["full_name"] ?></span>
         </div>

         <div class="profile_row">
            <span class="label">Registration No :</span>
            <span class="value"><?= $_SESSION["registration_no"] ?></span>
         </div>

         <div class="profile_row">
            <span class="label">Email :</span>
            <span class="value"><?= $_SESSION["email"] ?></span>
         </div>

         <div class="profile_row">
            <span class="label">Role :</span>
            <span class="value"><?= $_SESSION["role"] ?></span>
         </div>
      </div>
   </div>
   
</body>
</html>