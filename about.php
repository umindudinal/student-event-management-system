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
   <title>ITUM EM (About Us)</title>
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
               <li><a href="about.php" class="active">About Us</a></li>
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
      <div class="upper_bg_image">
         <div class="content">
            <h1>About Us</h1>
         </div>
      </div>


      <!-- What We Offer Section -->
      <section class="section_2">
         <div class="top_para">Sri Lanka's ultimate platform for exploring all the exciting events happening across universities nationwide.</div>

         <div class="what_we_offer">
            <h1>What We Offer</h1>
            <div class="offer_list">
               <div class="item">
                  <div class="topic">Free Events :</div>
                  <div class="content">Discover a wide variety of free events happening at universities across Sri Lanka, from academic seminars to fun social gatherings</div>
               </div>
               <div class="item">
                  <div class="topic">Event Booking :</div>
                  <div class="content">Reserve your spot for events directly through our platform. Whether it's a workshop, a guest lecture, or a social event, booking is quick and easy.</div>
               </div>
               <div class="item">
                  <div class="topic">Event Profile :</div>
                  <div class="content">Create your profile to track events you've registered for, manage your bookings, and add your favorite events to keep them handy.</div>
               </div>
               <div class="item">
                  <div class="topic">Explore & Discover :</div>
                  <div class="content">Browse through a diverse range of events, filter them by categories or dates, and never miss out on something interesting happening at your university or beyond.</div>
               </div>
            </div>
         </div>

         <div class="join_with_us">
            <h1>Join with Us</h1>
            <div class="para">At ITUM Sport Club, we're more than just a group-we're a movement. Joining us means becoming a part of a passionate and vibrant community united by shared values and a vision for the future. Together, we strive to make an impact, drive innovation, and create opportunities that matter.</div>
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
            </div>
            <div class="btn">
               <a href="#">Contact fot Join</a>
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