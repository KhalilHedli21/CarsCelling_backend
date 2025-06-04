<template>
  <div class="car-details">
    <h1>{{ car.make }} {{ car.model }}</h1>
    <img :src="car.image || '/toyota.jpg'" :alt="car.make + ' ' + car.model" class="car-image">
    <p><strong>Year:</strong> {{ car.year }}</p>
    <p><strong>Price:</strong> {{ formatPrice(car.price) }}</p>
    <p><strong>Mileage:</strong> {{ car.mileage.toLocaleString() }} km</p>
    <p><strong>Fuel Type:</strong> {{ car.fuelType }}</p>
    <p><strong>Transmission:</strong> {{ car.transmission }}</p>
    <p><strong>Description:</strong> {{ car.description }}</p>
    <button @click="contactSeller">Contact Seller</button>
  </div>
</template>

<script>
export default {
  props: ['car'],
  methods: {
    formatPrice(price) {
      return new Intl.NumberFormat('fr-DZ', { 
        style: 'currency', 
        currency: 'DZD',
        maximumFractionDigits: 0
      }).format(price || 0);
    },
    contactSeller() {
      alert(`Contact seller for ${this.car.make} ${this.car.model}`);
    }
  }
}
</script>

<style scoped>
.car-details {
  max-width: 800px;
  margin: 0 auto;
  padding: 1rem;
}

.car-image {
  width: 100%;
  height: auto;
  object-fit: cover;
}
</style>