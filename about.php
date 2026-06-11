<?php
include 'config.php';
session_start();
requireLogin();
?>
<?php include 'header.php'; ?>

<div class="page-banner">
   <h2>About Us</h2>
   <p class="breadcrumb"><a href="home.php">Home</a> / About</p>
</div>

<section class="section section-light">
   <div class="container">
      <div class="about-flex">
         <img src="images/about_us.webp" alt="About MangaXpress">
         <div class="about-content">
            <h3>Why Choose Us?</h3>
            <p>At MangaXpress, we know the excitement that comes with diving into your favorite manga and manhwa.
               That's why we're dedicated to bringing you authentic, high-quality products—from the latest releases
               to must-have collectibles—that let you enjoy your fandom to the fullest.</p>
            <p>We carefully select our items so every fan, whether a casual reader or a passionate collector, can
               find something special. With reliable service, affordable prices, and a true love for the stories
               you cherish, MangaXpress is your go-to destination for all things manga and manhwa.</p>
            <a href="contact.php" class="btn mt-2"><i class="fas fa-envelope"></i> Contact Us</a>
         </div>
      </div>
   </div>
</section>

<section class="section">
   <div class="container">
      <div class="section-header">
         <p class="section-eyebrow">What Fans Say</p>
         <h2 class="section-title">Client Reviews</h2>
      </div>
      <div class="reviews-grid">

         <div class="review-card">
            <img src="img/1.jpeg" alt="Eiichiro Oda" class="review-avatar">
            <div class="review-stars">
               <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
               <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <p class="review-text">The artwork is absolutely stunning, and the story kept me hooked from the very
               first chapter. Can't wait for the next volume!</p>
            <div class="review-author">Eiichiro Oda</div>
         </div>

         <div class="review-card">
            <img src="img/2.jpg" alt="IU" class="review-avatar">
            <div class="review-stars">
               <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
               <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <p class="review-text">Great quality print — the pages are sharp and the cover feels premium.
               Definitely worth adding to any manga collection.</p>
            <div class="review-author">IU</div>
         </div>

         <div class="review-card">
            <img src="img/3.jpg" alt="Akira Toriyama" class="review-avatar">
            <div class="review-stars">
               <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
               <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <p class="review-text">Characters are well-written and full of personality. I found myself laughing,
               tearing up, and cheering them on.</p>
            <div class="review-author">Akira Toriyama</div>
         </div>

         <div class="review-card">
            <img src="img/4.jpg" alt="Takehiko Inoue" class="review-avatar">
            <div class="review-stars">
               <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
               <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <p class="review-text">Perfect condition when it arrived. The translation is smooth and easy to follow
               without losing the original feel.</p>
            <div class="review-author">Takehiko Inoue</div>
         </div>

         <div class="review-card">
            <img src="img/5.jpg" alt="Kento Yamazaki" class="review-avatar">
            <div class="review-stars">
               <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
               <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <p class="review-text">A fantastic read for both newcomers and long-time fans. The pacing is spot on
               and the plot twists are incredible.</p>
            <div class="review-author">Kento Yamazaki</div>
         </div>

         <div class="review-card">
            <img src="img/6.jpeg" alt="Tao Tsuchiya" class="review-avatar">
            <div class="review-stars">
               <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
               <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <p class="review-text">Love the detailed world-building and emotional storytelling. This series quickly
               became one of my favorites.</p>
            <div class="review-author">Tao Tsuchiya</div>
         </div>

      </div>
   </div>
</section>

<?php include 'footer.php'; ?>