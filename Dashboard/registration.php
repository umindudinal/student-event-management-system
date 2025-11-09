<?php
session_start();

include '../API/connection.php';
$connection = getDatabaseConnection();

// ✅ Redirect if not logged in
if (!isset($_SESSION["registration_no"])) {
    header("Location: ../API/login.php");
    exit();
}

// ✅ Disable browser cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

$authenticated = isset($_SESSION["registration_no"]);

// ✅ Handle Delete Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_registration'])) {
    $event_code = $_POST['event_code'];
    $registration_no = $_POST['registration_no'];

    $stmt = $connection->prepare("DELETE FROM registration WHERE event_code = ? AND registration_no = ?");
    $stmt->bind_param("ss", $event_code, $registration_no);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Registration removed successfully.'); window.location.href='registration.php';</script>";
    } else {
        echo "<script>alert('Error removing registration or record not found.'); window.location.href='registration.php';</script>";
    }

    $stmt->close();
    exit();
}

// ✅ JOIN query
$sql = "
SELECT 
    e.event_code,
    e.title AS event_title,
    u.registration_no,
    u.full_name,
    u.email,
    u.phone,
    u.role,
    r.created_at AS registered_at
FROM registration r
JOIN event_users u ON r.registration_no = u.registration_no
JOIN all_events e ON r.event_code = e.event_code
ORDER BY e.title ASC, r.created_at DESC
";

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
   <title>ITUM EM (Registration)</title>
</head>
<body>
<div class="dashboard_container">

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

         <?php if ($authenticated): ?>
         <ul>
            <li><a href="../API/profile.php"><i class="fa-regular fa-user"></i> <?= htmlspecialchars($_SESSION["registration_no"]) ?></a></li>
            <li><a href="../API/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
         </ul>
         <?php else: ?>
         <ul style="margin-left: 0;">
            <li><a href="../API/login.php" class="login">LogIn</a></li>
         </ul>
         <?php endif; ?>
      </div>
   </nav>

   <!-- Side Navigation -->
   <div class="side_nav">
      <ul>
         <li><a href="dashboard.php"><i class="fa-solid fa-table-columns"></i> Dashboard</a></li>
         <li><a href="event_management.php"><i class="fa-solid fa-calendar"></i> Event Management</a></li>
         <li><a href="user_management.php"><i class="fa-solid fa-users"></i> User Management</a></li>
         <li><a href="registration.php" class="active"><i class="fa-solid fa-user-plus"></i> Registration</a></li>
         <li style="margin-top: 200px;"><a href="../API/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a></li>
      </ul>
   </div>

   <!-- Main Content -->
   <div class="dashboard_content">
      <div class="registration_management">
         <h1>User Registrations</h1>
         <?php if ($result && $result->num_rows > 0): ?>
            <table class="user_table">
               <tr>
                  <th>Registration No</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Role</th>
                  <th>Event Code</th>
                  <th>Event Title</th>
                  <th>Registered At</th>
                  <th>Action</th>
               </tr>
               <?php while ($row = $result->fetch_assoc()): ?>
               <tr>
                  <td><?= htmlspecialchars($row['registration_no']) ?></td>
                  <td><?= htmlspecialchars($row['full_name']) ?></td>
                  <td><?= htmlspecialchars($row['email']) ?></td>
                  <td><?= htmlspecialchars($row['phone']) ?></td>
                  <td><?= htmlspecialchars($row['role']) ?></td>
                  <td><?= htmlspecialchars($row['event_code']) ?></td>
                  <td><?= htmlspecialchars($row['event_title']) ?></td>
                  <td><?= htmlspecialchars($row['registered_at']) ?></td>
                  <td>
                     <form method="POST" onsubmit="return confirm('Are you sure you want to remove this registration?');">
                        <input type="hidden" name="event_code" value="<?= htmlspecialchars($row['event_code']) ?>">
                        <input type="hidden" name="registration_no" value="<?= htmlspecialchars($row['registration_no']) ?>">
                        <button type="submit" name="delete_registration" class="delete_btn">
                           <i class="fa-solid fa-trash"></i> Remove
                        </button>
                     </form>
                  </td>
               </tr>
               <?php endwhile; ?>
            </table>
         <?php else: ?>
            <p class="no-data">No registrations found.</p>
         <?php endif; ?>
      </div>
   </div>

</div>
</body>
</html>

<?php
$connection->close();
?>
