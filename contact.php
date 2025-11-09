<?php

session_start();
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
   <link rel="stylesheet" href="">
   <link rel="stylesheet" href="CSS/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
   <link rel="icon" type="image/png" href="https://online.uom.lk/pluginfile.php/1/theme_moove/logo/1761377935/University_of_Moratuwa_logo.png">
   <title>ITUM EM (Contact Us)</title>
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
               <li><a href="event.php">Event</a></li>
               <li><a href="contact.php" class="active">Contact Us</a></li>
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
      <div class="upper_bg_image">
         <div class="content">
            <h1>Contact Us</h1>
         </div>
      </div>


      <!-- Contact Us Section -->
      <section class="section_1 contact_us">
         <div class="left">
            <form action="#">
               <h1 style="text-align: left;">Inquire Us Now</h1>
               <div class="input_box">
                  <label>Registration No</label>
                  <input type="text" name="reg_no" placeholder="Enter your registration no" required>
               </div>
               <div class="input_box">
                  <label>Full Name</label>
                  <input type="text" name="full_name" placeholder="Enter your full name" required>
               </div>
               <div class="input_box">
                  <label>Email</label>
                  <input type="email" name="email" placeholder="Enter your email" required>
               </div>
               <div class="input_box">
                  <label>Event</label>
                  <input type="text"name="event" placeholder="Enter your event" required>
               </div>
               <div class="input_box">
                  <label>Message</label>
                  <textarea name="message" placeholder="Enter your message" required></textarea> 
               </div>
               <button type="submit">Send Message</button> 
            </form>
         </div>
         <div class="right">
            <div class="top">
               <h2>Contact Information</h2>
               <ul>
                  <li><i class="fa-solid fa-location-dot"></i> Institute of Technology, University of Moratuwa</li>
                  <li><i class="fa-solid fa-envelope"></i> info@itum.mrt.ac.lk</li>
                  <li><i class="fa-solid fa-phone"></i> (+94) 112 124 000</li>
               </ul>
            </div>
            <div class="bottom">
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.685748394122!2d79.99045147475594!3d6.808027593189498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae24e1a4acef3e7%3A0xb2ef9c84206274fc!2sInstitute%20of%20Technology%2C%20University%20of%20Moratuwa!5e0!3m2!1sen!2slk!4v1762337684388!5m2!1sen!2slk" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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