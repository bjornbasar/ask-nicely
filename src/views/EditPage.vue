<template>
  <div>
    <h2>Edit Page</h2>
    <router-link to="/list">
      <button class="back-button">Back to List</button>
    </router-link>
    <div class="edit-form">
      <label for="companyName">Company Name:</label>
      <div>{{ record.company }}</div>
      
      <label for="employeeName">Employee Name:</label>
      <div>{{ record.name }}</div>
      
      <label for="employeeEmail">Employee Email:</label>
      <input type="text" v-model="editedEmail" />
      
      <label for="salary">Salary:</label>
      <div>{{ record.salary }}</div>
    </div>
    <button @click="updateRecord">Save Changes</button>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      record: {},
      editedEmail: ''
    };
  },
  mounted() {
    const recordId = this.$route.params.id;
    axios.get(`${import.meta.env.VITE_API_URL}/data.php?id=${recordId}`)
      .then(response => {
        this.record = response.data;
        this.editedEmail = response.data.email;
      })
      .catch(error => {
        console.error(error);
        alert('Error fetching record details. Please try again.');
      });
  },
  methods: {
    updateRecord() {
      if (this.editedEmail !== this.record.email) {
        axios.post(`${import.meta.env.VITE_API_URL}/update.php`, {
          id: this.record.id,
          email: this.editedEmail
        })
        .then(response => {
          console.log(response.data);
          alert('Email updated successfully!');
        })
        .catch(error => {
          console.error(error);
          alert('Error updating email. Please try again.');
        });
      } else {
        alert('No changes detected.');
      }
    }
  }
};
</script>

<style scoped>
h2 {
  font-size: 1.5em;
  margin-bottom: 20px;
}

.back-button {
  background-color: #4caf50;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-bottom: 20px;
}

.edit-form {
  margin-top: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
}

button {
  background-color: #4caf50;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
</style>
