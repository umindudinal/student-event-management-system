<?php

session_start();

if (isset($_SESSION["registration_no"])) {
   header("Location: ../index.php");
   exit();
}

$registration_no = "";
$full_name = "";
$email = "";
$phone = "";
$password = "";

$registration_no_error = "";
$full_name_error = "";
$email_error = "";
$phone_error = "";
$password_error = "";

$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $registration_no = $_POST['reg_no'];
   $full_name = $_POST['full_name'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $password = $_POST['password'];

   if (empty($registration_no)) {
      $registration_no_error = "Registration No is required.";
      $error = true;
   }

   include 'connection.php';
   $dbConnection = getDatabaseConnection();
   $statement = $dbConnection->prepare("SELECT registration_no FROM event_users WHERE registration_no = ?");
   $statement->bind_param("s", $registration_no);
   $statement->execute();
   $statement->store_result();
   
   if ($statement->num_rows > 0) {
      $registration_no_error = "You have already registered with this Registration No.";
      $error = true;
   }

   if (empty($full_name)) {
      $full_name_error = "Full Name is required.";
      $error = true;
   }

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_error = "Email format is not valid.";
      $error = true;
   }

   if (empty($phone)) {
      $phone_error = "Phone is required.";
      $error = true;
   }

   if (strlen($password) < 6) {
      $password_error = "Password must be have at least 6 characters.";
      $error = true;
   }

   if (!$error) {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $statement = $dbConnection->prepare("INSERT INTO event_users (registration_no, full_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
      $statement->bind_param("sssss", $registration_no, $full_name, $email, $phone, $hashed_password);
      $statement->execute();
      $inserted_id = $statement->insert_id;

      $_SESSION["registration_no"] = $registration_no;
      $_SESSION["full_name"] = $full_name;
      $_SESSION["email"] = $email;
      $_SESSION["phone"] = $phone;

      header("Location: ../index.php");
      exit();
   }
   $statement->close();
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
   <title>ITUM EM (Registration)</title>
</head>
<body>
   <div class="wrapper">
      <div class="form_container">

         <div class="close_btn">
            <a href="../index.php"><i class="fa-solid fa-xmark"></i></a>
         </div>

         <div class="form_box register">
            <form method="post">
               <h1>Registration</h1>
               <div class="input_box">
                  <input type="text" name="reg_no" placeholder="Registration No" value="<?= $registration_no ?>">
                  <span><?= $registration_no_error ?></span>
                  <!-- <i class="fa-solid fa-address-card"></i> -->
               </div>
               <div class="input_box">
                  <input type="text" name="full_name" placeholder="Full Name" value="<?= $full_name ?>">
                  <span><?= $full_name_error ?></span>
                  <!-- <i class="fa-solid fa-user"></i> -->
               </div>
               <div class="input_box">
                  <input type="email" name="email" placeholder="Email" value="<?= $email ?>">
                  <span><?= $email_error ?></span>
                  <!-- <i class="fa-solid fa-envelope"></i> -->
               </div>
               <div class="input_box">
                  <input type="number" name="phone" placeholder="Phone" value="<?= $phone ?>">
                  <span><?= $phone_error ?></span>
                  <!-- <i class="fa-solid fa-envelope"></i> -->
               </div>
               <div class="input_box">
                  <input type="password" name="password" placeholder="Password">
                  <span><?= $password_error ?></span>
                  <!-- <i class="fa-solid fa-lock"></i> -->
               </div>
               <div class="forgot_link">
                  <p><input type="checkbox" require> I accept the Terms and Conditions</p>
               </div>
               <button type="submit" name="register" class="btn">Register</button>
               <p class="goto_btn">Already have an account? <a href="login.php">Login</a></p>
            </form>
         </div>
      </div>
   </div>
</body>
</html>