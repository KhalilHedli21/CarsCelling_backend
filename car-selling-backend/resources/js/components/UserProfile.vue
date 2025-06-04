<template>
  <div class="profile-container">
    <div class="profile-header">
      <div class="profile-avatar">
        <img :src="user.avatar || '/default-avatar.png'" alt="Profile Avatar">
        <button class="edit-avatar" @click="handleEditAvatar">
          <i class="fas fa-camera"></i>
        </button>
      </div>
      <div class="profile-info">
        <h1>{{ user.name }}</h1>
        <p class="user-email">{{ user.email }}</p>
        <div class="profile-stats">
          <div class="stat">
            <span class="stat-value">{{ favorites.length }}</span>
            <span class="stat-label">Favorites</span>
          </div>
          <div class="stat">
            <span class="stat-value">{{ listings.length }}</span>
            <span class="stat-label">Listings</span>
          </div>
          <div class="stat">
            <span class="stat-value">{{ reviews.length }}</span>
            <span class="stat-label">Reviews</span>
          </div>
        </div>
      </div>
      <button class="edit-profile-btn" @click="handleEditProfile">
        <i class="fas fa-edit"></i>
        Edit Profile
      </button>
    </div>

    <div class="profile-content">
      <div class="profile-section">
        <div class="section-header">
          <h2>My Favorites</h2>
          <button class="view-all-btn" @click="viewAllFavorites">View All</button>
        </div>
        <div class="favorites-grid">
          <div v-for="car in favorites.slice(0, 4)" :key="car.id" class="car-card">
            <img :src="car.image" :alt="`${car.make} ${car.model}`">
            <div class="car-info">
              <h3>{{ car.make }} {{ car.model }}</h3>
              <p class="car-price">${{ car.price.toLocaleString() }}</p>
              <div class="car-details">
                <span><i class="fas fa-calendar"></i> {{ car.year }}</span>
                <span><i class="fas fa-road"></i> {{ car.mileage.toLocaleString() }} km</span>
              </div>
            </div>
            <button class="remove-favorite" @click="removeFavorite(car.id)">
              <i class="fas fa-heart"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="profile-section">
        <div class="section-header">
          <h2>My Listings</h2>
          <button class="view-all-btn" @click="viewAllListings">View All</button>
        </div>
        <div class="listings-grid">
          <div v-for="listing in listings.slice(0, 4)" :key="listing.id" class="listing-card">
            <img :src="listing.image" :alt="`${listing.make} ${listing.model}`">
            <div class="listing-info">
              <h3>{{ listing.make }} {{ listing.model }}</h3>
              <p class="listing-price">${{ listing.price.toLocaleString() }}</p>
              <div class="listing-status" :class="listing.status">
                {{ listing.status }}
              </div>
            </div>
            <div class="listing-actions">
              <button class="edit-listing" @click="editListing(listing.id)">
                <i class="fas fa-edit"></i>
              </button>
              <button class="delete-listing" @click="deleteListing(listing.id)">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="profile-section">
        <div class="section-header">
          <h2>Recent Reviews</h2>
          <button class="view-all-btn" @click="viewAllReviews">View All</button>
        </div>
        <div class="reviews-list">
          <div v-for="review in reviews.slice(0, 3)" :key="review.id" class="review-card">
            <div class="review-header">
              <img :src="review.carImage" :alt="review.carName">
              <div class="review-info">
                <h3>{{ review.carName }}</h3>
                <div class="rating">
                  <i v-for="n in 5" :key="n" 
                     :class="['fas', 'fa-star', { 'active': n <= review.rating }]">
                  </i>
                </div>
              </div>
              <span class="review-date">{{ formatDate(review.date) }}</span>
            </div>
            <p class="review-text">{{ review.text }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

interface User {
  name: string;
  email: string;
  avatar?: string;
}

interface Car {
  id: number;
  make: string;
  model: string;
  year: number;
  price: number;
  mileage: number;
  image: string;
}

interface Listing extends Car {
  status: 'active' | 'pending' | 'sold';
}

interface Review {
  id: number;
  carName: string;
  carImage: string;
  rating: number;
  text: string;
  date: string;
}

export default defineComponent({
  name: 'UserProfile',
  data() {
    return {
      user: {
        name: 'John Doe',
        email: 'john.doe@example.com',
        avatar: ''
      } as User,
      favorites: [] as Car[],
      listings: [] as Listing[],
      reviews: [] as Review[]
    }
  },
  methods: {
    handleEditAvatar() {
      // Implement avatar edit functionality
      console.log('Edit avatar')
    },
    handleEditProfile() {
      // Implement profile edit functionality
      console.log('Edit profile')
    },
    viewAllFavorites() {
      // Navigate to favorites page
      console.log('View all favorites')
    },
    viewAllListings() {
      // Navigate to listings page
      console.log('View all listings')
    },
    viewAllReviews() {
      // Navigate to reviews page
      console.log('View all reviews')
    },
    removeFavorite(carId: number) {
      // Implement remove favorite functionality
      console.log('Remove favorite:', carId)
    },
    editListing(listingId: number) {
      // Implement edit listing functionality
      console.log('Edit listing:', listingId)
    },
    deleteListing(listingId: number) {
      // Implement delete listing functionality
      console.log('Delete listing:', listingId)
    },
    formatDate(date: string): string {
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      })
    }
  },
  async mounted() {
    // Fetch user data, favorites, listings, and reviews
    // This is where you would make API calls
    try {
      // Simulated data
      this.favorites = [
        {
          id: 1,
          make: 'Toyota',
          model: 'Camry',
          year: 2020,
          price: 25000,
          mileage: 15000,
          image: '/car1.jpg'
        },
        // Add more favorites...
      ]
      
      this.listings = [
        {
          id: 1,
          make: 'Honda',
          model: 'Civic',
          year: 2019,
          price: 20000,
          mileage: 25000,
          image: '/car2.jpg',
          status: 'active'
        },
        // Add more listings...
      ]
      
      this.reviews = [
        {
          id: 1,
          carName: 'BMW 3 Series',
          carImage: '/car3.jpg',
          rating: 5,
          text: 'Great car, excellent condition!',
          date: '2024-03-15'
        },
        // Add more reviews...
      ]
    } catch (error) {
      console.error('Error fetching profile data:', error)
    }
  }
})
</script>

