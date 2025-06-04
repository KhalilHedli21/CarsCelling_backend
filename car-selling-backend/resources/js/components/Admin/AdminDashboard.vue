<template>
  <div class="admin-dashboard">
    <h1>Admin Dashboard</h1>
    <div class="dashboard-stats">
      <div class="stat-card users">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-info">
          <h2>{{ stats.users }}</h2>
          <p>Users</p>
        </div>
      </div>
      <div class="stat-card cars">
        <div class="stat-icon"><i class="fas fa-car"></i></div>
        <div class="stat-info">
          <h2>{{ stats.cars }}</h2>
          <p>Car Listings</p>
        </div>
      </div>
      <div class="stat-card orders">
        <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
        <div class="stat-info">
          <h2>{{ stats.orders }}</h2>
          <p>Orders</p>
        </div>
      </div>
    </div>
    <div class="dashboard-links">
      <router-link to="/admin/users" class="dashboard-link">
        <i class="fas fa-users"></i> Manage Users
      </router-link>
      <router-link to="/admin/listings" class="dashboard-link">
        <i class="fas fa-car"></i> Manage Car Listings
      </router-link>
      <router-link to="/admin/orders" class="dashboard-link">
        <i class="fas fa-shopping-cart"></i> Manage Orders
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminDashboard',
  data() {
    return {
      stats: {
        users: 120,
        cars: 45,
        orders: 32
      }
    }
  }
}
</script>

<style scoped>
.admin-dashboard {
  padding: 2rem;
  max-width: 900px;
  margin: 0 auto;
}

h1 {
  color: #1a365d;
  text-align: center;
  margin-bottom: 2rem;
}

.dashboard-stats {
  display: flex;
  gap: 2rem;
  justify-content: center;
  margin-bottom: 2.5rem;
}

.stat-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.07);
  padding: 2rem 1.5rem;
  display: flex;
  align-items: center;
  min-width: 180px;
  gap: 1rem;
}

.stat-icon {
  font-size: 2.2rem;
  color: #4CAF50;
  background: #e6f4ea;
  border-radius: 50%;
  padding: 0.7rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.stat-info h2 {
  margin: 0;
  font-size: 2rem;
  color: #1a365d;
}

.stat-info p {
  margin: 0;
  color: #6b7280;
  font-size: 1rem;
}

.dashboard-links {
  display: flex;
  justify-content: center;
  gap: 2rem;
}

.dashboard-link {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: #1a365d;
  color: #fff;
  padding: 1rem 1.5rem;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 500;
  font-size: 1.1rem;
  transition: background 0.2s;
}

.dashboard-link:hover {
  background: #4CAF50;
  color: #fff;
}

@media (max-width: 700px) {
  .dashboard-stats {
    flex-direction: column;
    gap: 1.5rem;
    align-items: center;
  }
  .dashboard-links {
    flex-direction: column;
    gap: 1rem;
    align-items: center;
  }
}
</style>
