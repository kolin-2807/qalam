<!-- Qalam Pixel-Style Footer -->
<footer class="qalam-footer">
  <div class="footer-top">

    <div class="footer-brand">
      <h2>Qalam</h2>
      <p>Qalam — бағдарламалау негіздерін <br> үйреніп, алғашқы жобаларыңды <br> жасауды бастайтын орын.</p>

    </div>

    <div class="footer-links">
      <h3>Navigation</h3>
      <ul>
        <li><a href="../pages/quest_levels.php">Courses</a></li>
        <li><a href="../pages/quest_levels.php">Courses</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Clubs</a></li>
        <li><a href="#">Features</a></li>
      </ul>
    </div>


    <div class="footer-info">
      <h3>Information</h3>
      <p>+1234567890</p>
      <p>info@example.com</p>
      <p>123, Retro Street, NYC</p>
    </div>

    <div class="footer-hours">
      <h3>Opening Hours</h3>
      <p>Mon - Thu: 9:00 - 21:00</p>
      <p>Fri: 9:00 - 21:00</p>
      <p>Sat: 9:00 - 16:00</p>
      <p>Sun: Closed</p>
    </div>

  </div>

  <div class="footer-bottom">
    <p>© 2025 Qalam - Барлық құқықтар қорғалған</p><br>
    <div class="social-icons">
      <a href="https://facebook.com" target="_blank"><img src="../assets/images/footer/facebook.png" alt="Facebook"></a>
      <a href="https://youtube.com" target="_blank"><img src="../assets/images/footer/youtube.png" alt="YouTube"></a>
      <a href="https://instagram.com" target="_blank"><img src="../assets/images/footer/instagram.png" alt="Instagram"></a>
      <a href="https://tiktok.com" target="_blank"><img src="../assets/images/footer/tiktok.png" alt="Tiktok"></a>
    </div>
  </div>
</footer>

<!-- CSS -->
<style>
.qalam-footer {
  background-color: #222;
  color: #fff;
  font-family: 'Press Start 2P', cursive;
  font-size: 10px;
  padding: 30px 20px;
}

.footer-top {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-bottom: 20px;
}

p {
  line-height: 2.4;
}

.footer-brand h1 {
  font-size: 16px;
  margin-bottom: 10px;
}

.footer-brand p {
  font-size: 8px;
  color: #ccc;
}

.footer-links ul {
  list-style: none;
  padding: 0;
}

.footer-links ul li {
  margin-bottom: 8px;
}

.footer-links a {
  color: #f1c40f;
  text-decoration: none;
}

.footer-info p,
.footer-hours p {
  font-size: 8px;
  margin-bottom: 6px;
}

.footer-bottom {
  border-top: 1px solid #555;
  padding-top: 10px;
  align-items: center;
  text-align: center; /* ОРТАҒА */
}

.footer-bottom p {
  font-size: 8px;
  color: #aaa;
}

.social-icons a img {
  
  width: 24px;
  height: 24px;
  margin-left: 8px;
  transition: transform 0.3s;
  box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);}

.social-icons a img:hover {
  transform: scale(1.2);
}
</style>