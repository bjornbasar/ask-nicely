<template>
  <div>
    <h2>Data List</h2>
    <router-link to="/upload">
      <button class="upload-button">Upload</button>
    </router-link>
    <router-link to="/company-average">
      <button class="company-stats-button">Company Statistics</button>
    </router-link>
    <table class="data-table">
      <thead>
        <tr>
          <th>Company Name</th>
          <th>Employee Name</th>
          <th>Employee Email</th>
          <th>Salary</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="record in dataList" :key="record.id" @click="goToEditPage(record.id)" class="table-row">
          <td>{{ record.company }}</td>
          <td>{{ record.name }}</td>
          <td>{{ record.email }}</td>
          <td>{{ formatCurrency(record.salary) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      dataList: []
    };
  },
  mounted() {
    this.loadData();
  },
  methods: {
    loadData() {
      axios.get(`${import.meta.env.VITE_API_URL}/employees`)
        .then(response => {
          // Handle success
          this.dataList = response.data;
        })
        .catch(error => {
          // Handle error
          console.error(error);
          alert('Error fetching data. Please try again.');
        });
    },
    goToEditPage(recordId) {
      this.$router.push(`/edit/${recordId}`);
    },
    formatCurrency(value) {
      return `$${value.toFixed(2)}`;
    },
  }
};
</script>

<style scoped>
h2 {
  font-size: 1.5em;
  margin-bottom: 20px;
}

.upload-button, .company-stats-button {
  background-color: #4caf50;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.data-table th, .data-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.data-table th {
  background-color: #4caf50;
  color: white;
}

.table-row:hover {
  background-color: #f5f5f5;
  cursor: pointer;
}
</style>