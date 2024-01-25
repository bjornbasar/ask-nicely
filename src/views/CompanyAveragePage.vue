<!-- src/views/CompanyStatsPage.vue -->

<template>
  <div>
    <h2>Company Statistics</h2>
    <router-link to="/list">
      <button class="back-button">Back to List</button>
    </router-link>
    <table class="company-stats-table">
      <thead>
        <tr>
          <th>Company Name</th>
          <th>Average Salary</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="company in companyStats" :key="company.companyName">
          <td>{{ company.company }}</td>
          <td>{{ formatCurrency(company.averageSalary) }}</td>
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
      companyStats: []
    };
  },
  mounted() {
    this.loadCompanyStats();
  },
  methods: {
    loadCompanyStats() {
      axios.get(`http://192.168.105.24:8080/company-stats.php`)
        .then(response => {
          this.companyStats = response.data;
        })
        .catch(error => {
          console.error(error);
          alert('Error fetching company statistics. Please try again.');
        });
    },
    formatCurrency(value) {
      return `$${value.toFixed(2)}`;
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

.company-stats-table {
  width: 100%;
  border-collapse: collapse;
}

.company-stats-table th, .company-stats-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.company-stats-table th {
  background-color: #4caf50;
  color: white;
}

.company-stats-table td {
  white-space: nowrap;
}
</style>
