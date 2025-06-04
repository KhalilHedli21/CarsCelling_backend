<template>
  <div class="signup-container">
    <div class="signup-form">
      <h2>Create Account</h2>
      <p class="subtitle">Join our community of car enthusiasts</p>
      
      <form @submit.prevent="handleSubmit" novalidate>
        <div class="form-group">
          <label for="signup-name">Full Name</label>
          <div class="input-wrapper">
            <i class="fas fa-user"></i>
            <input 
              type="text" 
              id="signup-name" 
              v-model="name" 
              :class="{ 'error': errors.name }"
              @blur="validateName"
              required
              autocomplete="name"
            >
          </div>
          <span class="error-message" v-if="errors.name">{{ errors.name }}</span>
        </div>

        <div class="form-group">
          <label for="signup-email">Email</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope"></i>
            <input 
              type="email" 
              id="signup-email" 
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
          <label for="signup-password">Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input 
              :type="showPassword ? 'text' : 'password'" 
              id="signup-password" 
              v-model="password" 
              :class="{ 'error': errors.password }"
              @blur="validatePassword"
              required
              autocomplete="new-password"
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

        <div class="form-group">
          <label for="signup-confirm-password">Confirm Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input 
              :type="showConfirmPassword ? 'text' : 'password'" 
              id="signup-confirm-password" 
              v-model="confirmPassword" 
              :class="{ 'error': errors.confirmPassword }"
              @blur="validateConfirmPassword"
              required
              autocomplete="new-password"
            >
            <button 
              type="button" 
              class="toggle-password"
              @click="toggleConfirmPassword"
              tabindex="-1"
            >
              <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
            </button>
          </div>
          <span class="error-message" v-if="errors.confirmPassword">{{ errors.confirmPassword }}</span>
        </div>

        <div class="form-group">
          <label class="checkbox-label">
            <input 
              type="checkbox" 
              v-model="agreeToTerms"
              :class="{ 'error': errors.terms }"
            >
            <span>I agree to the <a href="#" @click.prevent="showTerms">Terms of Service</a> and <a href="#" @click.prevent="showPrivacy">Privacy Policy</a></span>
          </label>
          <span class="error-message" v-if="errors.terms">{{ errors.terms }}</span>
        </div>

        <button 
          type="submit" 
          :disabled="isLoading || !isFormValid"
          class="submit-button"
        >
          <span v-if="isLoading" class="loading-spinner"></span>
          <span v-else>Create Account</span>
        </button>

        <div class="social-signup">
          <p>Or sign up with</p>
          <div class="social-buttons">
            <button type="button" class="social-button google" @click="handleSocialSignup('google')">
              <i class="fab fa-google"></i>
              Google
            </button>
            <button type="button" class="social-button facebook" @click="handleSocialSignup('facebook')">
              <i class="fab fa-facebook-f"></i>
              Facebook
            </button>
          </div>
        </div>

        <p class="switch-form">
          Already have an account? 
          <router-link to="/login" class="signin-link">Sign in</router-link>
        </p>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

interface FormErrors {
  name?: string;
  email?: string;
  password?: string;
  confirmPassword?: string;
  terms?: string;
}

export default defineComponent({
  name: 'SignupForm',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      confirmPassword: '',
      agreeToTerms: false,
      showPassword: false,
      showConfirmPassword: false,
      isLoading: false,
      errors: {} as FormErrors
    }
  },
  computed: {
    isFormValid(): boolean {
      return !Object.keys(this.errors).length && 
             this.name.length > 0 && 
             this.email.length > 0 && 
             this.password.length > 0 && 
             this.confirmPassword.length > 0 &&
             this.agreeToTerms
    }
  },
  methods: {
    validateName() {
      if (!this.name) {
        this.errors.name = 'Name is required'
      } else if (this.name.length < 2) {
        this.errors.name = 'Name must be at least 2 characters'
      } else {
        delete this.errors.name
      }
    },
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
      } else if (this.password.length < 8) {
        this.errors.password = 'Password must be at least 8 characters'
      } else if (!/[A-Z]/.test(this.password)) {
        this.errors.password = 'Password must contain at least one uppercase letter'
      } else if (!/[a-z]/.test(this.password)) {
        this.errors.password = 'Password must contain at least one lowercase letter'
      } else if (!/[0-9]/.test(this.password)) {
        this.errors.password = 'Password must contain at least one number'
      } else {
        delete this.errors.password
      }
      this.validateConfirmPassword()
    },
    validateConfirmPassword() {
      if (!this.confirmPassword) {
        this.errors.confirmPassword = 'Please confirm your password'
      } else if (this.confirmPassword !== this.password) {
        this.errors.confirmPassword = 'Passwords do not match'
      } else {
        delete this.errors.confirmPassword
      }
    },
    togglePassword() {
      this.showPassword = !this.showPassword
    },
    toggleConfirmPassword() {
      this.showConfirmPassword = !this.showConfirmPassword
    },
    async handleSubmit() {
      this.validateName()
      this.validateEmail()
      this.validatePassword()
      this.validateConfirmPassword()
      
      if (!this.agreeToTerms) {
        this.errors.terms = 'You must agree to the terms and conditions'
      } else {
        delete this.errors.terms
      }
      
      if (!this.isFormValid) return
      
      try {
        this.isLoading = true
        await this.$emit('signup', {
          name: this.name,
          email: this.email,
          password: this.password
        })
      } catch (error) {
        console.error('Signup error:', error)
      } finally {
        this.isLoading = false
      }
    },
    handleSocialSignup(provider: 'google' | 'facebook') {
      // Implement social signup functionality
      console.log(`Social signup with ${provider}`)
    },
    showTerms() {
      // Implement terms modal
      console.log('Show terms')
    },
    showPrivacy() {
      // Implement privacy policy modal
      console.log('Show privacy policy')
    }
  }
})
</script>

<style scoped>
.signup-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  background-color: #f8f9fa;
}

.signup-form {
  width: 100%;
  max-width: 500px;
  background-color: #ffffff;
  padding: 2.5rem;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.signup-form h2 {
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

.checkbox-label {
  display: flex;
  align-items: flex-start;
  gap: 0.5rem;
  color: #4b5563;
  font-size: 0.875rem;
  cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
  margin-top: 0.25rem;
}

.checkbox-label a {
  color: #4CAF50;
  text-decoration: none;
}

.checkbox-label a:hover {
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

.social-signup {
  margin-top: 2rem;
  text-align: center;
}

.social-signup p {
  color: #6b7280;
  font-size: 0.875rem;
  margin-bottom: 1rem;
  position: relative;
}

.social-signup p::before,
.social-signup p::after {
  content: '';
  position: absolute;
  top: 50%;
  width: 30%;
  height: 1px;
  background-color: #e5e7eb;
}

.social-signup p::before {
  left: 0;
}

.social-signup p::after {
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

.signin-link {
  color: #4CAF50;
  text-decoration: none;
  font-weight: 500;
}

.signin-link:hover {
  text-decoration: underline;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@media (max-width: 640px) {
  .signup-form {
    padding: 1.5rem;
  }

  .social-buttons {
    flex-direction: column;
  }
}
</style>