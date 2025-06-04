<template>
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-section">
        <h3>About Us</h3>
        <p>Your trusted platform for buying and selling cars. We connect car enthusiasts with their perfect vehicles.</p>
      </div>
      
      <div class="footer-section">
        <h3>Quick Links</h3>
        <ul>
          <li><router-link to="/">Home</router-link></li>
          <li><router-link to="/cars">Cars for Sale</router-link></li>
          <li><router-link to="/sell">Sell Your Car</router-link></li>
          <li><router-link to="/contact">Contact</router-link></li>
        </ul>
      </div>
      
      <div class="footer-section">
        <h3>Contact Info</h3>
        <ul class="contact-info">
          <li>
            <i class="fas fa-envelope"></i>
            <a href="mailto:info@carseller.com">info@carseller.com</a>
          </li>
          <li>
            <i class="fas fa-phone"></i>
            <a href="tel:+1234567890">+1 (234) 567-890</a>
          </li>
          <li>
            <i class="fas fa-map-marker-alt"></i>
            <span>123 Car Street, Auto City, AC 12345</span>
          </li>
        </ul>
      </div>
      
      <div class="footer-section">
        <h3>Follow Us</h3>
        <div class="social-links">
          <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <i class="fab fa-facebook"></i>
          </a>
          <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
            <i class="fab fa-linkedin"></i>
          </a>
        </div>
      </div>
    </div>
    
    <div class="footer-bottom">
      <p>&copy; {{ currentYear }} Car Selling Website. All rights reserved.</p>
      <div class="footer-links">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
        <a href="#">Cookie Policy</a>
      </div>
    </div>
  </footer>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'Footer',
  computed: {
    currentYear(): number {
      return new Date().getFullYear()
    }
  }
})
</script>

<style scoped>
.footer {
  background-color: #1a365d;
  color: white;
  padding: 3rem 0 1rem;
  margin-top: auto;
}

.footer-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
}

.footer-section h3 {
  color: #fff;
  font-size: 1.2rem;
  margin-bottom: 1rem;
  position: relative;
  padding-bottom: 0.5rem;
}

.footer-section h3::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  width: 50px;
  height: 2px;
  background-color: #4CAF50;
}

.footer-section p {
  color: #ccc;
  line-height: 1.6;
}

.footer-section ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-section ul li {
  margin-bottom: 0.5rem;
}

.footer-section ul li a {
  color: #ccc;
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-section ul li a:hover {
  color: #4CAF50;
}

.contact-info li {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #ccc;
}

.contact-info i {
  color: #4CAF50;
}

.social-links {
  display: flex;
  gap: 1rem;
}

.social-links a {
  color: #ccc;
  font-size: 1.5rem;
  transition: color 0.3s ease;
}

.social-links a:hover {
  color: #4CAF50;
}

.footer-bottom {
  max-width: 1200px;
  margin: 2rem auto 0;
  padding: 1rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
}

.footer-bottom p {
  color: #ccc;
  margin: 0;
}

.footer-links {
  display: flex;
  gap: 1.5rem;
}

.footer-links a {
  color: #ccc;
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-links a:hover {
  color: #4CAF50;
}

@media (max-width: 768px) {
  .footer-container {
    grid-template-columns: 1fr;
    text-align: center;
  }

  .footer-section h3::after {
    left: 50%;
    transform: translateX(-50%);
  }

  .social-links {
    justify-content: center;
  }

  .footer-bottom {
    flex-direction: column;
    text-align: center;
  }

  .footer-links {
    justify-content: center;
  }
}
</style>