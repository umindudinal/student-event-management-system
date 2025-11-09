<?php
session_start();

$authenticated = false;

if (isset($_SESSION["registration_no"])) {
   $authenticated = true;
}

if (isset($_SESSION['flash_message'])) {
      echo "<script>alert('" . $_SESSION['flash_message'] . "');</script>";
      unset($_SESSION['flash_message']);
}

if (!isset($_SESSION["registration_no"])) {
    header("Location: ../API/login.php");
    exit();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include "../API/connection.php";
$connection = getDatabaseConnection();

/* ------------------- ADD EVENT ------------------- */
if (isset($_POST['add_event'])) {
   $event_code = $_POST['event_code'];
   $title = $_POST['event_title'];
   $date = $_POST['date'];
   $venue = $_POST['venue'];
   $description = $_POST['description'];

   $event_image = $_FILES['event_image']['name'];
   $tmp_name = $_FILES['event_image']['tmp_name'];
   $target = "../uploads/" . basename($event_image);

   if (move_uploaded_file($tmp_name, $target)) {
      $query = "INSERT INTO all_events (event_code, title, date, venue, description, image) VALUES ('$event_code', '$title', '$date', '$venue', '$description', '$event_image')";
      if (mysqli_query($connection, $query)) {
         $_SESSION['flash_message'] = "Event added successfully!";
         header("Location: event_management.php");
         exit();
      } 
      else {
         echo "Database error: " . mysqli_error($connection);
      }

   } else {
      echo "Image upload failed!";
   }
}

/* ------------------- DELETE EVENT ------------------- */
if (isset($_POST['delete_event'])) {
   $delete_code = $_POST['event_code'];
   $query = "DELETE FROM all_events WHERE event_code='$delete_code'";
   if (mysqli_query($connection, $query)) {
      $_SESSION['flash_message'] = "Event deleted successfully!";
      header("Location: event_management.php");
      exit();
   } 
   else {
      echo "Error deleting record: " . mysqli_error($connection);
   }
}

/* ------------------- EDIT EVENT ------------------- */
if (isset($_POST['edit_event'])) {
   $event_code = $_POST['event_code'];
   $title = $_POST['event_title'];
   $date = $_POST['date'];
   $venue = $_POST['venue'];
   $description = $_POST['description'];

   // Handle optional new image
   if (!empty($_FILES['event_image']['name'])) {
      $event_image = $_FILES['event_image']['name'];
      $tmp_name = $_FILES['event_image']['tmp_name'];
      $target = "../uploads/" . basename($event_image);
      move_uploaded_file($tmp_name, $target);
      $query = "UPDATE all_events SET title='$title', date='$date', venue='$venue', description='$description', image='$event_image' WHERE event_code='$event_code'";
   } else {
      $query = "UPDATE all_events SET title='$title', date='$date', venue='$venue', description='$description'WHERE event_code='$event_code'";
   }

   if (mysqli_query($connection, $query)) {
      $_SESSION['flash_message'] = "Event updated successfully!";
      header("Location: event_management.php");
      exit();
   } 
   else {
      echo "Error updating record: " . mysqli_error($connection);
   }
}

/* ------------------- LOAD EVENTS ------------------- */
$sql = "SELECT event_code, title, date, venue, description, image FROM all_events ORDER BY event_code DESC";
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
   <title>ITUM EM (Event Management)</title>
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
            <li><a href="event_management.php" class="active"><i class="fa-solid fa-calendar"></i> Event Management</a></li>
            <li><a href="user_management.php"><i class="fa-solid fa-users"></i> User Management</a></li>
            <li><a href="registration.php"><i class="fa-solid fa-user-plus"></i> Registration</a></li>
            <li style="margin-top: 200px;"><a href="../API/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a></li>
         </ul>
      </div>

      <!-- Dashboard Content -->
      <div class="dashboard_content event_management">

         <!-- Add Event Button -->
         <div class="top_section">
            <div id="addEventBtn" class="big_card dash-button">
               <i class="fa-solid fa-plus"></i> Add Event
            </div>
         </div>

         <!-- Event List -->
         <div id="eventListContainer" class="event_list_container">
            <h1>All Events</h1>
            <?php if ($result->num_rows > 0): ?>
               <?php while ($row = $result->fetch_assoc()): ?>
                  <div class="event-card">
                     <div>
                        <?php if (!empty($row['image'])): ?>
                           <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" width="150">
                        <?php else: ?>
                           <img src="../uploads/default_event.png" alt="Default Event Image" width="150">
                        <?php endif; ?>
                     </div>

                     <div class="event-info">
                        <h3><?= htmlspecialchars($row['title']) ?></h3>
                        <p><strong>Event Code:</strong> <?= htmlspecialchars($row['event_code']) ?></p>
                        <p><strong>Date:</strong> <?= htmlspecialchars($row['date']) ?></p>
                        <p><strong>Venue:</strong> <?= htmlspecialchars($row['venue']) ?></p>
                        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
                        
                        <div class="event-actions">
                           <button class="btn editBtn" 
                                   data-code="<?= htmlspecialchars($row['event_code']) ?>"
                                   data-title="<?= htmlspecialchars($row['title']) ?>"
                                   data-date="<?= htmlspecialchars($row['date']) ?>"
                                   data-venue="<?= htmlspecialchars($row['venue']) ?>"
                                   data-description="<?= htmlspecialchars($row['description']) ?>">
                                   <i class="fa-solid fa-pen"></i> Edit
                           </button>
                           <form method="post" style="display:inline;">
                              <input type="hidden" name="event_code" value="<?= htmlspecialchars($row['event_code']) ?>">
                              <button type="submit" name="delete_event" class="btn deleteBtn" onclick="return confirm('Are you sure you want to delete this event?')">
                                 <i class="fa-solid fa-trash"></i> Delete
                              </button>
                           </form>
                        </div>
                     </div>
                  </div>
               <?php endwhile; ?>
            <?php else: ?>
               <p style="text-align:center; color:#555;">No events found.</p>
            <?php endif; ?>
         </div>

         <!-- Add Event Modal -->
         <div class="form_container modal" id="addEventModal">
            <div class="form_box register modal_content">
               <div class="close_btn"><a href="#"><i class="fa-solid fa-xmark"></i></a></div>
               <form method="post" enctype="multipart/form-data">
                  <h1>Add Event</h1>
                  <div class="input_box">
                     <input type="text" name="event_code" placeholder="Event Code" required>
                  </div>
                  <div class="input_box">
                     <input type="text" name="event_title" placeholder="Event Title" required>
                  </div>
                  <div class="input_box">
                     <input type="date" name="date" required>
                  </div>
                  <div class="input_box">
                     <input type="text" name="venue" placeholder="Venue" required>
                  </div>
                  <div class="input_box">
                     <textarea name="description" placeholder="Description"></textarea>
                  </div>
                  <div class="input_box">
                     <input type="file" name="event_image" accept="image/*" class="input_image_box">
                  </div>
                  <button type="submit" name="add_event" class="btn">Add Now</button>
               </form>
            </div>
         </div>

         <!-- Edit Event Modal -->
         <div class="form_container modal" id="editEventModal">
            <div class="form_box register modal_content">
               <div class="close_btn"><a href="#"><i class="fa-solid fa-xmark"></i></a></div>
               <form method="post" enctype="multipart/form-data">
                  <h1>Edit Event</h1>
                  <div class="input_box">
                     <input type="text" name="event_code" id="edit_event_code" readonly>
                  </div>
                  <div class="input_box">
                     <input type="text" name="event_title" id="edit_event_title" required>
                  </div>
                  <div class="input_box">
                     <input type="date" name="date" id="edit_event_date" required>
                  </div>
                  <div class="input_box">
                     <input type="text" name="venue" id="edit_event_venue" required>
                  </div>
                  <div class="input_box">
                     <textarea name="description" id="edit_event_description"></textarea>
                  </div>
                  <div class="input_box">
                     <input type="file" name="event_image" accept="image/*" class="input_image_box">
                  </div>
                  <button type="submit" name="edit_event" class="btn">Save Changes</button>
               </form>
            </div>
         </div>
      </div>
   </div>

   <script src="../JS/event.js"></script>
</body>
</html>