<style scoped>
.profile-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.profile-header {
  display: flex;
  align-items: center;
  gap: 2rem;
  margin-bottom: 3rem;
  padding: 2rem;
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.profile-avatar {
  position: relative;
  width: 120px;
  height: 120px;
}

.profile-avatar img {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  object-fit: cover;
}

.edit-avatar {
  position: absolute;
  bottom: 0;
  right: 0;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #4CAF50;
  color: white;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.2s;
}

.edit-avatar:hover {
  background: #45a049;
}

.profile-info {
  flex: 1;
}

.profile-info h1 {
  font-size: 1.875rem;
  font-weight: 700;
  color: #1a365d;
  margin-bottom: 0.5rem;
}

.user-email {
  color: #6b7280;
  margin-bottom: 1rem;
}

.profile-stats {
  display: flex;
  gap: 2rem;
}

.stat {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.stat-value {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1a365d;
}

.stat-label {
  color: #6b7280;
  font-size: 0.875rem;
}

.edit-profile-btn {
  padding: 0.75rem 1.5rem;
  background: #4CAF50;
  color: white;
  border: none;
  border-radius: 0.5rem;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  transition: background-color 0.2s;
}

.edit-profile-btn:hover {
  background: #45a049;
}

.profile-section {
  background: white;
  border-radius: 12px;
  padding: 1.5rem;
  margin-bottom: 2rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.section-header h2 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1a365d;
}

.view-all-btn {
  color: #4CAF50;
  background: none;
  border: none;
  font-weight: 500;
  cursor: pointer;
}

.view-all-btn:hover {
  text-decoration: underline;
}

.favorites-grid,
.listings-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1.5rem;
}

.car-card,
.listing-card {
  position: relative;
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;
}

.car-card:hover,
.listing-card:hover {
  transform: translateY(-4px);
}

.car-card img,
.listing-card img {
  width: 100%;
  height: 160px;
  object-fit: cover;
}

.car-info,
.listing-info {
  padding: 1rem;
}

.car-info h3,
.listing-info h3 {
  font-size: 1rem;
  font-weight: 600;
  color: #1a365d;
  margin-bottom: 0.5rem;
}

.car-price,
.listing-price {
  font-size: 1.125rem;
  font-weight: 700;
  color: #4CAF50;
  margin-bottom: 0.5rem;
}

.car-details {
  display: flex;
  gap: 1rem;
  color: #6b7280;
  font-size: 0.875rem;
}

.car-details span {
  display: flex;
  align-items: center;
  gap: 0.25rem;
}

.remove-favorite {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: white;
  border: none;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: #ef4444;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: all 0.2s;
}

.remove-favorite:hover {
  background: #ef4444;
  color: white;
}

.listing-status {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 1rem;
  font-size: 0.875rem;
  font-weight: 500;
}

.listing-status.active {
  background: #dcfce7;
  color: #16a34a;
}

.listing-status.pending {
  background: #fef3c7;
  color: #d97706;
}

.listing-status.sold {
  background: #fee2e2;
  color: #dc2626;
}

.listing-actions {
  position: absolute;
  top: 1rem;
  right: 1rem;
  display: flex;
  gap: 0.5rem;
}

.edit-listing,
.delete-listing {
  background: white;
  border: none;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: all 0.2s;
}

.edit-listing {
  color: #4CAF50;
}

.delete-listing {
  color: #ef4444;
}

.edit-listing:hover {
  background: #4CAF50;
  color: white;
}

.delete-listing:hover {
  background: #ef4444;
  color: white;
}

.reviews-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.review-card {
  background: white;
  border-radius: 8px;
  padding: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.review-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}

.review-header img {
  width: 64px;
  height: 64px;
  border-radius: 8px;
  object-fit: cover;
}

.review-info {
  flex: 1;
}

.review-info h3 {
  font-size: 1rem;
  font-weight: 600;
  color: #1a365d;
  margin-bottom: 0.25rem;
}

.rating {
  display: flex;
  gap: 0.25rem;
}

.rating i {
  color: #d1d5db;
}

.rating i.active {
  color: #f59e0b;
}

.review-date {
  color: #6b7280;
  font-size: 0.875rem;
}

.review-text {
  color: #4b5563;
  line-height: 1.5;
}

@media (max-width: 768px) {
  .profile-header {
    flex-direction: column;
    text-align: center;
  }

  .profile-stats {
    justify-content: center;
  }

  .edit-profile-btn {
    width: 100%;
    justify-content: center;
  }

  .favorites-grid,
  .listings-grid {
    grid-template-columns: 1fr;
  }
}
</style>