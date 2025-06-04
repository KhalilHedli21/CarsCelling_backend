<template>
  <div class="landing">
    <section class="hero">
      <div class="hero-content">
        <h1>Find Your Perfect Car</h1>
        <p>Browse thousands of listings from trusted sellers</p>
        <div class="hero-buttons">
          <router-link to="/home" class="primary">Explore as Guest</router-link>
          <button @click="$emit('switch-to-signup')" class="secondary">Create Account</button>
        </div>
      </div>
    </section>

    <section class="featured-cars">
      <h2>Featured Listings</h2>
      <div class="car-grid">
        <div v-for="car in featuredCars" :key="car.id" class="car-card">
          <div class="car-image-container">
            <img :src="car.image || '/placeholder-car.jpg'" :alt="car.make + ' ' + car.model" class="car-image">
            <span class="car-year">{{ car.year }}</span>
          </div>
          <div class="car-details">
            <h3>{{ car.make }} {{ car.model }}</h3>
            <p class="car-price">{{ formatPrice(car.price) }}</p>
            <p class="car-mileage">{{ car.mileage.toLocaleString() }} km</p>
          </div>
        </div>
      </div>
    </section>

    <section class="benefits">
      <h2>Why Choose Us?</h2>
      <div class="benefits-grid">
        <div class="benefit-card">
          <div class="benefit-icon">🚗</div>
          <h3>Wide Selection</h3>
          <p>Thousands of cars from trusted sellers</p>
        </div>
        <div class="benefit-card">
          <div class="benefit-icon">💰</div>
          <h3>Best Prices</h3>
          <p>Competitive pricing guaranteed</p>
        </div>
        <div class="benefit-card">
          <div class="benefit-icon">🔍</div>
          <h3>Easy Search</h3>
          <p>Find exactly what you're looking for</p>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'Landing',
  data() {
    return {
      featuredCars: [
        {
          id: 1,
          make: 'Toyota',
          model: 'Camry',
          year: 2020,
          price: 2500000,
          mileage: 25000,
          image: '/placeholder-car.jpg'
        },
        {
          id: 2,
          make: 'Honda',
          model: 'Civic',
          year: 2019,
          price: 2200000,
          mileage: 35000,
          image: '/placeholder-car.jpg'
        },
        {
          id: 3,
          make: 'Ford',
          model: 'Mustang',
          year: 2021,
          price: 3500000,
          mileage: 15000,
          image: '/placeholder-car.jpg'
        }
      ]
    };
  },
  methods: {
    formatPrice(price) {
      return new Intl.NumberFormat('fr-DZ', { 
        style: 'currency', 
        currency: 'DZD',
        maximumFractionDigits: 0
      }).format(price);
    }
  }
};
</script>

<style scoped>
.landing {
  padding: 2rem 0;
}

.hero {
  background: linear-gradient(135deg, #1a365d, #4299e1);
  color: white;
  padding: 4rem 1rem;
  text-align: center;
  border-radius: 8px;
  margin-bottom: 3rem;
}

.hero-content {
  max-width: 800px;
  margin: 0 auto;
}

.hero h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.hero p {
  font-size: 1.2rem;
  margin-bottom: 2rem;
}

.hero-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
}

.hero-buttons .primary,
.hero-buttons .secondary {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s;
  display: inline-block;
  text-align: center;
  text-decoration: none;
}

.hero-buttons .primary {
  background-color: white;
  color: #1a365d;
}

.hero-buttons .primary:hover {
  background-color: #e2e8f0;
}

.hero-buttons .secondary {
  background-color: transparent;
  color: white;
  border: 1px solid white;
}

.hero-buttons .secondary:hover {
  background-color: rgba(255,255,255,0.1);
}

.featured-cars {
  margin-bottom: 3rem;
}

.featured-cars h2,
.benefits h2 {
  text-align: center;
  margin-bottom: 2rem;
  font-size: 2rem;
  color: #1a365d;
}

.car-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2rem;
}

.car-card {
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  transition: transform 0.3s;
}

.car-card:hover {
  transform: translateY(-5px);
}

.car-image-container {
  position: relative;
  height: 200px;
}

.car-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.car-year {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: rgba(0,0,0,0.7);
  color: white;
  padding: 0.25rem 0.75rem;
  border-radius: 1rem;
  font-size: 0.875rem;
}

.car-details {
  padding: 1.5rem;
}

.car-details h3 {
  margin-bottom: 0.5rem;
  color: #1a365d;
}

.car-price {
  font-weight: bold;
  color: #2b6cb0;
  margin-bottom: 0.5rem;
}

.car-mileage {
  color: #718096;
  font-size: 0.875rem;
}

.benefits {
  margin-bottom: 3rem;
}

.benefits-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  max-width: 1000px;
  margin: 0 auto;
}

.benefit-card {
  text-align: center;
  padding: 2rem 1rem;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.benefit-icon {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.benefit-card h3 {
  margin-bottom: 0.5rem;
  color: #1a365d;
}
</style>