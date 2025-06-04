<template>
  <div class="admin-users">
    <h1>User Management</h1>
    <div class="user-actions">
      <input v-model="search" type="text" placeholder="Search users by name or email..." class="search-input" />
    </div>
    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in filteredUsers" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.role }}</td>
          <td>
            <span :class="['status', user.status]">{{ user.status }}</span>
          </td>
          <td>
            <button class="edit-btn" @click="editUser(user)"><i class="fas fa-edit"></i></button>
            <button class="delete-btn" @click="deleteUser(user)"><i class="fas fa-trash"></i></button>
          </td>
        </tr>
        <tr v-if="filteredUsers.length === 0">
          <td colspan="6" class="no-users">No users found.</td>
        </tr>
      </tbody>
    </table>
    <!-- Edit Modal (placeholder) -->
    <div v-if="showEditModal" class="modal-overlay">
      <div class="modal-content">
        <h2>Edit User</h2>
        <form @submit.prevent="saveUser">
          <div class="form-group">
            <label>Name</label>
            <input v-model="editUserData.name" type="text" required />
          </div>
          <div class="form-group">
            <label>Email</label>
            <input v-model="editUserData.email" type="email" required />
          </div>
          <div class="form-group">
            <label>Role</label>
            <select v-model="editUserData.role">
              <option value="admin">Admin</option>
              <option value="client">Client</option>
            </select>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select v-model="editUserData.status">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
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
  name: 'AdminUserManagment',
  data() {
    return {
      search: '',
      users: [
        { id: 1, name: 'Alice Smith', email: 'alice@example.com', role: 'admin', status: 'active' },
        { id: 2, name: 'Bob Johnson', email: 'bob@example.com', role: 'client', status: 'inactive' },
        { id: 3, name: 'Charlie Lee', email: 'charlie@example.com', role: 'client', status: 'active' },
        { id: 4, name: 'Diana King', email: 'diana@example.com', role: 'client', status: 'active' },
      ],
      showEditModal: false,
      editUserData: {
        id: null,
        name: '',
        email: '',
        role: 'client',
        status: 'active'
      }
    }
  },
  computed: {
    filteredUsers() {
      if (!this.search) return this.users
      const s = this.search.toLowerCase()
      return this.users.filter(u =>
        u.name.toLowerCase().includes(s) ||
        u.email.toLowerCase().includes(s)
      )
    }
  },
  methods: {
    editUser(user) {
      this.editUserData = { ...user }
      this.showEditModal = true
    },
    saveUser() {
      const idx = this.users.findIndex(u => u.id === this.editUserData.id)
      if (idx !== -1) {
        this.users[idx] = { ...this.editUserData }
      }
      this.closeEditModal()
    },
    deleteUser(user) {
      if (confirm(`Are you sure you want to delete ${user.name}?`)) {
        this.users = this.users.filter(u => u.id !== user.id)
      }
    },
    closeEditModal() {
      this.showEditModal = false
    }
  }
}
</script>

<style scoped>
.admin-users {
  padding: 2rem;
  max-width: 1000px;
  margin: 0 auto;
}

h1 {
  color: #1a365d;
  text-align: center;
  margin-bottom: 2rem;
}

.user-actions {
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

.user-table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.07);
}

.user-table th, .user-table td {
  padding: 1rem;
  text-align: left;
}

.user-table th {
  background: #f1f5f9;
  color: #1a365d;
  font-weight: 600;
}

.user-table tr:not(:last-child) {
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
.status.active {
  background: #4CAF50;
}
.status.inactive {
  background: #9ca3af;
}

.edit-btn, .delete-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.1rem;
  margin-right: 0.5rem;
  color: #1a365d;
  transition: color 0.2s;
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

.no-users {
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
