<?php
session_start();
include "API/connection.php"; // adjust path if needed

$connection = getDatabaseConnection();

$authenticated = false;
if (isset($_SESSION["registration_no"])) {
    $authenticated = true;
}

// Fetch all events from database
$query = "SELECT * FROM all_events ORDER BY event_code DESC";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="CSS/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
   <link rel="icon" type="image/png" href="https://online.uom.lk/pluginfile.php/1/theme_moove/logo/1761377935/University_of_Moratuwa_logo.png">
   <title>ITUM EM (Events)</title>
</head>
<body>

   <div class="container">
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
               <li><a href="index.php">Home</a></li>
               <li><a href="about.php">About Us</a></li>
               <li><a href="event.php" class="active">Event</a></li>
               <li><a href="contact.php">Contact Us</a></li>
            </ul>

            <?php if ($authenticated) { ?>
            <ul>
               <li><a href="API/profile.php"><i class="fa-regular fa-user"></i> <?= $_SESSION["registration_no"] ?></a></li>
               <li><a href="API/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
            <?php } else { ?>
            <ul style="margin-left: 0;">
               <li><a href="API/login.php" class="login">LogIn</a></li>
            </ul>
            <?php } ?>
         </div>
      </nav>

      <div class="upper_bg_image">
         <div class="content">
            <h1>All Events</h1>
         </div>
      </div>

      <!-- Event Section -->
      <section class="section_2">
         <div class="card_section">
            <?php
            if (mysqli_num_rows($result) > 0) {
               while ($row = mysqli_fetch_assoc($result)) {
                  $eventDate = date("M d", strtotime($row['date']));
                  $month = date("M", strtotime($row['date']));
                  $day = date("d", strtotime($row['date']));
                  $imagePath = "uploads/" . $row['image'];
            ?>
                  <div class="item">
                     <div class="image">
                        <?php if (file_exists($imagePath)) { ?>
                           <img src="<?php echo $imagePath; ?>" alt="Event Image" width="200px">
                        <?php } else { ?>
                           <img src="Images/default.png" alt="No Image" width="200px">
                        <?php } ?>
                     </div>
                     <div class="content">
                        <div class="top">
                           <div class="date">
                              <p><?php echo $month; ?></p>
                              <span><?php echo $day; ?></span>
                           </div>
                           <div class="topic">
                              <p><?php echo htmlspecialchars($row['title']); ?></p>
                              <span><?php echo htmlspecialchars($row['description']); ?></span>
                           </div>
                        </div>
                        <ul>
                           <li>Event Code: <?php echo htmlspecialchars($row['event_code']); ?></li>
                        </ul>
                        <div class="bottom">
                           <div class="location"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($row['venue']); ?></div>
                           <div class="favorit">
                              <?php if (isset($_SESSION["registration_no"])) { ?>
                              <a href="API/event_register.php?event_code=<?php echo urlencode($row['event_code']); ?>" class="btn">Add Now <i class="fa-regular fa-bookmark"></i></a>
                              <?php } else { ?>
                              <a href="API/login.php" class="btn">Login <i class="fa-solid fa-lock"></i></a>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                  </div>
            <?php
            }
            } else {
               echo "<p class='no_events'>No events found.</p>";
            }
            ?>
         </div>
      </section>

      <!-- Footer Section -->
      <footer>
         <div class="footer1">
            <div class="item">
               <div class="image">
                  <img src="https://itum.mrt.ac.lk/sites/default/files/MicrosoftTeams-image.png" alt="">
               </div>
               <p class="para">
                  Eventick is a global self-service ticketing platform for live experiences that allows anyone to create, share, find and attend events that fuel their passions and enrich their lives.
               </p>
               <div class="social_link">
                  <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                  <a href="#"><i class="fa-brands fa-twitter"></i></a>
                  <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
               </div>
            </div>
            <div class="item c_item">
               <h3>Plan Events</h3>
               <ul>
                  <li><a href="#">Create and Set Up</a></li>
                  <li><a href="#">Sell Tickets</a></li>
                  <li><a href="#">Online RSVP</a></li>
                  <li><a href="#">Online Events</a></li>
               </ul>
            </div>
            <div class="item c_item">
               <h3>Eventick</h3>
               <ul>
                  <li><a href="#">ABout Us</a></li>
                  <li><a href="#">Press</a></li>
                  <li><a href="#">Contact Us</a></li>
                  <li><a href="#">Help Center</a></li>
                  <li><a href="#">How it Work</a></li>
                  <li><a href="#">Privacy</a></li>
                  <li><a href="#">Terms</a></li>
               </ul>
            </div>
            <div class="item">
               <h3>Stay in The Loop</h3>
               <p>Join our mailing list to stay in the loop with our newest for Event and concert</p>
               <div class="input_box">
                  <input type="email" placeholder="Enter your email address">
                  <button>Subscribe Now</button>
               </div>
            </div>
         </div>
         <div class="footer2">
            <p>Copyright &copy; 2025 ITUM Events</p>
         </div>
      </footer>
   </div>

   

</body>
</html>
