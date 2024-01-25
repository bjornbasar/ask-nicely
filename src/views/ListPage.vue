<template>
    <div>
      <h2>Data List</h2>
      <button @click="goToUploadPage">Upload</button>
      <table>
        <thead>
          <tr>
            <th>Company Name</th>
            <th>Employee Name</th>
            <th>Employee Email</th>
            <th>Salary</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="record in dataList" :key="record.id" @click="goToEditPage(record.id)">
            <td>{{ record.companyName }}</td>
            <td>{{ record.employeeName }}</td>
            <td>{{ record.employeeEmail }}</td>
            <td>{{ record.salary }}</td>
          </tr>
        </tbody>
      </table>
    </div>
</template>
  
<script>
  export default {
    data() {
      return {
        dataList: [] // Your data fetched from the backend will be stored here
      };
    },
    methods: {
      goToEditPage(recordId) {
        this.$router.push(`/edit/${recordId}`);
      },
      goToUploadPage() {
        this.$router.push('/upload');
      }
    }
  };
</script>

<style scoped>
/* Add your styles here */
</style>