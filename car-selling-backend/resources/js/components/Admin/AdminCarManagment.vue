<template>
  <div class="admin-cars">
    <h1>Car Listings Management</h1>
    <div class="car-actions">
      <input v-model="search" type="text" placeholder="Search cars by make, model, or owner..." class="search-input" />
    </div>
    <table class="car-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Make</th>
          <th>Model</th>
          <th>Owner</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="car in filteredCars" :key="car.id">
          <td>{{ car.id }}</td>
          <td>{{ car.make }}</td>
          <td>{{ car.model }}</td>
          <td>{{ car.owner }}</td>
          <td>
            <span :class="['status', car.status]">{{ car.status }}</span>
          </td>
          <td>
            <button class="approve-btn" v-if="car.status === 'pending'" @click="approveCar(car)"><i class="fas fa-check"></i></button>
            <button class="reject-btn" v-if="car.status === 'pending'" @click="rejectCar(car)"><i class="fas fa-times"></i></button>
            <button class="edit-btn" @click="editCar(car)"><i class="fas fa-edit"></i></button>
            <button class="delete-btn" @click="deleteCar(car)"><i class="fas fa-trash"></i></button>
          </td>
        </tr>
        <tr v-if="filteredCars.length === 0">
          <td colspan="6" class="no-cars">No car listings found.</td>
        </tr>
      </tbody>
    </table>
    <!-- Edit Modal (placeholder) -->
    <div v-if="showEditModal" class="modal-overlay">
      <div class="modal-content">
        <h2>Edit Car Listing</h2>
        <form @submit.prevent="saveCar">
          <div class="form-group">
            <label>Make</label>
            <input v-model="editCarData.make" type="text" required />
          </div>
          <div class="form-group">
            <label>Model</label>
            <input v-model="editCarData.model" type="text" required />
          </div>
          <div class="form-group">
            <label>Owner</label>
            <input v-model="editCarData.owner" type="text" required />
          </div>
          <div class="form-group">
            <label>Status</label>
            <select v-model="editCarData.status">
              <option value="approved">Approved</option>
              <option value="pending">Pending</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
          <div class="modal-actions">
            <button type="submit" class="save-btn">Save</button>
            <button type="button" class="cancel-btn" @click="closeEditModal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminCarManagment',
  data() {
    return {
      search: '',
      cars: [
        { id: 1, make: 'Toyota', model: 'Corolla', owner: 'Alice Smith', status: 'pending' },
        { id: 2, make: 'Honda', model: 'Civic', owner: 'Bob Johnson', status: 'approved' },
        { id: 3, make: 'Ford', model: 'Focus', owner: 'Charlie Lee', status: 'rejected' },
        { id: 4, make: 'BMW', model: '320i', owner: 'Diana King', status: 'approved' },
      ],
      showEditModal: false,
      editCarData: {
        id: null,
        make: '',
        model: '',
        owner: '',
        status: 'pending'
      }
    }
  },
  computed: {
    filteredCars() {
      if (!this.search) return this.cars
      const s = this.search.toLowerCase()
      return this.cars.filter(c =>
        c.make.toLowerCase().includes(s) ||
        c.model.toLowerCase().includes(s) ||
        c.owner.toLowerCase().includes(s)
      )
    }
  },
  methods: {
    approveCar(car) {
      car.status = 'approved'
    },
    rejectCar(car) {
      car.status = 'rejected'
    },
    editCar(car) {
      this.editCarData = { ...car }
      this.showEditModal = true
    },
    saveCar() {
      const idx = this.cars.findIndex(c => c.id === this.editCarData.id)
      if (idx !== -1) {
        this.cars[idx] = { ...this.editCarData }
      }
      this.closeEditModal()
    },
    deleteCar(car) {
      if (confirm(`Are you sure you want to delete ${car.make} ${car.model}?`)) {
        this.cars = this.cars.filter(c => c.id !== car.id)
      }
    },
    closeEditModal() {
      this.showEditModal = false
    }
  }
}
</script>

<style scoped>
.admin-cars {
  padding: 2rem;
  max-width: 1000px;
  margin: 0 auto;
}

h1 {
  color: #1a365d;
  text-align: center;
  margin-bottom: 2rem;
}

.car-actions {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 1rem;
}

.search-input {
  padding: 0.5rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 1rem;
  width: 300px;
  max-width: 100%;
}

.car-table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.07);
}

.car-table th, .car-table td {
  padding: 1rem;
  text-align: left;
}

.car-table th {
  background: #f1f5f9;
  color: #1a365d;
  font-weight: 600;
}

.car-table tr:not(:last-child) {
  border-bottom: 1px solid #e5e7eb;
}

.status {
  padding: 0.3rem 0.8rem;
  border-radius: 12px;
  font-size: 0.95rem;
  font-weight: 500;
  color: #fff;
  display: inline-block;
}
.status.approved {
  background: #4CAF50;
}
.status.pending {
  background: #fbbf24;
  color: #1a365d;
}
.status.rejected {
  background: #ef4444;
}

.approve-btn, .reject-btn, .edit-btn, .delete-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.1rem;
  margin-right: 0.5rem;
  color: #1a365d;
  transition: color 0.2s;
}
.approve-btn:hover {
  color: #4CAF50;
}
.reject-btn:hover {
  color: #ef4444;
}
.edit-btn:hover {
  color: #4CAF50;
}
.delete-btn {
  margin-right: 0;
}
.delete-btn:hover {
  color: #ef4444;
}

.no-cars {
  text-align: center;
  color: #6b7280;
  font-style: italic;
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}
.modal-content {
  background: #fff;
  padding: 2rem;
  border-radius: 12px;
  min-width: 320px;
  max-width: 90vw;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
.form-group {
  margin-bottom: 1.2rem;
}
.form-group label {
  display: block;
  margin-bottom: 0.4rem;
  color: #1a365d;
  font-weight: 500;
}
.form-group input, .form-group select {
  width: 100%;
  padding: 0.6rem;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 1rem;
}
.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}
.save-btn {
  background: #4CAF50;
  color: #fff;
  border: none;
  padding: 0.6rem 1.2rem;
  border-radius: 6px;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s;
}
.save-btn:hover {
  background: #388e3c;
}
.cancel-btn {
  background: #9ca3af;
  color: #fff;
  border: none;
  padding: 0.6rem 1.2rem;
  border-radius: 6px;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s;
}
.cancel-btn:hover {
  background: #6b7280;
}
</style>
