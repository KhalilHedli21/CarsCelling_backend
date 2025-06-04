<template>
  <div class="login-container">
    <div class="login-form">
      <h2>Welcome Back</h2>
      <p class="subtitle">Sign in to your account to continue</p>
      
      <form @submit.prevent="handleSubmit" novalidate>
        <div class="form-group">
          <label for="login-email">Email</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope"></i>
            <input 
              type="email" 
              id="login-email" 
              v-model="email" 
              :class="{ 'error': errors.email }"
              @blur="validateEmail"
              required
              autocomplete="email"
            >
          </div>
          <span class="error-message" v-if="errors.email">{{ errors.email }}</span>
        </div>

        <div class="form-group">
          <label for="login-password">Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input 
              :type="showPassword ? 'text' : 'password'" 
              id="login-password" 
              v-model="password" 
              :class="{ 'error': errors.password }"
              @blur="validatePassword"
              required
              autocomplete="current-password"
            >
            <button 
              type="button" 
              class="toggle-password"
              @click="togglePassword"
              tabindex="-1"
            >
              <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
            </button>
          </div>
          <span class="error-message" v-if="errors.password">{{ errors.password }}</span>
        </div>

        <div class="form-options">
          <label class="remember-me">
            <input type="checkbox" v-model="rememberMe">
            <span>Remember me</span>
          </label>
          <a href="#" class="forgot-password" @click.prevent="handleForgotPassword">Forgot password?</a>
        </div>

        <button 
          type="submit" 
          :disabled="isLoading || !isFormValid"
          class="submit-button"
        >
          <span v-if="isLoading" class="loading-spinner"></span>
          <span v-else>Sign In</span>
        </button>

        <div class="social-login">
          <p>Or continue with</p>
          <div class="social-buttons">
            <button type="button" class="social-button google" @click="handleSocialLogin('google')">
              <i class="fab fa-google"></i>
              Google
            </button>
            <button type="button" class="social-button facebook" @click="handleSocialLogin('facebook')">
              <i class="fab fa-facebook-f"></i>
              Facebook
            </button>
          </div>
        </div>

        <p class="switch-form">
          Don't have an account? 
          <router-link to="/signup" class="signup-link">Sign up</router-link>
        </p>

        <p class="guest-login">
          Or continue as 
          <router-link to="/home" class="guest-link">Guest</router-link>
        </p>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'LoginForm',
  data() {
    return {
      email: '',
      password: '',
      rememberMe: false,
      showPassword: false,
      isLoading: false,
      errors: {}
    }
  },
  computed: {
    isFormValid() {
      return !this.errors.email && !this.errors.password && 
             this.email.length > 0 && this.password.length > 0
    }
  },
  methods: {
    validateEmail() {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      if (!this.email) {
        this.errors.email = 'Email is required'
      } else if (!emailRegex.test(this.email)) {
        this.errors.email = 'Please enter a valid email address'
      } else {
        delete this.errors.email
      }
    },
    validatePassword() {
      if (!this.password) {
        this.errors.password = 'Password is required'
      } else if (this.password.length < 6) {
        this.errors.password = 'Password must be at least 6 characters'
      } else {
        delete this.errors.password
      }
    },
    togglePassword() {
      this.showPassword = !this.showPassword
    },
    async handleSubmit() {
      this.validateEmail()
      this.validatePassword()
      
      if (!this.isFormValid) return
      
      try {
        this.isLoading = true
        const response = await axios.post('/api/auth/login', {
          email: this.email,
          password: this.password
        })

        const { token, user } = response.data
        
        // Store token and user data
        localStorage.setItem('token', token)
        localStorage.setItem('user', JSON.stringify(user))
        
        // Set axios default header for future requests
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
        
        // Emit login event with user role
        this.$emit('login', {
          role: user.role,
          userData: user
        })

        // Redirect based on role
        if (user.role === 'admin') {
          this.$router.push('/admin/dashboard')
        } else {
          this.$router.push('/home')
        }
      } catch (error) {
        console.error('Login error:', error)
        if (error.response) {
          this.errors.submit = error.response.data.message || 'Login failed. Please try again.'
        } else {
          this.errors.submit = 'Network error. Please check your connection.'
        }
      } finally {
        this.isLoading = false
      }
    },
    handleForgotPassword() {
      // Implement forgot password functionality
      console.log('Forgot password clicked')
    },
    handleSocialLogin(provider) {
      // Implement social login functionality
      console.log(`Social login with ${provider}`)
    }
  }
}
</script>

