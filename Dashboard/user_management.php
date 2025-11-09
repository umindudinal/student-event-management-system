<?php
session_start();

$authenticated = false;

if (isset($_SESSION["registration_no"])) {
   $authenticated = true;
}

if (!isset($_SESSION["registration_no"])) {
   header("Location: ../API/login.php");
   exit();
}

include "../API/connection.php";
$connection = getDatabaseConnection();

/* ---------- ADD USER ---------- */
if (isset($_POST['add_user'])) {
   $registration_no = $_POST['registration_no'];
   $full_name = $_POST['full_name'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
   $role = $_POST['role'];

   $query = "INSERT INTO event_users (registration_no, full_name, email, phone, password, role)
            VALUES ('$registration_no', '$full_name', '$email', '$phone', '$password', '$role')";
   if (mysqli_query($connection, $query)) {
      $_SESSION['flash_message'] = "User added successfully!";
      header("Location: user_management.php");
      exit();
   } else {
      echo "Database error: " . mysqli_error($connection);
   }
}

/* ---------- DELETE USER ---------- */
if (isset($_POST['delete_user'])) {
   $registration_no = $_POST['registration_no'];
   $query = "DELETE FROM event_users WHERE registration_no='$registration_no'";
   if (mysqli_query($connection, $query)) {
      $_SESSION['flash_message'] = "User deleted successfully!";
      header("Location: user_management.php");
      exit();
   } else {
      echo "Error deleting user: " . mysqli_error($connection);
   }
}

/* ---------- EDIT USER ---------- */
if (isset($_POST['edit_user'])) {
   $registration_no = $_POST['registration_no'];
   $full_name = $_POST['full_name'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $role = $_POST['role'];

   $query = "UPDATE event_users 
            SET full_name='$full_name', email='$email', phone='$phone' 
            WHERE registration_no='$registration_no'";
   if (mysqli_query($connection, $query)) {
      $_SESSION['flash_message'] = "User updated successfully!";
      header("Location: user_management.php");
      exit();
   } else {
      echo "Error updating user: " . mysqli_error($connection);
   }
}

/* ---------- SHOW FLASH MESSAGE ---------- */
if (isset($_SESSION['flash_message'])) {
   echo "<script>alert('" . $_SESSION['flash_message'] . "');</script>";
   unset($_SESSION['flash_message']);
}

/* ---------- GET USERS ---------- */
$sql = "SELECT * FROM event_users ORDER BY registration_no ASC";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../CSS/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
   <link rel="icon" type="image/png" href="https://online.uom.lk/pluginfile.php/1/theme_moove/logo/1761377935/University_of_Moratuwa_logo.png">
   <title>ITUM EM (User Management)</title>
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
            <li><a href="dashboard.php"><i class="fa-solid fa-table-columns"></i> Dashboard</a></li>
            <li><a href="event_management.php"><i class="fa-solid fa-calendar"></i> Event Management</a></li>
            <li><a href="user_management.php" class="active"><i class="fa-solid fa-users"></i> User Management</a></li>
            <li><a href="registration.php"><i class="fa-solid fa-user-plus"></i> Registration</a></li>
            <li style="margin-top: 200px;"><a href="../API/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a></li>
         </ul>
      </div>

      <!-- Content -->
      <div class="dashboard_content">
         <div class="top_section">
            <div id="addUserBtn" class="big_card dash-button">
               <i class="fa-solid fa-user-plus"></i> Add User
            </div>
         </div>

         <div class="user_list_container">
            <h1>All Users</h1>
            <?php if ($result->num_rows > 0): ?>
               <table class="user_table">
                  <thead>
                     <tr>
                        <th>Registration No</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                  <?php while ($row = $result->fetch_assoc()): ?>
                     <tr>
                        <td><?= htmlspecialchars($row['registration_no']) ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                        <td class="action_buttons">
                           <button class="btn editUserBtn"
                                   data-reg="<?= htmlspecialchars($row['registration_no']) ?>"
                                   data-name="<?= htmlspecialchars($row['full_name']) ?>"
                                   data-email="<?= htmlspecialchars($row['email']) ?>"
                                   data-phone="<?= htmlspecialchars($row['phone']) ?>"
                                   data-role="<?= htmlspecialchars($row['role']) ?>">
                                   
                                   <i class="fa-solid fa-pen"></i> Edit
                           </button>
                           <form method="post" style="display:inline;">
                              <input type="hidden" name="registration_no" value="<?= htmlspecialchars($row['registration_no']) ?>">
                              <button type="submit" name="delete_user" class="btn deleteBtn" onclick="return confirm('Delete this user?')">
                                 <i class="fa-solid fa-trash"></i> Delete
                              </button>
                           </form>
                        </td>
                     </tr>
                  <?php endwhile; ?>
                  </tbody>
               </table>
            <?php else: ?>
               <p style="text-align:center;">No users found.</p>
            <?php endif; ?>
         </div>

         <!-- Add User Modal -->
         <div class="form_container modal" id="addUserModal">
            <div class="form_box modal_content">
               <div class="close_btn"><a href="#"><i class="fa-solid fa-xmark"></i></a></div>
               <form method="post">
                  <h1>Add User</h1>
                  <div class="input_box">
                     <input type="text" name="registration_no" placeholder="Registration No" maxlength="8" required>
                  </div>
                  <div class="input_box">
                     <input type="text" name="full_name" placeholder="Full Name" required>
                  </div>
                  <div class="input_box">
                     <input type="email" name="email" placeholder="Email" required>
                  </div>
                  <div class="input_box">
                     <input type="text" name="phone" placeholder="Phone No" maxlength="10" required>
                  </div>
                  <div class="input_box">
                     <input type="password" name="password" placeholder="Password" required>
                  </div>
                  <div class="input_box">
                     <select name="role" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                     </select>
                  </div>
                  <button type="submit" name="add_user" class="btn">Add User</button>
               </form>
            </div>
         </div>

         <!-- Edit User Modal -->
         <div class="form_container modal" id="editUserModal">
            <div class="form_box modal_content">
               <div class="close_btn"><a href="#"><i class="fa-solid fa-xmark"></i></a></div>
               <form method="post">
                  <h1>Edit User</h1>
                  <div class="input_box">
                     <input type="text" name="registration_no" id="edit_registration_no" readonly>
                  </div>
                  <div class="input_box">
                     <input type="text" name="full_name" id="edit_full_name" required>
                  </div>
                  <div class="input_box">
                     <input type="email" name="email" id="edit_email" required>
                  </div>
                  <div class="input_box">
                     <input type="text" name="phone" id="edit_phone" maxlength="10" required>
                  </div>
                  <div class="input_box">
                     <select name="role" id="edit_role" required>
                        <option value="Admin">Admin</option>
                        <option value="Student">Student</option>
                     </select>
                  </div>
                  <button type="submit" name="edit_user" class="btn">Save Changes</button>
               </form>
            </div>
         </div>
      </div>
   </div>

   <script src="../JS/user.js"></script>
</body>
</html>
