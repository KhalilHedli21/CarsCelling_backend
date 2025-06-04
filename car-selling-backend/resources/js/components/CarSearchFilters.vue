<template>
  <div class="search-filters">
    <h2>Advanced Search</h2>
    <form @submit.prevent="applyFilters">
      <div class="form-group">
        <label for="make">Make</label>
        <input type="text" id="make" v-model="make">
      </div>
      <div class="form-group">
        <label for="model">Model</label>
        <input type="text" id="model" v-model="model">
      </div>
      <div class="form-group">
        <label for="minPrice">Min Price</label>
        <input type="number" id="minPrice" v-model="minPrice">
      </div>
      <div class="form-group">
        <label for="maxPrice">Max Price</label>
        <input type="number" id="maxPrice" v-model="maxPrice">
      </div>
      <button type="submit">Apply Filters</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      make: '',
      model: '',
      minPrice: '',
      maxPrice: ''
    }
  },
  methods: {
    applyFilters() {
      this.$emit('apply-filters', {
        make: this.make,
        model: this.model,
        minPrice: this.minPrice,
        maxPrice: this.maxPrice
      })
    }
  }
}
</script>

<style scoped>
.search-filters {
  padding: 1rem;
  background: #f9f9f9;
  border-radius: 8px;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
}

.form-group input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
</style>