<?php
session_start();

if(isset($_SESSION["registration_no"])) {
   header("Location: ../index.php");
   exit();
}

$registration_no = "";
$password = "";
$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
   $registration_no = $_POST["reg_no"];
   $password = $_POST["password"];

   if(empty($registration_no) || empty($password)) {
      $error = "Please enter both Registration No and Password.";
   } else {
      include "connection.php";
      $dbConnection = getDatabaseConnection();

      $statement = $dbConnection->prepare("SELECT full_name, email, password, role FROM event_users WHERE registration_no = ?");
      $statement->bind_param("s", $registration_no);
      $statement->execute();

      $statement->bind_result($full_name, $email, $hashed_password, $role);
      
      if($statement->fetch()) {
         if(password_verify($password, $hashed_password)) {
            $_SESSION["registration_no"] = $registration_no;
            $_SESSION["full_name"] = $full_name;
            $_SESSION["email"] = $email;
            $_SESSION["role"] = $role;

            if($role == "Admin") {
               header("Location: ../index.php");
            } else {
               header("Location: ../index.php");
            }
            exit();
         }
      }

      $statement->close();
      $error = "Invalid Registration No or Password.";
   }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
   <link rel="stylesheet" href="../CSS/style.css">
   <link rel="icon" type="image/png" href="https://online.uom.lk/pluginfile.php/1/theme_moove/logo/1761377935/University_of_Moratuwa_logo.png">
   <title>ITUM EM (Login)</title>
</head>
<body>
   <div class="wrapper">
      <div class="form_container">

         <!-- colse button -->
         <div class="close_btn">
            <a href="../index.php"><i class="fa-solid fa-xmark"></i></a>
         </div>
         <!-- close button -->

         <div class="form_box login">
            <form method="post">
               <h1>LogIn</h1>

               <?php if(!empty($error)) { ?>
                  <div class="error_msg"><?= $error ?></div>
               <?php 
               } 
               ?>

               <div class="input_box">
                  <input type="text" name="reg_no" placeholder="Registration No" value="<?= $registration_no ?>">
                  <!-- <i class="fa-solid fa-address-card"></i> -->
                  <span></span>
               </div>
               <div class="input_box">
                  <input type="password" name="password" placeholder="Password">
                  <!-- <i class="fa-solid fa-lock"></i> -->
               </div>
               <div class="forgot_link">
                  <p><input type="checkbox"> Remember Me</p>
                  <a href="#">Forgot Password?</a>
               </div>
               <button type="submit" name="login" class="btn">LogIn</button> 
               <p class="goto_btn">Don't have an account? <a href="register.php">Register</a></p>
            </form>
         </div>
      </div>
   </div>
</body>
</html>