<style scoped>
.login-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  background-color: #f8f9fa;
}

.login-form {
  width: 100%;
  max-width: 450px;
  background-color: #ffffff;
  padding: 2.5rem;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.login-form h2 {
  font-size: 1.875rem;
  font-weight: 700;
  text-align: center;
  color: #1a365d;
  margin-bottom: 0.5rem;
}

.subtitle {
  text-align: center;
  color: #6b7280;
  margin-bottom: 2rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #4b5563;
  margin-bottom: 0.5rem;
}

.input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.input-wrapper i {
  position: absolute;
  left: 1rem;
  color: #9ca3af;
}

.input-wrapper input {
  width: 100%;
  padding: 0.75rem 1rem 0.75rem 2.5rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-size: 1rem;
  transition: all 0.2s;
}

.input-wrapper input:focus {
  outline: none;
  border-color: #4CAF50;
  box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
}

.input-wrapper input.error {
  border-color: #ef4444;
}

.error-message {
  color: #ef4444;
  font-size: 0.875rem;
  margin-top: 0.25rem;
}

.toggle-password {
  position: absolute;
  right: 1rem;
  background: none;
  border: none;
  color: #9ca3af;
  cursor: pointer;
  padding: 0;
}

.form-options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.remember-me {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #4b5563;
  font-size: 0.875rem;
}

.forgot-password {
  color: #4CAF50;
  font-size: 0.875rem;
  text-decoration: none;
}

.forgot-password:hover {
  text-decoration: underline;
}

.submit-button {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 0.875rem;
  border: none;
  border-radius: 0.5rem;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
}

.submit-button:hover:not(:disabled) {
  background-color: #45a049;
}

.submit-button:disabled {
  background-color: #9ca3af;
  cursor: not-allowed;
}

.loading-spinner {
  width: 1.25rem;
  height: 1.25rem;
  border: 2px solid #ffffff;
  border-top: 2px solid transparent;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

.social-login {
  margin-top: 2rem;
  text-align: center;
}

.social-login p {
  color: #6b7280;
  font-size: 0.875rem;
  margin-bottom: 1rem;
  position: relative;
}

.social-login p::before,
.social-login p::after {
  content: '';
  position: absolute;
  top: 50%;
  width: 30%;
  height: 1px;
  background-color: #e5e7eb;
}

.social-login p::before {
  left: 0;
}

.social-login p::after {
  right: 0;
}

.social-buttons {
  display: flex;
  gap: 1rem;
}

.social-button {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.75rem;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  background-color: white;
  color: #4b5563;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.social-button:hover {
  background-color: #f9fafb;
}

.social-button i {
  font-size: 1.25rem;
}

.social-button.google i {
  color: #ea4335;
}

.social-button.facebook i {
  color: #1877f2;
}

.switch-form {
  text-align: center;
  margin-top: 2rem;
  color: #6b7280;
  font-size: 0.875rem;
}

.signup-link {
  color: #4CAF50;
  text-decoration: none;
  font-weight: 500;
}

.signup-link:hover {
  text-decoration: underline;
}

.guest-login {
  text-align: center;
  margin-top: 1rem;
  color: #6b7280;
  font-size: 0.875rem;
}

.guest-link {
  color: #4CAF50;
  text-decoration: none;
  font-weight: 500;
}

.guest-link:hover {
  text-decoration: underline;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@media (max-width: 640px) {
  .login-form {
    padding: 1.5rem;
  }

  .social-buttons {
    flex-direction: column;
  }
}
</style>