<?php

session_start();

include "API/connection.php"; 
$connection = getDatabaseConnection();

$authenticated = false;
if (isset($_SESSION["registration_no"])) {
    $authenticated = true;
}

$query = "SELECT * FROM all_events ORDER BY event_code DESC";
$result = mysqli_query($connection, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="">
   <link rel="stylesheet" href="CSS/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
   <link rel="icon" type="image/png" href="https://online.uom.lk/pluginfile.php/1/theme_moove/logo/1761377935/University_of_Moratuwa_logo.png">
   <title>ITUM EM (Home)</title>
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
               <li><a href="index.php" class="active">Home</a></li>
               <li><a href="about.php">About Us</a></li>
               <li><a href="event.php">Event</a></li>
               <li><a href="contact.php">Contact Us</a></li>
            </ul>

            <?php 
            if ($authenticated) { 
            ?>
            <ul>
               <li><a href="API/profile.php"><i class="fa-regular fa-user"></i> <?= $_SESSION["registration_no"] ?></a></li>
               <li><a href="API/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
            <?php
            } else {
            ?>   
            <ul style="margin-left: 0;">
               <li><a href="API/login.php" class="login">LogIn</a></li>
            </ul>
            <?php 
            } 
            ?>
         </div>
      </nav>


      <!-- Banner Section -->
      <div class="background_image"></div>
      <div class="banner_content">
         <span>Welcome to...</span>
         <h1>ITUM Student Event Management System</h1>
         <p>Experience a smarter way to discover, join, and manage campus events where every idea turns into action!</p>
         <?php
         if (isset($_SESSION["role"]) && $_SESSION["role"] === "Admin") {
            echo '<a href="Dashboard/dashboard.php"><button>Go to Dashboard</button></a>';
         } 
         elseif (isset($_SESSION["registration_no"])) {
            echo '<a href="API/profile.php"><button>Go to Profile</button></a>';
         } 
         else {
            echo '<a href="API/login.php"><button>Get Started</button></a>';
         }
   ?>
      </div>


      <?php
      // Only 3 latest events
      $query = "SELECT * FROM all_events ORDER BY event_code DESC LIMIT 3";
      $result = mysqli_query($connection, $query);
      ?>


      <!-- Upcoming Events Section -->
      <section class="section_2">
         <h1>Upcoming Events</h1>
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
               echo "<p style='text-align:center; width:100%;'>No events found.</p>";
            }
            ?>
         </div>
         <div class="btn">
               <a href="event.php">Load More</a>
         </div>
      </section>


      <!-- Add Your Event Section -->
      <section class="section_3">
         <div class="back_image"></div>
         <div class="content">
            <h2>add your loving event</h2>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nesciunt odit voluptatum nobis culpa voluptates et.</p>
            <button>View all Events</button>
         </div>
      </section>


      <!-- Past Events & Reviews Section -->
      <section class="section_4">
         <div class="past_events">
            <h1>past succesfull event</h1>
            <p class="sub_title">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Modi, minima.</p> 
            <div class="past_event_cards">
               <div class="card">
                  <div class="image">
                     <img src="Images/pastEvent/1.png" alt="">
                  </div>
                  <div class="content">
                     <h3>6 Strategies to Find Your Conference Keynote and Other Speakers</h3>
                     <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis fugit quia sapiente quas neque nam dignissimos, sunt quidem commodi aspernatur.</p>
                     <span>12 March - Jhon Doe</span>
                  </div>
               </div>
               <div class="card">
                  <div class="image">
                     <img src="Images/pastEvent/2.png" alt="">
                  </div>
                  <div class="content">
                     <h3>How Successfully Used Paid Marketing to Drive Incremental Ticket Sales</h3>
                     <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis fugit quia sapiente quas neque nam dignissimos, sunt quidem commodi aspernatur.</p>
                     <span>12 March - Jhon Doe</span>
                  </div>
               </div>
               <div class="card">
                  <div class="image">
                     <img src="Images/pastEvent/3.png" alt="">
                  </div>
                  <div class="content">
                     <h3>Introducing Workspaces: Work smarter, not harder with new navigation</h3>
                     <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis fugit quia sapiente quas neque nam dignissimos, sunt quidem commodi aspernatur.</p>
                     <span>12 March - Jhon Doe</span>
                  </div>
               </div>
            </div>
            <div class="btn">
               <a href="#">Load More</a>
            </div>  
         </div>

         <div class="reviews">
            <h1>Reviews About Us</h1>
            <p class="sub_title">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minus, laboriosam.</p>
            <div class="reviews_cards">
               <div class="card">
                  <div class="top">
                     <div class="image">
                        <img src="Images/reviews/1.jpg" alt="">
                     </div>
                     <div class="right">
                        <div class="stars">
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-regular fa-star"></i>
                        </div>
                        <p class="name">Imasha Samodee</p>
                        <span>20 th March 2025</span>
                     </div>
                  </div>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate in iusto id, suscipit officia ipsam dolores minus fugiat reprehenderit fuga.</p>
               </div>
               <div class="card">
                  <div class="top">
                     <div class="image">
                        <img src="Images/reviews/2.jpg" alt="">
                     </div>
                     <div class="right">
                        <div class="stars">
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-regular fa-star"></i>
                        </div>
                        <p class="name">Umindu Dinal</p>
                        <span>20 th March 2025</span>
                     </div>
                  </div>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate in iusto id, suscipit officia ipsam dolores minus fugiat reprehenderit fuga.</p>
               </div>
               <div class="card">
                  <div class="top">
                     <div class="image">
                        <img src="Images/reviews/3.jpg" alt="">
                     </div>
                     <div class="right">
                        <div class="stars">
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-regular fa-star"></i>
                        </div>
                        <p class="name">Umindu Dinal</p>
                        <span>20 th March 2025</span>
                     </div>
                  </div>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate in iusto id, suscipit officia ipsam dolores minus fugiat reprehenderit fuga.</p>
               </div>
               <div class="card">
                  <div class="top">
                     <div class="image">
                        <img src="Images/reviews/4.jpg" alt="">
                     </div>
                     <div class="right">
                        <div class="stars">
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-regular fa-star"></i>
                        </div>
                        <p class="name">Imasha Samodee</p>
                        <span>20 th March 2025</span>
                     </div>
                  </div>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate in iusto id, suscipit officia ipsam dolores minus fugiat reprehenderit fuga.</p>
               </div>
               <div class="card">
                  <div class="top">
                     <div class="image">
                        <img src="Images/reviews/5.jpg" alt="">
                     </div>
                     <div class="right">
                        <div class="stars">
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-regular fa-star"></i>
                        </div>
                        <p class="name">Umindu Dinal</p>
                        <span>20 th March 2025</span>
                     </div>
                  </div>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate in iusto id, suscipit officia ipsam dolores minus fugiat reprehenderit fuga.</p>
               </div>
               <div class="card plus">
                  <div class="center">
                     <a href="#"><i class="fa-solid fa-plus"></i></a>
                     <p>Add Yours</p>
                  </div>
               </div>
            </div>
            <div class="btn">
               <a href="#">Load More</a>
            </div>
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
               <h3>Quick Link</h3>
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