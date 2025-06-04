<template>
  <div class="home">
    <div class="welcome-message">
      <h2 v-if="userType === 'guest'">Bienvenue, Invité!</h2>
      <h2 v-else>Bienvenue de retour!</h2>
      <p v-if="userType === 'guest'">Vous naviguez en tant qu'invité. <a href="#" @click.prevent="showSignup">Inscrivez-vous</a> pour sauvegarder vos préférences.</p>
    </div>

    <div class="car-filters">
      <input type="text" placeholder="Rechercher par marque ou modèle" v-model="searchQuery">
      <select v-model="priceRange">
        <option value="">Tous les prix</option>
        <option value="0-1000000">Moins de 1.000.000 DA</option>
        <option value="1000000-3000000">1.000.000 DA - 3.000.000 DA</option>
        <option value="3000000-5000000">3.000.000 DA - 5.000.000 DA</option>
        <option value="5000000">Plus de 5.000.000 DA</option>
      </select>
      <select v-model="yearRange">
        <option value="">Toutes les années</option>
        <option value="2020-2025">2020-2025</option>
        <option value="2015-2019">2015-2019</option>
        <option value="2010-2014">2010-2014</option>
      </select>
    </div>

    <div class="loading-spinner" v-if="loading">
      <div class="spinner"></div>
    </div>

    <div class="error-message" v-if="error">
      {{ error }}
    </div>

    <div class="car-grid" v-else>
      <div v-for="car in currentCars" :key="car.id" class="car-card">
        <div class="image-container">
          <img 
            :src="car.image || '/placeholder-car.jpg'" 
            :alt="car.make + ' ' + car.model" 
            class="car-image"
            loading="lazy"
          >
          <div class="car-badge">{{ car.year }}</div>
          <button class="favorite-button" @click="toggleFavorite(car)">
            {{ isFavorite(car) ? '❤️' : '🤍' }}
          </button>
        </div>
        <div class="car-details">
          <h3 class="car-title">{{ car.make }} {{ car.model }}</h3>
          <div class="price-container">
            <span class="car-price">{{ formatPrice(car.price) }}</span>
            <span class="car-mileage">{{ car.mileage.toLocaleString() }} km</span>
          </div>
          <div class="car-info">
            <span><strong>Carburant:</strong> {{ car.fuelType }}</span>
            <span><strong>Transmission:</strong> {{ car.transmission }}</span>
          </div>
          <p class="car-description">{{ car.description || 'Aucune description disponible' }}</p>
          <div class="car-actions">
            <button class="contact-button" @click="contactSeller(car)">Contacter le vendeur</button>
            <button class="details-button" @click="viewDetails(car)">Détails</button>
          </div>
        </div>
      </div>
    </div>

    <div class="pagination">
      <button :disabled="currentPage === 1" @click="prevPage">Précédent</button>
      <span>{{ currentPage }} / {{ totalPages }}</span>
      <button :disabled="currentPage === totalPages" @click="nextPage">Suivant</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    userType: {
      type: String,
      default: 'guest'
    }
  },
  data() {
    return {
      cars: [],
      favorites: [],
      loading: true,
      error: null,
      searchQuery: '',
      priceRange: '',
      yearRange: '',
      currentPage: 1,
      carsPerPage: 6
    }
  },
  computed: {
    filteredCars() {
      let filtered = this.cars;
      
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        filtered = filtered.filter(car => 
          car.make.toLowerCase().includes(query) || 
          car.model.toLowerCase().includes(query)
        );
      }
      
      if (this.priceRange) {
        if (this.priceRange === '5000000') {
          filtered = filtered.filter(car => car.price > 5000000);
        } else {
          const [min, max] = this.priceRange.split('-').map(Number);
          filtered = filtered.filter(car => car.price >= min && car.price <= max);
        }
      }
      
      if (this.yearRange) {
        const [min, max] = this.yearRange.split('-').map(Number);
        filtered = filtered.filter(car => car.year >= min && car.year <= max);
      }
      
      return filtered;
    },
    totalPages() {
      return Math.ceil(this.filteredCars.length / this.carsPerPage);
    },
    currentCars() {
      const start = (this.currentPage - 1) * this.carsPerPage;
      const end = start + this.carsPerPage;
      return this.filteredCars.slice(start, end);
    }
  },
  methods: {
    formatPrice(price) {
      return new Intl.NumberFormat('fr-DZ', { 
        style: 'currency', 
        currency: 'DZD',
        maximumFractionDigits: 0
      }).format(price || 0);
    },
    contactSeller(car) {
      if (this.userType === 'guest') {
        alert(`Veuillez vous inscrire pour contacter le vendeur à propos de cette ${car.make} ${car.model}`);
      } else {
        alert(`Contactez le vendeur à propos de ${car.make} ${car.model}`);
      }
    },
    viewDetails(car) {
      this.$emit('view-details', car);
    },
    toggleFavorite(car) {
      if (this.userType === 'guest') {
        alert('Veuillez vous inscrire pour sauvegarder des favoris');
        return;
      }
      
      const index = this.favorites.findIndex(f => f.id === car.id);
      if (index >= 0) {
        this.favorites.splice(index, 1);
      } else {
        this.favorites.push(car);
      }
    },
    isFavorite(car) {
      return this.favorites.some(f => f.id === car.id);
    },
    showSignup() {
      this.$emit('show-signup');
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    }
  },
  async mounted() {
try {
        const response = await axios.get('http://localhost:8000/api/cars');
        this.cars = response.data;
        this.loading = false;
    } catch (error) {
        this.error = 'Impossible de charger les voitures. Veuillez réessayer plus tard.';
        this.loading = false;
    }
  }
}
</script>

