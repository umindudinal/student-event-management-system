<?php
include 'connection.php';

if (isset($_GET['event_code'])) {
   $event_code = $_GET['event_code'];

   $connection = getDatabaseConnection();
   $sql = "SELECT title FROM all_events WHERE event_code = ?";
   $stmt = $connection->prepare($sql);
   $stmt->bind_param("s", $event_code);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($row = $result->fetch_assoc()) {
      $title = $row['title'];
   } else {
      $title = "Event Not Found";
   }

   $stmt->close();
   $connection->close();
} else {
   $title = "";
}

session_start();
$registration_no = isset($_SESSION['registration_no']) ? $_SESSION['registration_no'] : '';

if (empty($registration_no)) {
   header("Location: login.php");
   exit();
}

if (isset($_POST['register_event'])) {
   $event_code = $_GET['event_code'];
   $event_title = $title;
   $reg_no = $registration_no;

   $connection = getDatabaseConnection();

   $checkSql = "SELECT * FROM registration WHERE event_code = ? AND registration_no = ?";
   $checkStmt = $connection->prepare($checkSql);
   $checkStmt->bind_param("ss", $event_code, $reg_no);
   $checkStmt->execute();
   $checkResult = $checkStmt->get_result();

   if ($checkResult->num_rows > 0) {
      echo "<script>alert('⚠️ You have already registered for this event.');</script>";
   } else {
      $insertSql = "INSERT INTO registration (event_code, title, registration_no, created_at) VALUES (?, ?, ?, NOW())";
      $insertStmt = $connection->prepare($insertSql);
      $insertStmt->bind_param("sss", $event_code, $event_title, $reg_no);

      if ($insertStmt->execute()) {
         echo "<script>alert('✅ Successfully Registered to Event!');</script>";
      } else {
         echo "<script>alert('❌ Registration Failed: " . $insertStmt->error . "');</script>";
      }

      $insertStmt->close();
   }

   $checkStmt->close();
   $connection->close();
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
      <div class="form_container" style="width: 450px;">

         <div class="close_btn">
            <a href="../index.php"><i class="fa-solid fa-xmark"></i></a>
         </div>

         <div class="form_box register" >
            <form method="post">
               <h1>Register to Event</h1>
               <div class="input_box">
                  <p>Event Code</p>
                  <input type="text" name="event_code" value="<?php echo htmlspecialchars($_GET['event_code']); ?>" readonly>
               </div>
               <div class="input_box">
                  <p>Event Title</p>
                  <input type="text" name="event_title" value="<?= htmlspecialchars($title ?? '') ?>" readonly>
               </div>
               <div class="input_box">
                  <p>Registration No</p>
                  <input type="text" name="registration_no" value="<?= htmlspecialchars($registration_no) ?>" readonly>
               </div>
               <button type="submit" name="register_event" class="btn">Register to Event</button>
            </form>
         </div>
      </div>
   </div>
</body>
</html>