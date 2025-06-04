<template>
  <div class="modal" v-if="show">
    <div class="modal-background" @click="close"></div>
    <div class="modal-content">
      <h2>Contact Seller</h2>
      <form @submit.prevent="sendMessage">
        <div class="form-group">
          <label for="name">Your Name</label>
          <input type="text" id="name" v-model="name" required>
        </div>
        <div class="form-group">
          <label for="email">Your Email</label>
          <input type="email" id="email" v-model="email" required>
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea id="message" v-model="message" required></textarea>
        </div>
        <button type="submit">Send</button>
      </form>
    </div>
    <button class="modal-close" @click="close">Close</button>
  </div>
</template>

<script>
export default {
  props: ['show', 'car'],
  data() {
    return {
      name: '',
      email: '',
      message: ''
    }
  },
  methods: {
    close() {
      this.$emit('close')
    },
    sendMessage() {
      alert(`Message sent to seller of ${this.car.make} ${this.car.model}`)
      this.close()
    }
  }
}
</script>

<style scoped>
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-background {
  position: absolute;
  width: 100%;
  height: 100%;
}

.modal-content {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  max-width: 500px;
  width: 100%;
}

.modal-close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
}

.form-group input, .form-group textarea {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  padding: 0.5rem 1rem;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background: #0056b3;
}
</style>