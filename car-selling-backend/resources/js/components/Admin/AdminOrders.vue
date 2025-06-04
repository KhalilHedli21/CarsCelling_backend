<template>
  <div class="admin-orders">
    <h1>Orders Management</h1>
    <div class="order-actions">
      <input v-model="search" type="text" placeholder="Search orders by user or car..." class="search-input" />
    </div>
    <table class="order-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>User</th>
          <th>Car</th>
          <th>Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in filteredOrders" :key="order.id">
          <td>{{ order.id }}</td>
          <td>{{ order.user }}</td>
          <td>{{ order.car }}</td>
          <td>{{ order.date }}</td>
          <td>
            <select v-model="order.status" @change="updateStatus(order)">
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </td>
          <td>
            <button class="delete-btn" @click="deleteOrder(order)"><i class="fas fa-trash"></i></button>
          </td>
        </tr>
        <tr v-if="filteredOrders.length === 0">
          <td colspan="6" class="no-orders">No orders found.</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'AdminOrders',
  data() {
    return {
      search: '',
      orders: [
        { id: 1, user: 'Alice Smith', car: 'Toyota Corolla', date: '2024-05-01', status: 'pending' },
        { id: 2, user: 'Bob Johnson', car: 'Honda Civic', date: '2024-05-02', status: 'processing' },
        { id: 3, user: 'Charlie Lee', car: 'Ford Focus', date: '2024-05-03', status: 'completed' },
        { id: 4, user: 'Diana King', car: 'BMW 320i', date: '2024-05-04', status: 'cancelled' },
      ]
    }
  },
  computed: {
    filteredOrders() {
      if (!this.search) return this.orders
      const s = this.search.toLowerCase()
      return this.orders.filter(o =>
        o.user.toLowerCase().includes(s) ||
        o.car.toLowerCase().includes(s)
      )
    }
  },
  methods: {
    updateStatus(order) {
      // Placeholder for backend update
      // alert(`Order #${order.id} status updated to ${order.status}`)
    },
    deleteOrder(order) {
      if (confirm(`Are you sure you want to delete order #${order.id}?`)) {
        this.orders = this.orders.filter(o => o.id !== order.id)
      }
    }
  }
}
</script>

<style scoped>
.admin-orders {
  padding: 2rem;
  max-width: 1000px;
  margin: 0 auto;
}

h1 {
  color: #1a365d;
  text-align: center;
  margin-bottom: 2rem;
}

.order-actions {
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

.order-table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.07);
}

.order-table th, .order-table td {
  padding: 1rem;
  text-align: left;
}

.order-table th {
  background: #f1f5f9;
  color: #1a365d;
  font-weight: 600;
}

.order-table tr:not(:last-child) {
  border-bottom: 1px solid #e5e7eb;
}

select {
  padding: 0.3rem 0.8rem;
  border-radius: 8px;
  border: 1px solid #d1d5db;
  font-size: 1rem;
}

.delete-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.1rem;
  color: #1a365d;
  transition: color 0.2s;
}
.delete-btn:hover {
  color: #ef4444;
}

.no-orders {
  text-align: center;
  color: #6b7280;
  font-style: italic;
}
</style>