<style scoped>
.home {
  padding: 1rem;
}

.welcome-message {
  margin-bottom: 2rem;
  padding: 1rem;
  background-color: #f0f7ff;
  border-radius: 8px;
}

.welcome-message h2 {
  color: #1a365d;
  margin-bottom: 0.5rem;
}

.welcome-message a {
  color: #4299e1;
  text-decoration: none;
}

.welcome-message a:hover {
  text-decoration: underline;
}

.car-filters {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
  flex-wrap: wrap;
}

.car-filters input,
.car-filters select {
  padding: 0.5rem 1rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
  min-width: 200px;
}

.car-filters input {
  flex: 1;
  max-width: 400px;
}

.loading-spinner {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 200px;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #4299e1;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.error-message {
  color: #e53e3e;
  padding: 1rem;
  background: #fff5f5;
  border-radius: 0.5rem;
  margin: 1rem 0;
}

.car-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2rem;
}

.car-card {
  background: white;
  border-radius: 0.75rem;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease;
}

.car-card:hover {
  transform: translateY(-5px);
}

.image-container {
  position: relative;
  height: 200px;
}

.car-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.car-badge {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: rgba(0, 0, 0, 0.7);
  color: white;
  padding: 0.25rem 0.75rem;
  border-radius: 1rem;
  font-size: 0.875rem;
}

.favorite-button {
  position: absolute;
  top: 1rem;
  left: 1rem;
  background: rgba(255, 255, 255, 0.8);
  border: none;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  font-size: 1rem;
  cursor: pointer;
}

.car-details {
  padding: 1.5rem;
}

.car-title {
  color: #1a365d;
  margin-bottom: 0.5rem;
  font-size: 1.25rem;
}

.price-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 1rem 0;
}

.car-price {
  color: #2b6cb0;
  font-weight: 700;
  font-size: 1.25rem;
}

.car-mileage {
  color: #718096;
  font-size: 0.875rem;
}

.car-info {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.5rem;
  margin: 1rem 0;
  font-size: 0.875rem;
}

.car-description {
  color: #4a5568;
  margin-bottom: 1.5rem;
  font-size: 0.9375rem;
}

.car-actions {
  display: flex;
  gap: 0.5rem;
}

.contact-button {
  flex: 1;
  padding: 0.75rem;
  background-color: #4299e1;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  cursor: pointer;
}

.contact-button:hover {
  background-color: #3182ce;
}

.details-button {
  flex: 1;
  padding: 0.75rem;
  background-color: white;
  color: #4299e1;
  border: 1px solid #4299e1;
  border-radius: 4px;
  font-size: 1rem;
  cursor: pointer;
}

.details-button:hover {
  background-color: #f0f7ff;
}

.pagination {
  display: flex;
  justify-content: center;
  margin-top: 1rem;
}

.pagination button {
  padding: 0.5rem 1rem;
  margin: 0 0.5rem;
  border: none;
  border-radius: 4px;
  background: #4299e1;
  color: white;
  cursor: pointer;
}

.pagination button:disabled {
  background: #ccc;
  cursor: not-allowed;
}
</style>