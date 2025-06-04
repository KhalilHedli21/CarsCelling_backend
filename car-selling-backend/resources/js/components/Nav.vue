<template>
  <nav class="nav" :class="{ 'nav-mobile': isMobileMenuOpen }">
    <div class="nav-container">
      <div class="nav-logo">
        <router-link to="/">
          <img src="https://static.vecteezy.com/system/resources/previews/013/923/543/original/blue-car-logo-png.png" alt="Car Seller Logo" />
        </router-link>
      </div>
      
      <button class="mobile-menu-button" @click="toggleMobileMenu" aria-label="Toggle menu">
        <span class="hamburger" :class="{ 'is-active': isMobileMenuOpen }"></span>
      </button>

      <ul class="nav-links" :class="{ 'is-active': isMobileMenuOpen }">
        <li><router-link to="/" @click="closeMobileMenu">Home</router-link></li>
        <li><router-link to="/cars" @click="closeMobileMenu">Cars for Sale</router-link></li>
        
        <!-- Admin Navigation -->
        <template v-if="userType === 'user' && userRole === 'admin'">
          <li><router-link to="/admin/dashboard" @click="closeMobileMenu">Dashboard</router-link></li>
          <li><router-link to="/admin/users" @click="closeMobileMenu">Users</router-link></li>
          <li><router-link to="/admin/listings" @click="closeMobileMenu">Listings</router-link></li>
        </template>
        
        <!-- Client Navigation -->
        <template v-if="userType === 'user' && userRole === 'client'">
          <li><router-link to="/sell" @click="closeMobileMenu">Sell Your Car</router-link></li>
          <li><router-link to="/profile" @click="closeMobileMenu">Profile</router-link></li>
        </template>
        
        <li><router-link to="/contact" @click="closeMobileMenu">Contact</router-link></li>
        
        <!-- Guest Navigation -->
        <template v-if="userType === 'guest'">
          <li><router-link to="/login" @click="closeMobileMenu">Login</router-link></li>
          <li><router-link to="/signup" @click="closeMobileMenu" class="signup-button">Sign Up</router-link></li>
        </template>
        
        <!-- Logged in User Actions -->
        <template v-if="userType === 'user'">
          <li><a href="#" @click.prevent="handleLogout" class="logout-button">Logout</a></li>
        </template>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'NavBar',
  props: {
    userType: {
      type: String,
      required: true,
      validator: (value) => ['guest', 'user'].includes(value)
    },
    userRole: {
      type: String,
      default: null,
      validator: (value) => ['admin', 'client', null].includes(value)
    },
    isLoading: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      isMobileMenuOpen: false
    }
  },
  methods: {
    handleLogout() {
      this.closeMobileMenu()
      this.$emit('logout')
    },
    toggleMobileMenu() {
      this.isMobileMenuOpen = !this.isMobileMenuOpen
    },
    closeMobileMenu() {
      this.isMobileMenuOpen = false
    }
  },
  mounted() {
    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
      const target = e.target
      if (!target.closest('.nav') && this.isMobileMenuOpen) {
        this.closeMobileMenu()
      }
    })
  },
  beforeUnmount() {
    document.removeEventListener('click', this.closeMobileMenu)
  }
}
</script>

<style scoped>
.nav {
  background: #fff;
  color: #1a365d;
  position: sticky;
  top: 0;
  z-index: 100;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.07);
}

.nav-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.nav-logo {
  display: flex;
  align-items: center;
}

.nav-logo img {
  height: 40px;
  transition: transform 0.3s ease;
}

.nav-logo img:hover {
  transform: scale(1.05);
}

.nav-links {
  list-style: none;
  display: flex;
  gap: 1.5rem;
  align-items: center;
  margin: 0;
  padding: 0;
}

.nav-links a {
  color: #1a365d;
  text-decoration: none;
  font-weight: 500;
  padding: 0.5rem;
  border-radius: 4px;
  transition: all 0.3s ease;
}

.nav-links a:hover {
  background: #f1f5f9;
  color: #4CAF50;
  text-decoration: none;
}

.signup-button {
  background: #4CAF50;
  color: #fff !important;
  padding: 0.5rem 1rem !important;
}

.signup-button:hover {
  background: #45a049 !important;
  color: #fff !important;
}

.logout-button {
  color: #ef4444 !important;
}

.logout-button:hover {
  background: #ffeaea !important;
  color: #ef4444 !important;
}

.mobile-menu-button {
  display: none;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.5rem;
}

.hamburger {
  display: block;
  width: 24px;
  height: 2px;
  background: #1a365d;
  position: relative;
  transition: all 0.3s ease;
}

.hamburger::before,
.hamburger::after {
  content: '';
  position: absolute;
  width: 24px;
  height: 2px;
  background: #1a365d;
  transition: all 0.3s ease;
}

.hamburger::before {
  top: -8px;
}

.hamburger::after {
  bottom: -8px;
}

.hamburger.is-active {
  background: transparent;
}

.hamburger.is-active::before {
  transform: rotate(45deg);
  top: 0;
}

.hamburger.is-active::after {
  transform: rotate(-45deg);
  bottom: 0;
}

@media (max-width: 768px) {
  .mobile-menu-button {
    display: block;
  }

  .nav-links {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #fff;
    flex-direction: column;
    padding: 1rem;
    gap: 1rem;
  }

  .nav-links.is-active {
    display: flex;
  }

  .nav-links a {
    display: block;
    padding: 0.75rem;
    text-align: center;
    color: #1a365d;
  }

  .nav-links a:hover {
    background: #f1f5f9;
    color: #4CAF50;
  }
}
</style>